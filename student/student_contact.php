<?php
include('../connections/connection.php');

// ตรวจสอบว่ามีการล็อกอินและมีบทบาทเป็น 'teacher' หรือไม่
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    // ถ้าไม่ได้ล็อกอินหรือบทบาทไม่ใช่ 'teacher' ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหรือหน้าที่คุณต้องการ
    header('Location: ../login'); 
    exit();
}

try {
    $user_id = $_SESSION['user_id'];
    $stmt = $db->prepare("SELECT * FROM students WHERE s_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
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
  <div class="card overflow-auto">
    <div class="card-header "><h1 style="text-align: center;">ติดต่อ</h1> </div>
    <div class="card-body">
    <div class="row justify-content-between align-items-center">                 
            <form id="myForm">
                <div class="mb-3">
                    <label for="sendername" class="form-label">ชื่อ: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="sendername" name="sendername">
                </div>
                <div class="mb-3">
                    <label for="fromEmail" class="form-label">อีเมลของคุณ: <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="fromEmail" name="fromEmail">
                </div>
                <!-- Hidden input for recipient email -->
                <input type="hidden" id="toEmail" name="toEmail" value="ruslan123371@gmail.com">
                <div class="mb-3">
                    <label for="phoneNumber" class="form-label">เบอร์โทรศัพท์: <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber">
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">เรื่อง: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="subject" name="subject">
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">รายละเอียด: <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="message" name="message" rows="5"></textarea>
                </div>
                <button type="button" class="btn btn-primary d-block mx-auto" onclick="sendEmail()">ส่งอีเมล</button>
            </form>
        </div>
    </div>
</div>
  </main>
  <?php include('footer.php');?>
 <!-- ======= scripts ======= -->
<?php include('scripts.php');?>
<script src="https://cdn.emailjs.com/dist/email.min.js"></script>
<script type="text/javascript">
    function sendEmail() {
        emailjs.init("yp7s1k-MOX6hp_QkO"); // Replace YOUR_USER_ID with your EmailJS user ID

        var params = {
            sendername: document.querySelector("#sendername").value,
            fromEmail: document.querySelector("#fromEmail").value,
            phoneNumber: document.querySelector("#phoneNumber").value,
            toEmail: document.querySelector("#toEmail").value,
            subject: document.querySelector("#subject").value,
            message: document.querySelector("#message").value
        };

        var serviceID = "service_no0jh1w"; // Replace YOUR_SERVICE_ID with your EmailJS service ID
        var templateID = "template_w0ikhwh"; // Replace YOUR_TEMPLATE_ID with your EmailJS template ID

        emailjs.send(serviceID, templateID, params)
            .then(function(response) {
                console.log('SUCCESS!', response.status, response.text);
                alert('ส่งข้อมูลเรียบร้อยแล้ว รอการติดต่อจากผู้ดูแลระบบ 5-10 นาที่ !');
                document.getElementById('myForm').reset(); // Reset the form after successful submission
            }, function(error) {
                console.log('FAILED...', error);
                alert('ไม่สามารถส่งอีเมลได้ โปรดลองอีกครั้งในภายหลัง');
            });
    }
</script>
</body>
</html>
