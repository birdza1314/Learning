<?php
// เชื่อมต่อกับฐานข้อมูล
include('../connections/connection.php');

// คำสั่ง SQL สำหรับดึงข้อมูลจำนวนผู้เรียนที่สำเร็จในแต่ละวิชา
$sql = "SELECT course_id, COUNT(*) AS total_marks_done FROM marks_as_done GROUP BY course_id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$marks_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ส่งข้อมูลเป็น JSON กลับ
header('Content-Type: application/json');
echo json_encode($marks_data);
?>
