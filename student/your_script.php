<?php

// เชื่อมต่อฐานข้อมูล
 include('../connections/connection.php'); 

// ดึงข้อมูลไฟล์ที่อัปโหลด
$sql = "SELECT * FROM uploaded_files";
$stmt = $db->prepare($sql);
$stmt->execute();
$files = $stmt->fetchAll(PDO::FETCH_ASSOC);

// แปลงข้อมูลเป็น JSON
$data = array();
foreach ($files as $file) {
  $data[] = array(
    'name' => $file['name'],
    'size' => $file['size'],
    'type' => $file['type'],
    'uploaded_at' => $file['uploaded_at']
  );
}

echo json_encode($data);

?>
