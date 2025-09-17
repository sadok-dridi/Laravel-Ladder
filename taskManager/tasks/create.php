<?php
require_once '../includes/auth-check.php';
require_once '../includes/database.php';

$page_title = 'Create Task';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $priority = $_POST['priority'];
    $due_date = $_POST['due_date'] ?: null;
    $status = 'pending';

    if (empty($title)) {
        $error_message = 'Title is required!';
    } else {
        try {
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare("
                INSERT INTO tasks (user_id, title, description, priority, due_date, status) 
                VALUES (:user_id, :title, :description, :priority, :due_date, :status)
            ");

            $stmt->bindParam(':user_id', $current_user_id);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':priority', $priority);
            $stmt->bindParam(':due_date', $due_date);
            $stmt->bindParam(':status', $status);

            if ($stmt->execute()) {
                $success_message = 'Task created successfully!';
                // Clear form
                $title = $description = '';
                $priority = 'medium';
                $due_date = '';
            }
        } catch(PDOException $e) {
            $error_message = 'Error creating task. Please try again.';
        }
    }
}
?>

<?php include '../includes/header.php'; ?>

    <div class="form-container">
        <div class="form-card">
            <h2><i class="fas fa-plus"></i> Create New Task</h2>

            <form method="post" action="create.php">
                <div class="form-group">
                    <label for="title">Title *</label>
                    <input type="text" id="title" name="title" required
                           value="<?php echo htmlspecialchars($title ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($description ?? ''); ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="priority">Priority</label>
                        <select id="priority" name="priority">
                            <option value="low" <?php echo ($priority ?? 'medium') === 'low' ? 'selected' : ''; ?>>Low</option>
                            <option value="medium" <?php echo ($priority ?? 'medium') === 'medium' ? 'selected' : ''; ?>>Medium</option>
                            <option value="high" <?php echo ($priority ?? 'medium') === 'high' ? 'selected' : ''; ?>>High</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="due_date">Due Date</label>
                        <input type="date" id="due_date" name="due_date"
                               value="<?php echo $due_date ?? ''; ?>">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Task
                    </button>
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

<?php include '../includes/footer.php'; ?>