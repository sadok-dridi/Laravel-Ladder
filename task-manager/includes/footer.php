</div>

<footer class="footer">
    <div class="footer-container">
        <p>&copy; 2024 Task Manager. Built with PHP, MySQL, and ❤️</p>
        <p>Session ID: <?php echo session_id(); ?> | User ID: <?php echo $_SESSION['user_id'] ?? 'Not logged in'; ?></p>
    </div>
</footer>

<script>
    // Auto-hide alerts after 5 seconds
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);

    // Confirm delete actions
    function confirmDelete(taskTitle) {
        return confirm('Are you sure you want to delete "' + taskTitle + '"? This action cannot be undone.');
    }
</script>
</body>
</html>