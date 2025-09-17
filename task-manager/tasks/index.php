<?php
require_once '../includes/auth-check.php';
require_once '../includes/database.php';

$page_title = 'My Tasks';

// Get tasks from database
try {
    $database = new Database();
    $conn = $database->getConnection();

    $stmt = $conn->prepare("
        SELECT id, title, description, status, priority, due_date, created_at 
        FROM tasks 
        WHERE user_id = :user_id 
        ORDER BY 
            CASE priority 
                WHEN 'high' THEN 1 
                WHEN 'medium' THEN 2 
                WHEN 'low' THEN 3 
            END,
            due_date ASC,
            created_at DESC
    ");
    $stmt->bindParam(':user_id', $current_user_id);
    $stmt->execute();

    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    $error_message = 'Error loading tasks. Please try again.';
}

// Handle task deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_task'])) {
    try {
        $task_id = $_POST['task_id'];

        $stmt = $conn->prepare("DELETE FROM tasks WHERE id = :id AND user_id = :user_id");
        $stmt->bindParam(':id', $task_id);
        $stmt->bindParam(':user_id', $current_user_id);

        if ($stmt->execute()) {
            $success_message = 'Task deleted successfully!';
            // Refresh the page to show updated list
            header('Location: index.php?success=deleted');
            exit();
        }
    } catch(PDOException $e) {
        $error_message = 'Error deleting task.';
    }
}
?>

<?php include '../includes/header.php'; ?>

    <div class="page-header">
        <h1><i class="fas fa-list"></i> My Tasks</h1>
        <a href="create.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Task
        </a>
    </div>

<?php if (empty($tasks)): ?>
    <div class="empty-state">
        <i class="fas fa-clipboard-list fa-4x"></i>
        <h3>No tasks yet!</h3>
        <p>Get started by creating your first task.</p>
        <a href="create.php" class="btn btn-primary">Create Your First Task</a>
    </div>
<?php else: ?>
    <div class="tasks-grid">
        <?php foreach ($tasks as $task): ?>
            <div class="task-card task-<?php echo $task['status']; ?>">
                <div class="task-header">
                    <h3><?php echo htmlspecialchars($task['title']); ?></h3>
                    <span class="task-priority priority-<?php echo $task['priority']; ?>">
                        <?php echo ucfirst($task['priority']); ?>
                    </span>
                </div>

                <div class="task-body">
                    <?php if (!empty($task['description'])): ?>
                        <p><?php echo nl2br(htmlspecialchars($task['description'])); ?></p>
                    <?php endif; ?>

                    <div class="task-meta">
                        <?php if ($task['due_date']): ?>
                            <span class="task-due">
                                <i class="fas fa-calendar"></i>
                                Due: <?php echo date('M j, Y', strtotime($task['due_date'])); ?>
                            </span>
                        <?php endif; ?>

                        <span class="task-status status-<?php echo $task['status']; ?>">
                            <i class="fas fa-<?php echo $task['status'] === 'completed' ? 'check-circle' : 'circle'; ?>"></i>
                            <?php echo ucfirst($task['status']); ?>
                        </span>
                    </div>
                </div>

                <div class="task-actions">
                    <a href="edit.php?id=<?php echo $task['id']; ?>" class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i> Edit
                    </a>

                    <form method="post" style="display: inline;" onsubmit="return confirmDelete('<?php echo addslashes($task['title']); ?>')">
                        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                        <button type="submit" name="delete_task" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>

                    <?php if ($task['status'] !== 'completed'): ?>
                        <form method="post" action="edit.php" style="display: inline;">
                            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" name="update_status" class="btn btn-sm btn-success">
                                <i class="fas fa-check"></i> Complete
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>