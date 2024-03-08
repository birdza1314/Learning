<?php include("includes/Doctype.php"); ?>

<body class="gray-background" data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

<?php include("includes/head.php"); ?>
<?php include("includes/header.php"); ?>

    
<div class="container">

    <div class="site-section mt-5">
      <div class="container">
        <div class="row mb-5 justify-content-center text-center">
          <div class="col-lg-4 mb-5">
            <h2 class="section-title-underline mb-5">
              <span>ประเภทของรายวิชา</span>
            </h2>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
            <div class="feature-1 border">
              <div class="icon-wrapper bg-info">
                <span class="flaticon-mortarboard text-white"></span>
              </div>
              <div class="feature-1-content">
                <h2> กลุ่มสาระการเรียนรู้ภาษาไทย</h2>
               
                <p><a href="#" class="btn custom-btn px-4 rounded-0">รายละเอียด</a></p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
            <div class="feature-1 border">
              <div class="icon-wrapper bg-info">
                <span class="flaticon-school-material text-white"></span>
              </div>
              <div class="feature-1-content">
                <h2>กลุ่มสาระการเรียนรู้คณิตศาสตร์</h2>
              
                <p><a href="#" class="btn custom-btn px-4 rounded-0">รายละเอียด</a></p>
              </div>
            </div> 
          </div>
          <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
            <div class="feature-1 border">
              <div class="icon-wrapper bg-info">
                <span class="flaticon-books text-white"></span>
              </div>
              <div class="feature-1-content">
                <h2>กลุ่มสาระการเรียนรู้วิทยาศาสตร์และเทคโนโลยี</h2>
                <p><a href="#" class="btn custom-btn px-4 rounded-0">รายละเอียด</a></p>
              </div>
            </div> 
          </div>
        </div>
      </div>
      <div class="row mb-4 justify-content-center text-center">
      <div class="col-lg-4 mb-5">
        <button class="btn btn-primary btn-lg" onclick="showAllCategories()">ประเภททั้งหมด</button>
      </div>
    </div>

</div>
<?php include("includes/footer.php"); ?>
<?php include("includes/scripts.php"); ?>

</body>

</html>
