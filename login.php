<!-- login.php -->
<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user['id'];
            
            // Set a success message
            $_SESSION['login_success'] = true;
            
            header("Location: dash.html");
            exit;
        } else {
            header("Location: login.html?error=invalid");
            exit;
        }
    } catch(PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        header("Location: login.html?error=system");
        exit;
    }
}
?>