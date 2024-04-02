<?php
include('../connections/connection.php');
session_start();

// ตรวจสอบว่ามีการล็อกอินและมีบทบาทเป็น 'teacher' หรือไม่
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    // ถ้าไม่ได้ล็อกอินหรือบทบาทไม่ใช่ 'teacher' ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหรือหน้าที่คุณต้องการ
    header('Location: ../login.php');
    exit();
}

// ตรวจสอบว่ามีข้อมูลที่ส่งมาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['course_id'])) {
    // เชื่อมต่อกับฐานข้อมูล
    include('../connections/connection.php');

    // ดึง user_id จาก session
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

    // ดึง course_id จากข้อมูลที่ส่งมา
    $course_id = $_GET['course_id'];

    // ตรวจสอบว่าครูที่ล็อกอินมีสิทธิ์ลบคอร์สนี้หรือไม่
    $stmt = $db->prepare("SELECT * FROM courses WHERE c_id = ? AND teacher_id = ?");
    $stmt->execute([$course_id, $user_id]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($course) {
        // ถ้าครูที่ล็อกอินมีสิทธิ์ลบคอร์สนี้
        // ทำการลบคอร์ส
        $delete_stmt = $db->prepare("DELETE FROM courses WHERE c_id = ?");
        $delete_stmt->execute([$course_id]);

        // ปิดการเชื่อมต่อฐานข้อมูล
        $db = null;

        // ทำสิ่งที่คุณต้องการหลังจากลบข้อมูล
        echo "<script>alert('ลบคอร์สสำเร็จ'); window.location.href = 'course.php?success=true';</script>";
    } else {
        // ถ้าครูที่ล็อกอินไม่มีสิทธิ์ลบคอร์สนี้
        echo "<script>alert('คุณไม่มีสิทธิ์ลบคอร์สนี้'); window.location.href = 'course.php';</script>";
    }
} else {
    echo "Missing required fields.";
}
?>
