<?php include('uploads/head.php');?>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-custom sticky-top">
  <div class="container-fluid">
    <!-- Navbar brand with logo -->
    <a class="navbar-brand navbar-brand-custom" href="index">
      <img src="uploads/img/logo.png" alt="Logo">
    </a>
    <!-- Button to toggle the navbar on mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar items -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index">หน้าหลัก</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          คู่มือการใช้งาน
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="login">คู่มือการใช้งานสำหรับครู</a></li>
            <li><a class="dropdown-item" href="login">คู่มือการใช้งานสำหรับนักเรียน</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="contact">ติดต่อสอบถาม</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-outline-primary nav-btn" href="login">เข้าสู่ระบบ</a>
        </li>
      </ul>
    </div>
  </div>
</nav>



<div class="container"> 
<div class="row">
  <div class="col-12">
          <img src="uploads/img/R.jpg" class="d-block w-100" alt="รูปภาพ 2">
          <div class="carousel-caption d-none d-md-block">
            <a href="login" class="btn btn-outline-primary">เข้าสู่เว็บไซต์</a>
          </div>
        </div>

 </div>

 </div>
 <div class="card mt-5 me-5 mx-5" style="text-align: center;">
  <div class="card-title mt-4">
    <h3 style="font-family: 'Arial', sans-serif; color: #333; margin: 0;">กลุ่มสาระการเรียนรู้</h3>
  </div>
  <hr color="blue" size="5" width="100%">
  <div class="card-body">
    <div class="row mt-5">
      <div class="col-sm-4">
        <a href="student/group_details?group_id=1">
          <div class="card-body">
            <!-- เพิ่มรูปภาพ -->
            <img src="teacher/uploads/group/1.png" alt="ภาษาไทย" class="hover-img">
          </div>
        </a>
      </div>
      <div class="col-sm-4">
        <a href="student/group_details?group_id=2">
          <div class="card-body">
            <!-- เพิ่มรูปภาพ -->
            <img src="teacher/uploads/group/2.png" alt="คณิตศาสตร์" class="hover-img">
          </div>
        </a>
      </div>
      <div class="col-sm-4">
        <a href="student/group_details?group_id=3">
          <div class="card-body">
            <!-- เพิ่มรูปภาพ -->
            <img src="teacher/uploads/group/3.png" alt="วิทยาศาสตร์และเทคโนโลยี" class="hover-img">
          </div>
        </a>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-4">
        <a href="student/group_details?group_id=4">
          <div class="card-body">
            <!-- เพิ่มรูปภาพ -->
            <img src="teacher/uploads/group/4.png" alt="สังคมศึกษาฯ" class="hover-img">
          </div>
        </a>
      </div>
      <div class="col-sm-4">
        <a href="student/group_details?group_id=5">
          <div class="card-body">
            <!-- เพิ่มรูปภาพ -->
            <img src="teacher/uploads/group/5.png" alt="สุขศึกษาฯ" class="hover-img">
          </div>
        </a>
      </div>
      <div class="col-sm-4">
        <a href="student/group_details?group_id=6">
          <div class="card-body">
            <!-- เพิ่มรูปภาพ -->
            <img src="teacher/uploads/group/6.png" alt="เรียนรู้ศิลปะ" class="hover-img">
          </div>
        </a>
      </div>
    </div>

    <div style="text-align: center;" class="py-4">
      <!-- เพิ่มปุ่มรายวิชาทั้งหมดที่นี่ -->
      <a href="student/lib_all_course" class="btn btn-outline-primary">รายวิชาทั้งหมด <i class="bi bi-chevron-right"></i></a>
    </div>
  </div>
</div><!--Card over -->

<div class="search-bar">
                            <form action="details_All_course" method="POST" class="p-3">
                                <div class="input-group">
                                    <input type="text" name="search" id="search" class="form-control form-control-lg  rounded-0" placeholder="ค้นหารายวิชา..." autocomplete="off" required>
                                        <input type="submit" name="submit" value="ค้นหา" class="btn btn-outline-secondary btn-sm">
                                </div>
                                <div class="col-md-5">
                                    <div class="list-group" style="width: 250px;" id="show-list"></div>
                                </div>
                            </form>
                        </div><!-- End Search Bar -->

<hr color="blue" size="2" width="100%">


<footer class="footer bg-secondary text-light py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-start">
                <!-- โลโก้ -->
                <a class="navbar-brand navbar-brand-custom" href="#">
                    <img src="uploads/img/logo.png" alt="Logo">
                </a>
            </div>
            <div class="col-md-6 text-end">
                <!-- ข้อมูลติดต่อ -->
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
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://web.facebook.com/profile.php?id=100009502864499" target="_blank" >Ruslan Matha</a>

    </div>
</footer>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script>
$(document).ready(function() {
    $('#display-format').change(function() {
        var format = $(this).val();
        if (format === 'list') {
            $('.card-format').hide();
            $('.list-format').show(); // ต้องแสดง .list-format เมื่อเปลี่ยนเป็น list
        } else if (format === 'card') {
            $('.list-format').hide();
            $('.card-format').show();
        }
    });
    $("#search").keyup(function() {
        let searchText = $(this).val();
        if (searchText != "") {
            $.ajax({
                url: "student/action.php",
                method: "post",
                data: {
                    query: searchText
                },
                success: function(response) {
                    $("#show-list").html(response);
                }
            })
        } else {
            $("#show-list").html("");
        }
    });

    $(document).on('click', 'a', function() {
        $("#search").val($(this).text())
        $("#show-list").html("");
    });
});
</script>
</body>
</html>
