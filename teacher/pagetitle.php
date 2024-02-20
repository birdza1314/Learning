<?php
// functions.php (หรือไฟล์ที่เก็บฟังก์ชันทั้งหมด)
function generateBreadcrumb($currentPage) {
    // ตัวแปรเก็บข้อความ breadcrumb
    $breadcrumb = '';

    // ตรวจสอบหน้าปัจจุบันและกำหนด breadcrumb ตามต้องการ
    if ($currentPage == 'index') {
        $breadcrumb = '<li class="breadcrumb-item"><a href="index.html">Home</a></li>';
    } elseif ($currentPage == 'forms') {
        $breadcrumb = '<li class="breadcrumb-item"><a href="index.html">Home</a></li>';
        $breadcrumb .= '<li class="breadcrumb-item active">Forms</li>';
    } elseif ($currentPage == 'layouts') {
        $breadcrumb = '<li class="breadcrumb-item"><a href="index.html">Home</a></li>';
        $breadcrumb .= '<li class="breadcrumb-item">Forms</li>';
        $breadcrumb .= '<li class="breadcrumb-item active">Layouts</li>';
    }

    return $breadcrumb;
}
?>
