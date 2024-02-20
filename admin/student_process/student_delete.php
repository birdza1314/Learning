<?php
session_start();

include('../../connections/connection.php'); // นำเข้าไฟล์การเชื่อมต่อ PDO

try {
    $s_id = $_GET['s_id']; // รับค่า s_id จาก URL

    // สร้างคำสั่ง SQL สำหรับการลบ
    $sql = "DELETE FROM students WHERE s_id = :s_id";
    
    // เตรียมและประมวลผลคำสั่ง SQL ด้วย PDO
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':s_id', $s_id, PDO::PARAM_INT); // ผูกค่า s_id เพื่อป้องกัน SQL injection
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "ลบข้อมูลเรียบร้อยแล้ว";
    } else {
        $_SESSION['error'] = "ไม่สามารถลบข้อมูลได้ ลองใหม่อีกครั้ง";
    }

    // ส่งกลับไปยัง homepage.php
    header('Location: ../student_data.php');
    exit;

} catch (PDOException $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
    header('Location: ../student_data.php');
    exit;
}
?>
