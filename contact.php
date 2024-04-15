<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ส่งอีเมลผ่าน EmailJS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            max-width: 600px;
            width: 100%;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: bold;
            text-align: left;
        }

        .text-danger {
            color: red;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center mb-4">ติดต่อ</h1>
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
    <a class="btn btn-outline-success mt-3 d-block mx-auto" href="index">กลับสู่หน้าเว็บไซต์</a>
</div>

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
