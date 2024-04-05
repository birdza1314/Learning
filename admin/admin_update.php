<?php
include('../connections/connection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $a_id = $_POST['a_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
   
    

    // อัพเดทข้อมูลในฐานข้อมูล
    $sql_get_password = "SELECT password FROM admin WHERE a_id = :a_id";
    $stmt_get_password = $db->prepare($sql_get_password);
    $stmt_get_password->bindParam(':a_id', $a_id);
    $stmt_get_password->execute();
    $hashedPasswordFromDB = $stmt_get_password->fetchColumn();

    if (empty($password)) {
        // ถ้าไม่กรอกรหัสผ่านในฟอร์ม ให้ใช้รหัสผ่านที่อยู่ในฐานข้อมูล
        $hashedPassword = $hashedPasswordFromDB;
    } else {
        // ถ้ากรอกรหัสผ่านในฟอร์ม ให้ทำการ hash
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    }

    $sql = "UPDATE admin SET username = :username, password = :password  WHERE a_id = :a_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword); // ใช้ hashedPassword ที่เราได้ hash ไว้แล้ว
    $stmt->bindParam(':a_id', $a_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "อัพเดทข้อมูลสำเร็จ";
    } else {
        $_SESSION['error'] = "เกิดข้อผิดพลาดในการอัพเดทข้อมูล";
    }

    header("Location: index");  // กลับไปยังหน้าที่คุณต้องการ
    exit();
}
?>
