<?php
// Include database connection
include('../connections/connection.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set
    if(isset($_POST['lesson_id']) && isset($_POST['course_id']) && isset($_POST['timeLimit']) && isset($_POST['QuestDipLimit']) && isset($_POST['Quiz_Title'])) {
        // Retrieve data from the form
        $lesson_id = $_POST['lesson_id'];
        $course_id = $_POST['course_id'];
        $timeLimit = $_POST['timeLimit'];
        $QuestDipLimit = $_POST['QuestDipLimit'];
        $Quiz_Title = $_POST['Quiz_Title'];
        $QuizDesc = isset($_POST['QuizDesc']) ? $_POST['QuizDesc'] : '';

        // Prepare SQL statement to insert quiz data into the database
        $stmt = $db->prepare("INSERT INTO quizzes (lesson_id, c_id, time_limit, question_limit, quiz_title, quiz_description) VALUES (:lesson_id, :c_id, :timeLimit, :QuestDipLimit, :Quiz_Title, :QuizDesc)");
        $stmt->bindParam(':lesson_id', $lesson_id);
        $stmt->bindParam(':c_id', $course_id);
        $stmt->bindParam(':timeLimit', $timeLimit);
        $stmt->bindParam(':QuestDipLimit', $QuestDipLimit);
        $stmt->bindParam(':Quiz_Title', $Quiz_Title);
        $stmt->bindParam(':QuizDesc', $QuizDesc);

        // Execute the SQL statement
        if ($stmt->execute()) {
            // Get the quiz_id of the newly inserted quiz
            $quiz_id = $db->lastInsertId();

            // Insert into add_topic table
            $stmt_add_topic = $db->prepare("INSERT INTO add_topic (lesson_id, quiz_id) VALUES (:lesson_id, :quiz_id)");
            $stmt_add_topic->bindParam(':lesson_id', $lesson_id);
            $stmt_add_topic->bindParam(':quiz_id', $quiz_id);

            // Execute the SQL statement
            if ($stmt_add_topic->execute()) {
                // Redirect back to the page with success message
                echo "<script>alert('Quiz added successfully');</script>";
                echo "<script>window.history.back();</script>";
            } else {
                // Display error message if add_topic insert fails
                echo "<script>alert('Failed to add quiz');</script>";
                echo "<script>window.history.back();</script>";
            }
        } else {
            // Display error message if quiz insert fails
            echo "<script>alert('Failed to add quiz');</script>";
            echo "<script>window.history.back();</script>";
        }
    } else {
        // If required fields are not set, redirect back to the page with an error message
        echo "<script>alert('Required fields are not set');</script>";
        echo "<script>window.history.back();</script>";
    }
} else {
    // If form is not submitted, redirect back to the page with an error message
    echo "<script>alert('Form not submitted');</script>";
    echo "<script>window.history.back();</script>";
}
?>
