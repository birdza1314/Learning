<?php
// เชื่อมต่อกับฐานข้อมูล
include('../connections/connection.php');

// ตรวจสอบการล็อกอินและบทบาทของผู้ใช้
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header('Location: ../login.php'); 
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
// ตรวจสอบว่ามีการส่งค่า course_id มาหรือไม่
if (!isset($_GET['course_id'])) {
    // หากไม่มี course_id ให้กลับไปยังหน้าหลัก
    header('Location: index.php');
    exit();
}

// เริ่มต้นลำดับที่ 1
$counter = 1;


$course_id = $_GET['course_id'];

// ดึงข้อมูลของคอร์ส
$stmt = $db->prepare("SELECT * FROM courses WHERE c_id = ?");
$stmt->execute([$course_id]);
$course = $stmt->fetch();

$stmt = $db->prepare("SELECT scr.student_id, s.username, s.classroom, s.year, s.first_name, s.last_name
                      FROM student_course_registration scr
                      INNER JOIN students s ON scr.student_id = s.s_id
                      WHERE scr.course_id = ?");
$stmt->execute([$course_id]);
$members = $stmt->fetchAll();



?>

<?php
     include('head.php');
?>
<body>
<?php
     include('header.php');
     include('sidebar.php');
     
?>
  <main id="main" class="main">


<div class="container">
    <div class="card overflow-auto">
       <div class="card-body">
            <div class="row" >
                <div class="col-sm-10">
                    <h2 class="py-3">จัดการสมาชิก</h2>
                    <p>วิชา:  <?= $course['course_name']; ?></p>
                </div>
                    <div class="col-sm-2">
                  <!-- Button trigger modal -->
                    <a href="add_student_to_course.php?course_id=<?= $course['c_id']; ?>" type="button" class="btn btn-outline-primary mt-5 " >
                    ลงทะเบียนนักเรียน
                    </a>
                    </div>
        <table class="table table-borderless datatable table-format">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>รหัสนักเรียน</th>
                    <th>ชื่อ-นามสกุล</th>         
                    <th>ห้องเรียน</th>
                    <th>ปีการศึกษา</th>
                    <th>ตัวเลือก</th>   
                </tr>
            </thead>
            <tbody>
                <?php foreach ($members as $member): ?>
                    <tr>
                        <td scope="row"><?= $counter++; ?></td>
                        <td><?= $member['username']; ?></td>
                        <td><?= $member['first_name']; ?>  <?= $member['last_name']; ?></td>
                        <td><?= $member['classroom']; ?></td>
                        <td><?= $member['year']; ?></td>
                        <td>
                            <!-- Add delete button here -->
                            <a href="delete_student.php?course_id=<?= $course_id; ?>&student_id=<?= $member['student_id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบสมาชิกรายนี้ ?')"><i class="bi bi-trash-fill"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
  </main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- ======= Footer ======= -->
<?php include('footer.php');?>
 <!-- ======= scripts ======= -->
<?php include('scripts.php');?>
<script>
// เมื่อโหลดเสร็จแล้ว
$(document).ready(function() {
  // โหลดรายการปีการศึกษาและแสดงใน Dropdown
  $.ajax({
    url: 'Get_data_students/get_years.php', // ไฟล์ PHP ที่ใช้เพื่อดึงปีการศึกษา
    type: 'GET',
    success: function(response) {
      $('#yearSelect').html(response);
    }
  });

  // เมื่อเลือกปีการศึกษา
  $('#yearSelect').change(function() {
    var year = $(this).val();
    // โหลดรายการห้องเรียนที่เกี่ยวข้องกับปีการศึกษาและแสดงใน Dropdown
    $.ajax({
      url: 'Get_data_students/get_classrooms.php', // ไฟล์ PHP ที่ใช้เพื่อดึงห้องเรียน
      type: 'POST',
      data: {year: year},
      success: function(response) {
        $('#classroomSelect').html(response);
      }
    });
  });

  // ตรวจสอบเมื่อคลิกที่ปุ่ม "บันทึก"
  $('#saveRegistrationBtn').click(function() {
    var studentName = $('#studentName').val();
    var classroom = $('#classroomSelect').val();
    var year = $('#yearSelect').val();
    
    // ทำการบันทึกข้อมูลด้วย AJAX
    $.ajax({
      url: 'save_registration.php', // ไฟล์ PHP ที่ใช้เพื่อบันทึกข้อมูล
      type: 'POST',
      data: {studentName: studentName, classroom: classroom, year: year},
      success: function(response) {
        alert(response); // แสดงข้อความตอบกลับ
        $('#registerModal').modal('hide'); // ปิด Modal
      }
    });
  });
});
</script>
</body>
</html>
