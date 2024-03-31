
<?php
include('../connections/connection.php');
session_start();
if ($_SESSION['role'] !== 'admin') {
  header("Location: login.php");
  exit();
}
?>

<?php
$menu = "course";
include("header.php");
?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <h1> <i class="nav-icon fas fa-book"></i> </i> รายวิชาทั้งหมด</h1>
  </div>
</section>
<div class="card-header card-navy card-outline d-flex">
</div>
<!-- Main content -->
<section class="content">

<div class="card-body p-1">
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-12">
        <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
            <thead>
              <tr class="bg-info">
              <th scope="col">รูป</th>
                <th scope="col">รหัสวิชา</th>
                <th scope="col">ชื่อวิชา</th>
                <th scope="col">ครูผู้สอน</th>
                <th scope="col">กลุ่มสาระการเรียนรู้</th>
                
              </tr>
            </thead>
            <tbody>
    <?php
    $stmt = $db->query("
        SELECT c.course_code, c.course_name, t.first_name, s.group_name, c.c_img
        FROM courses AS c
        INNER JOIN teachers AS t ON c.teacher_id = t.t_id
        INNER JOIN learning_subject_group AS s ON c.group_id = s.group_id
    ");
    $stmt->execute();
    $courses = $stmt->fetchAll();

    if (!$courses) {
        echo "<tr><td colspan='6' class='text-center'>No courses found</td></tr>";
    } else {
        foreach ($courses as $row) {
    ?>
    <tr>
    <td style="text-align: center;">
    <img src="<?= $row['c_img']; ?>" alt="Course Image" width="50">
    </td>
        <td><?= isset($row['course_code']) ? $row['course_code'] : ''; ?></td>
        <td><?= isset($row['course_name']) ? $row['course_name'] : ''; ?></td>
        <td><?= isset($row['first_name']) ? $row['first_name'] : ''; ?></td>
        <td><?= isset($row['group_name']) ? $row['group_name'] : ''; ?></td>
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

    </section>
<!-- /.content -->

<?php include('footer.php'); ?>
</body>

</html>