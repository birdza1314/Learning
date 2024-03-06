<?php 

include('../connections/connection.php');

if (isset($_POST['submit'])) {
    $course = $_POST['search'];

    $sql = "SELECT * FROM courses WHERE course_name = :course_name";
    $stmt = $db->prepare($sql);
    $stmt->execute(['course_name' => $course]);
    $row = $stmt->fetch();
    
    // ตรวจสอบว่ามีข้อมูลใน $row หรือไม่ก่อนที่จะเข้าถึงค่า
    if ($row && is_array($row)) { // ตรวจสอบว่า $row เป็นอาร์เรย์หรือไม่
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

    <div class="container">
        <div class="row mt-5">
             <div class="col-md-4 mb-4">
                <div class="card">
                <img src="<?php echo $row['c_img']; ?>" class="card-img-top" alt="Course Image" style="height: 150px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['course_name']; ?></h5>
                        <p class="card-text">Course ID: <?php echo $row['course_code']; ?></p>
                        <a href="course_details.php?course_id=<?php echo $row['c_id']; ?>" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
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
