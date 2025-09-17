<?php
session_start();
require_once 'includes/functions.php';
// Redirect to dashboard if logged in
if (isset($_SESSION['user_id'])) {
    redirect('/dashboard.php');
    exit();
}

$page_title = 'Home';
?>


<?php include 'includes/header.php'; ?>

    <div class="hero-section">
        <div class="hero-content">
            <h1><i class="fas fa-tasks"></i> Task Manager</h1>
            <p class="hero-description">Organize your tasks, boost your productivity, and get things done with our intuitive task management system.</p>

            <div class="hero-features">
                <div class="feature">
                    <i class="fas fa-check-circle"></i>
                    <h3>Create Tasks</h3>
                    <p>Easily create and organize your tasks with priorities and due dates.</p>
                </div>

                <div class="feature">
                    <i class="fas fa-sync-alt"></i>
                    <h3>Track Progress</h3>
                    <p>Update task status and monitor your progress towards completion.</p>
                </div>

                <div class="feature">
                    <i class="fas fa-shield-alt"></i>
                    <h3>Secure & Private</h3>
                    <p>Your tasks are private and secure, accessible only by you.</p>
                </div>
            </div>

            <div class="hero-actions">
                <a href="<?php echo url('/auth/register.php'); ?>" class="btn btn-primary btn-large">
                    <i class="fas fa-user-plus"></i> Get Started
                </a>
                <a href="<?php echo url('/auth/login.php'); ?>" class="btn btn-secondary btn-large">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            </div>
        </div>
    </div>

    <div class="demo-section">
        <div class="container">
            <h2>Why Choose Our Task Manager?</h2>

            <div class="benefits-grid">
                <div class="benefit">
                    <i class="fas fa-mobile-alt"></i>
                    <h3>Responsive Design</h3>
                    <p>Works perfectly on desktop, tablet, and mobile devices.</p>
                </div>

                <div class="benefit">
                    <i class="fas fa-bolt"></i>
                    <h3>Fast & Efficient</h3>
                    <p>Built with modern PHP and MySQL for optimal performance.</p>
                </div>

                <div class="benefit">
                    <i class="fas fa-lock"></i>
                    <h3>Secure Authentication</h3>
                    <p>Passwords are hashed and sessions are securely managed.</p>
                </div>

                <div class="benefit">
                    <i class="fas fa-code"></i>
                    <h3>Open Standards</h3>
                    <p>Built with PHP, MySQL, HTML5, and CSS3 - no frameworks required.</p>
                </div>
            </div>
        </div>
    </div>

<?php include 'includes/footer.php'; ?>