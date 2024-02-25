<?php
include('../connections/connection.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve assignment data from the form
    $assignment_id = $_POST['assignment_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $open_time = $_POST['open_time'];
    $deadline = $_POST['deadline'];
    $close_time = $_POST['close_time'];
    $status = $_POST['status'];

    try {
        // Prepare SQL statement to update assignment data
        $query = "UPDATE assignments SET title = :title, description = :description, open_time = :open_time, deadline = :deadline, close_time = :close_time, status = :status WHERE assignment_id = :assignment_id";
        $statement = $db->prepare($query);
        $statement->bindParam(':title', $title, PDO::PARAM_STR);
        $statement->bindParam(':description', $description, PDO::PARAM_STR);
        $statement->bindParam(':open_time', $open_time, PDO::PARAM_STR);
        $statement->bindParam(':deadline', $deadline, PDO::PARAM_STR);
        $statement->bindParam(':close_time', $close_time, PDO::PARAM_STR);
        $statement->bindParam(':status', $status, PDO::PARAM_STR);
        $statement->bindParam(':assignment_id', $assignment_id, PDO::PARAM_INT);
        $statement->execute();

        // Redirect back to edit_assignment.php with assignment_id parameter
        echo "<script>alert('Assignment updated successfully.'); window.location.href = localStorage.getItem('previousPageUrl'); </script>";
        exit; // Exit script
    } catch(PDOException $e) {
        // Handle database connection errors
        echo "Error: " . $e->getMessage();
        echo "<script>alert('An error occurred while updating assignment data.');</script>"; // Show JavaScript alert
        exit; // Exit script
    }
} else {
    // Handle case where form is not submitted
    echo "Form is not submitted.";
    echo "<script>alert('Form is not submitted.');</script>"; // Show JavaScript alert
    exit; // Exit script
}
?>
