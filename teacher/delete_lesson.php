<?php
// Include database connection
include('../connections/connection.php');

// Check if lesson_id is set
if(isset($_POST['lesson_id'])) {
    $lesson_id = $_POST['lesson_id'];

    try {
        // Prepare SQL statement to delete the lesson
        $stmt = $db->prepare("DELETE FROM lessons WHERE lesson_id = :lesson_id");
        $stmt->bindParam(':lesson_id', $lesson_id);
        $stmt->execute();

        // Check if any rows were affected
        if($stmt->rowCount() > 0) {
            // If successful, return success message
            echo "Lesson deleted successfully!";
        } else {
            // If no rows were affected, return error message
            echo "No lesson found with the given ID!";
        }
    } catch (PDOException $e) {
        // Display an error message if something goes wrong
        echo "Error: " . $e->getMessage();
    }
} else {
    // If lesson_id is not set, return error message
    echo "Lesson ID is not provided!";
}
?>
