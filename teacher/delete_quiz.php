<?php
// Include database connection
include('../connections/connection.php');

// Check if quiz_id is set
if(isset($_POST['quiz_id'])) {
    $quiz_id = $_POST['quiz_id'];

    try {
        // Prepare SQL statement to delete the quiz
        $stmt = $db->prepare("DELETE FROM quizzes WHERE quiz_id = :quiz_id");
        $stmt->bindParam(':quiz_id', $quiz_id);
        $stmt->execute();

        // Check if any rows were affected
        if($stmt->rowCount() > 0) {
            // If successful, return success message
            echo "ลบข้อมูลสำเร็จ!";
        } else {
            // If no rows were affected, return error message
            echo "No quiz found with the given ID!";
        }
    } catch (PDOException $e) {
        // Display an error message if something goes wrong
        echo "Error: " . $e->getMessage();
    }
} else {
    // If quiz_id is not set, return error message
    echo "Quiz ID is not provided!";
}

// Redirect back to add_lessons.php with course_id
if(isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'];
    // Redirect back to add_lessons.php with course_id parameter
    echo "<script>window.location.href = 'add_lessons.php?course_id=$course_id';</script>";
} else {
    echo "<script>window.location.href = 'add_lessons.php';</script>";
}
?>
