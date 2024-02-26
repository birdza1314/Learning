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
  <?php
            include('pagetitle.php'); // เรียกไฟล์ที่เก็บฟังก์ชัน

            // ดึงชื่อหน้าปัจจุบันจาก URL หรือไฟล์ที่เก็บ
            $currentPage = 'course'; // ตั้งค่าตามที่ต้องการ

            // ส่วน HTML แสดง breadcrumb
            echo '<div class="pagetitle">
                    <h1>Form Layouts</h1>
                    <nav>
                        <ol class="breadcrumb">
                            ' . generateBreadcrumb($currentPage) . '
                        </ol>
                    </nav>
                </div><!-- End Page Title -->';
            ?>
</nav>
    <section class="section dashboard">
      <div class="row">
           <!-- My Course -->
           <div class="col-lg-12">
           
              <div class="card overflow-auto">
                <div class="card-body">
                  <div class="row">
                  <h4 class="mt-2">My Course</h4>
                  <p class="mt-2">My Course</p>
                  </div>    
                  <a href="add_course.php"  class="btn btn-outline-primary" style=" float: right;">Add Course</a>
                  <div class="mt-5">           
                  <table class="table table-borderless datatable">
                  </div>
                    <thead>
                    <tr>
                        <th scope="col">รูป</th>
                        <th scope="col">ชื่อวิชา</th>
                        <th scope="col">รหัสวิชา</th>
                        <th scope="col">รายละเอียด</th>
                        <th scope="col">รหัสลงทะเบียนเข้าเรียน</th>
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
                                    <td><img src="<?= $row['c_img']; ?>" alt="Course Image" class="rounded-circle" style="width: 60px; height: 60px;"></td>
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
                                    <td align="center">
                                        <a href="form_update_course.php?course_id=<?= $row['c_id']; ?>" class="btn btn-outline-warning btn-xs"><i class="bi bi-pencil-fill"></i></a>
                                        <a href="Delete_course.php?course_id=<?= $row['c_id']; ?>" class="btn btn-outline-danger btn-xs" onclick="return confirm('คุณต้องการลบคอร์สนี้ใช่หรือไม่?')"><i class="bi bi-trash-fill"></i></a>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                  </table>

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
