<?php
include('../connections/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['lesson_id']) && isset($_POST['course_id'])) {
        $lesson_id = $_POST['lesson_id'];
        $course_id = $_POST['course_id'];

        if(isset($_FILES['image'])) {
            $file_name = $_FILES['image']['name'];
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_path = "uploads/img/" . $file_name;

            if(move_uploaded_file($file_tmp, $file_path)) {
                $description = $_POST['description'];

                // Insert into images table
                $stmt = $db->prepare("INSERT INTO images (lesson_id, filename, file_path, description) VALUES (:lesson_id, :filename, :file_path, :description)");
                $stmt->bindParam(':lesson_id', $lesson_id);
                $stmt->bindParam(':filename', $file_name);
                $stmt->bindParam(':file_path', $file_path);
                $stmt->bindParam(':description', $description);

                if ($stmt->execute()) {
                    // Get the image_id of the newly inserted image
                    $img_id = $db->lastInsertId();

                    // Insert into add_topic table
                    $stmt_add_topic = $db->prepare("INSERT INTO add_topic (lesson_id, img_id) VALUES (:lesson_id, :img_id)");
                    $stmt_add_topic->bindParam(':lesson_id', $lesson_id);
                    $stmt_add_topic->bindParam(':img_id', $img_id); // เปลี่ยน $image_id เป็น $img_id
                    if ($stmt_add_topic->execute()) {
                        echo "<script>alert('อัปโหลดรูปภาพและบันทึกข้อมูลสำเร็จ');</script>";
                        echo "<script>window.location.href = 'add_lessons.php?course_id=" . (isset($course_id) ? $course_id : '') . "';</script>";
                    } else {
                        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูลลงในตาราง add_topic: " . $stmt_add_topic->errorInfo()[2];
                    }
                    
                } else {
                    echo "เกิดข้อผิดพลาดในการบันทึกข้อมูลลงในตาราง images: " . $stmt->errorInfo()[2];
                }
            } else {
                echo "เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ";
            }
        } else {
            echo "รูปภาพไม่ถูกส่งมา";
        }
    } else {
        echo "ข้อมูล lesson_id หรือ course_id ไม่ถูกส่งมา";
    }
} else {
    echo "Invalid request method.";
    exit();
}
?>
