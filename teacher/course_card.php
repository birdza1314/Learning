<?php
include('../connections/connection.php');

// ตรวจสอบว่ามีการล็อกอินและมีบทบาทเป็น 'teacher' หรือไม่
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    // ถ้าไม่ได้ล็อกอินหรือบทบาทไม่ใช่ 'teacher' ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหรือหน้าที่คุณต้องการ
    header('Location: login.php'); 
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
?>
<?php
     include('head.php');
?>
<body>
<?php
     include('header.php');
     include('sidebar.php');
     
?>
<?php $menu = "index"; ?>



  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>      
    </div><!-- End Page Title -->


<section class="section dashboard">
  <div class="row">
       <!-- My Course -->
       <div class="col-lg-12">
          <h5>My Course</h5>
          <a href="add_course.php"  class="btn btn-outline-primary" style=" float: right;">Add Course</a>
          <div class="mt-5">           
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php
                $stmt = $db->prepare("SELECT * FROM courses WHERE teacher_id = :teacher_id");
                $stmt->bindParam(':teacher_id', $user_id);
                $stmt->execute();
                $courses = $stmt->fetchAll();
                if (!$courses) {
                    echo "<div class='col'>No courses found</div>";
                } else {
                    foreach ($courses as $row) {
                ?>
                        <div class="col">
                            <div class="card">
                                <img src="<?= $row['c_img']; ?>" class="card-img-top" alt="Course Image" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $row['course_name']; ?></h5>
                                    <p class="card-text"><?= $row['description']; ?></p>
                                    <a href="form_update_course.php?course_id=<?= $row['c_id']; ?>" class="btn btn-warning"><i class="bi bi-pencil-fill"></i> Edit</a>
                                    <a href="Delete_course.php?course_id=<?= $row['c_id']; ?>" class="btn btn-danger" onclick="return confirm('คุณต้องการลบคอร์สนี้ใช่หรือไม่?')"><i class="bi bi-trash-fill"></i> Delete</a>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
          </div>
      </div><!-- My Course -->
  </div>
</section>


</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php include('footer.php');?>
<!-- ======= scripts ======= -->
<?php include('scripts.php');?>


</body>
</html>

