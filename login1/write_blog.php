<?php
session_start();
require 'db_connection.php';

// 检查用户是否已登录
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// 获取当前登录用户的用户名
$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // 查询用户ID (使用预处理语句)
    $sql_id = "SELECT id FROM user WHERE username = ?";
    $stmt_id = $conn->prepare($sql_id);
    if ($stmt_id) {
        $stmt_id->bind_param("s", $username);
        $stmt_id->execute();
        $stmt_id->bind_result($user_id);
        if ($stmt_id->fetch()) {
            $stmt_id->close();

            // 插入博客数据
            $stmt = $conn->prepare("INSERT INTO blogs (title, content, user_id, created_at) VALUES (?, ?, ?, NOW())");
            if ($stmt) {
                $stmt->bind_param("ssi", $title, $content, $user_id);
                if ($stmt->execute()) {
                    echo "<script>alert('博客发布成功！'); window.location.href='message-board.html';</script>";
                } else {
                    echo "<script>alert('博客发布失败！');</script>";
                }
                $stmt->close();
            } else {
                echo "<script>alert('数据库错误：无法准备博客插入语句。');</script>";
            }
        } else {
            echo "<script>
                  alert('用户信息获取失败，请重试!');
                  window.location.href = 'index.html';
                  </script>";
        }
    } else {
        echo "<script>alert('数据库错误：无法准备用户查询语句。');</script>";
    }
}
?>

