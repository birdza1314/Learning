<?php
// get_teacher_data.php
include('../connections/connection.php');

if (isset($_POST['teacherId'])) {
    $teacherId = $_POST['teacherId'];

    // ดึงข้อมูลจากฐานข้อมูล
    $stmt = $db->prepare("SELECT * FROM teachers WHERE t_id = ?");
    $stmt->execute([$teacherId]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    // ส่งข้อมูลเป็น JSON ไปยัง AJAX
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    // ถ้าไม่ได้รับ teacherId หรือไม่ถูกต้อง
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
}
?>
