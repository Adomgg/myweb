<?php
require 'db_connection.php';

// 检查表单是否通过POST方法提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取表单数据
    $username2 = htmlspecialchars($_POST["register-username"]);
    $password2 = htmlspecialchars($_POST["register-password"]);
    $password3 = htmlspecialchars($_POST["Coregister-password"]);
    // 用户名验证：只包含数字或字母
    if (!preg_match("/^.{1,15}$/", $username2)) {
        echo "<script> alert('用户名长度为1到15个字符！'); window.location.href = 'index.html'; </script>";
        exit;
    }
    
    // 密码验证：密码必须包含数字、字母和特殊符号，且至少8个字符
    if (!preg_match("/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[\W_]).{8,}$/", $password2)) {
        echo "<script> alert('密码必须包含字母、数字和特殊字符，并且至少8个字符！'); window.location.href = 'index.html'; </script>";
        exit;
    }
    if (!preg_match("/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[\W_]).{8,}$/", $password3)) {
        echo "<script> alert('确认密码必须包含字母、数字和特殊字符，并且至少8个字符！'); window.location.href = 'index.html'; </script>";
        exit;
    }
    if ($password2 != $password3){
        echo "<script>
        alert('两次输入密码不同！');
        window.location.href = 'index.html';
        </script>";
        exit();
    }

// $sql1 = "SELECT username FROM user WHERE username = '$username2' ";
// $sql = "INSERT INTO user (username, password) VALUES ('$username2', '$Coregister-password3')";
// // $result = $conn->($sql1);

// if(mysqli_query($conn, $sql1)) {
//     echo "<script>
//         alert('用户名已存在！');
//         window.location.href = 'index.html';
//         </script>";
//     exit();
// } elseif (mysqli_query($conn, $sql2)) {
//     echo "<script>
//         alert('注册成功！');
//         window.location.href = 'index.html';
//         </script>";
//     exit();
// } 
$sql1 = "SELECT username FROM user WHERE username = '$username2' ";
$stmt1 = mysqli_prepare($conn, $sql1);
mysqli_stmt_bind_param($stmt1, "s", $username2); // "s" 表示字符串类型
mysqli_stmt_execute($stmt1);
$result1 = mysqli_stmt_get_result($stmt1);

// 如果用户名已存在
if(mysqli_num_rows($result1) > 0) {
    echo "<script>
        alert('用户名已存在！');
        window.location.href = 'index.html';
        </script>";
    exit();
} else {
    // 插入新用户
    $sql = "INSERT INTO user (username, password) VALUES ('$username2', '$password3')";
    $stmt2 = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt2, "ss", $username2, $Co_register_password3); // "ss" 表示两个字符串类型
    if(mysqli_stmt_execute($stmt2)) {
        echo "<script>
            alert('注册成功，请重新登录！');
            window.location.href = 'index.html';
            </script>";
        exit();
    } else {
        echo "<script>
            alert('注册失败，请稍后再试！');
            window.location.href = 'index.html';
            </script>";
        exit();
    }
}

// 关闭准备好的语句
mysqli_stmt_close($stmt);
}
?>