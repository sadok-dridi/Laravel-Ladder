<?php
require_once '../includes/auth-check.php';
require_once '../includes/database.php';

// Check if task ID is provided
$task_id = $_GET['id'] ?? null;

if (!$task_id) {
    header('Location: index.php');
    exit();
}

try {
    $database = new Database();
    $conn = $database->getConnection();

    // Get task title for confirmation message
    $stmt = $conn->prepare("SELECT title FROM tasks WHERE id = :id AND user_id = :user_id");
    $stmt->bindParam(':id', $task_id);
    $stmt->bindParam(':user_id', $current_user_id);
    $stmt->execute();

    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$task) {
        header('Location: index.php?error=not_found');
        exit();
    }

    // Delete the task
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = :id AND user_id = :user_id");
    $stmt->bindParam(':id', $task_id);
    $stmt->bindParam(':user_id', $current_user_id);

    if ($stmt->execute()) {
        header('Location: index.php?success=deleted&task=' . urlencode($task['title']));
        exit();
    } else {
        header('Location: index.php?error=delete_failed');
        exit();
    }

} catch(PDOException $e) {
    header('Location: index.php?error=database_error');
    exit();
}