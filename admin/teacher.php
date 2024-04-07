<?php
include('../connections/connection.php');
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login");
    exit();
}

?>
<?php
// เริ่มต้นจากลำดับที่ 1
$counter = 1;
?>
<?php
$menu = "index";
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
            <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-user-plus"></i> เพิ่มข้อมูลบุคลากร </button>
            <button type="button" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#importModal"><i class="fa fa-user-plus"></i> เพิ่มข้อมูลบุคลากรจากไฟล์</button>
            <!--Modal import Excel-->
            <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="importModalLabel">Import Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../import_file/teacher_import" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="import_file" class="form-label">เลือกไฟล์บุคลากร:</label>
                                    <h6 style="color: red;">
                                        เฉพาะไฟล์นามสกุล 'xls', 'csv', 'xlsx'
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
            <!--Modal import Excel-->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        </div>
    </div>
    <div class="card-body p-1">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-12">
                <!-- ตารางข้อมูล -->
                <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                    <thead>
                        <tr class="bg-info">
                            <th scope="col">ลำดับที่</th>
                            <th scope="col">ชื่อผู้ใช้</th>
                            <th scope="col">ชื่อ</th>
                            <th scope="col">นามสกุล</th>    
                            <th scope="col">กลุ่มสาระการเรียนรู้</th>
                            <th scope="col">ตัวเลือก</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $db->query("SELECT * FROM teachers");
                        $stmt->execute();
                        $teachers = $stmt->fetchAll();
                        if (!$teachers) {
                            echo "<tr><td colspan='8' class='text-center'>No teachers found</td></tr>";
                        } else {
                            foreach ($teachers as $row) {
                                // ดึงข้อมูลกลุ่มที่เรียนจากตาราง learning_subject_group
                                $groupStmt = $db->prepare("SELECT group_name FROM learning_subject_group WHERE group_id = :group_id");
                                $groupStmt->bindParam(':group_id', $row['group_id']);
                                $groupStmt->execute();
                                $groupResult = $groupStmt->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <tr>
                                <td scope="row"><?= $counter++; ?></td>
                                    <td align="center">
                                    <?php
                                    // ตรวจสอบว่ามีข้อมูลใน $row['image'] หรือไม่
                                    if (!empty($row['image'])) {
                                        echo '<img src="teacher_process/img/' . $row['image'] . '" alt="Teacher Image" style="max-width: 100px; max-height: 100px;">';
                                    } else {
                                        // ใช้รูปภาพ Default ในกรณีที่ไม่มีรูปภาพ
                                        echo '<img src="teacher_process/img/Default.png" alt="Default Image" style="max-width: 100px; max-height: 100px;">';
                                    }
                                    ?>
                                    </td>
                                    <td><?= $row['username']; ?></td>
                                    <td><?= $row['first_name']; ?></td>
                                    <td><?= $row['last_name']; ?></td>                                  
                                    <td><?= isset($groupResult['group_name']) ? $groupResult['group_name'] : 'N/A'; ?></td>
                                    <td align="center">
                                        <!-- ตัวเลือกอื่น ๆ ที่คุณต้องการ -->
                                        <a class="btn btn-info btn-xs" href="#" data-bs-toggle="modal" data-bs-target="#profileModal" data-id="<?= $row['t_id']; ?>"><i class="fas fa-eye"></i></a>
                                        <a href="teacher_edit?t_id=<?= $row['t_id']; ?>" class="btn btn-warning btn-xs"><i class="fas fa-pencil-alt"></i></a>
                                        <a href="teacher_process/teacher_delete?t_id=<?= $row['t_id']; ?>" type="button" class="btn btn-danger btn-xs" onclick="return confirm('คุณต้องการลบข้อมูลนี้หรือไม่?');"><i class="fas fa-trash-alt"></i></a>
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
                                <label class="col-md-3 col-form-label">ชื่อผู้ใช้:</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="username" value="<?= $row['username']; ?>" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 col-form-label">ชื่อ:</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="first_name" value="<?= $row['first_name']; ?>" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 col-form-label">นามสกุล:</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="last_name" value="<?= $row['last_name']; ?>" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 col-form-label">กลุ่มสาระ:</label>
                                <div class="col-md-9">
                                    <!-- ต้องทำการดึงข้อมูลกลุ่มที่เรียนจากตาราง learning_subject_group และแสดงใน input -->
                                    <?php
                                    $groupStmt = $db->prepare("SELECT group_name FROM learning_subject_group WHERE group_id = :group_id");
                                    $groupStmt->bindParam(':group_id', $row['group_id']);
                                    $groupStmt->execute();
                                    $groupResult = $groupStmt->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <input type="text" class="form-control" name="group_name" value="<?= isset($groupResult['group_name']) ? $groupResult['group_name'] : 'N/A'; ?>" readonly>
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
                        <form action="teacher_process/teacher_insert.php" method="post">
                            <div class="form-group">
                                <label for="add_username">ชื่อผู้ใช้:</label>
                                <input type="text" class="form-control" id="add_username" name="username" autocomplete="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">รหัสผ่าน:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">ยืนยันรหัสผ่าน:</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            <div class="form-group">
                                <label for="first_name">ชื่อ:</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name">นามสกุล:</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required>
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
    function updateProfileModal(teacherId) {
        $.ajax({
            type: 'POST',
            url: 'get_teacher_data.php',
            data: { teacherId: teacherId },
            dataType: 'json',
            success: function (data) {
                $('#profileModal [name="username"]').val(data.username);
                $('#profileModal [name="first_name"]').val(data.first_name);
                $('#profileModal [name="last_name"]').val(data.last_name);
                $.ajax({
                    type: 'POST',
                    url: 'get_group_data.php',
                    data: { groupId: data.group_id },
                    dataType: 'json',
                    success: function (groupData) {
                        $('#profileModal [name="group_name"]').val(groupData.group_name);
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }

    $('#profileModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var teacherId = button.data('id');

        if (teacherId) {
            updateProfileModal(teacherId);
        } else {
            console.error('teacherId is not defined.');
        }
    });
</script>



<script>
   $(document).ready(function() {
       $('#example1').DataTable();
   });
</script>

</body>

</html>
