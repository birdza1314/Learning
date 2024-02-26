<?php
include('../connections/connection.php');

// Check if assignment_id is set in the URL parameter
if(isset($_GET['assignment_id'])) {
    // Retrieve assignment data based on assignment_id
    $assignment_id = $_GET['assignment_id'];
    
    try {
        // Prepare SQL statement to fetch assignment data
        $query = "SELECT * FROM assignments WHERE assignment_id = ?";
        $statement = $db->prepare($query);
        $statement->execute([$assignment_id]);

        // Check if assignment data is found
        if($statement->rowCount() > 0) {
            // Assign assignment data to $assignment
            $assignment = $statement->fetch(PDO::FETCH_ASSOC);
        } else {
            // Handle case where assignment data is not found
            echo "Assignment data is not available.";
            exit; // Exit script
        }
    } catch(PDOException $e) {
        // Handle database connection errors
        echo "Error: " . $e->getMessage();
        exit; // Exit script
    }
} else {
    // Handle case where assignment_id is not set in the URL parameter
    echo "Assignment ID is not provided.";
    exit; // Exit script
}
?>
<?php include('session.php'); ?>
<!-- ======= Head ======= -->
<?php include('head.php'); ?>
<!-- ======= Head ======= -->

<body>

  <!-- ======= Header ======= -->
  <?php include('header.php'); ?>

  <!-- ======= Sidebar ======= -->
  <?php include('sidebar.php'); ?>

<main id="main" class="main">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="fw-bold mb-0">Edit Assignment</h2>
            </div>
            <div class="card-body">
                <form action="update_assignment.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>">
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Assignment Title: <span class="text-danger">*</label>
                        <input type="text" class="form-control" name="title" id="title" value="<?php echo $assignment['title']; ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Assignment Description:</label>
                        <textarea class="form-control" name="description" id="description" rows="3" required><?php echo $assignment['description']; ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="file_path" class="form-label">Assignment File:</label>
                        <input type="file" class="form-control" name="file_path" id="file_path">
                    </div>
                    <div class="card">
                        <div class="card-header">
                                <h5 class="card-title">Availability <span class="text-danger">*</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-lg-4 col-md-6">
                                    <label for="open_time" class="form-label">Open Assignment At:</label>
                                    <input type="datetime-local" class="form-control" name="open_time" id="open_time" value="<?php echo date('Y-m-d\TH:i', strtotime($assignment['open_time'])); ?>" required>
                                </div>
                                <div class="mb-3 col-lg-4 col-md-6">
                                    <label for="deadline" class="form-label">Due date:</label>
                                    <input type="datetime-local" class="form-control" name="deadline" id="deadline" value="<?php echo isset($assignment['deadline']) ? date('Y-m-d\TH:i', strtotime($assignment['deadline'])) : ''; ?>" required>
                                </div>
                                <div class="mb-3 col-lg-4 col-md-6">
                                    <label for="close_time" class="form-label">Close Assignment At:</label>
                                    <input type="datetime-local" class="form-control" name="close_time" id="close_time" value="<?php echo isset($assignment['close_time']) ? date('Y-m-d\TH:i', strtotime($assignment['close_time'])) : ''; ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="status" class="form-label">Status:</label>
                        <select class="form-select" name="status" id="status" required>
                            <option value="open" <?php if ($assignment['status'] == 'open') echo 'selected'; ?>>Open</option>
                            <option value="closed" <?php if ($assignment['status'] == 'closed') echo 'selected'; ?>>Closed</option>
                        </select>
                    </div>
                    <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-outline-primary">Update Assignment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php include('footer.php');?>
<!-- ======= scripts ======= -->
<?php include('scripts.php');?>

<!-- Add jQuery script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Add Bootstrap script -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<?php include('scripts_topic.php');?>
<?php include('Modal_scripts.php');?>
</body>
</html>
<button onclick="goBack()">Go Back</button>

<script>
function goBack() {
  window.history.back();
}
</script>
