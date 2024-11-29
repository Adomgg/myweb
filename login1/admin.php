<?php
session_start();
require 'db_connection.php';

// 检查用户是否已登录
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// 处理搜索功能
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
    $sql = "SELECT blogs.id, blogs.title, blogs.content, user.username 
            FROM blogs 
            JOIN user ON blogs.user_id = user.id 
            WHERE blogs.title LIKE ? OR user.username LIKE ?
            ORDER BY blogs.created_at DESC";
    $stmt = $conn->prepare($sql);
    $like_query = '%' . $search_query . '%';
    $stmt->bind_param('ss', $like_query, $like_query);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT blogs.id, blogs.title, blogs.content, user.username 
            FROM blogs 
            JOIN user ON blogs.user_id = user.id 
            ORDER BY blogs.created_at DESC";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>留言管理</title>
    <style>
        /* 样式保持不变 */
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
            margin-bottom: 20px;
        }

        .search-bar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .search-bar input {
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 300px;
        }

        .search-bar button {
            padding: 10px 20px;
            margin-left: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-bar button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
        }

        table th {
            background-color: #f4f4f4;
        }

        .action-buttons button {
            margin-right: 10px;
            padding: 5px 10px;
            cursor: pointer;
            border: none;
            border-radius: 3px;
        }

        .delete-button {
            background-color: #ff4d4d;
            color: white;
        }

        .delete-button:hover {
            background-color: #e60000;
        }
    </style>
</head>
<body>
    <nav>
        <h2>导航栏</h2>
        <a href="admin.html">返回首页</a>
        <a href="admin.php">管理留言</a>
        <a href="manage_users.php">管理用户</a>
        <button class="logout-button" onclick="confirmLogout()">退出</button>
    </nav>

    <div class="container">
        <h1>留言管理</h1>

        <div class="search-bar">
            <form action="admin.php" method="GET">
                <input type="text" name="search" placeholder="搜索用户名或标题..." value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit">搜索</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>留言ID</th>
                    <th>标题</th>
                    <th>内容</th>
                    <th>用户名</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td>
                                <!-- 点击内容链接查看完整内容 -->
                                <a href="view_message.php?id=<?php echo $row['id']; ?>">
                                    <?php echo mb_substr(htmlspecialchars($row['content']), 0, 20, 'UTF-8') . '...'; ?>
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td class="action-buttons">
                                <button class="delete-button" onclick="confirmDelete(<?php echo $row['id']; ?>)">删除</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">没有找到相关留言。</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        function confirmLogout() {
            if (confirm("确定退出吗？")) {
                window.location.href = "index.html";
            }
        }

        function confirmDelete(id) {
            if (confirm("确定要删除这条留言吗？")) {
                window.location.href = "delete_message.php?id=" + id;
            }
        }
    </script>
</body>
</html>
