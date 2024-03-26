<header id="header" class="header fixed-top d-flex align-items-center">

<div class="d-flex align-items-center justify-content-between">
  <a href="index.html" class="logo d-flex align-items-center">
    <img src="img/logo.png" alt="">
    <span class="d-none d-lg-block">Teacher || Process</span>
  </a>
  <i class="bi bi-list toggle-sidebar-btn"></i>
</div><!-- End Logo -->

<nav class="header-nav ms-auto">
  <ul class="d-flex align-items-center">
    <li class="nav-item dropdown pe-3">

      <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
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

        <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $teacher['first_name'];?></span>
      </a><!-- End Profile Iamge Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
        <li class="dropdown-header">
          <h6><?php echo $teacher['first_name'];?> : <?php echo $teacher['last_name'];?></h6>
          <span><?php echo $_SESSION['role'];?></span>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="profile.php">
            <i class="bi bi-person"></i>
            <span>โปรไฟล์</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="../logout.php">
            <i class="bi bi-box-arrow-right"></i>
            <span>ออกจากระบบ</span>
          </a>
        </li>

      </ul><!-- End Profile Dropdown Items -->
    </li><!-- End Profile Nav -->

  </ul>
</nav><!-- End Icons Navigation -->

</header><!-- End Header -->
