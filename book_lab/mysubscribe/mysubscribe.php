<?php 
require("../pub/mysql_class.php");
include("../pub/login session.php");
$userid = $_SESSION[user_id]; //$userid = $_SESSION[user_id];//此行代码用以获取SESSION
?><!--引入数据库操作封装文件-->

<!DOCTYPE html>
<html lang="en">
	<head>
	    
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
        <meta name="google-site-verification" content="1VztQCrdTIxI_mBy2KSfKFXNLDuS5pmAjyii4uOTQ_g" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="http://222.197.181.3:8080/img/logo.png" rel="icon" type="image/png"/>
		<link href="/book_lab/_static/getsentry/styles/global.min.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="/book_lab/pub/buttons/buttons.css" />
		<link href="./lib/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen" />
		<link href="./lib/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen"/>

        <title>信软实验室预定</title>
		
		<script type="text/javascript" src="/book_lab/headfoot/jquery.js"></script>
		<script type="text/javascript" src="/book_lab/headfoot/clientSideInclude.js"></script>
		
	</head>
     
    <body onLoad="clientSideInclude('includefooter', '/book_lab/headfoot/footer.htm');clientSideInclude('includeheader', '/book_lab/headfoot/header.htm')">
		<span id="includeheader"></span>
		<section id="content">                
			<div class="container register">
				<?php
					$conn_db = new mysql("localhost","root","","subscribe_lab","utf8");
					$query = $conn_db->select("lab_subscribe", "*", "lab_subscribe.user_id='$userid'");
					$query_user = $conn_db->select("user", "*", "user.user_id='$userid'");
					$row_user = $conn_db->fetch_array($query_user);
					echo($row_user[jobnumber]);echo("&nbsp");
					echo($row_user[realname]);echo("&nbsp");
					if($row_user[idgroup] == "student")
					{
						echo("同学&nbsp&nbsp你好！！");echo("&nbsp&nbsp");
					}
					else echo("老师&nbsp&nbsp你好！！");echo("&nbsp&nbsp");
					?>
					<a href ="change_password.php" >修改密码</a>
				<div class="row">
					<div class="span10">
					<table class="table table-bordered">
						<?php 
						while($row = $conn_db->fetch_array($query)){
						$lquery =  $conn_db->select("lab_info", "*", "lab_info.id = $row[lab_id]");
						$lrow = $conn_db->fetch_array($lquery);
						?>
						<form name="subscription" action="selectfunction.php" method="post">
                        <input type="hidden" name="id" value="<?php echo($row[id])?>"/>
						<tr>
						<td><?php echo($row[date])?></td>
						<td><?php echo($lrow[building]);echo($lrow[floor]);echo("楼");echo($lrow[name]);?></td>
						<td><?php echo($row[start_time]);echo("－");echo($row[end_time]);?></td>
						<td width="230px">
						<table>
						<tr>
						<td><input type="submit" value="退订" name="delete" class="button blue medium"/></td>
						<td><input type="submit" value="签入" name="signin" class="button blue medium"/></td>
						<td><input type="submit" value="签出" name="signout" class="button blue medium"/></td>
						</tr>
						</table>
						</td>
						</tr>
						</form>
						<?php }?>  
					</table>
				
					</div>	
				</div>
			</div>
		</section>
        <span id="includefooter"></span>    
    </body>
</html>