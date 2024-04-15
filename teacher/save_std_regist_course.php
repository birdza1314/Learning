<?php
// Include database connection
include('../connections/connection.php');

// รับค่าจาก POST
$student_id = $_POST['student_id'];
$course_id = $_POST['course_id'];
$classes = $_POST['classes'];
$classroom = $_POST['classroom'];


try {
    // เขียนข้อมูลลงฐานข้อมูลโดยใช้ PDO
    $stmt = $db->prepare("INSERT INTO student_course_registration (student_id,course_id, classes, classroom ) VALUES (:student_id,:course_id, :classes, :classroom)");
    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':course_id', $course_id);
    $stmt->bindParam(':classes', $classes);
    $stmt->bindParam(':classroom', $classroom);
 
    
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
} catch (PDOException $e) {
    // ประมวลผลข้อผิดพลาด
    echo "Error: " . $e->getMessage();
}

// ปิดการเชื่อมต่อฐานข้อมูล (ไม่จำเป็นต้องใช้ใน PDO)
// mysqli_close($db);
?>
