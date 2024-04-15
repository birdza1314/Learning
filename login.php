<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url('uploads/img/R.jpg');
            background-size: cover;
            background-position: center;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.9); /* เพิ่มความโปร่งแสงให้กับพื้นหลัง */
            border-radius: 10px; /* โค้งมุมกรอบของการ์ด */
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* เงา */
        }

        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #0056b3; /* เปลี่ยนสีปุ่มเข้าสู่ระบบ */
            color: #fff;
            cursor: pointer;
        }
        .form-group input[type="submit"]:hover {
            background-color: #004080; /* เปลี่ยนสีเมื่อโฮเวอร์ */
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1>เข้าสู่ระบบ</h1>
                </div>
                <div class="card-body py-5 px-md-5">
                    <form action="login_db" method="POST" class="register-form" id="login-form">
                        <div class="form-group">
                            <label for="username"><i class="zmdi zmdi-account material-icons-name"></i> ชื่อผู้ใช้</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <label for="password"><i class="zmdi zmdi-lock"></i> รหัสผ่าน</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input type="checkbox" name="remember-me" id="remember-me" class="form-check-input">
                            <label for="remember-me" class="form-check-label">Remember me</label>
                        </div>
                        <a href="contact">ลืมรหัสผ่าน ?</a>
                    </div>
                        <div class="form-group">
                            <input type="submit" name="submit" id="submit" class="btn btn-primary" value="เข้าสู่ระบบ">
                        
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS (for optional use, for example, if you need dropdowns or other JS features) -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> -->
</body>
</html>
