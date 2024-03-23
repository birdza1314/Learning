<?php
// Include database connection details
include('../connections/connection.php');

// Start session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get lesson_id and course_id from the form data
    $lesson_id = isset($_POST['lesson_id']) ? (int) $_POST['lesson_id'] : null;
    $course_id = isset($_POST['course_id']) ? (int) $_POST['course_id'] : null;

    // Check if user is logged in
    if (isset($_SESSION['user_id'])) {
        // Get student_id from the session
        $student_id = (int) $_SESSION['user_id'];

        // Check if required parameters are provided
        if (!empty($lesson_id) && !empty($student_id) && !empty($course_id)) {
            try {
                // Prepare SQL statement to insert into marks_as_done table
                $sql = "INSERT INTO marks_as_done (student_id, course_id, lesson_id, mark_date) VALUES (:student_id, :course_id, :lesson_id, NOW())";
                
                // Prepare the statement
                $stmt = $db->prepare($sql);

                // Bind parameters
                $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
                $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
                $stmt->bindParam(':lesson_id', $lesson_id, PDO::PARAM_INT);

                // Execute the statement
                if ($stmt->execute()) {
                    // Success message
                    echo 'Lesson marked as done successfully!';
                } else {
                    // Error message
                    echo 'Error: Unable to mark lesson as done';
                }
            } catch (PDOException $e) {
                // Error message
                echo 'Error: ' . $e->getMessage();
            }
        } else {
            // Error message if required parameters are missing
            echo 'Error: Missing required parameters';
        }
    } else {
        // Redirect to login page if user is not logged in
        header('Location: login.php');
        exit();
    }
} else {
    // Redirect to appropriate page if form is not submitted
    header('Location: index.php');
    exit();
}
?>
