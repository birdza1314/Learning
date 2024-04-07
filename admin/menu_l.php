<!-- Main Sidebar Container -->
<?php
include('../connections/connection.php');

// ตรวจสอบว่ามีการล็อกอินและมีบทบาทเป็น 'admin' หรือไม่
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // ถ้าไม่ได้ล็อกอินหรือบทบาทไม่ใช่ 'admin' ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหรือหน้าที่คุณต้องการ
    header('Location: ../login'); 
    exit();
}

try {
    // ทำคำสั่ง SQL เพื่อดึงข้อมูลของผู้ใช้ที่ล็อกอิน
    $user_id = $_SESSION['user_id'];
    $stmt = $db->prepare("SELECT * FROM admin WHERE a_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    
    // ดึงข้อมูลจากผลลัพธ์ของคำสั่ง SQL
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // แสดงข้อผิดพลาด
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
}

?>
  <aside class="main-sidebar sidebar-light-navy elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link bg-navy">
      <img src="assets/dist/img/AdminLTELogo.png"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Admin | Process</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="assets/dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="p-2">
        <?php echo $admin['username'];?>
        <a href="admin_edit" class="btn btn-warning btn-xs "><i class="fas fa-pencil-alt"></i></a>
        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#adminModal">
            <i class="fa fa-user-plus"></i> 
        </button>
      </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <!-- nav-compact -->
        <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
       <!-- เมนู Dashboard -->
<li class="nav-item">
    <a href="index" class="nav-link <?php if($menu=="Dashboard"){echo "active";} ?> ">
        <i class="nav-icon fas fa-chart-line"></i> <!-- เปลี่ยนไอคอนเป็น fa-chart-line -->
        <p>Dashboard</p>
    </a>
</li>

<!-- เมนู ข้อมูลนักเรียน -->
<li class="nav-item">
    <a href="student_data" class="nav-link <?php if($menu=="student"){echo "active";} ?> ">
        <i class="nav-icon fas fa-user-graduate"></i> <!-- เปลี่ยนไอคอนเป็น fa-user-graduate -->
        <p>ข้อมูลนักเรียน</p>
    </a>
</li>

<!-- เมนู ข้อมูลบุคลากร -->
<li class="nav-item" >
    <a href="teacher" class="nav-link <?php if($menu=="index"){echo "active";} ?> ">
        <i class="nav-icon fas fa-chalkboard-teacher"></i> <!-- เปลี่ยนไอคอนเป็น fa-chalkboard-teacher -->
        <p>ข้อมูลครู</p>
    </a>
</li>

<!-- เมนู วิชาทั้งหมด -->
<li class="nav-item" >
    <a href="Lib_course" class="nav-link <?php if($menu=="course"){echo "active";} ?> ">
        <i class="nav-icon fas fa-book"></i> <!-- เปลี่ยนไอคอนเป็น fa-book -->
        <p>วิชาทั้งหมด</p>
    </a>
</li>

<!-- เมนู ออกจากระบบ -->
<li class="nav-item">
    <a href="../logout" class="nav-link text-danger">
        <i class="nav-icon fas fa-sign-out-alt"></i> <!-- เปลี่ยนไอคอนเป็น fa-sign-out-alt -->
        <p>ออกจากระบบ</p>
    </a>
</li>

        </ul>
      </nav>

      <!-- /.sidebar-menu -->
      <!-- http://fordev22.com/ -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <!-- Modal for Add Member -->
<div class="modal fade" id="adminModal" tabindex="-1" aria-labelledby="adminModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="adminModalLabel">เพิ่มข้อมูลสมาชิกฝ่ายทะเบียน</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="admin_process/admin_insert" method="post">
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
            <button type="submit" class="btn btn-primary">บันทึก</button>
        </form>
      </div>
    </div>
  </div>
</div>