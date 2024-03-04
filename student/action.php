<?php

include('../connections/connection.php');

if (isset($_POST['query'])) {
    $inputText = $_POST['query'];
    // เพิ่มการค้นหาด้วย course_code ด้วยคำสั่ง SQL
    $sql = "SELECT course_name FROM courses WHERE course_name LIKE :course OR course_code LIKE :course";
    $stmt = $db->prepare($sql);
    // ใช้ % รอบตัวแปร $inputText เพื่อค้นหาในทั้งชื่อวิชาและรหัสวิชา
    $stmt->execute(['course' => '%' . $inputText . '%']);
    $result = $stmt->fetchAll();

    if ($result) {
        foreach($result as $row) {
            echo '<a class="list-group-item list-group-item-action border-1">' . $row['course_name'] . '</a>';
        }
    } else {
        echo '<p class="list-group-item border-1">No record.</p>';
    }
}

?>
