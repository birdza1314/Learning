<?php
include('../connections/connection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if user is logged in
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
        http_response_code(401);
        exit();
    }

    // Get lesson_id and course_id from POST data
    $lesson_id = $_POST['lesson_id'];
    $course_id = $_POST['course_id'];
    $user_id = $_SESSION['user_id'];

    try {
        // Prepare SQL statement to delete the record from Marks_as_done table
        $stmt = $db->prepare("DELETE FROM Marks_as_done WHERE lesson_id = :lesson_id AND student_id = :student_id AND course_id = :course_id");
        $stmt->bindParam(':lesson_id', $lesson_id, PDO::PARAM_INT);
        $stmt->bindParam(':student_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
        $stmt->execute();

        // Send success response
        http_response_code(200);
        exit();
    } catch (PDOException $e) {
        // If there's any error, send error response
        http_response_code(500);
        exit();
    }
} else {
    // If not POST request, send error response
    http_response_code(405);
    exit();
}
?>
