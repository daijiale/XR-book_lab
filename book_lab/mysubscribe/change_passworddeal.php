<?php
	
	require_once("../pub/mysql_class.php");
	session_start();
	if($_SESSION["admin"])
	{
		$userid = $_SESSION['user_id'];
	}
	else
	{
		include("login session.php");
	}

    $OldPassword = $_POST["OldPassword"];
    $NewPassword = $_POST["NewPassword"];
    $NewPasswordAgain = $_POST["NewPasswordAgain"];

	if($OldPassword == "" || $NewPassword == "" || $NewPassword == "" )
	{
		echo "<script>alert('信息输入不完全！');location.href='change_password.php';</script>";
	}
	else
	{
	
		if( $NewPasswordAgain!=$NewPassword)
		{
			echo "<script>alert('新密码两次输入不一致！请检查！');location.href='change_password.php';</script>";
		}
		else
		{   
			$conn_db = new mysql("localhost","root","","subscribe_lab","utf8");
			$query = $conn_db->select("user", "*", "user_id = '$userid' and password = '$OldPassword'");
			if(empty($query))
			{
				echo "<script>alert('原密码输入错误！');location.href='change_password.php';</script>";	
			}
			else 
				$row = $conn_db->fetch_array($query);
        
			if($row)
			{
				$conn_db->update("user","Password = '$NewPassword' "," user_id = '$userid' and password = '$OldPassword'");
				echo "<script>alert('密码修改成功！');location.href='mysubscribe.php';</script>";	
			}
			else
			{
				echo "<script>alert('原密码输入错误！');location.href='change_password.php';</script>";	
			}
		} 
	}   //end else
?>