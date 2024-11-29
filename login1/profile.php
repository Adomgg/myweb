<?php
// 开启会话
session_start();

// 引入数据库连接文件
require 'db_connection.php';

// 检查用户是否已登录
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
 // 获取当前用户的 ID
$user_id = $_SESSION['user_id'];

// 准备查询用户信息的 SQL 语句
$stmt = $conn->prepare("SELECT username, password FROM user WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc(); // 获取用户信息
// // 获取当前登录用户的用户名
// $username = $_SESSION['username'];

// // 查询用户当前信息
// $sql = "SELECT avatar, email, bio FROM user WHERE username = ?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("s", $username);
// $stmt->execute();
// $result = $stmt->get_result();
// $user = $result->fetch_assoc();
// ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>个人信息</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            height: 100vh;
            margin: 0;
            color: #333;
        }

        nav {
            background-color: #333;
            color: #fff;
            width: 250px;
            height: 100vh;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        nav h2 {
            margin-bottom: 20px;
            font-size: 1.5em;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #575757;
        }

        .logout-button {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
            margin-top: auto;
        }

        .logout-button:hover {
            background-color: #e60000;
        }

        .container {
            flex: 1;
            margin-left: 2px;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            overflow-y: auto;
        }

        h1 {
            font-size: 2em;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            font-size: 1em;
            margin-bottom: 10px;
            display: block;
            color: #555;
        }

        input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        textarea {
            resize: none;
        }

        input[type="file"] {
            margin-bottom: 20px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <nav>
        <div>
            <h2>导航栏</h2>
            <a href="message-board.html">返回首页</a>
            <a href="view_blogs.php">查看博客</a>
            <a href="write_blogs.html">写博客</a>
            <a href="profile.php">个人信息</a>
        </div>
        <button class="logout-button" onclick="confirmLogout()">退出</button>
    </nav>

    <div class="container">
        <h1>个人信息</h1>
        <form action="zi_profile2.php" method="POST" enctype="multipart/form-data">
            <label for="avatar">头像：</label>
            <?php if (!empty($user['avatar'])): ?>
                <img src="<?php echo htmlspecialchars($user['avatar']); ?>" alt="头像" style="max-width: 100px; margin-bottom: 10px;">
            <?php endif; ?>
            <input type="file" id="avatar" name="avatar">

            <label for="email">邮箱：</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" placeholder="请输入邮箱" required>

            <label for="bio">自我介绍：</label>
            <textarea id="bio" name="bio" rows="5" placeholder="请输入自我介绍"><?php echo htmlspecialchars($user['bio']); ?></textarea>

            <button type="submit">保存信息</button>
        </form>
    </div>

    <script>
        function confirmLogout() {
            if (confirm("确定退出吗？")) {
                alert("成功退出！");
                window.location.href = "index.html";
            }
        }
    </script>
</body>
</html>
