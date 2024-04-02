<?php
session_start();
include('../connections/connection.php');

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    // ถ้าไม่ได้ล็อกอินหรือบทบาทไม่ใช่ 'student' ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหรือหน้าที่คุณต้องการ
    header('Location: ../login.php'); 
    exit();
}

try {
    // ทำคำสั่ง SQL เพื่อดึงข้อมูลของผู้ใช้ที่ล็อกอิน
    $user_id = $_SESSION['user_id'];
    $stmt = $db->prepare("SELECT * FROM students WHERE s_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    
    // ดึงข้อมูลจากผลลัพธ์ของคำสั่ง SQL
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // แสดงข้อผิดพลาด
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
}

try {
    // ทำคำสั่ง SQL เพื่อดึงคอร์สทั้งหมด
    $stmt = $db->prepare("SELECT * FROM courses");
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // แสดงข้อผิดพลาด
    echo "เกิดข้อผิดพลาดในการดึงคอร์ส: " . $e->getMessage();
}
?>

<?php include('head.php'); ?>
<body>
    <?php include('header.php'); ?>
    <?php include('sidebar.php'); ?>
    
    <main id="main" class="main">
    <div class="card">
      <div class="card-body">
        <div class="card-title">
          <h3>รายวิชาทั้งหมด</h3>
        </div>
        <div class="container">
        <div class="row">
        <div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
    เลือกกลุ่มสาระการเรียนรู้
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <li><a class="dropdown-item" href="#" data-search="ภาษาไทย" data-group-id="1">กลุ่มสาระการเรียนรู้ภาษาไทย</a></li>
    <li><a class="dropdown-item" href="#" data-search="คณิตศาสตร์" data-group-id="2">กลุ่มสาระการเรียนรู้คณิตศาสตร์</a></li>
    <li><a class="dropdown-item" href="#" data-search="วิทยาศาสตร์และเทคโนโลยี" data-group-id="3">กลุ่มสาระการเรียนรู้วิทยาศาสตร์และเทคโนโลยี</a></li>
    <li><a class="dropdown-item" href="#" data-search="สังคมศึกษา" data-group-id="4">กลุ่มสาระการเรียนรู้สังคมศึกษาฯ</a></li>
    <li><a class="dropdown-item" href="#" data-search="สุขศึกษา" data-group-id="5">กลุ่มสาระการเรียนรู้สุขศึกษาฯ</a></li>
    <li><a class="dropdown-item" href="#" data-search="ศิลปะ" data-group-id="6">กลุ่มสาระการเรียนรู้ศิลปะ</a></li>
    <li><a class="dropdown-item" href="#" data-search="การงานอาชีพ" data-group-id="7">กลุ่มสาระการเรียนรู้การงานอาชีพ</a></li>
    <li><a class="dropdown-item" href="#" data-search="ภาษาต่างประเทศ" data-group-id="8">กลุ่มสาระการเรียนรู้ภาษาต่างประเทศ</a></li>
    <li><a class="dropdown-item" href="#" data-search="อิสลามศึกษา" data-group-id="9">ครูผู้สอนอิสลามศึกษา</a></li>
  </ul>
</div>

</div>
          <hr color="blue" size="2" width="100%">
          <div class="row mt-5">
          <?php foreach ($courses as $course): ?>
            <?php if ($course['is_open'] == 1): ?>
                <div class="col-md-4 mb-4">
                <div class="card" style="width: 18rem;">
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
                    <a href="course_details.php?course_id=<?php echo $course['c_id']; ?>" class="btn btn-outline-primary" style="float: right;">รายละเอียด</a>
                    </div>
                </div>
                </div>
            <?php endif; ?>
            <?php endforeach; ?>

          </div>
        </div>
      </div>
    </div>
  </main>
<!-- ======= Footer ======= -->
<?php include('footer.php');?>
<!-- ======= scripts ======= -->
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<?php include('scripts.php');?>
<script>
$(document).ready(function() {
    $(".dropdown-item").click(function() {
        var groupId = $(this).data('group-id'); // ดึงค่า group_id จาก attribute data-group-id ของลิงก์ที่คลิก
        var searchText = $(this).data('search'); // ดึงคำค้นหาจาก attribute data-search ของลิงก์ที่คลิก
        filterCourses(groupId, searchText); // เรียกใช้ฟังก์ชัน filterCourses และส่ง group_id และ searchText ไป
    });

    $("#search").keyup(function() {
        var searchText = $(this).val();
        if (searchText != "") {
            filterCourses(null, searchText); // เรียกใช้ฟังก์ชัน filterCourses โดยไม่ระบุ group_id แต่ระบุ searchText
        } else {
            $("#show-list").html("");
        }
    });

    function filterCourses(groupId, searchText) {
        $.ajax({
            url: "get_course.php",
            method: "post",
            data: {
                group_id: groupId, // ส่งค่า group_id ไปยัง action.php เพื่อใช้ในการกรองคอร์ส
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

      var group_id = link.getAttribute('data-group-id'); // ดึงค่า group_id จากลิงก์
      console.log("group_id:", group_id); // ตรวจสอบค่า group_id ในคอนโซล

      var filteredCourses = courses.filter(function(course) {
        return course.group_id == group_id; // กรองคอร์สตาม group_id
      });
      console.log("Filtered courses:", filteredCourses); // ตรวจสอบคอร์สที่ถูกกรองในคอนโซล

      var courseContainer = document.querySelector('.row.mt-5');
      courseContainer.innerHTML = '';

      var filteredCourses = courses.filter(function(course) {
  return course.group_id == group_id; // กรองคอร์สตาม group_id
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

</body>
</html>
