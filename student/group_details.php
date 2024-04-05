<?php
include('../connections/connection.php');

// ตรวจสอบว่ามีค่า $_GET['group_id'] ที่ถูกส่งมาหรือไม่
if (isset($_GET['group_id'])) {
    // รับค่า group_id จาก URL
    $group_id = $_GET['group_id'];

    // คำสั่ง SQL เพื่อดึงข้อมูลของกลุ่มสาระนั้น ๆ
    $sql = "SELECT * FROM courses WHERE group_id = :group_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':group_id', $group_id);
    $stmt->execute();
    $group_courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // คำสั่ง SQL เพื่อดึงชื่อของกลุ่มสาระ
    $sql_group_name = "SELECT group_name FROM learning_subject_group WHERE group_id = :group_id";
    $stmt_group_name = $db->prepare($sql_group_name);
    $stmt_group_name->bindParam(':group_id', $group_id);
    $stmt_group_name->execute();
    $group_name = $stmt_group_name->fetchColumn(); // ใช้ fetchColumn() เพื่อดึงค่าเดียวจากคอลัมน์แรก
} else {
    // ถ้าไม่มีค่า $_GET['group_id'] ที่ถูกส่งมาใน URL
    // คุณสามารถทำการจัดการข้อผิดพลาดได้ตามต้องการ
    echo "ไม่พบรหัสกลุ่มสาระ";
}
?>

<?php include('../uploads/head.php');?>
<body style="background-color: rgb(220, 220, 220);">

<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-custom sticky-top">
  <div class="container-fluid">
    <!-- Navbar brand with logo -->
    <a class="navbar-brand navbar-brand-custom" href="../index">
      <img src="../uploads/img/logo.png" alt="Logo">
    </a>
    <!-- Button to toggle the navbar on mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar items -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="../index">หน้าหลัก</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          คู่มือการใช้งาน
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="#">คู่มือการใช้งานสำหรับครู</a></li>
            <li><a class="dropdown-item" href="#">คู่มือการใช้งานสำหรับนักเรียน</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="#">ติดต่อสอบถาม</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-outline-primary nav-btn" href="../login">เข้าสู่ระบบ</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


    <div class="container  mt-5">
    <div class="card " >  
    <h1 class="text-center">รายละเอียดกลุ่มสาระ</h1>
    <h2 class="text-center"><?php echo $group_name; ?></h2>
 
      
    <div class="row mt-5 me-5 mx-5">
            <?php foreach ($group_courses as $course): ?>
                <?php if ($course['is_open'] == 1): ?>
              <div class="col-md-4 mb-4">
                  <div class="card border-primary border-3 shadow" style="width: 18rem;">
                  <?php if (!empty($course['c_img'])): ?>
                <div class="text-center">
                    <img src="<?php echo $course['c_img']; ?>" class="card-img-top" alt="รูปภาพ" style="height: 150px; object-fit: cover;">
                </div>
            <?php else: ?>
                <div class="text-center">
                    <img src="../admin/teacher_process/img/course.jpg" class="card-img-top" alt="รูปภาพ" style="height: 150px; object-fit: cover;">
                </div>
            <?php endif; ?>
                      <div class="card-body">
                          <h5 class="card-title"><?php echo $course['course_name']; ?></h5>
                          <p class="card-text">รหัสวิชา: <?php echo $course['course_code']; ?></p>
                          <?php
                          // เรียกข้อมูลผู้สอนจากตาราง teachers โดยใช้ teacher_id จากตาราง courses เป็นเงื่อนไข
                          $teacher_id = $course['teacher_id'];
                          $teacher_stmt = $db->prepare("SELECT * FROM teachers WHERE t_id = :teacher_id");
                          $teacher_stmt->bindParam(':teacher_id', $teacher_id);
                          $teacher_stmt->execute();
                          $teacher = $teacher_stmt->fetch(PDO::FETCH_ASSOC);
                          ?>
                          <p class="card-text">ครูผู้สอน: <?php echo $teacher['first_name']; ?> <?php echo $teacher['last_name']; ?></p>
                          <a href="../login" class="btn btn-outline-primary" style="float: right;">รายละเอียด</a>
                      </div>
                  </div>
              </div>
          <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    </div>
    <footer class="footer bg-secondary text-light py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-start">
                    <!-- โลโก้ -->
                    <a class="navbar-brand navbar-brand-custom" href="#">
                        <img src="../uploads/img/logo.png" alt="Logo">
                    </a>
                </div>
                <div class="col-md-6 text-end">
                    <!-- ข้อมูลติดต่อ -->
                    <p class="mb-1">ติดต่อเรา: example@example.com</p>
                    <p class="mb-0">โทรศัพท์: 012-345-6789</p>
                </div>
            </div>
        </div>
    </footer>

<footer class="footer bg-dark text-light py-4">
    <div class="container text-center">

      &copy; Copyright <strong><span>E-learning System</span></strong>. All Rights Reserved 
    </div>
    <div class="credits text-center">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://web.facebook.com/profile.php?id=100009502864499" target="_blank" >Ruslan Matha</a>

    </div>
</footer>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
