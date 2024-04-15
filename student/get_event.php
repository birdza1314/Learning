<?php
// เชื่อมต่อกับฐานข้อมูล
include('../connections/connection.php');

// ตรวจสอบว่ามีการล็อกอินและมีบทบาทเป็น 'student' หรือไม่
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    // ถ้าไม่ได้ล็อกอินหรือบทบาทไม่ใช่ 'student' ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหรือหน้าที่คุณต้องการ
    header('Location: ../login.php'); 
    exit();
}

try {
    // ทำคำสั่ง SQL เพื่อดึงข้อมูลของผู้ใช้ที่ล็อกอิน
    $user_id = $_SESSION['user_id'];
    $stmt = $db->prepare("SELECT * FROM students WHERE s_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    
    // ดึงข้อมูลจากผลลัพธ์ของคำสั่ง SQL
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // แสดงข้อผิดพลาด
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
}

// Function สำหรับดึงข้อมูลกิจกรรมจากฐานข้อมูล
function getAssignments() {
    include('../connections/connection.php');
    try {
        // Get the user ID of the logged-in student
        $student_id = $_SESSION['user_id'];

        // Retrieve the courses that the student is registered for
        $stmt_courses = $db->prepare("SELECT course_id FROM student_course_registration WHERE student_id = :student_id");
        $stmt_courses->bindParam(':student_id', $student_id);
        $stmt_courses->execute();
        $registered_courses = $stmt_courses->fetchAll(PDO::FETCH_COLUMN);

        // If the student is not registered for any courses, return an empty array
        if (empty($registered_courses)) {
            return [];
        }

        // Prepare SQL query to fetch assignments for registered courses that are open
        $stmt = $db->prepare("SELECT a.assignment_id, a.title, a.open_time, a.close_time, a.course_id
                              FROM assignments a 
                              INNER JOIN courses c ON a.course_id = c.c_id
                              WHERE c.c_id IN (".implode(',', $registered_courses).") AND c.is_open = 1");
        $stmt->execute();
        
        $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $assignments;
    } catch (PDOException $e) {
        echo "เกิดข้อผิดพลาด: " . $e->getMessage();
    }
}


// เรียกใช้งานฟังก์ชันเพื่อดึงข้อมูลกิจกรรม
$assignments = getAssignments();
// แสดงผลข้อมูลเป็น JSON
header('Content-Type: application/json');
echo json_encode($assignments);
?>
