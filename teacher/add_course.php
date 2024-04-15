<?php
include('../connections/connection.php');

// ตรวจสอบว่ามีการล็อกอินและมีบทบาทเป็น 'teacher' หรือไม่
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    // ถ้าไม่ได้ล็อกอินหรือบทบาทไม่ใช่ 'teacher' ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหรือหน้าที่คุณต้องการ
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
?>
<!-- ======= Head ======= -->
<?php 
  include('head.php'); 
?>
<!-- ======= Head ======= -->

<body>

  <!-- ======= Header ======= -->
  <?php include('header.php'); ?>



  <!-- ======= Sidebar ======= -->
  <?php include('sidebar.php'); ?>
  <main id="main" class="main">

<div class="pagetitle">
  <h1>Add Course</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
      <li class="breadcrumb-item">Forms</li>
    </ol>
  </nav>
</div><!-- End Page Title -->
<section class="section">
  <div class="row">
    <div class="col-lg-6 mx-auto">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">เพิ่มรายวิชา</h5>

          <!-- Horizontal Form -->
          <form class=" mx-auto" action="add_course_db" method="post" enctype="multipart/form-data">
          <div class="row mb-3">
                  <label for="c_img" class="col-sm-2 col-form-label">รูป</label>
                  <div class="col-sm-10">
                    <input class="form-control" type="file" id="c_img" name="c_img">
                  </div>
                </div>
            <div class="row mb-3">
              <label for="course_name" class="col-sm-2 col-form-label">ชื่อ วิชา<span style="color: red;">*</span></label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="course_name" name="course_name" required>
              </div>
            </div> 
            <div class="row mb-3">
              <label for="course_Code" class="col-sm-2 col-form-label">รหัส วิชา<span style="color: red;">*</span></label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="course_Code" name="course_Code" required>
              </div>
            </div>
            <div class="row mb-3">
                <label for="class_id" class="col-sm-2 col-form-label">ระดับชั้น<span style="color: red;">*</span></label>
                <div class="col-sm-10">
                    <!-- ใช้ select element เพื่อให้เลือกกลุ่ม -->
                    <select class="form-select" id="class_id" name="class_id">
                        <!-- ตรวจสอบและแสดงตัวเลือกจากข้อมูลที่มีอยู่ในฐานข้อมูล -->
                        <?php
                        $stmt = $db->query("SELECT * FROM classes");
                        $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($groups as $group) {
                            echo "<option value='{$group['class_id']}'>{$group['classes']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>    
            <div class="row mb-3">
                <label for="group_id" class="col-sm-2 col-form-label">กลุ่ม<span style="color: red;">*</span></label>
                <div class="col-sm-10">
                    <!-- ใช้ select element เพื่อให้เลือกกลุ่ม -->
                    <select class="form-select" id="group_id" name="group_id">
                        <!-- ตรวจสอบและแสดงตัวเลือกจากข้อมูลที่มีอยู่ในฐานข้อมูล -->
                        <?php
                        $stmt = $db->query("SELECT * FROM learning_subject_group");
                        $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($groups as $group) {
                            echo "<option value='{$group['group_id']}'>{$group['group_name']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>         
              <div class="row mb-3">
                  <label for="inputPassword" class="col-sm-2 col-form-label">รายละเอียด</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" style="height: 100px" name="course_description"></textarea>
                  </div>
                </div> 
            <div class="text-center">
              <button type="submit" class="btn btn-primary">บันทึก</button>
              <a href="../teacher/course" class="btn btn-secondary" onclick="cancelEdit()">ยกเลิก</a>
            </div>
          </form><!-- End Horizontal Form -->

        </div>
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
