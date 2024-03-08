<script>
// ฟังก์ชั่นสำหรับการแก้ไข Quiz
function editQuiz(quizId) {
    // Redirect ไปยังหน้าแก้ไข Quiz โดยส่งค่า quizId ไปด้วย
    window.location.href = "edit_quiz.php?quiz_id=" + quizId;
}

// ฟังก์ชั่นสำหรับการลบ Quiz
function deleteQuiz(quizId) {
    var confirmation = confirm("คุณแน่ใจหรือไม่ที่ต้องการลบ Quiz นี้?");
    if (confirmation) {
        // ถ้าผู้ใช้ยืนยันการลบ
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
    }
}
function deleteAssignment(assignment_id) {
    // Confirm before deleting
    if (confirm("คุณแน่ใจหรือไม่ว่าต้องการลบการมอบหมายนี้?")) {
        // Send AJAX request to delete assignment
        $.ajax({
            url: 'delete_assignment.php',
            method: 'POST',
            data: {
                assignment_id: assignment_id
            },
            success: function(response) {
                // Handle success response here
                console.log(response);
                // Reload or update page as needed
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }
}

</script>