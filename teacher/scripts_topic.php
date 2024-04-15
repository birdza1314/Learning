<script>
// ฟังก์ชั่นสำหรับการแก้ไข Quiz
function editQuiz(quizId) {
    // Redirect ไปยังหน้าแก้ไข Quiz โดยส่งค่า quizId ไปด้วย
    window.location.href = "edit_quiz.php?quiz_id=" + quizId;
}
</script>
<script>
    function viewQuizResults(quizId) {
        window.location.href = "view_quiz_results.php?quiz_id=" + quizId;
    }
</script>

<script>
    // ฟังก์ชั่นสำหรับการลบ Quiz
    function deleteQuiz(quizId) {
        // ใช้ confirm เพื่อแสดงการยืนยันก่อนลบ
        var confirmDelete = confirm("คุณแน่ใจหรือไม่ว่าต้องการลบการมอบหมายนี้?");
        if (confirmDelete) {
            // ถ้าผู้ใช้ต้องการลบ
            $.ajax({
                type: "POST",
                url: "delete_quiz.php",
                data: { quiz_id: quizId },
                success: function(response) {
                    // รีโหลดหน้าเพื่อแสดงการเปลี่ยนแปลง
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // แสดงข้อความผิดพลาดในกรณีที่ไม่สามารถลบได้
                    console.error("Error deleting quiz:", error);
                }
            });
        } else {
            // ถ้าผู้ใช้ยกเลิกการลบ
            alert("การมอบหมายนี้ยังไม่ถูกลบ");
        }
    }
</script>

<script>
    // ฟังก์ชั่นสำหรับการลบ Assignment
    function deleteAssignment(assignment_id) {
        // ใช้ confirm เพื่อแสดงการยืนยันก่อนลบ
        var confirmDelete = confirm("คุณแน่ใจหรือไม่ว่าต้องการลบการมอบหมายนี้?");
        if (confirmDelete) {
            // ถ้าผู้ใช้ต้องการลบ
            $.ajax({
                type: "POST",
                url: "delete_assignment.php",
                data: { assignment_id: assignment_id },
                success: function(response) {
                    // รีโหลดหน้าเพื่อแสดงการเปลี่ยนแปลง
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // แสดงข้อความผิดพลาดในกรณีที่ไม่สามารถลบได้
                    console.error("Error deleting assignment:", error);
                }
            });
        } else {
            // ถ้าผู้ใช้ยกเลิกการลบ
            alert("การมอบหมายนี้ยังไม่ถูกลบ");
        }
    }
</script>

<script>
    // ฟังก์ชั่นสำหรับการลบไฟล์
    function deletefile(fileId) {
        // ใช้ confirm เพื่อแสดงการยืนยันก่อนลบ
        var confirmDelete = confirm("คุณต้องการลบไฟล์นี้หรือไม่?");
        if (confirmDelete) {
            // ถ้าผู้ใช้ต้องการลบ
            $.ajax({
                type: "POST",
                url: "delete_file.php",
                data: { file_id: fileId },
                success: function(response) {
                    // รีโหลดหน้าเพื่อแสดงการเปลี่ยนแปลง
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // แสดงข้อความผิดพลาดในกรณีที่ไม่สามารถลบได้
                    console.error("Error deleting file:", error);
                }
            });
        } else {
            // ถ้าผู้ใช้ยกเลิกการลบ
            alert("ไฟล์นี้ยังไม่ถูกลบ");
        }
    }
</script>
