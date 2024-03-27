<!-- Main Sidebar Container -->
<?php
include('../connections/connection.php');

// ตรวจสอบว่ามีการล็อกอินและมีบทบาทเป็น 'admin' หรือไม่
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // ถ้าไม่ได้ล็อกอินหรือบทบาทไม่ใช่ 'admin' ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหรือหน้าที่คุณต้องการ
    header('Location: login.php'); 
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
        <a href="admin_edit.php" class="btn btn-warning btn-xs "><i class="fas fa-pencil-alt"></i></a>
      </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <!-- nav-compact -->
        <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
            <a href="index.php" class="nav-link <?php if($menu=="Dashboard"){echo "active";} ?> ">
              <i class="nav-icon fas fa-address-card"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <li class="nav-header">Page</li>


          <li class="nav-item">
            <a href="student_data.php" class="nav-link <?php if($menu=="student"){echo "active";} ?> ">
              <i class="nav-icon fas fa-address-card"></i>
              <p>ข้อมูลนักเรียน</p>
            </a>
          </li>
      
          <li class="nav-item" >
            <a href="teacher.php" class="nav-link <?php if($menu=="index"){echo "active";} ?> ">
              <i class="nav-icon fas fa-address-card"></i>
              <p>ข้อมูลบุคลากร</p>
            </a>
          </li>
          <li class="nav-item" >
            <a href="#" class="nav-link <?php if($menu=="course"){echo "active";} ?> ">
              <i class="nav-icon fas fa-address-card"></i>
              <p>วิชาทั้งหมด</p>
            </a>
          </li>

      <div class="user-panel mt-2 pb-3 mb-2 d-flex">
  
      </div>
          <li class="nav-item">
            <a href="../logout.php" class="nav-link text-danger">
              <i class="nav-icon fas fa-power-off"></i>
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