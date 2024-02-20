<?php
include('../connections/connection.php');
// ตรวจสอบว่ามีการล็อกอินและมีบทบาทเป็น 'teacher' หรือไม่
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    // ถ้าไม่ได้ล็อกอินหรือบทบาทไม่ใช่ 'teacher' ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหรือหน้าที่คุณต้องการ
    header('Location: login.php'); 
    exit();
}
// ตรวจสอบว่ามีข้อมูล $teacher หรือไม่
if (!empty($_SESSION['teacher_id'])) {
    $teacher_id = $_SESSION['teacher_id'];

    try {
        // ทำคำสั่ง SQL เพื่อดึงข้อมูลของครู
        $stmt = $db->prepare("SELECT * FROM teachers WHERE teacher_id = :teacher_id");
        $stmt->bindParam(':teacher_id', $teacher_id);
        $stmt->execute();

        // ดึงข้อมูลจากผลลัพธ์ของคำสั่ง SQL
        $teacher = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // แสดงข้อผิดพลาด
        echo "Error: " . $e->getMessage();
        exit(); // จบการทำงานถ้าพบข้อผิดพลาด
    }
}
try {
    // ทำคำสั่ง SQL เพื่อดึงข้อมูลของผู้ใช้ที่ล็อกอิน
    $user_id = $_SESSION['user_id'];
    $stmt = $db->prepare("SELECT * FROM teachers WHERE t_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    
    // ดึงข้อมูลจากผลลัพธ์ของคำสั่ง SQL
    $teacher = $stmt->fetch(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // แสดงข้อผิดพลาด
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
}
?>