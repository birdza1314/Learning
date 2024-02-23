<?php
// Include database connection
include('../connections/connection.php');

// Check if question_id is set and not empty
if (isset($_POST['question_id']) && !empty($_POST['question_id'])) {
    // Sanitize question_id to prevent SQL injection
    $questionId = $_POST['question_id'];

    // Prepare SQL statement to delete the question from the database
    $stmt = $db->prepare("DELETE FROM questions WHERE question_id = ?");
    
    // Execute the statement with the question_id parameter
    if ($stmt->execute([$questionId])) {
        // If deletion is successful, return success message
        $response = array('message' => 'Question deleted successfully.');
        echo json_encode($response); // Make sure to return the response as JSON
    } else {
        // If deletion fails, return error message
        $response = array('message' => 'Failed to delete question.');
        echo json_encode($response); // Make sure to return the response as JSON
    }
} else {
    // If question_id is not set or empty, return error message
    $response = array('message' => 'Invalid question ID.');
    echo json_encode($response); // Make sure to return the response as JSON
}
?>
