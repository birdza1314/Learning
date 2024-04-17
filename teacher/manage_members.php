<?php
// เชื่อมต่อกับฐานข้อมูล
include('../connections/connection.php');

// ตรวจสอบการล็อกอินและบทบาทของผู้ใช้
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header('Location: ../login'); 
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

$stmt = $db->prepare("SELECT scr.student_id, s.username, s.classroom, s.classes, s.first_name, s.last_name
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

  <h2 class="py-3">จัดการสมาชิก</h2>
<div class="container">
    <div class="card overflow-auto">
       <div class="card-body">
            <div class="row" >
                <div class="col-sm-7">
                    
                    <h2 class="py-3">วิชา:  <?= $course['course_name']; ?></h2>
                </div>
                    <div class="col-sm-5 d-flex " >
                  <!-- Button trigger modal -->
                  <button type="button" class="btn btn-outline-primary mt-5 py-3 open-addstudent-modal" >
                  ลงทะเบียนรายบุคคล
                    </button>
                    <a href="add_student_to_course.php?course_id=<?= $course['c_id']; ?>" type="button" class="btn btn-outline-primary mt-5 mx-4 py-3" >
                    ลงทะเบียนเป็นห้อง
                    </a>
                    </div>
        <table class="table table-borderless datatable table-format">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>รหัสนักเรียน</th>
                    <th>ชื่อ-นามสกุล</th> 
                    <th>ระดับชั้น</th>        
                    <th>ห้องเรียน</th>
                    <th>ตัวเลือก</th>   
                </tr>
            </thead>
            <tbody>
                <?php foreach ($members as $member): ?>
                    <tr>
                        <td scope="row"><?= $counter++; ?></td>
                        <td><?= $member['username']; ?></td>
                        <td><?= $member['first_name']; ?>  <?= $member['last_name']; ?></td>
                        <td><?= $member['classes']; ?></td>
                        <td><?= $member['classroom']; ?></td>
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
  
<!-- Modal Add Lessons -->
<div class="modal fade" id="addstudentModal" tabindex="-1" aria-labelledby="addstudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addstudentModalLabel">ลงทะเบียนรายบุคคล</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addStudentForm">
                    <div class="form-group">
                        <label for="username">รหัสนักเรียน</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="username" name="username" required>
                            <button type="button" class="btn btn-outline-secondary" id="fetchStudentDataBtn">ดึงข้อมูล</button>
                        </div>
                        <small id="noDataMessage" class="form-text text-danger d-none">ไม่มีข้อมูลนักเรียน</small>
                    </div>
                    
                        <input type="hidden" class="form-control" id="s_id" name="s_id">
                  
                    <div class="form-group">
                        <label for="first_name">ชื่อ</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="last_name">นามสกุล</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="classes">ระดับชั้น</label>
                        <input type="text" class="form-control" id="classes" name="classes" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="classroom">ห้องเรียน</label>
                        <input type="text" class="form-control" id="classroom" name="classroom" required readonly>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveaddstd">บันทึก</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- ======= Footer ======= -->
<?php include('footer.php');?>
 <!-- ======= scripts ======= -->
<?php include('scripts.php');?>
<script>
  $(document).on('click', '.open-addstudent-modal', function() {

$('#addstudentModal').modal('show'); 
});
$(document).ready(function() {
    $('#fetchStudentDataBtn').click(function() {
        var username = $('#username').val();
        $.ajax({
            url: 'Get_data_students/get_student_data.php',
            type: 'POST',
            data: { student_id: username },
            success: function(response) {
                var studentData = JSON.parse(response);
                if (studentData) {
                    $('#s_id').val(studentData.s_id);
                    $('#first_name').val(studentData.first_name);
                    $('#last_name').val(studentData.last_name);
                    $('#classes').val(studentData.classes);
                    $('#classroom').val(studentData.classroom);
                    $('#noDataMessage').addClass('d-none');
                } else {
                     $('#s_id').val('');
                    $('#first_name').val('');
                    $('#last_name').val('');
                    $('#classes').val('');
                    $('#classroom').val('');
                    $('#noDataMessage').removeClass('d-none');
                }
            }
        });
    });
    $('#saveaddstd').click(function() {
    var student_id = $('#s_id').val(); // ใช้ $('#s_id').val(); แทน $('#username').val();
    var classes = $('#classes').val();
    var classroom = $('#classroom').val();
    var course_id = <?php echo $course_id; ?>; 

    // แสดงค่าที่ส่งไปใน Console Log
    console.log('student_id:', student_id);
    console.log('classes:', classes);
    console.log('classroom:', classroom);
    console.log('course_id:', course_id);

    $.ajax({
    url: 'save_std_regist_course.php',
    type: 'POST',
    data: {
        student_id: student_id,
        classes: classes,
        classroom: classroom,
        course_id: course_id
    },
    success: function(response) {
        if (response == 'success') {
            $('#addstudentModal').modal('hide');
            alert('บันทึกข้อมูลนักเรียนสำเร็จ');
            location.reload(); // รีเฟรชหน้าเว็บ
        } else {
            alert('เกิดข้อผิดพลาดในการบันทึกข้อมูลนักเรียน');
        }
    }
});
});
});

</script>
</body>
</html>
