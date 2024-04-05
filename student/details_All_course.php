<?php
include('../connections/connection.php');

if (isset($_POST['submit'])) {
    $course = $_POST['search'];

    $sql = "SELECT * FROM courses WHERE course_name LIKE :course_name";
    $stmt = $db->prepare($sql);
    // ใช้ % รอบตัวแปร $course เพื่อให้ค้นหาทุกวิชาที่มีคำที่คล้ายกัน
    $stmt->execute(['course_name' => '%' . $course . '%']);
    $rows = $stmt->fetchAll();
    
    // ตรวจสอบว่ามีข้อมูลใน $rows หรือไม่ก่อนที่จะเข้าถึงค่า
    if ($rows) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

    <div class="container">
        <div class="row mt-5">
        <?php
foreach ($rows as $row) {
?>
<div class="col-md-4 mb-4">
    <div class="card" style="width: 18rem;">
        <img src="<?php echo $row['c_img']; ?>" class="card-img-top" alt="Course Image" style="height: 150px; object-fit: cover;">
        <div class="card-body">
            <h5 class="card-title"><?php echo $row['course_name']; ?></h5>
            <p class="card-text">รหัสวิชา: <?php echo $row['course_code']; ?></p>
            <?php
            // เรียกข้อมูลผู้สอนจากตาราง teachers โดยใช้ teacher_id จากตาราง courses เป็นเงื่อนไข
            $teacher_id = $row['teacher_id'];
            $teacher_stmt = $db->prepare("SELECT * FROM teachers WHERE t_id = :teacher_id");
            $teacher_stmt->bindParam(':teacher_id', $teacher_id);
            $teacher_stmt->execute();
            $teacher = $teacher_stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <p class="card-text">ครูผู้สอน: <?php echo $teacher['first_name']; ?> <?php echo $teacher['last_name']; ?></p>
            <a href="course_details?course_id=<?php echo $row['c_id']; ?>" class="btn btn-primary">รายละเอียด</a>
        </div>
    </div>
</div>
<?php
}
?>

        </div>
    </div>
    
</body>
</html>
<?php
    } else {
        echo '<p>No record found.</p>';
    }
} else {
    header("location: index.php");
    exit();
}

?>
