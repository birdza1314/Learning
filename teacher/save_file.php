<?php
include('../connections/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['lesson_id']) && isset($_POST['course_id'])) {
        $lesson_id = $_POST['lesson_id'];
        $course_id = $_POST['course_id'];

        if(isset($_FILES['file'])) {
            $file_name = $_FILES['file']['name'];
            $file_tmp = $_FILES['file']['tmp_name'];
            $file_path = "uploads/files/" . $file_name;

            if(move_uploaded_file($file_tmp, $file_path)) {
                $description = $_POST['description'];

                $stmt = $db->prepare("INSERT INTO files (lesson_id, file_name, file_path, description) VALUES (:lesson_id, :file_name, :file_path, :description)");
                $stmt->bindParam(':lesson_id', $lesson_id);
                $stmt->bindParam(':file_name', $file_name);
                $stmt->bindParam(':file_path', $file_path);
                $stmt->bindParam(':description', $description);

                if ($stmt->execute()) {
                    $file_id = $db->lastInsertId();

                    $stmt_add_topic = $db->prepare("INSERT INTO add_topic (lesson_id, file_id) VALUES (:lesson_id, :file_id)");
                    $stmt_add_topic->bindParam(':lesson_id', $lesson_id);
                    $stmt_add_topic->bindParam(':file_id', $file_id);

                    if ($stmt_add_topic->execute()) {
                        echo "<script>alert('อัปโหลดไฟล์และบันทึกข้อมูลสำเร็จ');</script>";
                        echo "<script>window.location.href = 'add_lessons.php?course_id=$course_id';</script>";
                    } else {
                        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูลลงในตาราง add_topic: " . $stmt_add_topic->errorInfo()[2];
                    }
                } else {
                    echo "เกิดข้อผิดพลาดในการบันทึกข้อมูลลงในตาราง files: " . $stmt->errorInfo()[2];
                }
            } else {
                echo "เกิดข้อผิดพลาดในการอัปโหลดไฟล์";
            }
        } else {
            echo "ไฟล์ไม่ถูกส่งมา";
        }
    } else {
        echo "ข้อมูล lesson_id หรือ course_id ไม่ถูกส่งมา";
    }
} else {
    echo "Invalid request method.";
    exit();
}
?>
