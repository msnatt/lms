<?php
session_start();
include '../config/connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['exam_id'] ?? null;

    $sql = "SELECT  question_sets.id,
                    question_sets.title,
                    question_sets.type,
                    question_sets.description,
                    question_sets.start_time,
                    question_sets.exam_period,
                    question_sets.created_at,
                    question_sets.is_deleted,

                    questions.id AS questions_id,
                    questions.question_set_id AS questions_question_set_id,
                    questions.question_text AS questions_question_text,
                    questions.question_type AS questions_question_type,       
                    questions.created_at AS questions_created_at,       

                    choices.id AS choices_id,
                    choices.question_id AS choices_question_id,
                    choices.choice_text AS choices_choice_text,
                    choices.is_correct AS choices_is_correct

            FROM question_sets
            LEFT JOIN questions ON question_sets.id = questions.question_set_id
            LEFT JOIN choices ON questions.id = choices.question_id
            WHERE question_sets.is_deleted = 0 AND question_sets.id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];

    while ($row = $result->fetch_assoc()) {

        // ✅ สร้างโครงสร้างหลักหากยังไม่มีข้อมูลใน `$data`
        if (empty($data)) {
            $data = [
                "id" => $row["id"],
                "title" => $row["title"],
                "type" => $row["type"],
                "description" => $row["description"],
                "start_time" => $row["start_time"],
                "exam_period" => $row["exam_period"],
                "created_at" => $row["created_at"],
                "is_deleted" => $row["is_deleted"],
                "questions" => [],
            ];
        }

        // ✅ ตรวจสอบว่า `courses` มีข้อมูลนี้อยู่แล้วหรือยัง
        $courseExists = array_filter($data["questions"], function ($c) use ($row) {
            return $c["questions_id"] == $row["questions_id"];
        });

        if (!$courseExists) {
            $data["questions"][] = [
                "questions_id" => $row["questions_id"],
                "questions_question_set_id" => $row["questions_question_set_id"],
                "questions_question_text" => $row["questions_question_text"],
                "questions_question_type" => $row["questions_question_type"],
                "questions_created_at" => $row["questions_created_at"],
                "choices" => [],
            ];
        }
        foreach ($data['questions'] as &$question) {
            if ($question["questions_id"] == $row["choices_question_id"]) {
                // หา choice ว่ามีหรือยัง
                $choiceExists = array_filter($question["choices"], function ($c) use ($row) {
                    return $c["choices_id"] == $row["choices_id"];
                });

                if (!$choiceExists && $row["choices_id"]) { // เผื่อว่า choices_id อาจว่าง
                    $question["choices"][] = [
                        "choices_id" => $row["choices_id"],
                        "choices_question_id" => $row["choices_question_id"],
                        "choices_choice_text" => $row["choices_choice_text"],
                        "choices_is_correct" => $row["choices_is_correct"],
                    ];
                }
            }
        }
        unset($question);
    }

    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);


    $stmt->close();
}

$conn->close();
