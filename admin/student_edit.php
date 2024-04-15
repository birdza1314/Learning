<?php
// Include necessary files and start session
include('../connections/connection.php');
session_start();

// Check if id is set in the URL
if (isset($_GET['s_id'])) {
  $s_id = $_GET['s_id'];

  // Fetch user data from the database based on id
  $stmt = $db->prepare("SELECT * FROM students WHERE s_id = ?");
  $stmt->execute([$s_id]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  // Check if user data is found
  if (!$row) {
    echo "User not found.";
    exit;
  }
} else {
  echo "User ID is not specified.";
  exit;
}

$menu = "student";
include("header.php");
?>

<!-- Your HTML and Bootstrap code for the edit form goes here -->
<!-- Populate the form fields with the fetched user data -->
<div class="container mt-5">
  <h1 class="mb-4">แก้ไขข้อมูลนักเรียน</h1>
  <div class="card">
    <div class="card-body">
      <form action="student_process/student_update.php" method="post" onsubmit="return validateForm()">
        <input type="hidden" name="s_id" value="<?= $row['s_id']; ?>">

        <div class="mb-3">
          <label for="edit_username" class="form-label">ชื่อผู้ใช้:<span style="color:red;">*</span></label>
          <input type="text" class="form-control" id="edit_username" name="username" value="<?= $row['username']; ?>" autocomplete="username" required>
        </div>

        <div class="mb-3">
          <label for="edit_password" class="form-label">รหัสผ่าน: <span style="color:red;">*</span></label>
          <input type="password" class="form-control" id="edit_password" name="password">
        </div>

        <div class="mb-3">
          <label for="edit_confirm_password" class="form-label">ยืนยัน รหัสผ่าน :<span style="color:red;">*</span></label>
          <input type="password" class="form-control" id="edit_confirm_password" name="confirm_password">
        </div>

        <div class="mb-3">
          <label for="edit_first_name" class="form-label">ชื่อ:<span style="color:red;">*</span></label>
          <input type="text" class="form-control" id="edit_first_name" name="first_name" value="<?= $row['first_name']; ?>" required>
        </div>

        <div class="mb-3">
          <label for="edit_last_name" class="form-label">นามสกุล:<span style="color:red;">*</span></label>
          <input type="text" class="form-control" id="edit_last_name" name="last_name" value="<?= $row['last_name']; ?>" required>
        </div>
        <div class="mb-3">
          <label for="edit_class" class="form-label">ระดับชั้น:<span style="color:red;">*</span></label>
          <input type="text" class="form-control" id="edit_class" name="classes" value="<?= $row['classes']; ?>" required>
        </div>
  
        <div class="mb-3">
          <label for="edit_class" class="form-label">ห้องเรียน:<span style="color:red;">*</span></label>
          <input type="text" class="form-control" id="edit_class" name="classroom" value="<?= $row['classroom']; ?>" required>
        </div>
        <div class="mb-3">
          <label for="year" class="form-label">ปีการศึกษา:<span style="color:red;">*</span></label>
          <input type="text" class="form-control" id="year" name="year" value="<?= $row['year']; ?>" required>
        </div>


        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="../admin/student_data" class="btn btn-secondary" onclick="cancelEdit()">Cancel</a>
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
      window.location.href = "cancel_edit";
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
