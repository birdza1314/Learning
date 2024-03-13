<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bootstrap 5 Card Example</title>
  <!-- เรียกใช้ Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
  <h2>My Courses</h2>
  <div class="row mt-3">
    <!-- เริ่มต้นการ์ด -->
    <div class="col-md-4 mb-4">
      <div class="card">
        <img src="course_image.jpg" class="card-img-top" alt="Course Image">
        <div class="card-body">
          <h5 class="card-title">Course Name</h5>
          <p class="card-text">Course description goes here.</p>
          <a href="#" class="btn btn-primary">View Details</a>
        </div>
      </div>
    </div>
    <!-- สิ้นสุดการ์ด -->
  </div>
</div>

<!-- เรียกใช้ Bootstrap 5 JavaScript ถ้าคุณต้องการใช้งาน JS ของ Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
