<?php
// เชื่อมต่อกับฐานข้อมูล
include('../connections/connection.php');

// ตรวจสอบการล็อกอินและบทบาทของผู้ใช้
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header('Location: ../login'); 
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
  <div class="container">
    <div class="card overflow-auto">
       <div class="card-body">
       <div class="container">
    <h2 class="py-3">ลงทะเบียนนักเรียน</h2>
    <form id="registrationForm">
        <!-- Dropdown ปีการศึกษา -->
        <div class="form-group">
            <label for="classesSelect">ระดับชั้นมัธยมศึกษาปีที่ <span style="color: red;">*</span></label>
            <select class="form-control" id="classesSelect" required>
                <!-- Options will be populated dynamically using JavaScript -->
            </select>
        </div>
        <!-- Dropdown ห้องเรียน -->
        <div class="form-group">
            <label for="classroomSelect">ห้องเรียน<span style="color: red;">*</span></label>
            <select class="form-control" id="classroomSelect" disabled required>
                <!-- Options will be populated dynamically using JavaScript -->
            </select>
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">บันทึก</button>
        </div>
    </form>
</div>

        </div>
    </div>
</main>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- ======= Footer ======= -->
<?php include('footer.php');?>
 <!-- ======= scripts ======= -->
<?php include('scripts.php');?>

<script>
$(document).ready(function() {
    // Populate classes options
    $.ajax({
        url: "Get_data_students/get_classes.php",
        type: "GET",
        dataType: "json",
        success: function(data) {
            var options = '<option value="">เลือกระดับชั้น</option>';
            data.forEach(function(classes) {
                options += '<option value="' + classes + '">' + classes + '</option>';
            });
            $('#classesSelect').html(options);
        }
    });

    // Handle change event on classes select
    $('#classesSelect').change(function() {
        var classes = $(this).val();
        // Populate classroom options based on selected classes
        $.ajax({
            url: "Get_data_students/get_classrooms.php",
            type: "GET",
            dataType: "json",
            data: { classes: classes },
            success: function(data) {
                var options = '<option value="">เลือกห้องเรียน</option>';
                data.forEach(function(classroom) {
                    options += '<option value="' + classroom + '">' + classroom + '</option>';
                });
                $('#classroomSelect').html(options).prop('disabled', false);
            }
        });
    });

    // Handle form submission
    $('#registrationForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        // Gather form data
        var formData = {
            classes: $('#classesSelect').val(),
            classroom: $('#classroomSelect').val(),
            course_id: <?php echo $_GET['course_id']; ?> // Get course ID from URL
        };

        // Submit data to save_registration.php
        $.ajax({
            url: "save_registration.php",
            type: "POST",
            data: formData,
            success: function(response) {
                alert(response); // Display response message
                // You can redirect the user to another page here if needed
            }
        });
    });
});
</script>

</body>
</html>
