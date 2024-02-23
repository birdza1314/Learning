<?php
    // Include database connection
    include('../connections/connection.php');

    // Check if quiz_id is set in the URL
    if(isset($_POST['quiz_id'])) {
        // Retrieve quiz_id from the form data
        $quiz_id = $_POST['quiz_id'];
        
        // Prepare SQL statement to select quiz data based on quiz_id
        $stmt = $db->prepare("SELECT * FROM quizzes WHERE quiz_id = :quiz_id");
        $stmt->bindParam(':quiz_id', $quiz_id);
        
        try {
            // Execute the SQL statement
            $stmt->execute();
            
            // Fetch quiz data
            $quiz = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // If an error occurs, display the error message
            echo "Error: " . $e->getMessage();
        }
    } else {
        // If quiz_id is not set in the form data, redirect back to the page with an error message
        echo "<script>window.location.href = 'add_lessons.php?error=Quiz ID not provided';</script>";
    }

   // Check if the form is submitted and quiz_id is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['quiz_id'])) {
    // Retrieve the question_id and other updated data from the form
    $question_id = $_POST['question_id'];
    $quiz_id = $_POST['quiz_id'];
    $updatedQuestionText = $_POST['updatedQuestionText'];
    $updatedChoice1 = $_POST['updatedChoice1'];
    $updatedChoice2 = $_POST['updatedChoice2'];
    $updatedChoice3 = $_POST['updatedChoice3'];
    $updatedChoice4 = $_POST['updatedChoice4'];
    $updatedCorrectAnswer = $_POST['updatedCorrectAnswer'];

    // Prepare SQL statement to update the question data
    $stmt = $db->prepare("UPDATE questions SET question_text = :question_text, choice_ch1 = :choice_ch1, choice_ch2 = :choice_ch2, choice_ch3 = :choice_ch3, choice_ch4 = :choice_ch4, correct_answer = :correct_answer WHERE question_id = :question_id");

    // Bind parameters
    $stmt->bindParam(':question_text', $updatedQuestionText);
    $stmt->bindParam(':choice_ch1', $updatedChoice1);
    $stmt->bindParam(':choice_ch2', $updatedChoice2);
    $stmt->bindParam(':choice_ch3', $updatedChoice3);
    $stmt->bindParam(':choice_ch4', $updatedChoice4);
    $stmt->bindParam(':correct_answer', $updatedCorrectAnswer);
    $stmt->bindParam(':question_id', $question_id);

    // Execute the SQL statement
    try {
        $stmt->execute();
        // Redirect back to the edit_quiz.php page with the quiz_id
        
        header("Location: edit_quiz.php?quiz_id={$quiz_id}");
        exit();
    } catch (PDOException $e) {
        // If an error occurs, display the error message
        echo "Error: " . $e->getMessage();
    }
} else {
    // If quiz_id is not set in the form data, redirect back to the page with an error message
    echo "<script>window.location.href = 'add_lessons.php?error=Quiz ID not provided';</script>";
}

?>
