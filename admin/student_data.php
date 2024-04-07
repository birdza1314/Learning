
<?php
include('../connections/connection.php');
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  // ถ้าไม่ได้ล็อกอินหรือบทบาทไม่ใช่ 'admin' ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหรือหน้าที่คุณต้องการ
  header('Location: ../login'); 
  exit();

}
?>
<?php
// เริ่มต้นจากลำดับที่ 1
$counter = 1;
?>
<?php
$menu = "student";
include("header.php");
?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <h1><i class="nav-icon fas fa-address-card"></i> จัดการข้อมูลสมาชิก</h1>
  </div>
</section>

<!-- Main content -->
<section class="content">
  
   <div class="card-header card-navy card-outline d-flex">
    <div class="ml-auto">
        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-user-plus"></i> เพิ่มข้อมูลนักเรียน
        </button>
        <button type="button" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#importModal">
            <i class="fa fa-user-plus"></i> เพิ่มข้อมูลนักเรียน file 
        </button>
          <!--Modal import Excell-->
              <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="importModalLabel">Import Data</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                          <form action="../import_file/student_import" method="POST" enctype="multipart/form-data">
                          <div class="mb-3">
                              <label for="import_file" class="form-label">เพิ่มข้อมูลนักเรียน:</label>
                              <h6 style="color: red;">
                                เฉพาะ ไฟล์นามสกุล 'xls' 'csv' 'xlsx'
                                *
                                </h6>
                              <input type="file" name="import_file" class="form-control" id="import_file">
                          </div>
                          <button type="submit" name="save_excel_data" class="btn btn-primary">Import</button>
                          </form>
                      </div>
                    </div>
                </div>
              </div>
          <!--Modal import Excell-->
              <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>                 
        </div>
    </div>
    <div class="card-body p-1">
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-12">
          <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
            <thead>
              <tr class="bg-info">
                <th scope="col">ลำดับที่</th>
                <th scope="col">ชื่อผู้ใช้</th>
                <th scope="col">ชื่อ</th>
                <th scope="col">นามสกุล</th>
                <th scope="col">ห้องเรียน</th>
                <th scope="col">ปีการศึกษา</th>
                <th scope="col">ตัวเลือก</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $stmt = $db->query("SELECT * FROM students");
              $stmt->execute();
              $students = $stmt->fetchAll();
              if (!$students) {
                echo "<tr><td colspan='6' class='text-center'>No students found</td></tr>";
              } else {
                foreach ($students as $row) {
              ?>
                  <tr>
                  

                    <!-- ใช้ตัวแปร $counter เพื่อแสดงลำดับ -->
                    <td scope="row"><?= $counter++; ?></td>
                    <td><?= $row['username']; ?></td>
                    <td><?= $row['first_name']; ?></td>
                    <td><?= $row['last_name']; ?></td>
                    <td><?= $row['classroom']; ?></td>
                    <td><?= $row['year']; ?></td>
                    <td align="center">
                      
                    <a class="btn btn-info btn-xs" href="#" data-bs-toggle="modal" data-bs-target="#profileModal"data-id="<?= $row['s_id']; ?>"><i class="fas fa-eye"></i></a>
                    <a href="student_edit?s_id=<?= $row['s_id']; ?>" class="btn btn-warning btn-xs"><i class="fas fa-pencil-alt"></i></a>
                      <a href="student_process/student_delete?s_id=<?= $row['s_id']; ?>" type="button" class="btn btn-danger btn-xs" onclick="return confirm('คุณต้องการลบข้อมูลนี้หรือไม่?');"><i class="fas fa-trash-alt"></i></a>
                    </td>
                  </tr>
              <?php
                }
              }
              ?>
            </tbody>
          </table>
        </div>
        <div class="col-md-1"></div>
      </div>
    </div>

  
 <!-- Modal for User Profile -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="profileModalLabel">โปรไฟล์ผู้ใช้</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <!-- ใช้ Bootstrap Grid System เพื่อจัดรูปแบบข้อมูล -->
          <div class="container">
            <div class="row mb-3">
              <label class="col-md-3 col-form-label">ลำดับ:</label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="s_id" readonly>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-md-3 col-form-label">Username:</label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="username" readonly>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-md-3 col-form-label">ชื่อ:</label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="first_name" readonly>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-md-3 col-form-label">นามสกุล:</label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="last_name" readonly>
              </div>
            </div>   
            <div class="row mb-3">
              <label class="col-md-3 col-form-label">ห้องเรียน:</label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="classroom" readonly>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-md-3 col-form-label">ปีการศึกษา:</label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="year" readonly>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <!-- เพิ่มปุ่มหรือ Element ต่างๆ ที่ต้องการได้ที่นี่ -->
      </div>
    </div>
  </div>
</div>


<!-- Modal for Add Member -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลสมาชิก</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="student_process/student_insert" method="post">
          <div class="form-group">
            <label for="add_username">ชื่อผู้ใช้:<span style="color:red;">*</span></label>
            <input type="text" class="form-control" id="add_username" name="username" autocomplete="username" required>
          </div>
          <div class="form-group">
              <label for="password">รหัสผ่าน:<span style="color:red;">*</span></label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
              <label for="confirm_password">ยืนยันรหัสผ่าน:<span style="color:red;">*</span></label>
              <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="form-group">
              <label for="first_name">ชื่อ:<span style="color:red;">*</span></label>
              <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
              <label for="last_name">นามสกุล:<span style="color:red;">*</span></label>
              <input type="text" class="form-control" id="last_name" name="last_name" required>
            </div>
            <div class="form-group">
              <label for="classroom">ห้องเรียน:<span style="color:red;">*</span></label>
              <input type="text" class="form-control" id="classroom" name="classroom" required>
            </div>
            <div class="form-group">
              <label for="year">ปีการศึกษา:<span style="color:red;">*</span></label>
              <input type="text" class="form-control" id="year" name="year" required>
            </div>
            <button type="submit" class="btn btn-primary">บันทึก</button>
        </form>
      </div>
    </div>
  </div>
</div>


</section>
<!-- /.content -->

<?php include('footer.php'); ?>
<script>
  $(document).ready(function(){
    // เมื่อ Modal ถูกเปิด
    $('#profileModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // ปุ่มที่ถูกคลิก
      var studentId = button.data('id'); // ดึงค่า data-id จากปุ่มที่ถูกคลิก

      // ดึงข้อมูลนักเรียนจาก get_student_data.php โดยใช้ studentId
      $.ajax({
        type: 'GET',
        url: 'get_student_data.php',
        data: { studentId: studentId },
        dataType: 'json', // เพิ่ม dataType เพื่อให้ jQuery ทราบว่าข้อมูลที่รับมาเป็น JSON
        success: function(data) {
          // นำข้อมูลที่ดึงมาไปแสดงใน Modal
          $('#profileModal .modal-body input[name="s_id"]').val(data.s_id);
          $('#profileModal .modal-body input[name="username"]').val(data.username);
          $('#profileModal .modal-body input[name="first_name"]').val(data.first_name);
          $('#profileModal .modal-body input[name="last_name"]').val(data.last_name);
          $('#profileModal .modal-body input[name="classroom"]').val(data.classroom);
          $('#profileModal .modal-body input[name="year"]').val(data.year);
        },
        error: function() {
          alert('เกิดข้อผิดพลาดในการดึงข้อมูลนักเรียน');
        }
      });
    });
  });
</script>


</body>

</html>