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
            echo "[" . $data['user_id'] . "] joined Meeting room " . $from->room_id . "\n";

            $roomId = $data['room_id'];
            $user_id = $data['user_id'];
            $name = "&lt;server&gt;";
            $message = "[" . $user_id . "] Joined meeting.";

            // ✅ ส่งเฉพาะคนในห้องเดียวกัน
            foreach ($this->clients as $client) {
                if (isset($client->room_id) && $client->room_id === $roomId) {
                    $client->send(json_encode([
                        'type' => 'join',
                        'name' => $name,
                        'message' => $message
                    ]));
                }
            }
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
                        'type' => 'chat',
                        'name' => $name,
                        'message' => $message
                    ]));
                }
            }
        } else if ($data['type'] === 'offer') {
            foreach ($this->clients as $client) {
                if ($client->room_id == $from->room_id && $client->user_id == $data['to_user_id']) {
                    $client->send(json_encode([
                        'type' => 'offer',
                        'offer' => $data['offer'],
                        'from_user_id' => $from->user_id,
                        'room_id' => $from->room_id
                    ]));
                }
            }
        } else if ($data['type'] === 'answer') {
            foreach ($this->clients as $client) {
                if ($client->room_id == $from->room_id && $client->user_id == $data['to_user_id']) {
                    $client->send(json_encode([
                        'type' => 'answer',
                        'answer' => $data['answer'],
                        'from_user_id' => $from->user_id,
                        'room_id' => $from->room_id
                    ]));
                }
            }
        } else if ($data['type'] === 'candidate') {
            foreach ($this->clients as $client) {
                if ($client->room_id == $from->room_id && $client->user_id == $data['to_user_id']) {
                    $client->send(json_encode([
                        'type' => 'candidate',
                        'candidate' => $data['candidate'],
                        'from_user_id' => $from->user_id,
                        'room_id' => $from->room_id
                    ]));
                }
            }
        } else if ($data['type'] === 'leave') {

            $roomId = $data['room_id'];
            $user_id = $data['user_id'];
            $name = "&lt;server&gt;";
            $message = "[" . $user_id . "] leave.";

            // ✅ ส่งเฉพาะคนในห้องเดียวกัน
            foreach ($this->clients as $client) {
                if (isset($client->room_id) && $client->room_id === $roomId) {
                    $client->send(json_encode([
                        'type' => 'leave',
                        'name' => $name,
                        'message' => $message
                    ]));
                }
            }
            echo "[" . $data['user_id'] . "] leave room " . $from->room_id . "\n";
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
