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
    $open_time = $_POST['open_time'];
    $close_time = $_POST['close_time'];
    $status = $_POST['status'];
// ตรวจสอบเงื่อนไขว่ามีการอัปโหลดไฟล์หรือไม่
if (isset($_FILES['file_path']) && $_FILES['file_path']['name'] != "") {
    $file_name = $_FILES['file_path']['name']; // ดึงชื่อไฟล์จริง
    $temp_name = $_FILES['file_path']['tmp_name']; // ดึงชื่อไฟล์ชั่วคราว
    $file_path = "uploads/ass/" . $file_name; // กำหนดที่อยู่ของไฟล์

    // ย้ายไฟล์ไปยังโฟลเดอร์ปลายทาง
    if (move_uploaded_file($temp_name, $file_path)) {
        // ถ้ามีการอัปโหลดไฟล์เรียบร้อยแล้ว
       
    } else {
        // ถ้ามีปัญหาในการอัปโหลดไฟล์
        echo "<script>alert('มีปัญหาในการอัปโหลดไฟล์');</script>";
        echo "<script>window.history.back();</script>";
    }
} else {
    // หากไม่มีการอัปโหลดไฟล์ กำหนดค่าเป็นค่าว่าง
    $file_path = ""; 
    $file_name = ""; 
}

// เพิ่ม Assignment ใหม่
$sql = "INSERT INTO assignments (lesson_id, course_id, title, description, deadline, file_path, file_name, open_time, close_time, status) VALUES (:lesson_id, :course_id, :title, :description, :deadline, :file_path, :file_name, :open_time, :close_time, :status)";
$stmt = $db->prepare($sql);
$stmt->bindParam(':lesson_id', $lesson_id);
$stmt->bindParam(':course_id', $course_id); // เพิ่มบรรทัดนี้เพื่อรับค่า course_id จาก URL
$stmt->bindParam(':title', $title);
$stmt->bindParam(':description', $description);
$stmt->bindParam(':deadline', $deadline);
$stmt->bindParam(':file_path', $file_path);
$stmt->bindParam(':file_name', $file_name);
$stmt->bindParam(':open_time', $open_time);
$stmt->bindParam(':close_time', $close_time);
$stmt->bindParam(':status', $status);




    if ($stmt->execute()) {
        $assignment_id = $db->lastInsertId(); // รับค่า ID ของ Assignment ที่เพิ่มล่าสุด

    // เพิ่มข้อมูลลงในตาราง add_topic
$sql_add_topic = "INSERT INTO add_topic (lesson_id, assignment_id, topic_type) VALUES (:lesson_id, :assignment_id, :topic_type)";
$stmt_add_topic = $db->prepare($sql_add_topic);
$stmt_add_topic->bindParam(':lesson_id', $lesson_id);
$stmt_add_topic->bindParam(':assignment_id', $assignment_id);
$stmt_add_topic->bindParam(':topic_type', $topic_type); // ประกาศ $topic_type ก่อนการใช้งานและกำหนดค่าของมัน

// ตรวจสอบว่า $topic_type ถูกกำหนดค่าไว้ก่อนการใช้งานหรือไม่
$topic_type = 'แบบฝึกหัด';

if ($stmt_add_topic->execute()) {
    // แสดงข้อความแจ้งเตือนเมื่อเพิ่มข้อมูลสำเร็จ
    echo "<script>alert('เพิ่ม Assignment ใหม่เรียบร้อยแล้ว');</script>";
    echo "<script>window.history.back();</script>";
} else {
    // แสดงข้อความผิดพลาดเมื่อไม่สามารถเพิ่มข้อมูลได้
    echo "<script>alert('เกิดข้อผิดพลาดในการบันทึกข้อมูลลงในตาราง add_topic: ');</script>" . $stmt_add_topic->errorInfo()[2];
}
    } else {
        // แสดงข้อผิดพลาดในการบันทึกข้อมูลลงในตาราง assignments
        echo "<script>alert('เกิดข้อผิดพลาดในการบันทึกข้อมูลลงในตาราง assignments:');</script> " . $stmt->errorInfo()[2];
    }
}

?>