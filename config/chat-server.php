<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Server\IoServer;
use React\EventLoop\Loop;
use React\Socket\SecureServer;
use React\Socket\SocketServer;

echo dirname(__DIR__) . '/vendor/autoload.php'; // ตรวจสอบว่าถูกไหม


require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '../config/connect.php';

class Chat implements MessageComponentInterface
{
    protected $clients;
    protected $conn;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        global $conn;
        $this->conn = $conn;
        echo "Chat server started and MySQLi connected (WSS)\n";
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);

        if ($data['type'] === 'join') {
            $from->room_id = $data['room_id'];
            $from->user_id = $data['user_id'];
            echo "[{$from->user_id}] joined room {$from->room_id}\n";
        }
        // new user to video call.
        elseif ($data['type'] === 'new-peer') {
            // ส่งข้อความ "new-peer" ไปยังผู้ใช้คนอื่นในห้องเดียวกัน
            foreach ($this->clients as $client) {
                if (
                    isset($client->room_id, $client->user_id) &&
                    $client->room_id === $from->room_id &&
                    $client !== $from
                ) {
                    $client->send(json_encode([
                        'type' => 'new-peer',
                        'new_user_id' => $from->user_id,
                        'room_id' => $from->room_id
                    ]));
                }
            }
        }
        // 🎯 เพิ่ม support สำหรับ offer ที่มี target_id
        elseif ($data['type'] === 'offer' || $data['type'] === 'answer' || $data['type'] === 'candidate') {
            foreach ($this->clients as $client) {
                if (
                    isset($client->room_id, $client->user_id) &&
                    $client->room_id === $from->room_id &&
                    $client->user_id === $data['target_id']
                ) {
                    $client->send(json_encode([
                        'type' => $data['type'],
                        $data['type'] => $data[$data['type']], // offer/answer/candidate
                        'room_id' => $from->room_id,
                        'sender_id' => $from->user_id, // ส่ง sender_id
                        'target_id' => $data['target_id'] // ส่ง target_id
                    ]));
                }
            }
        } elseif ($data['type'] === 'chat') {
            $stmt = $this->conn->prepare("INSERT INTO chat_messages (chat_room_id, user_id, message) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $data['room_id'], $data['user_id'], $data['message']);
            $stmt->execute();

            foreach ($this->clients as $client) {
                if (isset($client->room_id) && $client->room_id === $from->room_id) {
                    $client->send(json_encode([
                        'type' => 'chat',
                        'name' => $data['name'],
                        'message' => $data['message']
                    ]));
                }
            }
        } elseif ($data['type'] === 'leave') {
            foreach ($this->clients as $client) {
                if ( isset($client->room_id, $client->user_id) &&
                    $client->room_id === $from->room_id &&
                    $client !== $from
                ) {
                    $client->send(json_encode([
                        'type' => 'leave',
                        'sender_id' => $from->user_id,
                        'room_id' => $from->room_id
                    ]));
                }
            }
            echo "[{$from->user_id}] left room {$from->room_id}\n";
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }
}

// ✅ สร้าง WebSocket Server แบบปลอดภัย (WSS)
$loop = Loop::get();


// เปิด socket พอร์ต 8085
$socket = new SocketServer('0.0.0.0:8085', [], $loop);

// เพิ่มการเข้ารหัส SSL
$secure_socket = new SecureServer($socket, $loop, [
    'local_cert' => 'D:/xampp/apache/conf/ssl.crt/49.0.69.152.pem', // 👈 เปลี่ยนเป็น path ของคุณ
    'local_pk' => 'D:/xampp/apache/conf/ssl.key/49.0.69.152-key.pem',  // 👈 เปลี่ยนเป็น path ของคุณ
    'allow_self_signed' => true,
    'verify_peer' => false
]);

$server = new IoServer(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    $secure_socket,
    $loop
);

echo "Secure WSS server started on port 8085...\n";
$loop->run();
