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

// 获取当前登录用户的用户名
$username = $_SESSION['username'];

// 查询所有博客，按发布时间倒序排列
$sql = "SELECT blogs.id, blogs.title, blogs.content, user.username 
        FROM blogs 
        JOIN user ON blogs.user_id = user.id 
        ORDER BY blogs.created_at DESC";

// 执行查询
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>查看留言</title>
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

        .container h1 {
            font-size: 2em;
            color: #333;
            margin-bottom: 20px;
        }

        .blog {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            background: #fff;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .blog h2 {
            font-size: 1.5em;
            color: #333;
            margin-bottom: 10px;
        }

        .blog p {
            font-size: 1em;
            color: #555;
            margin-bottom: 10px;
        }

        .blog small {
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>
<body>
    <nav>
        <div>
            <h2>导航栏</h2>
            <a href="message-board.html">返回首页</a>
            <a href="view_blogs.php">查看留言</a>
            <a href="write_blogs.html">写留言</a>
        </div>
        <button class="logout-button" onclick="confirmLogout()">退出</button>
    </nav>

    <div class="container">
        <h1>所有留言</h1>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="blog">
                    <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                    <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                    <small>作者: <?php echo htmlspecialchars($row['username']); ?></small>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>目前没有留言。</p>
        <?php endif; ?>
    </div>

    <script>
        // 确认退出
        function confirmLogout() {
            if (confirm("确定退出吗？")) {
                alert("成功退出！");
                window.location.href = "index.html";
            }
        }
    </script>
</body>
</html>
