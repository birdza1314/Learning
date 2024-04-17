<?php
include('../connections/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['group_id']) && isset($_POST['class_id'])) {
    $group_id = $_POST['group_id'];
    $class_id = $_POST['class_id'];

    // คำสั่ง SQL เพื่อดึงข้อมูลของกลุ่มสาระ
    $sql_group = "SELECT * FROM learning_subject_group WHERE group_id = :group_id";
    $stmt_group = $db->prepare($sql_group);
    $stmt_group->bindParam(':group_id', $group_id);
    $stmt_group->execute();
    $group_data = $stmt_group->fetch(PDO::FETCH_ASSOC);

    if ($group_data) {
        // ดึงข้อมูลกลุ่มสาระ
        $group_name = $group_data['group_name'];

        // คำสั่ง SQL เพื่อดึงข้อมูลของวิชาในกลุ่มสาระและระดับชั้นที่เลือก
        $sql_courses = "SELECT * FROM courses WHERE group_id = :group_id AND class_id = :class_id";
        $stmt_courses = $db->prepare($sql_courses);
        $stmt_courses->bindParam(':group_id', $group_id);
        $stmt_courses->bindParam(':class_id', $class_id);
        $stmt_courses->execute();
        $group_courses = $stmt_courses->fetchAll(PDO::FETCH_ASSOC);
    } 
}
?>

<?php include('../uploads/head.php');?>
<body style="background-color: rgb(220, 220, 220);">

<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-custom sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand navbar-brand-custom" href="../index">
            <img src="../uploads/img/logo.png" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../index">หน้าหลัก</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        คู่มือการใช้งาน
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="../login">คู่มือการใช้งานสำหรับครู</a></li>
                        <li><a class="dropdown-item" href="../login">คู่มือการใช้งานสำหรับนักเรียน</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2" href="../contact">ติดต่อสอบถาม</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-primary nav-btn" href="../login">เข้าสู่ระบบ</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- แบบฟอร์มเลือกกลุ่มสาระและระดับชั้น -->
<div class="container mt-5">
    <div class="row">
      <div class="card">
    <div class="card-header py-5">
        <div class="col-md-6 offset-md-3">
            <form action="" method="POST" class="d-flex justify-content-center align-items-center">
                <select name="group_id" id="group_id" class="form-select me-3"required>
                    <option value="">เลือกกลุ่มสาระ</option>
                    <?php
                    // ดึงข้อมูลกลุ่มสาระจากฐานข้อมูล
                    $sql_groups = "SELECT * FROM learning_subject_group";
                    $stmt_groups = $db->prepare($sql_groups);
                    $stmt_groups->execute();
                    $groups = $stmt_groups->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach ($groups as $group) {
                        echo '<option value="' . $group['group_id'] . '">' . $group['group_name'] . '</option>' ;
                    }
                    ?>
                </select>
                <select name="class_id" id="class_id" class="form-select me-3" required>
                    <option value="">เลือกระดับชั้น</option>
                    <option value="1">ระดับชั้น ม.1</option>
                    <option value="2">ระดับชั้น ม.2</option>
                    <option value="3">ระดับชั้น ม.3</option>
                    <option value="4">ระดับชั้น ม.4</option>
                    <option value="5">ระดับชั้น ม.5</option>
                    <option value="6">ระดับชั้น ม.6</option>
                    <!-- เพิ่มตัวเลือกของระดับชั้นอื่น ๆ ตามต้องการ -->
                </select>
                <button class="btn btn-outline-primary" type="submit">ตกลง</button>
            </form>
        </div>
        </div>
    </div>
</div>
</div>
<?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($group_courses) && count($group_courses) > 0): ?>
    <!-- แสดงรายละเอียดวิชา -->
    <div class="container mt-5">
        <div class="card">
        <div class="card-header py-5">
            <h2 class="text-center "><?php echo $group_name; ?></h2>
        </div>
            <div class="row mt-5 me-5 mx-5">
                <?php foreach ($group_courses as $course): ?>
                    <?php if ($course['is_open'] == 1): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card border-primary border-3 shadow" style="width: 18rem;">
                                <?php if (!empty($course['c_img'])): ?>
                                    <div class="text-center">
                                        <img src="<?php echo $course['c_img']; ?>" class="card-img-top" alt="รูปภาพ" style="height: 150px; object-fit: cover;">
                                    </div>
                                <?php else: ?>
                                    <div class="text-center">
                                        <img src="../admin/teacher_process/img/course.jpg" class="card-img-top" alt="รูปภาพ" style="height: 150px; object-fit: cover;">
                                    </div>
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $course['course_name']; ?></h5>
                                    <p class="card-text">รหัสวิชา: <?php echo $course['course_code']; ?></p>
                                    <?php
                                    $teacher_id = $course['teacher_id'];
                                    $teacher_stmt = $db->prepare("SELECT * FROM teachers WHERE t_id = :teacher_id");
                                    $teacher_stmt->bindParam(':teacher_id', $teacher_id);
                                    $teacher_stmt->execute();
                                    $teacher = $teacher_stmt->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <p class="card-text">ครูผู้สอน: <?php echo $teacher['first_name']; ?> <?php echo $teacher['last_name']; ?></p>
                                    <a href="../login" class="btn btn-outline-primary" style="float: right;">รายละเอียด</a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="container mt-5">
        <div class="card">
          <div class="card-header">
            <h1 class="text-center">ไม่มีรายวิชาที่เปิด</h1>
            </div>
        </div>
    </div>
<?php endif; ?>


<footer class="footer bg-secondary text-light py-4  mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-start">
                <a class="navbar-brand navbar-brand-custom" href="#">
                    <img src="../uploads/img/logo.png" alt="Logo">
                </a>
            </div>
            <div class="col-md-6 text-end">
                <p class="mb-1">ติดต่อเรา: example@example.com</p>
                <p class="mb-0">โทรศัพท์: 012-345-6789</p>
            </div>
        </div>
    </div>
</footer>

<footer class="footer bg-dark text-light py-4">
    <div class="container text-center">
        &copy; Copyright <strong><span>E-learning System</span></strong>. All Rights Reserved 
    </div>
    <div class="credits text-center">
        Designed by <a href="https://web.facebook.com/profile.php?id=100009502864499" target="_blank" >Ruslan Matha</a>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
