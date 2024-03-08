<header id="header" class="header fixed-top d-flex align-items-center">

<div class="d-flex align-items-center justify-content-between">
  <a href="index.html" class="logo d-flex align-items-center">
    <img src="img/logo.png" alt="">
    <span class="d-none d-lg-block">Teacher || Process</span>
  </a>
  <i class="bi bi-list toggle-sidebar-btn"></i>
</div><!-- End Logo -->
    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

<nav class="header-nav ms-auto">
  <ul class="d-flex align-items-center">

  <li class="nav-item dropdown pe-4">
  <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
    <span class="badge1 bg-primary badge circle">4</span>
    <i class="bi bi-bell fs-4"></i>
</a>

    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
      <li class="dropdown-header1">
        <h6>Notifications</h6>
        <span class="text-muted">You have 4 new notifications</span>
      </li>
      <li>
        <hr class="dropdown-divider">
      </li>

      <li class="notification-item1">
        <a class="dropdown-item1 d-flex align-items-center" href="#">
          <i class="bi bi-exclamation-circle text-warning"></i>
          <span>Lorem Ipsum</span><br>
          <p class="text-muted">Quae dolorem earum veritatis oditseno</p>
        </a>
      </li>
      <li>
        <hr class="dropdown-divider">
      </li>
      <li class="notification-item1">
        <a class="dropdown-item1 d-flex align-items-center" href="#">
          <i class="bi bi-x-circle text-danger"></i>
          <span>Atque rerum nesciunt</span>
          <p class="text-muted">Quae dolorem earum veritatis oditseno</p>
        </a>
      </li>
      <li>
        <hr class="dropdown-divider">
      </li>
      <li class="notification-item1">
        <a class="dropdown-item1 d-flex align-items-center" href="#">
          <i class="bi bi-check-circle text-success"></i>
          <span>Sit rerum fuga</span>
          <p class="text-muted">Quae dolorem earum veritatis oditseno</p>
        </a>
      </li>
      <li>
        <hr class="dropdown-divider">
      </li>
      <li class="dropdown-footer">
      <a href="#">Show all notifications</a>
    </li>
     </ul>
  </li>


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
            <span>My Profile</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
            <i class="bi bi-gear"></i>
            <span>Account Settings</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
            <i class="bi bi-question-circle"></i>
            <span>Need Help?</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="../logout.php">
            <i class="bi bi-box-arrow-right"></i>
            <span>Sign Out</span>
          </a>
        </li>

      </ul><!-- End Profile Dropdown Items -->
    </li><!-- End Profile Nav -->

  </ul>
</nav><!-- End Icons Navigation -->

</header><!-- End Header -->
