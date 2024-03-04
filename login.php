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
            background-color: #2ca1e6;
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
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<!-- Section: Design Block -->
<section class="">
  <!-- Jumbotron -->
  <div class="px-4 py-5 px-md-5 text-center text-lg-start" style="background-color: hsl(0, 0%, 96%)">
    <div class="container">
      <div class="row gx-lg-5 align-items-center">
        <div class="col-lg-6 mb-5 mb-lg-0">
          <h1 class="my-5 display-3 fw-bold ls-tight">
          E-learning system :  <br />
            <span class="text-primary"> case study of Suanprayawittaya school </span>
          </h1>
          <p style="color: hsl(217, 10%, 50.8%)">
          ระบบบริหารการเรียนการสอนออนไลน์
กรณีศึกษาโรงเรียนสวนพระยาวิทยา
          </p>
        </div>

        <div class="col-lg-6 mb-5 mb-lg-0">
          <div class="card">
          <div class="card-header">
          <h1 > เข้าสู่ระบบ </h1>
            <div class="card-body py-5 px-md-5">
            <form action="login_db.php" method="POST" class="register-form" id="login-form">
                <div class="form-group">
                    <label for="username"><i class="zmdi zmdi-account material-icons-name"></i> ชื่อผู้ใช้</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <label for="password"><i class="zmdi zmdi-lock"></i> รหัสผ่าน</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-group">
                    <input type="checkbox" name="remember-me" id="remember-me" class="form-check-input">
                    <label for="remember-me" class="form-check-label">Remember me</label>
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
    </div>
  </div>
  <!-- Jumbotron -->
</section>
<!-- Section: Design Block -->

    <!-- Bootstrap 5 JS (for optional use, for example, if you need dropdowns or other JS features) -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> -->
</body>
</html>
