<?php
$servername = "localhost";
$username = "root";
$password = "123456";
//$database = "liuyanban"
 
// // 创建连接
// $conn = mysqli_connect($servername, $username, $password );
 
// // 检测连接
// if (!$conn) {
//     die("连接失败" . mysqli_connect_error());
// }
// echo "<script> alert('连接成功'); </script>";

// // 创建数据库
// $sql = "CREATE DATABASE test";
// if($conn->query($sql) === TRUE){
//     echo "创建成功";
// } else{
//     echo"创建失败". $conn->error;
// }

// 在数据库test中创建表user
$database = "liuyanban";
$conn = mysqli_connect($servername, $username, $password,$database);
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
$sql = "CREATE TABLE blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    user_id INT NOT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";

     
    if ($conn->query($sql) === TRUE) {
        echo "Table test 创建成功";
    } else {
        echo "创建数据表错误: " . $conn->error;
    }

    // //往user表中插入数据
    // $database = "liuyanban";   // 替换为你的数据库名

    // // 连接数据库
    // $conn = mysqli_connect($servername, $username, $password, $database);
    
    // // 检测连接
    // if (!$conn) {
    //     die("连接失败: " . mysqli_connect_error());
    // }
    
    // // 往user表中插入数据
    // $sql = "INSERT INTO user (username, password) VALUES ('rrr', '7779')";
    // // $sql .= "INSERT INTO user (username, password) VALUES ('ttt', '8889')";
    // // $sql .= "INSERT INTO user (username, password) VALUES ('yyy', '9999')";
    
    // // 执行SQL查询并判断结果
    // if (mysqli_query($conn, $sql)) {
    //     echo "成功添加";
    // } else {
    //     echo "添加失败: " . mysqli_multi_error($conn) . "<br>";
    // }
    
    // // 关闭数据库连接
    // mysqli_close($conn);


    // $servername = "localhost";
    // $username = "root";
    // $password = "123456";
    // $database = "liuyanban";
 
    // // 创建连接
    // $conn = new mysqli($servername, $username, $password, $database);

    // // 检查连接
    // if ($conn->connect_error) {
    //     die("连接失败: " . $conn->connect_error);
    // } 
    // //创建实例
    // $sql = "SELECT username,password FROM user WHERE username = 'aaa'";
    // $result = $conn->query($sql);
    
    // if ($result->num_rows > 0) {
    //     // 输出数据
    //     while($row = $result->fetch_assoc()) {
    //         echo "username: " . $row["username"]. " - password: " . $row["password"].  "<br>";
    //     }
    // } else {
    //     echo "0 结果";
    // }
    // mysqli_close($conn);
?>