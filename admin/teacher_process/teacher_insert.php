<?php
// นำเข้าการเชื่อมต่อฐานข้อมูล
include('../../connections/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าที่ส่งมาจากฟอร์ม
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $email = htmlspecialchars($_POST['email']);

    // เตรียมคำสั่ง SQL เพื่อเพิ่มข้อมูล
    $sql = "INSERT INTO teachers (username, password, first_name, last_name,  email) 
            VALUES (:username, :password, :first_name, :last_name,  :email)";

    // ใช้ PDO เพื่อทำการเพิ่มข้อมูล
    try {
        // ใช้ password_hash() สำหรับเก็บรหัสผ่าน
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        
        $stmt->bindParam(':email', $email);
       

        // ประมวลผลคำสั่ง SQL
        $stmt->execute();

        // แสดงข้อความเมื่อบันทึกสำเร็จ
        echo "<script>
                alert('บันทึกสำเร็จ! ข้อมูลของคุณได้รับการบันทึกเรียบร้อยแล้ว');
                window.location = '../index.php';
              </script>";
    } catch (PDOException $e) {
        // กรณีเกิดข้อผิดพลาด
        echo "Error: " . $e->getMessage();
    }
} else {
    // หากไม่มีการส่งข้อมูลมาโดยตรงผ่าน POST ให้ redirect กลับไปยังหน้า index.php
    header("Location: ../index.php");
    exit();
}
?>
