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
  <main id="main" class="main">
  <div class="pagetitle">
      <h1>My Course</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">My Course</li>
        </ol>
      </nav>      
    </div><!-- End Page Title -->
</nav>
    <section class="section dashboard">
      <div class="row">
           <!-- My Course -->
           <div class="col-lg-12">
           
              <div class="card overflow-auto">
                <div class="card-body">
                <div class="card-header">
    <div class="row justify-content-between align-items-center">
        <div class="col">
            <h4 class="mt-2">รายวิชาของฉัน</h4>
        </div>
        <div class="col-auto">
            <div class="form-group mb-0">
                <label class="mb-0" for="display-format">รูปแบบการแสดงผล:</label>
                <select class="form-control" id="display-format">
                    <option value="table">Table</option>
                    <option value="card">Card</option>
                </select>
            </div>
        </div>
    </div>
</div>

         
 
                  <a href="add_course.php"  class="btn btn-outline-primary mt-2 me-2" style=" float: right;">เพิ่มวิชาใหม่</a>
                  <div class="mt-6">           
                  <table class="table table-borderless datatable table-format mt-5">
                    <thead>
                    <tr>
                        <th scope="col">รูป</th>
                        <th scope="col">ชื่อวิชา</th>
                        <th scope="col">รหัสวิชา</th>
                        <th scope="col">รายละเอียด</th>
                        <th scope="col">รหัสลงทะเบียนเข้าเรียน</th>
                        <th scope="col">สถานะ</th>
                        <th scope="col">ตัวเลือก</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $stmt = $db->prepare("SELECT * FROM courses WHERE teacher_id = :teacher_id");
                        $stmt->bindParam(':teacher_id', $user_id);
                        $stmt->execute();
                        $courses = $stmt->fetchAll();
                        if (!$courses) {
                            echo "<tr><td colspan='6' class='text-center'>No courses found</td></tr>";
                        } else {
                            foreach ($courses as $row) {
                        ?>
                                <tr>
                                <td>
    <?php if(isset($row['c_img']) && !empty($row['c_img'])): ?>
        <img src="<?= $row['c_img']; ?>" alt="Course Image" class="rounded-circle" style="width: 60px; height: 60px;">
    <?php else: ?>
        <img src="../admin/teacher_process/img/course.jpg" alt="Placeholder Image" class="rounded-circle" style="width: 60px; height: 60px;">
    <?php endif; ?>
</td>

                                    <td><?= $row['course_name']; ?></a></td>
                                    <td><?= $row['course_code']; ?></td>
                                    <td class="description-column"><?= $row['description']; ?></td>
                                    <td align="center">
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editAccessCodeModal<?= $row['c_id']; ?>">
                                            Edit Access Code
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="editAccessCodeModal<?= $row['c_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Access Code</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- แบบฟอร์มสำหรับแก้ไข access_code -->
                                                        <form method="post" action="access_code.php">
                                                            <input type="hidden" name="course_id" value="<?= $row['c_id']; ?>">
                                                            <label for="newAccessCode">New Access Code:</label>
                                                            <input type="text" class="form-control" id="newAccessCode" name="new_access_code" required>
                                                            <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php 
                                            if ($row['is_open'] == 1) {
                                                echo '<span style="color: green;">เปิด</span>';
                                            } else {
                                                echo '<span style="color: red;">ปิด</span>';
                                            }
                                        ?>
                                    </td>
                                    <td class="td-button" align="center">
                                    <a href="add_lessons.php?course_id=<?= $row['c_id']; ?>" class="btn btn-success btn-xs me-2"><i class="bi bi-file-plus"></i> แก้ไขบทเรียน</a>
                                    <a href="form_update_course.php?course_id=<?= $row['c_id']; ?>" class="btn btn-outline-warning btn-xs me-2"><i class="bi bi-pencil-fill"></i></a>
                                    <!-- เพิ่มฟอร์มสำหรับคัดลอกและบันทึก -->
                                    <form id="copyForm" method="post" action="copy_course.php" onsubmit="return confirmCopy()">
                                        <input type="hidden" name="existing_course" value="<?= $row['c_id']; ?>">
                                        <input type="hidden" name="new_course_name" value="Copy of <?= $row['course_name']; ?>">
                                        <button type="submit" class="btn btn-outline-primary"><i class="bi bi-copy"></i></button>
                                    </form>
                                </td>
                                    </tr>
                              <?php
                            }
                        }
                                        ?>
                </tbody>
                </table>
                <div class="card-columns card-format">
    <?php
        $i = 0;
        foreach ($courses as $row) {
            if ($i % 3 == 0) {
                echo '<div class="row">';
            }
    ?>
   <div class="col-lg-4 mb-4">
    <div class="card shadow border">
        <?php if(isset($row['c_img']) && !empty($row['c_img'])): ?>
            <img src="<?= $row['c_img']; ?>" class="card-img-top" alt="Course Image">
    <?php else: ?>
        <img src="../admin/teacher_process/img/course.jpg" class="card-img-top" alt="Course Image">
    <?php endif; ?>
        <div class="card-body">
            <h5 class="card-title"><?= $row['course_name']; ?></h5>
            <p class="card-text"><?= $row['course_code']; ?></p>
            <p class="card-text" style="max-height: 70px; overflow-y: auto;"><?= $row['description']; ?></p>
            <p style="color: <?php echo ($row['is_open'] == 1) ? 'green' : 'red'; ?>; border: 1px solid <?php echo ($row['is_open'] == 1) ? 'green' : 'red'; ?>; padding: 5px; border-radius: 5px;">
                สถานะ: <?php echo ($row['is_open'] == 1) ? 'เปิด' : 'ปิด'; ?>
            </p>
            <div class="td-button" style="float: inline-end;">  
                <a href="add_lessons.php?course_id=<?= $row['c_id']; ?>" class="btn btn-success btn-xs me-2"><i class="bi bi-file-plus"></i> แก้ไขบทเรียน</a>       
                <a href="form_update_course.php?course_id=<?= $row['c_id']; ?>" class="btn btn-outline-warning me-1"><i class="bi bi-pencil-fill"></i></a>
                <!-- เพิ่มฟอร์มสำหรับคัดลอกและบันทึก -->
                <form id="copyForm" method="post" action="copy_course.php" onsubmit="return confirmCopy()">
                    <input type="hidden" name="existing_course" value="<?= $row['c_id']; ?>">
                    <input type="hidden" name="new_course_name" value="Copy of <?= $row['course_name']; ?>">
                    <button type="submit" class="btn btn-outline-primary "><i class="bi bi-copy"></i></button>
                </form>
            </div>  
        </div>
    </div>
</div>

    <?php
            $i++;
            if ($i % 3 == 0) {
                echo '</div>';
            }
        }
    ?>
</div><!-- End card-format -->


            </div>

          </div>
        </div><!-- My Course -->
  </div>
</section>
</main><!-- End #main -->
<script>
    function confirmCopy() {
        return confirm("คุณแน่ใจหรือไม่ที่ต้องการคัดลอกและบันทึกเป็นคอร์สใหม่?");
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- ======= Footer ======= -->
<?php include('footer.php');?>
 <!-- ======= scripts ======= -->
<?php include('scripts.php');?>
<script>
  $(document).ready(function() {
    $('#display-format').change(function() {
      var format = $(this).val();
      if (format === 'table') {
        $('.card-format').hide();
        $('.table-format').show();
      } else if (format === 'card') {
        $('.table-format').hide();
        $('.card-format').show();
      }
    });
  });
</script>
</body>
</html>