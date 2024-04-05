<?php
session_start();
require_once('connections/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = strtolower($_POST["username"]);
    $password = $_POST["password"];

    try {
        // Search in admin table
        $stmt = $db->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['user_id'] = $admin['a_id'];
            $_SESSION['role'] = 'admin';
            header("Location: admin/index");
            exit();
        }

        // Search in teachers table
        $stmt = $db->prepare("SELECT * FROM teachers WHERE username = ?");
        $stmt->execute([$username]);
        $teacher = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($teacher && password_verify($password, $teacher['password'])) {
            $_SESSION['user_id'] = $teacher['t_id'];
            $_SESSION['role'] = 'teacher';
            header("Location: teacher/index");
            exit();
        }

        // Search in students table
        $stmt = $db->prepare("SELECT * FROM students WHERE username = ?");
        $stmt->execute([$username]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($student && password_verify($password, $student['password'])) {
            $_SESSION['user_id'] = $student['s_id'];
            $_SESSION['role'] = 'student';
            header("Location: student/index");
            exit();
        }

        // If no matching data found in any table
        echo '<script>alert("รหัสผ่านไม่ถูกต้อง กรุณาตรวจสอบ ID และ รหัสผ่านให้ถูกต้อง");</script>';
        header("Refresh: 0; url=login");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
