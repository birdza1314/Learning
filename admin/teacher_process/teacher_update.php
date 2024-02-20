<?php
include('../../connections/connection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $t_id = $_POST['t_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $group_id = $_POST['group_id'];

    // อัพเดทข้อมูลในฐานข้อมูล
    $sql_get_password = "SELECT password FROM teachers WHERE t_id = :t_id";
    $stmt_get_password = $db->prepare($sql_get_password);
    $stmt_get_password->bindParam(':t_id', $t_id);
    $stmt_get_password->execute();
    $hashedPasswordFromDB = $stmt_get_password->fetchColumn();

    if (empty($password)) {
        // ถ้าไม่กรอกรหัสผ่านในฟอร์ม ให้ใช้รหัสผ่านที่อยู่ในฐานข้อมูล
        $hashedPassword = $hashedPasswordFromDB;
    } else {
        // ถ้ากรอกรหัสผ่านในฟอร์ม ให้ทำการ hash
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    }

    $sql = "UPDATE teachers SET username = :username, password = :password, first_name = :first_name, last_name = :last_name, email = :email, group_id = :group_id, image_id = :image_id WHERE t_id = :t_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':first_name', $firstName);
    $stmt->bindParam(':last_name', $lastName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':group_id', $group_id);
    $stmt->bindParam(':t_id', $t_id);

    // ดึงข้อมูลรูปภาพจากตาราง teachers_images
    $imageQuery = "SELECT image_id, filename FROM teachers_images WHERE teacher_id = :teacher_id";
    $imageStmt = $db->prepare($imageQuery);
    $imageStmt->bindParam(':teacher_id', $t_id);
    $imageStmt->execute();
    $image = $imageStmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($image['filename'])) {
        // ถ้ามีรูปภาพใน teachers_images ให้ใส่ image_id ลงใน teachers
        $stmt->bindParam(':image_id', $image['image_id']);  // แทน image_id ด้วยชื่อคอลัมน์ที่เก็บ ID ในตาราง teachers_images
    } else {
        // ถ้าไม่มีรูปภาพใน teachers_images ให้ใส่ค่า NULL ลงใน teachers
        $stmt->bindValue(':image_id', null, PDO::PARAM_NULL);
    }

    // ตรวจสอบว่ามีไฟล์รูปถูกอัปโหลดมาหรือไม่
    if (isset($_FILES['teacher_image']) && $_FILES['teacher_image']['error'] === UPLOAD_ERR_OK) {
        // ตั้งชื่อไฟล์และที่อยู่ที่ต้องการบันทึกไฟล์รูปภาพ
        $upload_dir = 'img/';  // ปรับตามโครงสร้างโฟลเดอร์ของคุณ
        $image_name = $_FILES['teacher_image']['name'];
        $image_path = $upload_dir . $image_name;

        // ลบรูปภาพเก่า (ถ้ามี)
        if (!empty($image['filename'])) {
            unlink('img/' . $image['filename']);
        }

        // บันทึกรูปภาพใหม่
        move_uploaded_file($_FILES['teacher_image']['tmp_name'], $image_path);

        // บันทึกชื่อไฟล์รูปภาพลงในตาราง teachers_images
        if (empty($image['filename'])) {
            $query_insert_image = "INSERT INTO teachers_images (teacher_id, filename) VALUES (:teacher_id, :filename)";
        } else {
            $query_insert_image = "UPDATE teachers_images SET filename = :filename WHERE teacher_id = :teacher_id";
        }
        $stmt_insert_image = $db->prepare($query_insert_image);
        $stmt_insert_image->bindParam(':teacher_id', $t_id);
        $stmt_insert_image->bindParam(':filename', $image_name);
        $stmt_insert_image->execute();
    }

    if ($stmt->execute()) {
        $_SESSION['success'] = "อัพเดทข้อมูลสำเร็จ";
    } else {
        $_SESSION['error'] = "เกิดข้อผิดพลาดในการอัพเดทข้อมูล";
    }

    header("Location: ../index.php");  // กลับไปยังหน้าที่คุณต้องการ
    exit();
}
?>
