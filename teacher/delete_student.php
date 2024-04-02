<?php
// เชื่อมต่อกับฐานข้อมูล
include('../connections/connection.php');

// ตรวจสอบการล็อกอินและบทบาทของผู้ใช้
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header('Location: ../login.php'); 
    exit();
}

// ตรวจสอบว่ามีข้อมูล student_id และ course_id ที่ส่งมาหรือไม่
if (isset($_GET['student_id']) && isset($_GET['course_id'])) {
    $student_id = $_GET['student_id'];
    $course_id = $_GET['course_id'];

    try {
        // ลบรายการที่มี student_id และ course_id ตรงกันออกจากตาราง student_course_registration
        $stmt = $db->prepare("DELETE FROM student_course_registration WHERE student_id = ? AND course_id = ?");
        $stmt->execute([$student_id, $course_id]);
        
        // ลบเสร็จสิ้น กลับไปยังหน้าที่แสดงรายชื่อนักเรียนในคอร์ส
        header("Location: manage_members.php?course_id=$course_id");
        exit();
    } catch (PDOException $e) {
        // หากเกิดข้อผิดพลาดในการลบ แสดงข้อความผิดพลาด
        echo "เกิดข้อผิดพลาดในการลบ: " . $e->getMessage();
    }
} else {
    // หากไม่มี student_id หรือ course_id ที่ส่งมา ให้กลับไปยังหน้าหลัก
    header('Location: index.php');
    exit();
}
?>
