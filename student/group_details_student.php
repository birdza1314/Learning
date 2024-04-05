<?php

session_start();
include('../connections/connection.php');

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    // ถ้าไม่ได้ล็อกอินหรือบทบาทไม่ใช่ 'student' ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหรือหน้าที่คุณต้องการ
    header('Location: ../login'); 
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

<?php
     include('head.php');
?>
<body>
<?php
     include('header.php');
     include('sidebar.php');
     
?>

  <main id="main" class="main">

    <div class="container  mt-5">
    <div class="card " >  
      <div class="card-title">
    <h3 class="text-center mt-2">รายละเอียด</h3>
    <h4 class="text-center"><?php echo $group_name; ?></h4>
    <hr color="blue" size="3" width="100%">
    </div>  
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
                          <a href="course_details?course_id=<?php echo $course['c_id']; ?>" class="btn btn-outline-primary" style="float: right;">รายละเอียด</a>
                      </div>
                  </div>
              </div>
          <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    </div>
  </main>
  <?php include('footer.php');?>
 <!-- ======= scripts ======= -->
 <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<?php include('scripts.php');?>


</body>
</html>

