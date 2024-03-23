<?php
// Include connection file
include('../connections/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if data is received
    if (isset($_POST['existing_course']) && isset($_POST['new_course_name'])) {
        $existing_course_id = $_POST['existing_course'];
        $new_course_name = $_POST['new_course_name'];

        try {
            // Fetch original course data
            $stmt = $db->prepare("SELECT * FROM courses WHERE c_id = :existing_course_id");
            $stmt->bindParam(':existing_course_id', $existing_course_id);
            $stmt->execute();
            $original_course = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if original course data is found
            if ($original_course) {
                // Insert new course data based on original course
                $stmt = $db->prepare("INSERT INTO courses (course_name, description, teacher_id) VALUES (:course_name, :description, :teacher_id)");
                $stmt->bindParam(':course_name', $new_course_name);
                $stmt->bindParam(':description', $original_course['description']);
                $stmt->bindValue(':teacher_id', $original_course['teacher_id']);
                $stmt->execute();
                

                // Redirect with success message
                header("Location: success.php");
                exit();
            } else {
                // Handle error: Original course not found
                echo "Error: Original course not found.";
            }
        } catch (PDOException $e) {
            // Handle database error
            echo "Database error: " . $e->getMessage();
        }
    } else {
        // Handle missing data error
        echo "Error: Missing data.";
    }
} else {
    // Handle invalid request method error
    echo "Error: Invalid request method.";
}
?>
