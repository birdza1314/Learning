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

    <div class="pagetitle">
      <h1 >Welcome Back : <?php echo $student['first_name'];?>! 👋</h1>
   
    </div><!-- End Page Title -->


    <div class="card overflow-auto "style="text-align: center;">
        <div class="card-title mt-4" >
            <h3 style="font-family: 'Arial', sans-serif; color: #333; margin: 0;">กลุ่มสาระการเรียนรู้</h3>
        </div>

        <div class="card-body">


        <div class="row mt-5">
        <div class="col-sm-6">
            <a href="group_details_student?group_id=1">
                <div class="card-body">
                    <!-- เพิ่มรูปภาพ -->
                    <img style="margin-left: 150px; " src="../teacher/uploads/group/1.png" alt="ภาษาไทย" width="70%" class="hover-img">
                </div>
            </a>
        </div>

        <div class="col-sm-6">
            <a href="group_details_student?group_id=2">
                <div class="card-body">
                    <!-- เพิ่มรูปภาพ -->
                    <img style=" margin-right: 150px;" src="../teacher/uploads/group/2.png" alt="คณิตศาสตร์" width="70%" class="hover-img">
                </div>
            </a>
        </div>  
    </div>

    <div class="row">
        <div class="col-sm-6 d-flex justify-content-center align-items-center">    
            <a href="group_details_student?group_id=3">
                <div class="card-body">
                    <!-- เพิ่มรูปภาพ -->
                    <img  style="margin-left: 150px; " src="../teacher/uploads/group/3.png" alt="วิทยาศาสตร์และเทคโนโลยี" width="70%" class="hover-img">
                </div>
            </a>
        </div>

        <div class="col-sm-6 d-flex justify-content-center align-items-center">
            <a href="group_details_student?group_id=4">
                <div class="card-body">
                    <!-- เพิ่มรูปภาพ -->
                    <img style=" margin-right: 150px;" src="../teacher/uploads/group/4.png" alt="สังคมศึกษาฯ" width="70%" class="hover-img">
                </div>
            </a>
        </div>  
    </div>

    <div class="row">
        <div class="col-sm-6 d-flex justify-content-center align-items-center"> 
            <a href="group_details_student?group_id=5">
                <div class="card-body">
                    <!-- เพิ่มรูปภาพ -->
                    <img style="margin-left: 150px;" src="../teacher/uploads/group/5.png" alt="สุขศึกษาฯ" width="70%" class="hover-img">
                </div>
            </a> 
        </div>

        <div class="col-sm-6 d-flex justify-content-center align-items-center">         
            <a href="group_details_student?group_id=6">
                <div class="card-body">
                    <!-- เพิ่มรูปภาพ -->
                    <img style=" margin-right: 150px;" src="../teacher/uploads/group/6.png" alt="เรียนรู้ศิลปะ" width="70%" class="hover-img">
                </div>
            </a>
        </div> 
    </div>

           <div style="text-align: center;" class="py-4">
                <!-- เพิ่มปุ่มรายวิชาทั้งหมดที่นี่ -->
                <a href="lib_course.php" class="btn btn-outline-primary">รายวิชาทั้งหมด <i class="bi bi-chevron-right"></i></a>
            </div>
            <div class="search-bar">
                <form action="details_All_course" method="POST" class="p-3">
                    <div class="input-group">
                        <input type="text" name="search" id="search" class="form-control form-control-lg  rounded-0" placeholder="ค้นหารายวิชา..." autocomplete="off" required>
                            <input type="submit" name="submit" value="ค้นหา" class="btn btn-outline-secondary btn-sm">
                    </div>
                    <div class="col-md-5">
                        <div class="list-group" style="width: 300px;" id="show-list"></div>
                    </div>
                </form>
            </div><!-- End Search Bar -->
        </div>
    </div><!--Card over -->


  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
<?php include('footer.php');?>
 <!-- ======= scripts ======= -->
 <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<?php include('scripts.php');?>
<script>

$(document).ready(function() {
  $("#search").keyup(function() {
      let searchText = $(this).val();
      if (searchText != "") {
          $.ajax({
              url: "action.php",
              method: "post",
              data: {
                  query: searchText
              },
              success: function(response) {
                  $("#show-list").html(response);
              }
          })
      } else {
          $("#show-list").html("");
      }
  })

  $(document).on('click', 'a', function() {
      $("#search").val($(this).text())
      $("#show-list").html("");
  })
})
</script>

</body>
</html>








