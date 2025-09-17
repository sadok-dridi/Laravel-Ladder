<?php
require_once '../includes/auth-check.php';
require_once '../includes/database.php';

$page_title = 'Edit Task';
$error_message = '';

// Get task ID from URL
$task_id = $_GET['id'] ?? null;

if (!$task_id) {
    header('Location: index.php');
    exit();
}

// Get current task data
try {
    $database = new Database();
    $conn = $database->getConnection();

    $stmt = $conn->prepare("SELECT * FROM tasks WHERE id = :id AND user_id = :user_id");
    $stmt->bindParam(':id', $task_id);
    $stmt->bindParam(':user_id', $current_user_id);
    $stmt->execute();

    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$task) {
        header('Location: index.php');
        exit();
    }

} catch(PDOException $e) {
    $error_message = 'Error loading task.';
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if this is a status update
    if (isset($_POST['update_status'])) {
        $new_status = $_POST['status'];

        $stmt = $conn->prepare("UPDATE tasks SET status = :status WHERE id = :id AND user_id = :user_id");
        $stmt->bindParam(':status', $new_status);
        $stmt->bindParam(':id', $task_id);
        $stmt->bindParam(':user_id', $current_user_id);

        if ($stmt->execute()) {
            header('Location: index.php?success=updated');
            exit();
        }
    } else {
        // Full update
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $priority = $_POST['priority'];
        $due_date = $_POST['due_date'] ?: null;
        $status = $_POST['status'];

        if (empty($title)) {
            $error_message = 'Title is required!';
        } else {
            try {
                $stmt = $conn->prepare("
                    UPDATE tasks 
                    SET title = :title, description = :description, priority = :priority, 
                        due_date = :due_date, status = :status 
                    WHERE id = :id AND user_id = :user_id
                ");

                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':priority', $priority);
                $stmt->bindParam(':due_date', $due_date);
                $stmt->bindParam(':status', $status);
                $stmt->bindParam(':id', $task_id);
                $stmt->bindParam(':user_id', $current_user_id);

                if ($stmt->execute()) {
                    $success_message = 'Task updated successfully!';
                    // Refresh task data
                    $task = array_merge($task, [
                        'title' => $title,
                        'description' => $description,
                        'priority' => $priority,
                        'due_date' => $due_date,
                        'status' => $status
                    ]);
                }
            } catch(PDOException $e) {
                $error_message = 'Error updating task. Please try again.';
            }
        }
    }
}
?>

<?php include '../includes/header.php'; ?>

    <div class="form-container">
        <div class="form-card">
            <h2><i class="fas fa-edit"></i> Edit Task</h2>

            <form method="post" action="edit.php?id=<?php echo $task_id; ?>">
                <div class="form-group">
                    <label for="title">Title *</label>
                    <input type="text" id="title" name="title" required
                           value="<?php echo htmlspecialchars($task['title']); ?>">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($task['description']); ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="priority">Priority</label>
                        <select id="priority" name="priority">
                            <option value="low" <?php echo $task['priority'] === 'low' ? 'selected' : ''; ?>>Low</option>
                            <option value="medium" <?php echo $task['priority'] === 'medium' ? 'selected' : ''; ?>>Medium</option>
                            <option value="high" <?php echo $task['priority'] === 'high' ? 'selected' : ''; ?>>High</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="due_date">Due Date</label>
                        <input type="date" id="due_date" name="due_date"
                               value="<?php echo $task['due_date'] ? date('Y-m-d', strtotime($task['due_date'])) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="pending" <?php echo $task['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="in_progress" <?php echo $task['status'] === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                            <option value="completed" <?php echo $task['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Task
                    </button>
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

<?php include '../includes/footer.php'; ?>