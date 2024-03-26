<?php
session_start();
include('../connections/connection.php');

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php'); 
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบว่ามีข้อมูลที่ส่งมาจากแบบฟอร์มหรือไม่
    if (!isset($_POST['quiz_id']) || !isset($_SESSION['user_id'])) {
        echo "Invalid request!";
        exit();
    }

    $quiz_id = $_POST['quiz_id'];
    $user_id = $_SESSION['user_id'];

    // ดึงข้อมูลแบบทดสอบจากฐานข้อมูล
    $stmt = $db->prepare("SELECT * FROM quizzes WHERE quiz_id = :quiz_id");
    $stmt->bindParam(':quiz_id', $quiz_id);
    $stmt->execute();
    $quiz = $stmt->fetch(PDO::FETCH_ASSOC);

    // ตรวจสอบว่ามีแบบทดสอบหรือไม่
    if (!$quiz) {
        echo "Quiz not found!";
        exit();
    }

    // ดึงคำถามที่เกี่ยวข้องกับแบบทดสอบนี้
    $stmt = $db->prepare("SELECT * FROM questions WHERE quiz_id = :quiz_id");
    $stmt->bindParam(':quiz_id', $quiz_id);
    $stmt->execute();
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ตรวจสอบว่ามีคำถามหรือไม่
    if (!$questions) {
        echo "No questions found for this quiz!";
        exit();
    }

    // เตรียมคำสั่ง SQL สำหรับการเพิ่มข้อมูลลงในตาราง student_answers
    $stmt = $db->prepare("INSERT INTO student_answers (student_id, quiz_id, question_id, chosen_answer) VALUES (:student_id, :quiz_id, :question_id, :chosen_answer)");

    // วนลูปเพื่อบันทึกคำตอบของนักเรียนลงในตาราง student_answers
    foreach ($questions as $question) {
        $question_id = $question['question_id'];
        $chosen_answer = $_POST['question_' . $question_id];
        
        // ผู้ใช้เลือกที่ตอบคำถามได้
        if (!empty($chosen_answer)) {
            // ทำการ bind parameters และ execute คำสั่ง SQL
            $stmt->bindParam(':student_id', $user_id);
            $stmt->bindParam(':quiz_id', $quiz_id);
            $stmt->bindParam(':question_id', $question_id);
            $stmt->bindParam(':chosen_answer', $chosen_answer);
            $stmt->execute();
        }
    }


    $total_questions = count($questions);
    $score = 0;

    // ตรวจสอบคำตอบที่ถูกต้องและคำตอบที่ผู้ใช้เลือก
    foreach ($questions as $question) {
        $question_id = $question['question_id'];
        $correct_answer = $question['correct_answer'];
        $user_answer = $_POST['question_' . $question_id];

        if ($user_answer == $correct_answer) {
            $score++;
        }
    }

    // บันทึกคะแนนลงในฐานข้อมูล
    try {
        $stmt = $db->prepare("INSERT INTO quiz_results (quiz_id, user_id, score, total_questions) VALUES (:quiz_id, :user_id, :score, :total_questions)");
        $stmt->bindParam(':quiz_id', $quiz_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':score', $score);
        $stmt->bindParam(':total_questions', $total_questions);
        $stmt->execute();
        
        // ส่งผลการสอบไปยังหน้าที่แสดงผลการสอบ
        echo "<script>window.history.go(-3);</script>";
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    echo "Invalid request!";
    exit();
}
?>
