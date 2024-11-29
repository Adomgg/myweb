<?php
$servername = "localhost";
$username1 = "root";
$password1 = "123456";
$database = "liuyanban";

// 创建连接
$conn = mysqli_connect($servername, $username1, $password1, $database);

// //检测连接
// if ($conn->connect_error) {
//     die("连接失败: " . $conn->connect_error);
// }
?>