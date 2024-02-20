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

 <!-- ======= Head ======= -->
<?php  $menu = "Course"; include('head.php');?>

<body>

  <!-- ======= Header ======= -->
  <?php include('header.php');?>

  <!-- ======= Sidebar ======= -->
  <?php include('sidebar.php');?>

  <main id="main" class="main">

<div class="pagetitle">
  <h1>Cards</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item">Components</li>
      <li class="breadcrumb-item active">Cards</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row align-items-top">
    <div class="col-lg-6">

      <!-- Card with an image on left -->
      <div class="card mb-3">
        <div class="row g-0">
          <div class="col-md-4">
            <img src="assets/img/card.jpg" class="img-fluid rounded-start" alt="...">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title">Card with an image on left</h5>
              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
            </div>
          </div>
        </div>
      </div><!-- End Card with an image on left -->

    </div>

    

    </div>

  </div>
</section>

</main><!-- End #main -->













  
  <!-- ======= Footer ======= -->
<?php include('footer.php');?>

<!-- ======= scripts ======= -->
<?php include('scripts.php');?>

</body>

</html>