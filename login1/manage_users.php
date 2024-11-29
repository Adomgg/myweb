<?php
session_start();
require 'db_connection.php';

// 检查用户是否已登录
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// 获取所有用户信息
$sql = "SELECT id, username FROM user";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户管理</title>
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
        }

        nav h2 {
            margin-bottom: 20px;
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

        .edit-button {
            background-color: #4CAF50;
            color: white;
        }

        .edit-button:hover {
            background-color: #45a049;
        }

        .delete-button {
            background-color: #ff4d4d;
            color: white;
        }

        .delete-button:hover {
            background-color: #e60000;
        }

        form {
            max-width: 500px;
            margin-top: 20px;
        }

        form label {
            display: block;
            margin-bottom: 10px;
            font-size: 1em;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #45a049;
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
        <h1>用户管理</h1>

        <table>
            <thead>
                <tr>
                    <th>用户ID</th>
                    <th>用户名</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td class="action-buttons">
                        <button class="edit-button" onclick="openEditForm(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['username']); ?>')">编辑</button>
                        <button class="delete-button" onclick="confirmDelete(<?php echo $row['id']; ?>)">删除</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <form id="editForm" action="update_user.php" method="POST" style="display: none;">
            <input type="hidden" id="userId" name="id">
            <label for="username">用户名：</label>
            <input type="text" id="username" name="username" required>
            <label for="password">新密码：</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">保存更改</button>
        </form>
    </div>

    <script>
        function confirmLogout() {
            if (confirm("确定退出吗？")) {
                window.location.href = "index.html";
            }
        }

        function confirmDelete(userId) {
            if (confirm("确定要删除该用户吗？")) {
                window.location.href = "delete_user.php?id=" + userId;
            }
        }

        function openEditForm(id, username) {
            document.getElementById('editForm').style.display = 'block';
            document.getElementById('userId').value = id;
            document.getElementById('username').value = username;
        }
    </script>
</body>
</html>
