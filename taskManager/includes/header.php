<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager - <?php echo $page_title ?? 'Dashboard'; ?></title>
    <link rel="stylesheet" href="<?php echo asset('/style.css'); ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar">
    <div class="nav-container">
        <div class="nav-brand">
            <i class="fas fa-tasks"></i>
            Task Manager
        </div>
        <div class="nav-menu">
            <a href="<?php echo url('/dashboard.php'); ?>" class="nav-link"><i class="fas fa-home"></i> Dashboard</a>
            <a href="<?php echo url('/tasks/index.php'); ?>" class="nav-link"><i class="fas fa-list"></i> My Tasks</a>
            <a href="<?php echo url('/tasks/create.php'); ?>" class="nav-link"><i class="fas fa-plus"></i> New Task</a>
            <span class="nav-user">Welcome <?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?></span>
            <a href="<?php echo url('/auth/logout.php'); ?>" class="nav-link logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <?php if (isset($success_message)): ?>
        <div class="alert success">
            <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
    <div class="alert error">
        <i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
    </div>
<?php endif; ?>