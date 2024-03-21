<?php
include('../connections/connection.php');

// ตรวจสอบว่ามีการล็อกอินและมีบทบาทเป็น 'teacher' หรือไม่
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
        // ถ้าไม่ได้ล็อกอินหรือบทบาทไม่ใช่ 'teacher' ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหรือหน้าที่คุณต้องการ
        header('Location: login.php'); 
        exit();
    }

    try {
        // ทำคำสั่ง SQL เพื่อดึงข้อมูลของผู้ใช้ที่ล็อกอิน
        $user_id = $_SESSION['user_id'];
        $stmt = $db->prepare("SELECT * FROM teachers WHERE t_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        
        // ดึงข้อมูลจากผลลัพธ์ของคำสั่ง SQL
        $teacher = $stmt->fetch(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        // แสดงข้อผิดพลาด
        echo "เกิดข้อผิดพลาด: " . $e->getMessage();
        }
?>

 <!-- ======= Head ======= -->
<?php include('head.php');?>

<body>

  <!-- ======= Header ======= -->
  <?php include('header.php');?>

  <!-- ======= Sidebar ======= -->
  <?php include('sidebar.php');?>
  <?php $menu = "profile"; ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
          <div class="col-xl-4">
            <div class="card">
              <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                <!-- ตรวจสอบว่ามีรูปภาพในตาราง teachers_images หรือไม่ -->
                  <?php if (!empty($teacher['image_id'])): ?>
                      <?php
                      // ดึง URL ของรูปภาพจากตาราง teachers_images
                      $imageQuery = "SELECT filename FROM teachers_images WHERE image_id = :image_id";
                      $imageStmt = $db->prepare($imageQuery);
                      $imageStmt->bindParam(':image_id', $teacher['image_id']);
                      $imageStmt->execute();
                      $image = $imageStmt->fetch(PDO::FETCH_ASSOC);

                      // ตรวจสอบว่ามี URL ของรูปภาพหรือไม่
                      if (!empty($image['filename'])):
                          $imagePath = '../admin/teacher_process/img/' . $image['filename'];
                      else:
                          $imagePath = '../admin/teacher_process/img/Defaul.png'; // กำหนด local path ของรูปภาพที่ใช้เป็นค่าสำรอง
                      endif;
                      ?>
                      <!-- แสดงรูปภาพ -->
                      <img src="<?php echo $imagePath; ?>" alt="Profile" class="rounded-circle">
                  <?php else: ?>
                      <!-- กรณีไม่มี image_id ในตาราง teachers -->
                      <img src="../admin/teacher_process/img/Defaul.png" alt="Default Profile" class="rounded-circle">
                  <?php endif; ?>

                <h2><?php echo $teacher['first_name'];?></h2>
                <h3><?php echo $_SESSION['role'];?></h3>
                <div class="social-links mt-2">
                  <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                  <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                  <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                  <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
            </div>
          </div>


        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">ภาพรวม</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">แก้ไขโปรไฟล์</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">เปลี่ยนรหัสผ่าน</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">เกี่ยวกับ</h5>
                  <p class="small fst-italic">
                    #
                  </p>

                  <h5 class="card-title">รายละเอียดโปรไฟล์</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">ชื่อ</div>
                    <div class="col-lg-9 col-md-8"><?php echo $teacher['first_name'];?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">นามสกุล</div>
                    <div class="col-lg-9 col-md-8"><?php echo $teacher['last_name'];?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">งาน</div>
                    <div class="col-lg-9 col-md-8"><?php echo $_SESSION['role'];?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8"><?php echo $teacher['email'];?></div>
                  </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">


          <!-- Profile Edit Form -->
          <form action="save_profile.php" method="post" enctype="multipart/form-data">
              <div class="row mb-3">
                  <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">รูปโปรไฟล์</label>
                  <div class="col-md-8 col-lg-9">
              <!-- ตรวจสอบว่ามีรูปภาพในตาราง teachers_images หรือไม่ -->
              <?php if (!empty($teacher['image_id'])): ?>
                  <?php
                  // ดึง URL ของรูปภาพจากตาราง teachers_images
                  $imageQuery = "SELECT filename FROM teachers_images WHERE teacher_id = :teacher_id";
                  $imageStmt = $db->prepare($imageQuery);
                  $imageStmt->bindParam(':teacher_id', $teacher['t_id']);
                  $imageStmt->execute();
                  $image = $imageStmt->fetch(PDO::FETCH_ASSOC);

                  // ตรวจสอบว่ามี URL ของรูปภาพหรือไม่
                  if (!empty($image['filename'])):
                      $imagePath = '../admin/teacher_process/img/' . $image['filename'];
                  else:
                      $imagePath = '../admin/teacher_process/img/Defaul.png'; // กำหนด local path ของรูปภาพที่ใช้เป็นค่าสำรอง
                  endif;
                  ?>
                  <!-- แสดงรูปภาพ -->
                  <img src="<?php echo $imagePath; ?>" alt="Profile" class="rounded-circle">
              <?php else: ?>
                  <!-- กรณีไม่มีรูปในตาราง teachers_images -->
                  <img src="../admin/teacher_process/img/Defaul.png" alt="Default Profile" class="rounded-circle">
              <?php endif; ?>
              <div class="pt-2">
                  <label for="newProfileImage">Choose image File:</label>
                  <input type="file" name="newProfileImage" id="newProfileImage" class="form-control-file">
              </div>
            </div>

              </div>

              <div class="row mb-3">
                  <label for="fullName" class="col-md-4 col-lg-3 col-form-label">ชื่อ</label>
                  <div class="col-md-8 col-lg-9">
                      <input name="fullName" type="text" class="form-control" id="fullName" value="<?php echo $teacher['first_name'];?>">
                  </div>
              </div>

              <div class="row mb-3">
                  <label for="lastName" class="col-md-4 col-lg-3 col-form-label">นามสกุล</label>
                  <div class="col-md-8 col-lg-9">
                      <input name="lastName" type="text" class="form-control" id="lastName" value="<?php echo $teacher['last_name'];?>">
                  </div>
              </div>

              <div class="row mb-3">
                  <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                  <div class="col-md-8 col-lg-9">
                      <input name="email" type="email" class="form-control" id="email" value="<?php echo $teacher['email'];?>">
                  </div>
              </div>

              <div class="text-center">
                  <button type="submit" class="btn btn-primary">บันทึก</button>
              </div>
          </form><!-- End Profile Edit Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                 <!-- Change Password Form -->
<form id="changePasswordForm" action="change_password.php" method="POST">
    <div class="row mb-3">
        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">รหัสผ่านใหม่</label>
        <div class="col-md-8 col-lg-9">
            <input name="newpassword" type="password" class="form-control" id="newPassword">
        </div>
    </div>

    <div class="row mb-3">
        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">ป้อนรหัสผ่านใหม่อีกครั้ง</label>
        <div class="col-md-8 col-lg-9">
            <input name="renewpassword" type="password" class="form-control" id="renewPassword">
        </div>
    </div>

    <div id="passwordMatchMessage" class="text-center"></div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary">เปลี่ยนรหัสผ่าน</button>
    </div>
</form><!-- End Change Password Form -->

<script>
    document.getElementById("changePasswordForm").addEventListener("submit", function(event) {
        event.preventDefault(); // ป้องกันการส่งฟอร์มโดยปกติ

        var newPassword = document.getElementById("newPassword").value;
        var renewPassword = document.getElementById("renewPassword").value;
        var passwordMatchMessage = document.getElementById("passwordMatchMessage");

        // เช็คว่ารหัสผ่านทั้งสองต้องเหมือนกันหรือไม่
        if (newPassword === renewPassword) {
            // ถ้าเหมือนกัน กำหนดสีเขียวและข้อความ "รหัสผ่านตรงกัน"
            passwordMatchMessage.style.color = "green";
            passwordMatchMessage.textContent = "รหัสผ่านตรงกัน";
            // ส่งฟอร์มไปยังไฟล์ change_password.php
            this.submit();
        } else {
            // ถ้าไม่เหมือนกัน กำหนดสีแดงและข้อความ "รหัสผ่านไม่ตรงกัน"
            passwordMatchMessage.style.color = "red";
            passwordMatchMessage.textContent = "รหัสผ่านไม่ตรงกัน";
        }
    });
</script>



                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->
  <!-- ======= Footer ======= -->
<?php include('footer.php');?>

 <!-- ======= scripts ======= -->
 <?php include('scripts.php');?>

</body>

</html>