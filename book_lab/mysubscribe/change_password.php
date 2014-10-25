
<?php
/*session_start();
$_SESSION["admin"] = true;  
$_SESSION['username'] = "abc";
仅调试使用
*/
include("../pub/login session.php");
?>

<!DOCTYPE html>
	
	<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<meta name="google-site-verification" content="1VztQCrdTIxI_mBy2KSfKFXNLDuS5pmAjyii4uOTQ_g" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="http://222.197.181.3:8080/img/logo.png" rel="icon" type="image/png"/>
		<link href="/book_lab/_static/getsentry/styles/global.min.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="/book_lab/pub/buttons/buttons.css" />
		<title>信软实验室预定</title>
		
		<script type="text/javascript" src="/book_lab/headfoot/jquery.js"></script>
		<script type="text/javascript" src="/book_lab/headfoot/clientSideInclude.js"></script>
	</head>
	
	<body onLoad="clientSideInclude('includefooter','/book_lab/headfoot/footer.htm');clientSideInclude('includeheader', '/book_lab/headfoot/header.htm')">
		<span id="includeheader"></span>
		<section id="content">
			<div class="container register">
				<div class="row">
					<div class="span8 primary">
						<h1>修改密码</h1>
						<fieldset>
						<form action="change_passworddeal.php" method="post" class="form-horizontal" name="changepassword" onsubmit="return CheckPost();">
							<!--<input type='hidden' name='username' value="$_SESSION['username']" />调试时使用-->
							<div class="control-group">
			  					<label for="OldPassword">原始密码</label>
			  					<div class="controls">
									<input id="OldPassword" name="OldPassword" type="password" />
								</div>
							</div>
							<div class="control-group">
			 	 				<label for="NewPassword">新密码</label>
			  					<div class="controls">
									<input id="NewPassword" name="NewPassword" type="password" />
								</div>
							</div>
							<div class="control-group">
			  					<label for="NewPasswordAgain">确认密码</label>
			  					<div class="controls">
									<input id="NewPasswordAgain" name="NewPasswordAgain" type="password" />
								</div>
							</div>
	
							<button id="submit" type="submit" class="button big blue">提交</button>
						</form>
						</fieldset>
	  				</div>
	  			</div>
	  		</div>
		</section>
		<span id="includefooter"></span>
	</body>
</html>
