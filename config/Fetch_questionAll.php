<?php
// Student-facing exam loader for pages/examination.php.
// SECURITY: must NOT expose choices.is_correct — that is the answer key.
// Admin question preview uses config/Fetch_ExamDetail.php instead.
session_start();

include "../config/no-crash.php";
include "../config/connect.php";
include "../config/admin-guard.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

require_login_json();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $id = isset($_GET['exam_id']) ? (int) $_GET['exam_id'] : 0;

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
                    choices.choice_text AS choices_choice_text

            FROM question_sets
            LEFT JOIN questions ON question_sets.id = questions.question_set_id
            LEFT JOIN choices ON questions.id = choices.question_id
            WHERE question_sets.is_deleted = 0 AND question_sets.id = ?
            ORDER BY questions.id, choices.id";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    $qIndex = [];   // questions_id => index into $data['questions']

    while ($row = $result->fetch_assoc()) {

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

        if ($row["questions_id"] !== null && !isset($qIndex[$row["questions_id"]])) {
            $qIndex[$row["questions_id"]] = count($data["questions"]);
            $data["questions"][] = [
                "questions_id" => $row["questions_id"],
                "questions_question_set_id" => $row["questions_question_set_id"],
                "questions_question_text" => $row["questions_question_text"],
                "questions_question_type" => $row["questions_question_type"],
                "questions_created_at" => $row["questions_created_at"],
                "choices" => [],
            ];
        }

        if ($row["choices_id"] !== null && isset($qIndex[$row["choices_question_id"]])) {
            $data["questions"][$qIndex[$row["choices_question_id"]]]["choices"][] = [
                "choices_id" => $row["choices_id"],
                "choices_question_id" => $row["choices_question_id"],
                "choices_choice_text" => $row["choices_choice_text"],
            ];
        }
    }

    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    $stmt->close();
}

$conn->close();
