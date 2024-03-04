<?php
include('../connections/connection.php');

// ตรวจสอบว่ามี Lesson ID และ Course ID ที่ถูกส่งมาหรือไม่
if (!isset($_GET['lesson_id']) || !isset($_GET['course_id'])) {
    echo "Lesson ID or Course ID not provided.";
    exit; // หยุดการทำงานของสคริปต์เพื่อป้องกันการดำเนินการต่อ
}

// ดึงข้อมูล Lesson จาก URL
$lesson_id = $_GET['lesson_id'];
$course_id = $_GET['course_id'];

// ตรวจสอบว่ามีการ submit ฟอร์มหรือไม่
if (isset($_POST['submit'])) {
    // ดึงข้อมูลจากฟอร์ม
    $title = $_POST['title'];
    $description = $_POST['description'];
    $deadline = $_POST['deadline'];
    $weight = $_POST['weight'];
    $open_time = $_POST['open_time'];
    $close_time = $_POST['close_time'];
    $status = $_POST['status'];

    // ตรวจสอบเงื่อนไขว่ามีการอัปโหลดไฟล์หรือไม่
    if (isset($_FILES['file_path']) && $_FILES['file_path']['name'] != "") {
        $file_path = $_FILES['file_path']['name'];
    } else {
        $file_path = ""; // กำหนดให้เป็นค่าว่างหากไม่มีไฟล์ถูกอัปโหลด
    }

    // เพิ่ม Assignment ใหม่
    $sql = "INSERT INTO assignments (lesson_id, title, description, deadline, file_path, weight, open_time, close_time, status) VALUES (:lesson_id, :title, :description, :deadline, :file_path, :weight, :open_time, :close_time, :status)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':lesson_id', $lesson_id);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':deadline', $deadline);
    $stmt->bindParam(':file_path', $file_path);
    $stmt->bindParam(':weight', $weight);
    $stmt->bindParam(':open_time', $open_time);
    $stmt->bindParam(':close_time', $close_time);
    $stmt->bindParam(':status', $status);

    if ($stmt->execute()) {
        $assignment_id = $db->lastInsertId(); // รับค่า ID ของ Assignment ที่เพิ่มล่าสุด

        // เพิ่มข้อมูลลงในตาราง add_topic
        $sql_add_topic = "INSERT INTO add_topic (lesson_id, assignment_id) VALUES (:lesson_id, :assignment_id)";
        $stmt_add_topic = $db->prepare($sql_add_topic);
        $stmt_add_topic->bindParam(':lesson_id', $lesson_id);
        $stmt_add_topic->bindParam(':assignment_id', $assignment_id);

        if ($stmt_add_topic->execute()) {
            // แสดงข้อความแจ้งเตือนเมื่อเพิ่มข้อมูลสำเร็จ
            echo "<script>alert('เพิ่ม Assignment ใหม่เรียบร้อยแล้ว');</script>";
            echo "<script>window.history.back();</script>";
        } else {
            // แสดงข้อความผิดพลาดเมื่อไม่สามารถเพิ่มข้อมูลได้
            echo "เกิดข้อผิดพลาดในการบันทึกข้อมูลลงในตาราง add_topic: " . $stmt_add_topic->errorInfo()[2];
        }
    } else {
        // แสดงข้อผิดพลาดในการบันทึกข้อมูลลงในตาราง assignments
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูลลงในตาราง assignments: " . $stmt->errorInfo()[2];
    }
}

?>