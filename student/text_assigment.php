<?php
include('../connections/connection.php');
session_start();

// ตรวจสอบการเข้าสู่ระบบและบทบาทของผู้ใช้ว่าเป็นนักเรียนหรือไม่
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header('Location: ../login');
    exit();
}

// ตรวจสอบว่ามีการส่งค่า assignment_id และ description มาหรือไม่
if (!isset($_POST['assignment_id']) || !isset($_POST['description'])) {
    echo "Assignment ID or Description is missing.";
    exit();
}

$user_id = $_SESSION['user_id'];
$assignment_id = $_POST['assignment_id'];
$description = $_POST['description'];

// บันทึกข้อมูลการอัปโหลดลงในฐานข้อมูล
$stmt = $db->prepare("INSERT INTO submitted_assignments (student_id, assignment_id, description, submitted_datetime) VALUES (:student_id, :assignment_id, :description, NOW())");
$stmt->bindParam(':student_id', $user_id);
$stmt->bindParam(':assignment_id', $assignment_id);
$stmt->bindParam(':description', $description);

if ($stmt->execute()) {
    // แสดงข้อความเมื่อบันทึกสำเร็จ
    echo "Description has been submitted successfully.";
} else {
    // แสดงข้อความเมื่อมีข้อผิดพลาดในการบันทึก
    echo "Error submitting description.";
}
?>
                            <!-- เพิ่ม textarea สำหรับให้ผู้ใช้พิมพ์ข้อความ -->
                            <div class="form-group">
                                    <label for="description">ข้อความ:</label>
                                    <textarea class="form-control quill-editor-full" id="description" name="description" rows="3"></textarea>
                                </div>
                                
        