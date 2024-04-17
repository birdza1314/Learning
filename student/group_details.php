<?php
include('../connections/connection.php');

if (isset($_GET['group_id'])) {
    $group_id = $_GET['group_id'];

    $sql_group = "SELECT * FROM learning_subject_group WHERE group_id = :group_id";
    $stmt_group = $db->prepare($sql_group);
    $stmt_group->bindParam(':group_id', $group_id);
    $stmt_group->execute();
    $group_data = $stmt_group->fetch(PDO::FETCH_ASSOC);

    if ($group_data) {
        $group_name = $group_data['group_name'];

        // เพิ่มแบบฟอร์มเลือกระดับชั้น
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $class_id = $_POST['class_id'];

            $sql_courses = "SELECT * FROM courses WHERE group_id = :group_id AND class_id = :class_id";
            $stmt_courses = $db->prepare($sql_courses);
            $stmt_courses->bindParam(':group_id', $group_id);
            $stmt_courses->bindParam(':class_id', $class_id);
            $stmt_courses->execute();
            $group_courses = $stmt_courses->fetchAll(PDO::FETCH_ASSOC);
        }
    } else {
        echo "ไม่พบข้อมูลกลุ่มสาระ";
        exit;
    }
} else {
    echo "ไม่มีค่ารหัสกลุ่มสาระ";
    exit;
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

<div class="container mt-5">
    <div class="card">
        <h1 class="text-center">รายละเอียดกลุ่มสาระ</h1>
        <h2 class="text-center"><?php echo $group_name; ?></h2>
        <div class="row mt-5 me-5 mx-5">
        <div class="col-md-6 offset-md-3">
            <form action="" method="POST" class="d-flex justify-content-center align-items-center">
                <input type="hidden" name="group_id" value="<?php echo $group_id; ?>">
                <select name="class_id" id="class_id" class="form-select me-3" required>
                    <option selected>เลือกระดับชั้น</option>
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
        <div class="row mt-5 me-5 mx-5">
            <?php if (isset($group_courses)): ?>
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
            <?php endif; ?>
        </div>
    </div>
</div>

<footer class="footer bg-secondary text-light py-4">
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
