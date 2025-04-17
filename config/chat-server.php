<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '../config/connect.php';

class Chat implements MessageComponentInterface
{
    protected $clients;
    protected $conn;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;

        // ✅ ดึง conn จาก global หรือใช้จาก include
        global $conn;
        $this->conn = $conn;

        echo "Chat server started and MySQLi connected\n";
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
            echo "[" . $data['user_id'] . "] joined room " . $from->room_id . "\n";
            return;
        } else if ($data['type'] === 'chat') {

            $roomId = $data['room_id'];
            $user_id = $data['user_id'];
            $name = $data['name'];
            $message = $data['message'];

            //กำหนด room_id ให้กับ client
            // $from->room_id = $roomId;

            $stmt = $this->conn->prepare("INSERT INTO chat_messages (chat_room_id, user_id, message) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $roomId, $user_id, $message);
            $stmt->execute();

            // ✅ ส่งเฉพาะคนในห้องเดียวกัน
            foreach ($this->clients as $client) {
                if (isset($client->room_id) && $client->room_id === $roomId) {
                    $client->send(json_encode([
                        'name' => $name,
                        'message' => $message
                    ]));
                }
            }
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

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

$server = IoServer::factory(
    new HttpServer(new WsServer(new Chat())),
    8085
);

$server->run();
