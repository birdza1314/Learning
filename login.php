<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Form by Colorlib</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="regis/fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="regis/css/style.css">
</head>
<body>

        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="regis/images/signin-image.jpg" alt="sing up image"></figure>
                        <a href="register.php" class="signup-image-link">Create an account</a>
                    </div>

                    <div class="signin-form ">
                        <h2 class="form-title">log in</h2>
                        <?php if (isset($_SESSION['err_fill'])) : ?>
                            <div class="alert alert-danger alert-custom" role="alert">
                                <?php echo $_SESSION['err_fill']; ?>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['err_pw'])) : ?>
                            <div class="alert alert-danger alert-custom" role="alert">
                                <?php echo $_SESSION['err_pw']; ?>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['err_uname'])) : ?>
                            <div class="alert alert-danger alert-custom" role="alert">
                                <?php echo $_SESSION['err_uname']; ?>
                            </div>
                        <?php endif; ?>
                        <form action="login_db.php" method="POST" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="username"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="username" id="username" placeholder="username" require/>
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="password" placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="submit" id="submit" class="form-submit" value="Log in"/>
                            </div>
                        </form>
                        <div class="social-login">
                            <span class="social-label">Or login with</span>
                            <ul class="socials">
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <!-- JS -->
    <script src="regis/vendor/jquery/jquery.min.js"></script>
    <script src="regis/js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>

<?php
    if (isset($_SESSION['err_fill']) || isset($_SESSION['err_pw']) || isset($_SESSION['err_uname'])) {
        unset($_SESSION['err_fill']);
        unset($_SESSION['err_pw']);
        unset($_SESSION['err_uname']);
    }
?>