<?php
include('../connections/connection.php');

// Check if course_id and lesson_name are set in the POST request
if(isset($_POST['course_id']) && isset($_POST['lesson_name'])) {
    // Retrieve course_id and lesson_name from POST data
    $course_id = $_POST['course_id'];
    $lesson_name = $_POST['lesson_name'];

    try {
        // Prepare SQL statement to insert lesson data into the database
        $stmt = $db->prepare("INSERT INTO lessons (course_id, lesson_name) VALUES (:course_id, :lesson_name)");
        $stmt->bindParam(':course_id', $course_id);
        $stmt->bindParam(':lesson_name', $lesson_name);
        $stmt->execute();

        // Return success message if insertion is successful
        echo "Lesson inserted successfully!";
    } catch (PDOException $e) {
        // Return error message if something goes wrong
        echo "Error inserting lesson: " . $e->getMessage();
    }
} else {
    // Return error message if course_id or lesson_name are not set in the POST request
    echo "Error: course_id or lesson_name not set!";
}
?>
