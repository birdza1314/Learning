<?php
include('../connections/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $assignment_id = $_POST['assignment_id'];

    // Delete assignment from the assignments table
    $stmt_delete_assignment = $db->prepare("DELETE FROM assignments WHERE assignment_id = :assignment_id");
    $stmt_delete_assignment->bindParam(':assignment_id', $assignment_id);
    $stmt_delete_assignment->execute();

    // Delete assignment from the topics table
    $stmt_delete_topic = $db->prepare("DELETE FROM topics WHERE assignment_id = :assignment_id");
    $stmt_delete_topic->bindParam(':assignment_id', $assignment_id);
    $stmt_delete_topic->execute();

    // Check if the assignment was successfully deleted
    if ($stmt_delete_assignment->rowCount() > 0 && $stmt_delete_topic->rowCount() > 0) {
        // Return success message or any other relevant data
        echo "Assignment and related topics deleted successfully";
    } else {
        // Return error message or handle the situation as needed
        echo "Failed to delete assignment and related topics";
    }
} else {
    // Handle invalid request method
    echo "Invalid request method";
}
?>
