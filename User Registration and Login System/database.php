<?php
/**
 * Database connection using PDO (PHP Data Objects)
 * This is the modern, secure way to connect to MySQL
 */

class Database {
    private $host = 'localhost';
    private $db_name = 'user_auth_system';
    private $username = 'root'; // Change if needed
    private $password = ''; // Change if needed
    private $conn;

    // Method to get database connection
    public function getConnection() {
        $this->conn = null;

        try {
            // Data Source Name (DSN) - tells PDO which database to connect to
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8";

            // Create PDO instance (connection)
            $this->conn = new PDO($dsn, $this->username, $this->password);

            // Set error mode to exception - makes PDO throw exceptions on errors
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prevent emulated prepared statements (extra security)
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        } catch(PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }

        return $this->conn;
    }
}
?>