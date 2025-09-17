<?php
require_once 'includes/auth-check.php';
require_once 'includes/database.php';

$page_title = 'Dashboard';

// Get stats for dashboard
try {
    $database = new Database();
    $conn = $database->getConnection();

    // Total tasks
    $stmt = $conn->prepare("SELECT COUNT(*) FROM tasks WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $current_user_id);
    $stmt->execute();
    $total_tasks = $stmt->fetchColumn();

    // Completed tasks
    $stmt = $conn->prepare("SELECT COUNT(*) FROM tasks WHERE user_id = :user_id AND status = 'completed'");
    $stmt->bindParam(':user_id', $current_user_id);
    $stmt->execute();
    $completed_tasks = $stmt->fetchColumn();

    // Recent tasks
    $stmt = $conn->prepare("
        SELECT * FROM tasks 
        WHERE user_id = :user_id 
        ORDER BY created_at DESC 
        LIMIT 5
    ");
    $stmt->bindParam(':user_id', $current_user_id);
    $stmt->execute();
    $recent_tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    $error_message = 'Error loading dashboard data.';
}
?>

<?php include 'includes/header.php'; ?>

    <div class="dashboard">
        <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $total_tasks; ?></h3>
                    <p>Total Tasks</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon completed">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $completed_tasks; ?></h3>
                    <p>Completed</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon pending">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $total_tasks - $completed_tasks; ?></h3>
                    <p>Pending</p>
                </div>
            </div>
        </div>

        <div class="recent-tasks">
            <h2><i class="fas fa-history"></i> Recent Tasks</h2>

            <?php if (empty($recent_tasks)): ?>
                <div class="empty-state">
                    <i class="fas fa-clipboard-list fa-3x"></i>
                    <p>No tasks yet. <a href="tasks/create.php">Create your first task!</a></p>
                </div>
            <?php else: ?>
                <div class="tasks-list">
                    <?php foreach ($recent_tasks as $task): ?>
                        <div class="task-item">
                            <div class="task-main">
                                <h4><?php echo htmlspecialchars($task['title']); ?></h4>
                                <span class="task-status status-<?php echo $task['status']; ?>">
                                <?php echo ucfirst($task['status']); ?>
                            </span>
                            </div>
                            <div class="task-meta">
                            <span class="task-priority priority-<?php echo $task['priority']; ?>">
                                <?php echo ucfirst($task['priority']); ?>
                            </span>
                                <?php if ($task['due_date']): ?>
                                    <span class="task-due">
                                    Due: <?php echo date('M j, Y', strtotime($task['due_date'])); ?>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="quick-actions">
            <h2><i class="fas fa-bolt"></i> Quick Actions</h2>
            <div class="action-buttons">
                <a href="tasks/create.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> New Task
                </a>
                <a href="tasks/index.php" class="btn btn-secondary">
                    <i class="fas fa-list"></i> View All Tasks
                </a>
            </div>
        </div>
    </div>

<?php include 'includes/footer.php'; ?>