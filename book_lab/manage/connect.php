<?php $server="localhost"; 
$username="root"; 
$password=""; 
$database="subscribe_lab"; 
$timezone="Asia/Shanghai";
if($database=="") 
{  
	$query="use members"; 
	 if(mysql_query($query)==null)  
	 {   
	 	$query="create database subscribe_lab";   
	 	if(mysql_query($query)==1)   
	 	{    //创建数据库成功，开始连接数据库   
	 		 $database="subscribe_lab";    
	 		 $conn=mysql_connect($server,$username,$password)    
	 		 or die("不能连接数据库");    
	 		 mysql_select_db($database,$conn)    
	 		 or die("无法打开数据库");   
	 	}   
	 		 else  {   
	 		 	 echo "Error while creating database (Error".mysql_errno().":\"".mysql_error()."\")<br>";//创建数据库出错   
	 		 	     }  
	 		 	 
	 		 	 }  else  
	 		 	 {   //如果数据库中存在数据库   
	 		 	 	$database="subscribe_lab";   
	 		 	 	$conn=mysql_connect($server,$username,$password)   
	 		 	 	or die("could not connect mysql");   
	 		 	 	mysql_select_db($database,$conn)   
	 		 	 	or die("could not open database");  
	 		 	 	} 
}
 else {  //如果选择的是别的数据库，也就是说$database不为空  
 	$conn=mysql_connect($server,$username,$password)  
 	or die("无法连接数据库");  
 	mysql_select_db($database,$conn)  
 	or die("无法打开数据库"); 
 	} 
	
header("Content-Type: text/html; charset=utf-8");
date_default_timezone_set($timezone); //北京时间
 	?>
 	
 	
