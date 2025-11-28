<?php
header('Content-Type: text/plain; charset=utf-8');
require 'config.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    error_log("[DB CONNECT FAIL]" . $conn->connect_error . "\n", 3, "db_connect_fail.log");
    die("DB Connection failed");
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name  = trim($_POST['name'] ?? '');
    $biz   = trim($_POST['biz'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    $name  = htmlspecialchars($name,  ENT_QUOTES, 'UTF-8');
    $biz   = htmlspecialchars($biz,   ENT_QUOTES, 'UTF-8');
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars($phone, ENT_QUOTES, 'UTF-8');

    if ($name && $biz && $email && $phone && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("INSERT INTO leads (name, biz, email, phone) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssss", $name, $biz, $email, $phone);
            $stmt->execute();
            $stmt->close();
            file_put_contents("insert_ok.log", "[INSERT OK]{$name}|{$biz}|{$email}|{$phone}\n", FILE_APPEND);
        }
    }

    $conn->close();

    // Redirect
    header("Location: cta_success.php");
    exit;
}

$conn->close();
?>
