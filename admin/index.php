<?php
// เชื่อมต่อกับฐานข้อมูล
include('../connections/connection.php');

// คำสั่ง SQL เพื่อดึงจำนวนนักเรียนทั้งหมด
$stmt = $db->prepare("SELECT COUNT(*) AS total_students FROM students");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_students = $result['total_students'];
// คำสั่ง SQL เพื่อดึงจำนวนนักเรียนทั้งหมด
$stmt = $db->prepare("SELECT COUNT(*) AS total_teachers FROM teachers");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_teachers = $result['total_teachers'];
// คำสั่ง SQL เพื่อดึงจำนวนวิชาที่มี is_open = 1
$stmt = $db->prepare("SELECT COUNT(*) AS total_courses FROM courses WHERE is_open = 1");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_courses = $result['total_courses'];
$stmt = $db->prepare("SELECT COUNT(*) AS total_courses FROM courses WHERE is_open = 0");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_courses_close = $result['total_courses'];

// คำสั่ง SQL เพื่อดึงจำนวนไฟล์ทั้งหมด
$stmt = $db->prepare("SELECT (SELECT COUNT(*) FROM files) +
                             (SELECT COUNT(*) FROM student_images) +
                             (SELECT COUNT(*) FROM teachers_images) +
                             (SELECT COUNT(*) FROM images) +
                             (SELECT COUNT(*) FROM submitted_assignments) AS total_files");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_files = $result['total_files'];
?>
<?php
$menu = "Dashboard";
include("header.php");
?>

<body id="page-top">

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1><i class="nav-icon fas fa-address-Dashboard"></i> Dashboard</h1>
    </div>
</section>
                <!-- Begin Page Content -->
                <div class="container mt-4">

                    <!-- Content Row -->
                    <div class="row">
                    <!--total students Card  -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            จำนวนนักเรียน</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_students; ?> คน</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<!-- Total Teachers Card  -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        ครูผู้สอนทั้งหมด</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_teachers; ?> คน</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    วิชาทังหมด (ที่เปิด)</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_courses; ?> วิชา</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-book-open fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                        วิชาทังหมด (ที่ปิด)</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_courses_close; ?>วิชา</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-book-open fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Total Files</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_files; ?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-file fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-primary"></i> Direct
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Social
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-info"></i> Referral
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->


        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
    <?php include('footer.php'); ?>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>