<?php
session_start();
require 'db_connection.php';

// 检查用户是否已登录
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// 检查请求方法是否为 POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 验证输入是否存在
    if (isset($_POST['id'], $_POST['username'], $_POST['password'])) {
        $id = intval($_POST['id']); // 确保 ID 是整数
        $username = trim($_POST['username']); // 去除空白字符
        $password = trim($_POST['password']); // 去除空白字符

        // 检查 username 和 password 是否为空
        if (empty($username) || empty($password)) {
            echo "用户名和密码不能为空。";
            exit();
        }

        // 准备更新 SQL 语句
        $sql = "UPDATE user SET username = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo "SQL 语句准备失败：" . $conn->error;
            exit();
        }

        // 绑定参数
        $stmt->bind_param("ssi", $username, $password, $id);

        // 执行查询并检查结果
        if ($stmt->execute()) {
            // 更新成功，跳转到用户管理页面
            header('Location: manage_users.php');
            exit();
        } else {
            // 执行失败，输出错误信息
            echo "更新失败：" . $stmt->error;
        }

        // 关闭语句
        $stmt->close();
    } else {
        echo "输入不完整。";
    }
}

// 关闭数据库连接
$conn->close();
?>
