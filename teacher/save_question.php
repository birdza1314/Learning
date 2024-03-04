<?php
// Include database connection
include('../connections/connection.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $quiz_id = $_POST['quiz_id'];
    $questionText = $_POST['questionText'];
    $choice1 = $_POST['choice1'];
    $choice2 = $_POST['choice2'];
    $choice3 = $_POST['choice3'];
    $choice4 = $_POST['choice4'];
    $correctAnswer = $_POST['correctAnswer'];

    // Prepare SQL statement to check if quiz_id exists in quizzes table
    $stmt_check = $db->prepare("SELECT * FROM quizzes WHERE quiz_id = ?");
    $stmt_check->execute([$quiz_id]);
    $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

    // Check if quiz_id exists in quizzes table
    if($result) {
        // Prepare SQL statement to insert new question into the database
        $stmt_insert = $db->prepare("INSERT INTO questions (quiz_id, question_text, choice_ch1, choice_ch2, choice_ch3, choice_ch4, correct_answer) VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        // Assign values to parameters and execute the statement
        $stmt_insert->execute([$quiz_id, $questionText, $choice1, $choice2, $choice3, $choice4, $correctAnswer]);
        
        // Redirect back to the page with a success message
        echo "<script>window.history.back();</script>";
        exit();
    } else {
        // If quiz_id does not exist in quizzes table, redirect back to the page with an error message
        echo "<script>window.history.back();</script>";
        exit();
    }
} else {
    // If form is not submitted, redirect back to the page with an error message
    header("Location: edit_quiz.php?error=Form submission error");
    exit();
}
?>
