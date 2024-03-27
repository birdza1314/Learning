<?php
// Include necessary files and start session
include('../connections/connection.php');
session_start();

// Check if id is set in the URL
if (isset($_GET['t_id'])) {
  $t_id = $_GET['t_id'];

  // Fetch user data from the database based on id
  $stmt = $db->prepare("SELECT * FROM teachers WHERE t_id = ?");
  $stmt->execute([$t_id]);
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

$menu = "index";
include("header.php");
?>

<!-- Your HTML and Bootstrap code for the edit form goes here -->
<!-- Populate the form fields with the fetched user data -->
<div class="container mt-5">
  <h1 class="mb-4">User Edit Form</h1>
  <div class="card">
    <div class="card-body">
      <form action="teacher_process/teacher_update.php" method="post" onsubmit="return validateForm()"  enctype="multipart/form-data">
        <input type="hidden" name="t_id" value="<?= $row['t_id']; ?>">
                  
          <!-- โค้ด HTML สำหรับอัปโหลดรูปภาพ -->
          <div class="mb-3">
              <?php
          // ตรวจสอบว่ามีข้อมูลใน $row['filename'] หรือไม่

          // ตรวจสอบว่ามีข้อมูลรูปภาพหรือไม่
          $stmtImage = $db->prepare("SELECT * FROM teachers_images WHERE teacher_id = ?");
          $stmtImage->execute([$row['t_id']]);

          if ($stmtImage->rowCount() > 0) {
              $imageRow = $stmtImage->fetch(PDO::FETCH_ASSOC);
              echo '<img src="teacher_process/img/' . $imageRow['filename'] . '" alt="Teacher Image" style="max-width: 100px; max-height: 100px;">';
          } else {
            echo '<img src="teacher_process/img/Defaul.png" alt="Default Image" style="max-width: 100px; max-height: 100px;">';
          }
          ?>
          </div>


        <label for="teacher_image" class="form-label">อัปโหลดรูปภาพใหม่:</label>
        <input type="file" name="teacher_image" id="teacher_image">
        <div class="mb-3">
          <label for="edit_username" class="form-label">Username:</label>
          <input type="text" class="form-control" id="edit_username" name="username" value="<?= $row['username']; ?>" autocomplete="username" required>
        </div>

        <div class="mb-3">
          <label for="edit_password" class="form-label">Password:</label>
          <input type="password" class="form-control" id="edit_password" name="password">
        </div>

        <div class="mb-3">
          <label for="edit_confirm_password" class="form-label">Confirm Password:</label>
          <input type="password" class="form-control" id="edit_confirm_password" name="confirm_password">
        </div>

        <div class="mb-3">
          <label for="edit_first_name" class="form-label">First Name:</label>
          <input type="text" class="form-control" id="edit_first_name" name="first_name" value="<?= $row['first_name']; ?>" required>
        </div>

        <div class="mb-3">
          <label for="edit_last_name" class="form-label">Last Name:</label>
          <input type="text" class="form-control" id="edit_last_name" name="last_name" value="<?= $row['last_name']; ?>" required>
        </div>

        <div class="mb-3">
          <label for="edit_email" class="form-label">Email:</label>
          <input type="email" class="form-control" id="edit_email" name="email" value="<?= $row['email']; ?>" required>
        </div>
        <div class="mb-3">
        <label for="edit_group_id" class="form-label">กลุ่มที่เรียน:</label>
           <select class="form-select" id="edit_group_id" name="group_id">
            <?php
            // Fetch group data from the learning_subject_group table
            $groupStmt = $db->query("SELECT * FROM learning_subject_group");
            $groupStmt->execute();
            $groups = $groupStmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($groups as $group) {
                $selected = ($group['group_id'] == $row['group_id']) ? 'selected' : '';
                echo '<option value="' . $group['group_id'] . '" ' . $selected . '>' . $group['group_name'] . '</option>';
            }
            ?>
           </select>
         </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="../admin/index.php" class="btn btn-secondary" onclick="cancelEdit()">Cancel</a>
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
      window.location.href = "teacher.php";
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
