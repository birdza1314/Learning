<?php

$connection = mysqli_connect("localhost", "root", "", "your_database_name");

// ดึงข้อมูลคำถาม
$questionId = $_POST['question_id'];
$sql = "SELECT * FROM questions WHERE question_id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $questionId);
$stmt->execute();
$result = $stmt->get_result();
$questionData = $result->fetch_assoc();

// ส่งข้อมูลคำถามกลับไปยัง client
echo json_encode($questionData);

?>
