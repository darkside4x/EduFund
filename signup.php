<!-- signup.php -->
<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        // Check if username or email already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        
        if ($stmt->rowCount() > 0) {
            header("Location: signup.html?error=exists");
            exit;
        }

        // Insert new user
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);

        // Get the new user's ID
        $user_id = $pdo->lastInsertId();

        // Set session variables
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $user_id;
        
        // Set a success message
        $_SESSION['signup_success'] = true;
        
        header("Location: dash.html");
        exit;
    } catch(PDOException $e) {
        error_log("Signup error: " . $e->getMessage());
        header("Location: signup.html?error=system");
        exit;
    }
}
?>