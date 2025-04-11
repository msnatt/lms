$query = "INSERT INTO chat_messages (user_id, message, chat_room_id) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("isi", $user_id, $message, $chat_room_id);
$stmt->execute();