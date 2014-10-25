<?php

//包含数据库连接文件
include('connect.php');
//检测用户名及密码是否正确

$query="select * from user where username='$_POST[username]'and password='$_POST[password]'";
$result=mysql_query($query);
$row=mysql_fetch_array($result);
$user_id=$result['user_id'];
if($row){
    //登录成功
	session_start(); 
    //  注册登陆成功的 admin 变量，并赋值 true 
    $_SESSION["admin"] = true;  
    $_SESSION['username'] = $username;
		//增加了session里user_id，但是前端注册表格数据表中对应user_id 是否已经更改
	$_SESSION['user_id'] = $user_id;
    echo ' 信软实验室欢迎您！点击进入 <a href="//localhost:801/book_lab/mysubscribe/mysubscribe.php">用户中心</a><br />';
    exit;
} else {
    exit('登录失败！点击此处 <a href="login.htm">返回</a> 重试');
}
?>
