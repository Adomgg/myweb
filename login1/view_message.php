<?php
session_start();
require 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 查询指定留言
    $sql = "SELECT blogs.title, blogs.content, user.username, blogs.created_at 
            FROM blogs 
            JOIN user ON blogs.user_id = user.id 
            WHERE blogs.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $message = $result->fetch_assoc();
    } else {
        echo "留言不存在！";
        exit();
    }
} else {
    echo "未提供留言ID！";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>查看留言</title>
    <style>
        /* 可复用样式 */
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 10px;
        }

        .back-button {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .back-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($message['title']); ?></h1>
        <p><strong>作者:</strong> <?php echo htmlspecialchars($message['username']); ?></p>
        <p><strong>发布时间:</strong> <?php echo htmlspecialchars($message['created_at']); ?></p>
        <hr>
        <p><?php echo nl2br(htmlspecialchars($message['content'])); ?></p>
        <a href="admin.php" class="back-button">返回留言管理</a>
    </div>
</body>
</html>
