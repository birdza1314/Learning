<?php
include('../connections/connection.php');
session_start();

// ตรวจสอบว่ามีการล็อกอินและมีบทบาทเป็น 'student' หรือไม่
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit();
}

// ตรวจสอบว่ามี course_id ที่ถูกต้องหรือไม่
if (!isset($_GET['course_id'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$course_id = $_GET['course_id'];

try {
    // ตรวจสอบการลงทะเบียนของนักเรียนในวิชานี้
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

    echo "<script>alert('ลงทะเบียนเรียนสำเร็จ');</script>";
    header('Location: course_details.php?course_id=' . $course_id);
    exit();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>
