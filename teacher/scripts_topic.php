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
    // ฟังก์ชั่นสำหรับการลบ file
    function deleteQuiz(quizId) {
        // ใช้ SweetAlert เพื่อแสดงการยืนยันก่อนลบ
        swal({
            title: "คุณแน่ใจหรือไม่?",
            text: "คุณแน่ใจหรือไม่ว่าต้องการลบการมอบหมายนี้?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
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
                        console.error("Error deleting file:", error);
                    }
                });
            } else {
                // ถ้าผู้ใช้ยกเลิกการลบ
                swal("การมอบหมายนี้ยังไม่ถูกลบ");
            }
        });
    }
</script>
<script>
    // ฟังก์ชั่นสำหรับการลบ file
    function deleteAssignment(assignment_id) {
        // ใช้ SweetAlert เพื่อแสดงการยืนยันก่อนลบ
        swal({
            title: "คุณแน่ใจหรือไม่?",
            text: "คุณแน่ใจหรือไม่ว่าต้องการลบการมอบหมายนี้?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
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
                        console.error("Error deleting file:", error);
                    }
                });
            } else {
                // ถ้าผู้ใช้ยกเลิกการลบ
                swal("การมอบหมายนี้ยังไม่ถูกลบ");
            }
        });
    }
</script>
<script>
    // ฟังก์ชั่นสำหรับการลบ file
    function deletefile(fileId) {
        // ใช้ SweetAlert เพื่อแสดงการยืนยันก่อนลบ
        swal({
            title: "คุณแน่ใจหรือไม่?",
            text: "คุณต้องการลบไฟล์นี้หรือไม่?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
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
                swal("ไฟล์นี้ยังไม่ถูกลบ");
            }
        });
    }
</script>