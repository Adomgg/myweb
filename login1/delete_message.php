<?php
session_start();
require 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 删除留言
    $sql = "DELETE FROM blogs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // 重定向到留言管理页面
    header('Location: admin.php');
    exit();
}
?>
