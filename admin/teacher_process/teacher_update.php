<?php
include('../../connections/connection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $t_id = $_POST['t_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
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

    $sql = "UPDATE teachers SET username = :username, password = :password, first_name = :first_name, last_name = :last_name, group_id = :group_id WHERE t_id = :t_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':first_name', $firstName);
    $stmt->bindParam(':last_name', $lastName);
    $stmt->bindParam(':group_id', $group_id);
    $stmt->bindParam(':t_id', $t_id);

    // ตรวจสอบว่ามีไฟล์รูปถูกอัปโหลดมาหรือไม่
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // ตั้งชื่อไฟล์และที่อยู่ที่ต้องการบันทึกไฟล์รูปภาพ
        $upload_dir = 'img/';  // ปรับตามโครงสร้างโฟลเดอร์ของคุณ
        $image_name = $_FILES['image']['name'];
        $image_path = $upload_dir . $image_name;

        // ลบรูปภาพเก่า (ถ้ามี)
        $imageQuery = "SELECT image FROM teachers WHERE t_id = :t_id";
        $imageStmt = $db->prepare($imageQuery);
        $imageStmt->bindParam(':t_id', $t_id);
        $imageStmt->execute();
        $oldImage = $imageStmt->fetchColumn();
        if (!empty($oldImage)) {
            unlink('img/' . $oldImage);
        }

        // บันทึกรูปภาพใหม่
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);

        // บันทึกชื่อไฟล์รูปภาพลงในตาราง teachers
        $stmt_update_image = $db->prepare("UPDATE teachers SET image = :image WHERE t_id = :t_id");
        $stmt_update_image->bindParam(':image', $image_name);
        $stmt_update_image->bindParam(':t_id', $t_id);
        $stmt_update_image->execute();
    }

    if ($stmt->execute()) {
        $_SESSION['success'] = "อัพเดทข้อมูลสำเร็จ";
    } else {
        $_SESSION['error'] = "เกิดข้อผิดพลาดในการอัพเดทข้อมูล";
    }

    header("Location: ../teacher");
    exit();
}
?>
