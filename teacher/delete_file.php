<?php
// Include database connection
include('../connections/connection.php');

// Check if file_id is set
if(isset($_POST['file_id'])) {
    $file_id = $_POST['file_id'];

    try {
        // Prepare SQL statement to delete the quiz
        $stmt = $db->prepare("DELETE FROM files WHERE file_id = :file_id");
        $stmt->bindParam(':file_id', $file_id);
        $stmt->execute();

        // Check if any rows were affected
        if($stmt->rowCount() > 0) {
            // If successful, return success message
            echo "Quiz deleted successfully!";
        } else {
            // If no rows were affected, return error message
            echo "No quiz found with the given ID!";
        }
    } catch (PDOException $e) {
        // Display an error message if something goes wrong
        echo "Error: " . $e->getMessage();
    }
} else {
    // If file_id is not set, return error message
    echo "Quiz ID is not provided!";
}

// Redirect back to add_lessons.php with course_id
if(isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'];
    // Redirect back to add_lessons.php with course_id parameter
    echo "<script>window.location.href = 'add_lessons?course_id=$course_id';</script>";
} else {
    echo "<script>window.location.href = 'add_lessons';</script>";
}
?>
