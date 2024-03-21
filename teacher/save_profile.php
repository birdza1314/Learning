<?php
include('../connections/connection.php');

// เรียกใช้งาน session
session_start();

// ตรวจสอบว่ามีการล็อกอินและมีบทบาทเป็น 'teacher' หรือไม่
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    // ถ้าไม่ได้ล็อกอินหรือบทบาทไม่ใช่ 'teacher' ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหรือหน้าที่คุณต้องการ
    header('Location: login.php'); 
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
            // ตรวจสอบประเภทของไฟล์
            $fileType = pathinfo($_FILES['newProfileImage']['name'], PATHINFO_EXTENSION);

            // สร้างชื่อไฟล์ใหม่โดยใช้รหัสผู้ใช้
            $newFileName = $user_id . '.' . $fileType;

            // ย้ายไฟล์ไปยังโฟลเดอร์ที่เหมาะสม
            if (move_uploaded_file($_FILES['newProfileImage']['tmp_name'], '../admin/teacher_process/img/' . $newFileName)) {
                // เพิ่มข้อมูลรูปภาพใหม่ลงในตาราง teachers_images
                $imageInsertStmt = $db->prepare("INSERT INTO teachers_images (teacher_id, filename) VALUES (:user_id, :filename)");
                $imageInsertStmt->bindParam(':user_id', $user_id);
                $imageInsertStmt->bindParam(':filename', $newFileName);
                $imageInsertStmt->execute();

                // ดึง image_id ที่เพิ่งเพิ่มลงในตาราง teachers_images
                $imageId = $db->lastInsertId();

                // อัปเดต image_id ในตาราง teachers
                $updateImageIdStmt = $db->prepare("UPDATE teachers SET image_id = :image_id WHERE t_id = :user_id");
                $updateImageIdStmt->bindParam(':image_id', $imageId);
                $updateImageIdStmt->bindParam(':user_id', $user_id);
                $updateImageIdStmt->execute();

                // แสดงการแจ้งเตือนเมื่อรูปภาพถูกอัปโหลดเรียบร้อย
                echo '<script>alert("อัปโหลดรูปภาพเรียบร้อยแล้ว");</script>';
            } else {
                // แสดงข้อผิดพลาดถ้าไม่สามารถอัปโหลดรูปได้
                echo '<script>alert("เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ");</script>';
            }
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
