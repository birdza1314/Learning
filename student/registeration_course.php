<?php
include('../connections/connection.php');
session_start();

// ตรวจสอบว่ามีการล็อกอินและมีบทบาทเป็น 'student' หรือไม่
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header('Location: ../login.php');
    exit();
}

// ตรวจสอบว่ามี course_id ที่ถูกต้องหรือไม่
if (!isset($_GET['course_id'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$course_id = $_GET['course_id'];

// ตรวจสอบการส่งรหัสลงทะเบียน
if (!isset($_POST['access_code'])) {
    echo "กรุณากรอกรหัสลงทะเบียน";
    exit();
}

$access_code = $_POST['access_code'];

try {
    // เรียกข้อมูลของคอร์สจากฐานข้อมูล
    $stmt = $db->prepare("SELECT * FROM courses WHERE c_id = :course_id AND access_code = :access_code");
    $stmt->bindParam(':course_id', $course_id);
    $stmt->bindParam(':access_code', $access_code);
    $stmt->execute();
    $course = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($course) {
        // ตรวจสอบก่อนว่ามีการลงทะเบียนแล้วหรือไม่
        $stmt = $db->prepare("SELECT * FROM student_course_registration WHERE student_id = :student_id AND course_id = :course_id");
        $stmt->bindParam(':student_id', $user_id);
        $stmt->bindParam(':course_id', $course_id);
        $stmt->execute();
        $registration = $stmt->fetch(PDO::FETCH_ASSOC);

        // ถ้ามีการลงทะเบียนแล้วให้กลับไปยังหน้า my_course.php ด้วยข้อความที่บอกว่าได้ลงทะเบียนแล้ว
        if ($registration) {
            header('Location: my_course.php');
            exit();
        }

        // หากยังไม่ได้ลงทะเบียน ให้ทำการเพิ่มข้อมูลลงในตาราง student_course_registration
        $stmt = $db->prepare("INSERT INTO student_course_registration (student_id, course_id, registration_date) VALUES (:student_id, :course_id, NOW())");
        $stmt->bindParam(':student_id', $user_id);
        $stmt->bindParam(':course_id', $course_id);
        $stmt->execute();

        // เมื่อลงทะเบียนสำเร็จให้แสดงข้อความแจ้งเตือนและกลับไปยังหน้า my_course.php
        echo "<script>alert('ลงทะเบียนเรียนสำเร็จ');</script>";
        header('Location: course_details.php?course_id=' . $course_id);
        exit();
    } else {
        // ถ้ารหัสลงทะเบียนไม่ถูกต้อง
        echo "<script>alert('รหัสลงทะเบียนไม่ถูกต้อง');</script>";
        echo "<script>window.history.back();</script>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>
