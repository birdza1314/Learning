<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- เรียกใช้ Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2>User Profile</h2>
        </div>
        <div class="card-body">
            <?php
            include('../connections/connection.php');

            if (isset($_GET['user_id'])) {
                $user_id = $_GET['user_id'];

                $select_stmt = $db->prepare("SELECT * FROM users WHERE user_id = :user_id");
                $select_stmt->bindParam(':user_id', $user_id);
                $select_stmt->execute();

                $user = $select_stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    echo "<p><strong>Username:</strong> " . htmlspecialchars($user['username']) . "</p>";
                    // สามารถแสดงข้อมูลอื่น ๆ ได้ตามต้องการ

                    // เพิ่มปุ่มแก้ไขและลบ
                    echo '<a href="edit_profile.php?user_id=' . $user['user_id'] . '" class="btn btn-warning">Edit</a>';
                    echo ' <a href="delete_profile.php?user_id=' . $user['user_id'] . '" class="btn btn-danger">Delete</a>';
                } else {
                    echo "<p>User not found.</p>";
                }
            } else {
                echo "<p>No user ID provided.</p>";
            }
            ?>
        </div>
    </div>
</div>

<!-- เรียกใช้ Bootstrap 5 JS และ Popper.js ร่วมกับ jQuery -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
