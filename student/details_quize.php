<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ทำแบบทดสอบ</title>
    <!-- เพิ่ม CSS เพื่อปรับการแสดงผลให้ responsive -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5 text-center">ทำแบบทดสอบ</h1>
        <!-- แสดงคำถามและตัวเลือกในแบบฟอร์ม -->
        <form action="submit_quiz.php" method="POST" id="quizForm">
            <?php
            // ค้นหาและแสดงคำถาม
            $stmt = $db->prepare("SELECT * FROM questions WHERE quiz_id = :quiz_id");
            $stmt->bindParam(':quiz_id', $quiz_id);
            $stmt->execute();
            $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($questions as $question) {
                // แสดงคำถาม
                echo '<div class="card mt-4">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $question['question'] . '</h5>';

                // แสดงตัวเลือก
                for ($i = 1; $i <= 4; $i++) {
                    echo '<div class="form-check">';
                    echo '<input class="form-check-input" type="radio" name="answer_' . $question['question_id'] . '" id="answer_' . $question['question_id'] . '_' . $i . '" value="' . $i . '">';
                    echo '<label class="form-check-label" for="answer_' . $question['question_id'] . '_' . $i . '">' . $question['option_' . $i] . '</label>';
                    echo '</div>';
                }

                echo '</div>';
                echo '</div>';
            }
            ?>
            <!-- ปุ่มสำหรับส่งแบบทดสอบ -->
            <button type="submit" class="btn btn-primary mt-3">ส่งแบบทดสอบ</button>
        </form>
    </div>
    <!-- เพิ่ม JavaScript เพื่อให้ Bootstrap ทำงานได้ -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // คำนวณเวลาที่เหลือจากเวลาเริ่มต้นและเวลาที่กำหนด
        var startTime = <?php echo strtotime($quiz['start_time']) * 1000; ?>; // เวลาเริ่มต้นของแบบทดสอบ (มิลลิวินาที)
        var timeLimit = <?php echo $quiz['time_limit'] * 1000; ?>; // ระยะเวลาที่กำหนดในแบบทดสอบ (มิลลิวินาที)
        var endTime = startTime + timeLimit; // เวลาสิ้นสุดของแบบทดสอบ (มิลลิวินาที)
        
        // ตั้งเวลาเพื่อส่งแบบทดสอบโดยอัตโนมัติ
        setTimeout(function() {
            document.getElementById("quizForm").submit();
        }, endTime - Date.now()); // แปลงเวลาให้เป็นมิลลิวินาที
    </script>
</body>
</html>
