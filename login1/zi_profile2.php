<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

// 文件上传逻辑
$avatar = null;
if (!empty($_FILES['avatar']['name'])) {
    $targetDir = "uploads/";
    $avatar = $targetDir . basename($_FILES['avatar']['name']);
    move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar);
}

// 更新用户信息
$email = $_POST['email'];
$bio = $_POST['bio'];

$sql = "UPDATE user SET email = ?, bio = ?, avatar = ? WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $email, $bio, $avatar, $username);
$stmt->execute();

header('Location: profile.php');
exit();
?>
