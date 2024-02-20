<?php
include('../connections/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['teacherId'])) {
    try {
        $teacherId = $_POST['teacherId'];

        $stmt = $db->prepare("SELECT filename FROM teachers_images WHERE teacher_id = :teacher_id");
        $stmt->bindParam(':teacher_id', $teacherId);
        $stmt->execute();

        // ตรวจสอบว่ามีข้อมูลรูปหรือไม่
        if ($stmt->rowCount() > 0) {
            $imageData = $stmt->fetch(PDO::FETCH_ASSOC);

            // ส่งรูปภาพกลับในรูปแบบ JSON
            header('Content-Type: application/json');
            echo json_encode($imageData);
        } else {
            // ถ้าไม่มีข้อมูลรูป
            header('HTTP/1.1 404 Not Found');
            echo json_encode(['error' => 'Image not found']);
        }
    } catch (Exception $e) {
        // หากเกิดข้อผิดพลาด
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Internal Server Error']);
    }
} else {
    // หากไม่มีข้อมูลที่ต้องการ
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Bad Request']);
}
?>
