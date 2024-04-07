<?php
include('../connections/connection.php');

// ตรวจสอบว่ามีการล็อกอินและมีบทบาทเป็น 'admin' หรือไม่
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // ถ้าไม่ได้ล็อกอินหรือบทบาทไม่ใช่ 'admin' ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหรือหน้าที่คุณต้องการ
    header('Location: ../login'); 
    exit();
}

try {
    // ทำคำสั่ง SQL เพื่อดึงข้อมูลของผู้ใช้ที่ล็อกอิน
    $user_id = $_SESSION['user_id'];
    $stmt = $db->prepare("SELECT * FROM admin WHERE a_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    
    // ดึงข้อมูลจากผลลัพธ์ของคำสั่ง SQL
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // แสดงข้อผิดพลาด
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
}

$menu = "index";
include("header.php");
?>

<!-- Your HTML and Bootstrap code for the edit form goes here -->
<!-- Populate the form fields with the fetched user data -->
<div class="container mt-5">
  <h1 class="mb-4">User Edit Form</h1>
  <div class="card">
    <div class="card-body">
      <form action="admin_process/admin_update" method="post" onsubmit="return validateForm()">
      <input type="hidden" name="a_id" value="<?= $admin['a_id']; ?>" >

        <div class="mb-3">
          <label for="edit_username" class="form-label">Username:</label>
          <input type="text" class="form-control" id="edit_username" name="username" value="<?=$admin['username']; ?>" autocomplete="username" required>
        </div>

        <div class="mb-3">
          <label for="edit_password" class="form-label">Password:</label>
          <input type="password" class="form-control" id="edit_password" name="password">
        </div>

        <div class="mb-3">
          <label for="edit_confirm_password" class="form-label">Confirm Password:</label>
          <input type="password" class="form-control" id="edit_confirm_password" name="confirm_password">
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="index" class="btn btn-secondary" onclick="cancelEdit()">Cancel</a>
      </form>
    </div>
  </div>
</div>


<!-- Bootstrap and additional scripts go here -->
<script>
    function cancelEdit() {
    var confirmation = confirm("คุณแน่ใจหรือไม่ที่ต้องการยกเลิกแก้ไขนี้?");
    
    if (confirmation) {
      // กรณีผู้ใช้ยืนยันการยกเลิก
      window.location.href = "../index";
    }
  }
  // Validation function
  function validateForm() {
    var password = document.getElementById("edit_password").value;
    var confirmPassword = document.getElementById("edit_confirm_password").value;

    if (password !== confirmPassword) {
      alert("รหัสผ่านและการยืนยันรหัสผ่านไม่ตรงกัน");
      return false;
    }
    return true;
  }
</script>
