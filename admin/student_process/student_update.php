<?php
include('../../connections/connection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $s_id = $_POST['s_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $gender = $_POST['gender'];
    $class = $_POST['class'];
    

    // อัพเดทข้อมูลในฐานข้อมูล
    $sql_get_password = "SELECT password FROM students WHERE s_id = :s_id";
    $stmt_get_password = $db->prepare($sql_get_password);
    $stmt_get_password->bindParam(':s_id', $s_id);
    $stmt_get_password->execute();
    $hashedPasswordFromDB = $stmt_get_password->fetchColumn();

    if (empty($password)) {
        // ถ้าไม่กรอกรหัสผ่านในฟอร์ม ให้ใช้รหัสผ่านที่อยู่ในฐานข้อมูล
        $hashedPassword = $hashedPasswordFromDB;
    } else {
        // ถ้ากรอกรหัสผ่านในฟอร์ม ให้ทำการ hash
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    }

    $sql = "UPDATE students SET username = :username, password = :password, first_name = :first_name, last_name = :last_name, gender = :gender, class = :class WHERE s_id = :s_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword); // ใช้ hashedPassword ที่เราได้ hash ไว้แล้ว
    $stmt->bindParam(':first_name', $firstName);
    $stmt->bindParam(':last_name', $lastName);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':class', $class);
    $stmt->bindParam(':s_id', $s_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "อัพเดทข้อมูลสำเร็จ";
    } else {
        $_SESSION['error'] = "เกิดข้อผิดพลาดในการอัพเดทข้อมูล";
    }

    header("Location: ../student_data.php");  // กลับไปยังหน้าที่คุณต้องการ
    exit();
}
?>
