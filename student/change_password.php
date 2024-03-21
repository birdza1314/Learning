<?php
// เรียกใช้งาน session
session_start();

// เชื่อมต่อกับฐานข้อมูล
include('../connections/connection.php');

// ตรวจสอบการล็อกอิน
if (!isset($_SESSION['user_id'])) {
    // ถ้าไม่ได้ล็อกอิน ให้เปลี่ยนเส้นทางไปยังหน้าล็อกอิน
    header('Location: login.php');
    exit();
}

// รับค่ารหัสผ่านใหม่
$newPassword = $_POST['newpassword'];

// ตรวจสอบว่ามีการส่งรหัสผ่านใหม่หรือไม่
if (empty($newPassword)) {
    // ถ้าไม่มี ให้เปลี่ยนเส้นทางไปยังหน้าแก้ไขโปรไฟล์พร้อมกับข้อความแจ้งเตือน
    header('Location:profile.php?error=1');
    exit();
}

// เข้ารหัสรหัสผ่านใหม่
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

// อัปเดตรหัสผ่านใหม่ในฐานข้อมูล
$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("UPDATE students SET password = :password WHERE s_id = :user_id");
$stmt->bindParam(':password', $hashedPassword);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();

// เปลี่ยนเส้นทางไปยังหน้าโปรไฟล์พร้อมกับข้อความแจ้งเตือน
echo '<script>alert("อัพเดทข้อมูลสำเร็จ"); window.location.href = "profile.php?success=1";</script>';
exit();
?>
