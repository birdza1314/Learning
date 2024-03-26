<?php
// Include database connection
include('../connections/connection.php');

// Check if form is submitted
if(isset($_POST['quiz_id'])) {
    // Retrieve data from the form
    $quiz_id = $_POST['quiz_id'];
    $timeLimit = $_POST['timeLimit'];
    $QuestDipLimit = $_POST['QuestDipLimit'];
    $Quiz_Title = $_POST['Quiz_Title'];
    $QuizDesc = $_POST['QuizDesc'];
    $status = $_POST['status'];

    // Prepare SQL statement to update quiz data in the database
    $stmt = $db->prepare("UPDATE quizzes SET time_limit = :timeLimit, question_limit = :QuestDipLimit, quiz_title = :Quiz_Title, quiz_description = :QuizDesc,status=:status WHERE quiz_id = :quiz_id");
    $stmt->bindParam(':timeLimit', $timeLimit);
    $stmt->bindParam(':QuestDipLimit', $QuestDipLimit);
    $stmt->bindParam(':Quiz_Title', $Quiz_Title);
    $stmt->bindParam(':QuizDesc', $QuizDesc);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':quiz_id', $quiz_id);

    try {
        // Execute the SQL statement
        $stmt->execute();
        // Check if the update was successful
        if($stmt->rowCount() > 0) {
            // Redirect back to the page with a success message
            echo "<script>alert('อัพเดทสำเร็จ');</script>";
            echo "<script>window.location.href = 'edit_quiz.php?quiz_id=$quiz_id';</script>";
        } else {
            // If no rows were affected, redirect back to the page with an error message
            echo "<script>window.location.href = 'edit_quiz.php?quiz_id=$quiz_id';</script>";
        }
    } catch (PDOException $e) {
        // If an error occurs, display the error message
        echo "Error: " . $e->getMessage();
    }
} else {
    // If form is not submitted, redirect back to the page with an error message
    echo "<script>window.location.href = 'edit_quiz.php?error=Form not submitted';</script>";
}
?>
