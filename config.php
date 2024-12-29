<!-- config.php -->
<?php
$host = 'sql12.freesqldatabase.com';
$dbname = 'sql12754543';
$username = 'sql12754543';
$password = 'pStI1imTDR';
$port = 3306;

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>