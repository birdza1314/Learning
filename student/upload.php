<?php
include('../connections/connection.php');
session_start();

// ตรวจสอบการเข้าสู่ระบบและบทบาทของผู้ใช้ว่าเป็นนักเรียนหรือไม่
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT * FROM students WHERE s_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$student = $stmt->fetch(PDO::FETCH_ASSOC);

// ตรวจสอบว่ามีการส่งค่า assignment_id มาหรือไม่
if (!isset($_POST['assignment_id'])) {
    echo "Assignment ID is missing.";
    exit();
}

$assignment_id = $_POST['assignment_id'];

// ดึงรายละเอียดของการบ้านจากฐานข้อมูล
$stmt = $db->prepare("SELECT * FROM assignments WHERE assignment_id = :assignment_id");
$stmt->bindParam(':assignment_id', $assignment_id);
$stmt->execute();
$assignment = $stmt->fetch(PDO::FETCH_ASSOC);

// ตรวจสอบว่ามีการส่งการบ้านหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if(isset($_FILES['file'])) {
        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_path = "uploads/" . $file_name;

        // ตรวจสอบชนิดของไฟล์ที่อัปโหลด
        $imageFileType = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (!in_array($imageFileType, array("pdf", "doc", "docx", "ppt", "pptx", "txt", "jpg", "jpeg", "png", "gif", "xls", "xlsx", "csv"))) {
            echo "Sorry, only PDF, DOC, DOCX, PPT, PPTX, TXT, JPG, JPEG, PNG, GIF, XLS, XLSX, CSV files are allowed.";
            exit();
        }
        
        
        // ย้ายไฟล์ไปยังโฟลเดอร์ที่ต้องการ
        if (move_uploaded_file($file_tmp, $file_path)) {
            // บันทึกข้อมูลการส่งงานลงในฐานข้อมูล
            $stmt = $db->prepare("INSERT INTO submitted_assignments (student_id, assignment_id, submitted_file, submitted_datetime) VALUES (:student_id, :assignment_id, :submitted_file, NOW())");
            $stmt->bindParam(':student_id', $user_id);
            $stmt->bindParam(':assignment_id', $assignment_id);
            $stmt->bindParam(':submitted_file', $file_path);
            $stmt->bindParam(':submitted_file', $file_name);
            $stmt->execute();

            // แสดงแจ้งเตือนเมื่อบันทึกสำเร็จ
            echo "<script>alert('The file " . htmlspecialchars(basename($file_name)) . " บันทึกข้อมูลสำเร็จ.');</script>";
            // กลับไปยังหน้าเดิมหรือหน้าที่คุณต้องการ
            echo "<script>window.history.back(2);</script>";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "<script>alert('บันทึกข้อมูลสำเร็จ');</script>";
        echo "<script>window.location.href = 'status_assignment.php?assignment_id=" . $assignment_id . "';</script>";    
    }
}

?>
