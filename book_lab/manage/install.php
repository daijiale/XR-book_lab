<?php //导入数据库连接文件 
include 'connect.php';
 //自动安装数据库表 
 $query="create table user (
   username  varchar(32)CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
   realname  varchar(32)CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
   jobnumber   varchar(32),
   onecard   varchar(32),
   identity  varchar(32),
   sex       varchar(32),
   idgroup     varchar(32),
   email      varchar(64), 
   tel        varchar(32),
   password varchar(32), 
   token varchar(20), 
   token_exptime int(32),
   status   tinyint(10),
   SignUpdate int(32),
   UserLevel tinyint,  
   LastLogin varchar(32), 
   LastLoginFail varchar(32), 
   NumLoginFail tinyint )"; 
   $result=mysql_query($query); 
   if($result==1) 
   {  
   	echo "signup table succesfully created.<br>"; 
   } 
   else {  
   	echo "Error while creating table(ErrorNumber".mysql_errno().":\"".mysql_error()."\")<br>";
   	 } 
?>
   	 
	 