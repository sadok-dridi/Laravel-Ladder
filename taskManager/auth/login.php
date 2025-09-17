<?php
session_start();
require_once '../includes/database.php';
require_once '../includes/functions.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    $redirect_path = $_GET['redirect'] ?? '/dashboard.php';

// Validate it's a safe path within your application
    $allowed_paths = ['/dashboard.php', '/tasks/index.php', '/profile.php'];
    if (in_array($redirect_path, $allowed_paths)) {
        header('Location: ' . url($redirect_path));
    } else {
        header('Location: ' . url('/dashboard.php')); // Fallback
    }
    exit();
}

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error_message = 'Please enter both username and password!';
    } else {
        try {
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if (password_verify($password, $user['password'])) {
                    // Create session
                    session_regenerate_id(true);
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['logged_in'] = true;
                    $_SESSION['login_time'] = time();

                    // Redirect to intended page or dashboard
                    $redirect = $_GET['redirect'] ?? '../dashboard.php';
                    header('Location: ' . $redirect);
                    exit();
                }
            }

            $error_message = 'Invalid username or password!';

        } catch(PDOException $e) {
            $error_message = 'Login failed. Please try again.';
        }
    }
}

$page_title = 'Login';
?>
<?php include '../includes/header.php'; ?>

    <div class="auth-container">
        <div class="auth-card">
            <h2><i class="fas fa-sign-in-alt"></i> Login</h2>

            <form method="post" action="login.php<?php echo isset($_GET['redirect']) ? '?redirect=' . urlencode($_GET['redirect']) : ''; ?>">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required
                           value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>

            <p class="auth-link">
                Don't have an account? <a href="register.php">Register here</a>
            </p>
        </div>
    </div>

<?php include '../includes/footer.php'; ?>