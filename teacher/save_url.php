<?php
// Include database connection
include('../connections/connection.php');

// Check if it's a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if course_id is set
    if (isset($_POST['course_id'])) {
        $course_id = $_POST['course_id'];

        // Check if lesson_id is set
        if (isset($_POST['lesson_id'])) {
            $lesson_id = $_POST['lesson_id'];

            // Check if url_description is set
            if (isset($_POST['url_description'])) {
                $url_description = $_POST['url_description'];

                // Check if url is set
                if (isset($_POST['url'])) {
                    $url = $_POST['url'];

                    // **เพิ่มการตรวจสอบว่า lesson_id มีอยู่ในตาราง lessons หรือไม่**
                    $stmt_check_lesson = $db->prepare("SELECT * FROM lessons WHERE lesson_id = :lesson_id");
                    $stmt_check_lesson->bindParam(':lesson_id', $lesson_id, PDO::PARAM_INT);
                    $stmt_check_lesson->execute();

                    if ($stmt_check_lesson->rowCount() === 0) {
                        echo "<script>alert('Lesson ID ไม่ถูกต้อง');</script>";
                        exit();
                    }

                    // Prepare SQL statement to insert URL data into database
                    $stmt = $db->prepare("INSERT INTO urls (lesson_id, url, description) VALUES (:lesson_id, :url, :description)");
                    $stmt->bindParam(':lesson_id', $lesson_id);
                    $stmt->bindParam(':url', $url);
                    $stmt->bindParam(':description', $url_description);

                    // Execute SQL statement to insert URL
                    if ($stmt->execute()) {
                        // Get the last inserted URL ID
                        $last_url_id = $db->lastInsertId();

                        // Prepare SQL statement to insert data into add_topic table
                        $stmt_add_topic = $db->prepare("INSERT INTO add_topic (lesson_id, url_id) VALUES (:lesson_id, :url_id)");
                        $stmt_add_topic->bindParam(':lesson_id', $lesson_id);
                        $stmt_add_topic->bindParam(':url_id', $last_url_id);

                        // Execute SQL statement to insert data into add_topic table
                        if ($stmt_add_topic->execute()) {
                            echo "<script>alert('บันทึกข้อมูลเสร็จสิ้น');</script>";
                            echo "<script>window.location.href = 'add_lessons.php?course_id=$course_id';</script>";
                        } else {
                            echo "บันทึกข้อมูลลงในตาราง add_topic ล้มเหลว: " . $stmt_add_topic->errorInfo()[2];
                            exit();
                        }
                    } else {
                        echo "Error: เกิดข้อผิดพลาดในการบันทึกข้อมูล URL";
                        exit();
                    }
                } else {
                    echo "URL is required.";
                    exit();
                }
            } else {
                echo "Description is required.";
                exit();
            }
        } else {
            echo "Lesson ID is required.";
            exit();
        }
    } else {
        echo "Course ID is required.";
        exit();
    }
} else {
    echo "Invalid request method.";
    exit();
}
?>
