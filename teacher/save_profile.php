<?php
include('../connections/connection.php');

// เรียกใช้งาน session
session_start();

// ตรวจสอบว่ามีการล็อกอินและมีบทบาทเป็น 'teacher' หรือไม่
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    // ถ้าไม่ได้ล็อกอินหรือบทบาทไม่ใช่ 'teacher' ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหรือหน้าที่คุณต้องการ
    header('Location: ../login.php'); 
    exit();
}

// ตรวจสอบว่ามีการส่งข้อมูลแบบ POST มาหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // รับค่าจากฟอร์มแก้ไขโปรไฟล์
        $fullName = $_POST['fullName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $user_id = $_SESSION['user_id'];

        // อัปเดตข้อมูลในฐานข้อมูล
        $stmt = $db->prepare("UPDATE teachers SET first_name = :fullName, last_name = :lastName, email = :email WHERE t_id = :user_id");
        $stmt->bindParam(':fullName', $fullName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        // ตรวจสอบว่ามีการอัปโหลดรูปภาพหรือไม่
        if (isset($_FILES['newProfileImage']) && $_FILES['newProfileImage']['error'] === UPLOAD_ERR_OK) {
            // ตั้งชื่อไฟล์และที่อยู่ที่ต้องการบันทึกไฟล์รูปภาพ
            $upload_dir = '../admin/teacher_process/img/'; // โฟลเดอร์ที่เก็บรูปภาพบนเซิร์ฟเวอร์
            $image_name = $_FILES['newProfileImage']['name'];
            $image_path = $upload_dir . $image_name;

            // บันทึกรูปภาพใหม่
            move_uploaded_file($_FILES['newProfileImage']['tmp_name'], $image_path);

            // บันทึกชื่อไฟล์รูปภาพลงในตาราง teachers
            $sql = "UPDATE teachers SET image = :image WHERE t_id = :user_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':image', $image_name);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
        }
        echo '<script>alert("อัพเดทข้อมูลสำเร็จ"); window.location.href = "profile.php?success=1";</script>';
        exit();
        
    } catch (PDOException $e) {
        // หากเกิดข้อผิดพลาดในการประมวลผลคำสั่ง SQL
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $e->getMessage();
    }
} else {
    // หากไม่มีการส่งข้อมูลแบบ POST กลับไปยังหน้าแก้ไขโปรไฟล์
    exit();
}
?>
