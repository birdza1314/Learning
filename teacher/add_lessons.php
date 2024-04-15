<?php
include('../connections/connection.php');
// ตรวจสอบว่ามีการล็อกอินและมีบทบาทเป็น 'teacher' หรือไม่
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    // ถ้าไม่ได้ล็อกอินหรือบทบาทไม่ใช่ 'teacher' ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหรือหน้าที่คุณต้องการ
    header('Location: ../login'); 
    exit();
}
// ตรวจสอบว่ามีข้อมูล $teacher หรือไม่
if (!empty($_SESSION['teacher_id'])) {
    $teacher_id = $_SESSION['teacher_id'];

    try {
        // ทำคำสั่ง SQL เพื่อดึงข้อมูลของครู
        $stmt = $db->prepare("SELECT * FROM teachers WHERE teacher_id = :teacher_id");
        $stmt->bindParam(':teacher_id', $teacher_id);
        $stmt->execute();

        // ดึงข้อมูลจากผลลัพธ์ของคำสั่ง SQL
        $teacher = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // แสดงข้อผิดพลาด
        echo "Error: " . $e->getMessage();
        exit(); // จบการทำงานถ้าพบข้อผิดพลาด
    }
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

// Check if course_id is set
if(isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];

    try {
        // Prepare SQL statement to select lessons of the specific course and user
        $stmt = $db->prepare("SELECT * FROM lessons WHERE course_id = :course_id");
        $stmt->bindParam(':course_id', $course_id);
        $stmt->execute();

        // Fetch lessons data
        $lessons = $stmt->fetchAll();
    } catch (PDOException $e) {
        // Display an error message if something goes wrong
        echo "Error: " . $e->getMessage();
        exit(); // Stop script execution if an error occurs
    }
}
// ตรวจสอบว่ามีการส่ง course_id มาหรือไม่
if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];

    try {
        // ทำคำสั่ง SQL เพื่อดึงข้อมูลของคอร์สที่ต้องการแก้ไข
        $stmt = $db->prepare("SELECT * FROM courses WHERE c_id = :course_id");
        $stmt->bindParam(':course_id', $course_id);
        $stmt->execute();

        // ดึงข้อมูลจากผลลัพธ์ของคำสั่ง SQL
        $course = $stmt->fetch(PDO::FETCH_ASSOC);

        // ดึงข้อมูลกลุ่มทั้งหมด
        $stmt = $db->query("SELECT * FROM learning_subject_group");
        $stmt->execute();
        $groups = $stmt->fetchAll();
    } catch (PDOException $e) {
        // แสดงข้อผิดพลาด
        echo "Error: " . $e->getMessage();
        exit(); // จบการทำงานถ้าพบข้อผิดพลาด
    }

    // ตรวจสอบว่ามีข้อมูล $teacher หรือไม่
    if (!empty($_SESSION['teacher_id'])) {
        $teacher_id = $_SESSION['teacher_id'];

        try {
            // ทำคำสั่ง SQL เพื่อดึงข้อมูลของครู
            $stmt = $db->prepare("SELECT * FROM teachers WHERE teacher_id = :teacher_id");
            $stmt->bindParam(':teacher_id', $teacher_id);
            $stmt->execute();

            // ดึงข้อมูลจากผลลัพธ์ของคำสั่ง SQL
            $teacher = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // แสดงข้อผิดพลาด
            echo "Error: " . $e->getMessage();
            exit(); // จบการทำงานถ้าพบข้อผิดพลาด
        }
    }
} else {
    // ถ้าไม่มี course_id ที่ส่งมา ให้ redirect หรือทำการแจ้งเตือนตามที่เหมาะสม
    header('Location: index');
    exit();
}
?>
<!-- ======= Head ======= -->
<?php include('head.php'); ?>
<!-- ======= Head ======= -->

<body>

  <!-- ======= Header ======= -->
  <?php include('header.php'); ?>

  <!-- ======= Sidebar ======= -->
  <?php include('sidebar.php'); ?>

  <main id="main" class="main">
  <div class="pagetitle">
        <h1>Edit Course</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="#" onclick="history.back()">My Course</a></li>
                <li class="breadcrumb-item"><a href="#" onclick="history.back()">Edit Course</a></li>
                <li class="breadcrumb-item active">Ad Lessons</li>
            </ol>
        </nav>      
    </div><!-- End Page Title -->

  <div class="container">
    <div class="card">
        <div class="card-body">
        
        <div class="card mt-3">
            <div class="card-body">
            
            <?php if (!empty($course['c_img'])): ?>
                <div class="text-center">
                    <img src="<?php echo $course['c_img']; ?>" class="card-img-top" alt="รูปภาพ" style="max-width: 50%; height: auto;">
                </div>
            <?php endif; ?>


                <h5 class="card-title"><?php echo $course['course_name']; ?></h5>
                <p class="card-text">รหัสวิชา: <?php echo $course['course_code']; ?></p>
                <p class="card-text">รายละเอียด: <?php echo $course['description']; ?></p>

            </div>
        </div>
        <div class="row">
    <div class="col-12 d-flex justify-content-end">
        <button type="button" class="btn btn-primary mt-3 open-Lesson-modal">เพิ่มบทเรียน</button>
    </div>
</div>


            <!-- เพิ่ม Element input hidden สำหรับ courseId -->
            <input type="hidden" id="courseId" value="<?= $course_id ?>">
            <div id="accordionContainer">
           
                <!-- Loop through lessons and display them --> 
                <?php include('display_topics.php');?>
            </div>
        </div>
    </div>
</div>

<?php include('Modal.php');?>
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php include('footer.php');?>
 <!-- ======= scripts ======= -->
  <?php include('scripts.php');?>

  <!-- Add jQuery script -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Add Bootstrap script -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  

  <?php include('scripts_topic.php');?>
  <?php include('Modal_scripts.php');?>
</body>
</html>
