<?php
// Include เพื่อเชื่อมต่อกับฐานข้อมูล
include('../connections/connection.php');

// ตรวจสอบว่ามีค่า studentId ที่ส่งมาหรือไม่
if(isset($_GET['studentId'])) {
    $studentId = $_GET['studentId'];

    // เขียน SQL query เพื่อดึงข้อมูลนักเรียนจากฐานข้อมูล
    $stmt = $db->prepare("SELECT * FROM students WHERE s_id = :studentId");
    $stmt->bindParam(':studentId', $studentId);
    $stmt->execute();

    // Fetch ข้อมูลเป็น associative array
    $studentData = $stmt->fetch(PDO::FETCH_ASSOC);

    // ส่งข้อมูลในรูปแบบ JSON
    header('Content-Type: application/json');
    echo json_encode($studentData);
} else {
    // ถ้าไม่มี studentId ส่งมา
    echo 'Invalid Request';
}
?>
