<?php
// functions.php (หรือไฟล์ที่เก็บฟังก์ชันทั้งหมด)
function generateBreadcrumb($currentPage) {
    // ตัวแปรเก็บข้อความ breadcrumb
    $breadcrumb = '';

    // ตรวจสอบหน้าปัจจุบันและกำหนด breadcrumb ตามต้องการ
    if ($currentPage == 'course') {
        $breadcrumb = '<li class="breadcrumb-item"><a href="course.php">Home</a></li>';
    } elseif ($currentPage == 'Edit_course') {
        $breadcrumb = '<li class="breadcrumb-item"><a href="course.php">Home</a></li>';
        $breadcrumb .= '<li class="breadcrumb-item active">Edit Course</li>';
    } elseif ($currentPage == 'lessons') {
        $breadcrumb = '<li class="breadcrumb-item"><a href="course.php">Home</a></li>';
        $breadcrumb .= '<li class="breadcrumb-item active">Lesson</li>';
    } elseif ($currentPage == 'index') {
        $breadcrumb = '<li class="breadcrumb-item"><a href="index.php">Home</a></li>';
        $breadcrumb .= '<li class="breadcrumb-item active">Dashboard</li>';
    } elseif ($currentPage == 'My Course') {
        $breadcrumb = '<li class="breadcrumb-item"><a href="index.php">Home</a></li>';
        $breadcrumb .= '<li class="breadcrumb-item active">My Course</li>';
    }
    return $breadcrumb;
}
?>
My Course