<header id="header" class="header fixed-top d-flex align-items-center">

<div class="d-flex align-items-center justify-content-between">
  <a href="index.php" >
    <img src="../uploads/img/logo.png" alt="" style="width: 250px; height: 60px;">
  </a>
  <i class="bi bi-list toggle-sidebar-btn" style="font-size: 24px;"></i>
</div>

<nav class="header-nav ms-auto">
  <ul class="d-flex align-items-center">
<!-- Dropdown Notification -->
<div class="dropdown d-none d-md-block">
  <button class="btn dropdown-toggle" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="bi bi-bell-fill"></i><span class="badge bg-danger" id="notificationCount">0</span>
  </button>
  <ul class="dropdown-menu dropdown-menu-end notification" aria-labelledby="notificationDropdown" id="notificationList">
    <!-- รายการแจ้งเตือนจะถูกแสดงที่นี่ -->
  </ul>
</div>
<!-- JavaScript Code for Notification -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // เลือก dropdown element
  var notificationDropdown = document.getElementById('notificationDropdown');
  var notificationList = document.getElementById('notificationList');
  var notificationCount = document.getElementById('notificationCount');

  // Function สำหรับดึงข้อมูลกิจกรรมและแสดงผลใน dropdown notification
  function fetchAndDisplayNotifications() {
    // ส่งคำร้องขอ GET ไปยังไฟล์ get_assignments.php เพื่อดึงข้อมูลกิจกรรม
    fetch('get_event.php')
      .then(response => response.json())
      .then(data => {
        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if (data.length > 0) {
          // กำหนด HTML ใหม่สำหรับ dropdown notification
          var html = '';
          data.forEach(event => {
            // เพิ่มลิงก์ไปยังหน้าวิชาที่เกี่ยวข้อง
            html += `<li><a class="dropdown-item" href="course_details.php?course_id=${event.course_id}"><i class="bi bi-exclamation-diamond text-warning"></i> ${event.title} - สิ้นสุด ${event.close_time.split(' ')[0].split('-').reverse().join('-')} ${event.close_time.split(' ')[1]}</a></li>`;

            // เพิ่มเส้นขีดในระหว่างรายการข้อมูล
            html += `<li><hr class="dropdown-divider"></li>`;
          });
          // นำ HTML ใหม่มาแทนที่ใน dropdown notification
          notificationList.innerHTML = html;
          // กำหนดจำนวนของแจ้งเตือนใหม่
          notificationCount.innerText = data.length;
        } else {
          // ถ้าไม่มีข้อมูล ให้แสดงข้อความ "ไม่มีกิจกรรม"
          notificationList.innerHTML = '<li><span class="dropdown-item">ไม่มีกิจกรรม</span></li>';
        }
      });
  }

  // เรียกใช้งานฟังก์ชัน fetchAndDisplayNotifications เมื่อเปิดหน้าเว็บ
  fetchAndDisplayNotifications();
});

</script>



    <li class="nav-item dropdown pe-3">

      <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
         <!-- ตรวจสอบว่ามีรูปภาพในตาราง students_images หรือไม่ -->
                  <?php if (!empty($student['image'])): ?>
                  <?php
                  // ตรวจสอบว่ามี URL ของรูปภาพหรือไม่
                  $imagePath = 'images/' . $student['image'];
                  ?>
                  <!-- แสดงรูปภาพ -->
                  <img src="<?php echo $imagePath; ?>" alt="Profile" class="rounded-circle">
              <?php else: ?>
                  <!-- กรณีไม่มีรูปภาพ -->
                  <img src="images/Default.png" alt="Default Profile" class="rounded-circle">
              <?php endif; ?>

        <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $student['first_name'];?></span>
      </a><!-- End Profile Iamge Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
        <li class="dropdown-header">
          <h6><?php echo $student['first_name'];?> : <?php echo $student['last_name'];?></h6>
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
