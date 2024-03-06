<?php include('../connections/connection.php'); ?>
<?php session_start(); ?>

<!-- ตรวจสอบการเข้าสู่ระบบและบทบาทของผู้ใช้ว่าเป็นนักเรียนหรือไม่ -->
<?php
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT * FROM students WHERE s_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!isset($_GET['assignment_id'])) {
    header('Location: index.php');
    exit();
}

$assignment_id = $_GET['assignment_id'];

// ดึงรายละเอียดของการบ้านจากฐานข้อมูล
$assignment_id = $_GET['assignment_id'];
$stmt = $db->prepare("SELECT * FROM assignments WHERE assignment_id = :assignment_id");
$stmt->bindParam(':assignment_id', $assignment_id);
$stmt->execute();
$assignment = $stmt->fetch(PDO::FETCH_ASSOC);


// กำหนดค่าสำหรับภาษาไทย
setlocale(LC_TIME, 'th_TH.UTF-8');

// แสดงวันที่และเวลาเริ่มต้นและสิ้นสุด
$startDateTime = strftime('%A, %e %B %Y %I:%M %p', strtotime($assignment['open_time']));
$endDateTime = strftime('%A, %e %B %Y %I:%M %p', strtotime($assignment['close_time']));
?>

<!-- ส่วนของ HTML -->
<?php include('head.php'); ?>
<body>
    <?php include('header.php'); ?>
    <?php include('sidebar.php'); ?>
    
    <main id="main" class="main">
    <div class="card overflow-auto">
        <div class="card-body">
            <div class="container">
                <h2 class="py-2"> <i class="bi bi-journal-arrow-up text-danger"></i> <?php echo $assignment['title']; ?></h2>
                <div class="row">
                    <div class="card">
                        <!-- แสดงวันที่และเวลาเริ่มต้นและสิ้นสุด -->
                        เปิด: <?php echo $startDateTime; ?><br>
                        สิ้นสุด: <?php echo $endDateTime; ?>
                    </div>
                    <div class="mt-3 card">
                        <h5>รายละเอียด</h5>
                        <p><?php echo $assignment['description']; ?></p><br><br>
                        <h3>File Upload</h3>
                       <!-- File Upload Form -->
                        <form action="upload.php" method="post" enctype="multipart/form-data" class="dropzone" id="myAwesomeDropzone">
                            <!-- Input hidden เพื่อส่ง assignment_id -->
                            <input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>">
    
                            <!-- แสดงไฟล์ที่เคยบันทึกไว้ก่อนหน้า -->
                            <h3>Uploaded Files:</h3>
                            <ul id="file-list">
                                <!-- ตำแหน่งสำหรับแสดงรายการไฟล์ -->
                            </ul>

                            <!-- Dropzone -->
                            <div class="fallback">
                                <input name="file" type="file" multiple />
                            </div>
                            <div class="dz-message needsclick">
                                <i class="h1 text-muted ri-upload-cloud-2-line"></i>
                                <h3>ลากไฟล์มาวางหรือคลิกเพื่ออัพโหลด</h3>
                                <span class="text-muted font-13">(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</span>
                            </div>
                            <div class="row">
                                <button type="submit" name="submit" class="btn btn-primary mt-3">บันทึกการเปลียนแปง</button>
                            </div>
                        </form>
                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
    <?php include('footer.php'); ?>
    <?php include('scripts.php'); ?>
    <!-- เพิ่มสคริปต์ jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- เพิ่มสคริปต์ Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- เพิ่มสคริปต์ที่กำหนดเองสำหรับฟังก์ชันการค้นหา -->
    <!-- Add Dropzone.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>
    <!-- JavaScript for Deleting Files -->
    <script>
       // Initialize Dropzone
Dropzone.options.myAwesomeDropzone = {
    init: function() {
        this.on("addedfile", function(file) {
            var fileList = document.getElementById('file-list'); // Reference to the file list

            // Create list item for the file
            var listItem = document.createElement('li');
            listItem.textContent = file.name;

            // Create delete link
            var deleteLink = document.createElement('a');
            deleteLink.innerHTML = '<i class="fas fa-trash"></i>';
            deleteLink.href = '#';
            deleteLink.onclick = function(e) {
                e.preventDefault();
                // Remove file from Dropzone
                file.previewElement.remove();
                // Remove file from file list
                listItem.remove();
            };

            // Append delete link to list item
            listItem.appendChild(deleteLink);

            // Append list item to file list
            fileList.appendChild(listItem);
        });
    }
};

    </script>

    <script>
        $(document).ready(function() {
            $("#search").keyup(function() {
                let searchText = $(this).val();
                if (searchText != "") {
                    $.ajax({
                        url: "action.php",
                        method: "post",
                        data: {
                            query: searchText
                        },
                        success: function(response) {
                            $("#show-list").html(response);
                        }
                    });
                } else {
                    $("#show-list").html("");
                }
            });

            $(document).on('click', 'a', function() {
                $("#search").val($(this).text());
                $("#show-list").html("");
            });
        });
    </script>
    
</body>
</html>
