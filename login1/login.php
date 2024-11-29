<?php
session_start(); // 启动会话
// $_SESSION['username'] = $name; // 设置会话变量
// $_SESSION['is_logged_in'] = true;  // 设置登录状态
require 'db_connection.php';

// 检查表单是否通过POST方法提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取表单数据
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);

    $_SESSION['username'] = $username; // 设置会话变量
    // $_SESSION['password'] = $password; // 设置会话变量

    // 用户名验证：只包含数字或字母
    if (!preg_match("/^.{1,15}$/", $username)) {
        echo "<script> alert('用户名长度为1到15个字符！'); window.location.href = 'index.html'; </script>";
        exit;
    }
    
    // 密码验证：密码必须包含数字、字母和特殊符号，且至少8个字符
    if (!preg_match("/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[\W_]).{8,}$/", $password)) {
        echo "<script> alert('密码必须包含字母、数字和特殊字符，并且至少8个字符！'); window.location.href = 'index.html'; </script>";
        exit;
    }

    $sql = "SELECT password FROM user where username = '$username' ";
    $result = $conn->query($sql);

    // 如果查询返回结果
    // 如果查询成功并且找到了结果
if ($result && $result->num_rows > 0) {
    $row =$result->fetch_assoc(); // 获取查询结果
    if($password === $row['password']){
        if($username === "admin" && $password === "123456a@"){
            echo "<script>
            alert('欢迎管理员admin！');
            window.location.href = 'admin.html';
            </script>";
            exit();
        }else{
            echo "<script>
            alert('登录成功！');
            window.location.href = 'message-board.html';
            </script>";
            exit();
        }
    } else {
        echo "<script>
        alert('密码错误，请重新登录！');
        window.location.href = 'index.html';
        </script>";
        exit();
    }
    } else {
        // 用户名不存在
        echo "<script>
        alert('用户名不存在，请重新登录！');
        window.location.href = 'index.html';
        </script>";
        exit();
    }

    // 关闭准备好的语句
    mysqli_stmt_close($stmt);
}
?>

