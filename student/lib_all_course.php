<?php
session_start();
include('../connections/connection.php');
    // ทำคำสั่ง SQL เพื่อดึงคอร์สทั้งหมด
    $stmt = $db->prepare("SELECT * FROM courses");
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
          <a class="nav-link dropdown-toggle" href="../login" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          คู่มือการใช้งาน
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="../login">คู่มือการใช้งานสำหรับครู</a></li>
            <li><a class="dropdown-item" href="../login">คู่มือการใช้งานสำหรับนักเรียน</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="../contact">ติดต่อสอบถาม</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-outline-primary nav-btn" href="../login">เข้าสู่ระบบ</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
        <div class="container">
        <div class="card mt-5"> 
        <h3 class="my-4 me-5 mx-5">รายวิชาทั้งหมด</h3>
      <div class="row me-5 mx-5">
      <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    เลื่อกระดับชั้น
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="#" data-search="1" data-class-id="1">1</a></li>
                    <li><a class="dropdown-item" href="#" data-search="2" data-class-id="2">2</a></li>
                    <li><a class="dropdown-item" href="#" data-search="3" data-class-id="3">3</a></li>
                    <li><a class="dropdown-item" href="#" data-search="4" data-class-id="4">4</a></li>
                    <li><a class="dropdown-item" href="#" data-search="5" data-class-id="5">5</a></li>
                    <li><a class="dropdown-item" href="#" data-search="6" data-class-id="6">6</a></li>
                </ul>
            </div>
      </div>

          <hr color="blue" size="2" width="100%">
          
          <div class="row mt-5 me-5 mx-5">
            
          <?php foreach ($courses as $course): ?>
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
   


<!-- ======= scripts ======= -->
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>

<script>
$(document).ready(function() {
    $(".dropdown-item").click(function() {
        var classId = $(this).data('class-id'); // ดึงค่า class_id จาก attribute data-class-id ของลิงก์ที่คลิก
        var searchText = $(this).data('search'); // ดึงคำค้นหาจาก attribute data-search ของลิงก์ที่คลิก
        filterCourses(classId, searchText); // เรียกใช้ฟังก์ชัน filterCourses และส่ง class_id และ searchText ไป
    });

    $("#search").keyup(function() {
        var searchText = $(this).val();
        if (searchText != "") {
            filterCourses(null, searchText); // เรียกใช้ฟังก์ชัน filterCourses โดยไม่ระบุ class_id แต่ระบุ searchText
        } else {
            $("#show-list").html("");
        }
    });

    function filterCourses(classId, searchText) {
        $.ajax({
            url: "get_course_classes.php",
            method: "post",
            data: {
                class_id: classId, // ส่งค่า class_id ไปยัง action.php เพื่อใช้ในการกรองคอร์ส
                query: searchText
            },
            success: function(response) {
                $("#show-list").html(response);
            }
        });
    }
});

</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  var courseLinks = document.querySelectorAll('a[data-search]');
  var courses = <?php echo json_encode($courses); ?>;

  courseLinks.forEach(function(link) {
    link.addEventListener('click', function(event) {
      event.preventDefault(); // ป้องกันการโหลดหน้าใหม่เมื่อคลิกที่ลิงก์

      var class_id = link.getAttribute('data-class-id'); // ดึงค่า class_id จากลิงก์
      console.log("class_id:", class_id); // ตรวจสอบค่า class_id ในคอนโซล

      var filteredCourses = courses.filter(function(course) {
        return course.class_id == class_id; // กรองคอร์สตาม class_id
      });
      console.log("Filtered courses:", filteredCourses); // ตรวจสอบคอร์สที่ถูกกรองในคอนโซล

      var courseContainer = document.querySelector('.row.mt-5');
      courseContainer.innerHTML = '';

      var filteredCourses = courses.filter(function(course) {
  return course.class_id == class_id; // กรองคอร์สตาม class_id
});
  console.log("Filtered courses:", filteredCourses); // ตรวจสอบคอร์สที่ถูกกรองในคอนโซล

  var courseContainer = document.querySelector('.row.mt-5');
  courseContainer.innerHTML = '';

  filteredCourses.forEach(function(course) {
    var card = document.createElement('div');
    card.classList.add('col-md-4', 'mb-4');
    card.innerHTML = `
      <div class="card" style="width: 18rem;">
        <img src="${course.c_img}" class="card-img-top" alt="Course Image" style="height: 150px; object-fit: cover;">
        <div class="card-body">
          <h5 class="card-title">${course.course_name}</h5>
          <p class="card-text">รหัสวิชา: ${course.course_code}</p>
          <p class="card-text">ครูผู้สอน: ${course.teacher ? course.teacher.first_name + ' ' + course.teacher.last_name : 'ไม่พบข้อมูล'}</p>
          <a href="course_details.php?course_id=${course.c_id}" class="btn btn-outline-primary" style="float: right;">รายละเอียด</a>
        </div>
      </div>
    `;
    courseContainer.appendChild(card);
      });
    });
  });
});
</script>

</script>
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
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</footer>
</body>
</html>