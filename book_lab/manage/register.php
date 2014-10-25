<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<?php //用户注册以后的数据处理文件。需要先检查数据合法性，然后写入数据库 
//获取注册用户提交的数据 

$username1=$_POST["username"];//用户帐号名 
$realname1=$_POST["realname"];//用户姓名 
$jobnumber1=$_POST["jobnumber"];//用户学号
$onecard1=$_POST["onecard"];//用户一卡通帐号
$identity1=$_POST["identity"];//用户身份证号
$sex1=$_POST["sex"];//性别
$idgroup1=$_POST["idgroup"];//用户类型 
$email1=$_POST["email"];//邮箱 
$tel1=$_POST["tel"];//电话
$password1=$_POST["password"];//密码 
$confirmpassword1=$_POST["confirmpassword"];//确认密码
$token = md5($username1.$password1); //md5加密后创建用于激活识别码
$token_exptime = time()+60*60*24;//激活时间设置,过期时间为24小时后
//定义保存激活码变量 
include 'connect.php'; 

//判断用户名函数 

function Check_username($username)//参数为用户注册的用户名 
{  
//用户名三个方面检查  
//是否为空   字符串检测   长度检测  
	$Max_Strlen_username=16;//用户名最大长度  
	$Min_Strlen_username=4;//用户名最短长度
	$usernameChars="/^[A-Za-z0-9_-]/";//字符串检测的正则表达式  
	$usernameGood="用户名检测正确";//定义返回的字符串变量  
    if($username=="")
	{  
      	 $usernameGood="用户名不能为空";   
      	 return $usernameGood; 
     } 
	if(!preg_match("$usernameChars",$username))//正则表达式匹配检查  
	{   
		$usernameGood="用户名字符串检测不正确";   
      	return $usernameGood;  
    } 
	if (strlen($username)<$Min_Strlen_username || strlen($username)>$Max_Strlen_username)  
    {   
		$usernameGood="用户名字长度检测不正确";   
		return $usernameGood;  
    }  
	return $usernameGood; 
}


//判断密码是否合法函数 
function Check_password($password) { 
	//是否为空    字符串检测      长度检测  
	$Max_Strlen_password=16;//密码最大长度  
	$Min_Strlen_password=6;//密码最短长度  
	$passwordChars="/^[A-Za-z0-9_-]/";//密码字符串检测正则表达式  
	$passwordGood="密码检测正确";//定义返回的字符串变量  
	if($password=="") 
	{   
      	$passwordGood="密码不能为空";   
      	return $passwordGood; 
	}  
    if(!preg_match("$passwordChars",$password))  
    {   
		$passwordGood="密码字符串检测不正确，请输入常用字符";  
		return $passwordGood; 
    }
	if(strlen($password)<$Min_Strlen_password || strlen($password)>$Max_Strlen_password) 
	{   
		$passwordGood="密码长度检测不正确，请输入（6-16位）密码";   
		return $passwordGood;  
	}
	return $passwordGood; 
	} 
	
//判断用户学号是否合法函数 
function Check_jobnumber($jobnumber) { 
	//是否为空    字符串检测      长度检测  
	$Max_Strlen_jobnumber=16;//最大长度  
	$Min_Strlen_jobnumber=13;//最短长度  
	$jobnumberChars="/^[A-Za-z0-9_-]/";//字符串检测正则表达式  
	$jobnumberGood="学号检测正确";//定义返回的字符串变量  
	if($jobnumber=="") 
	{   
      	$jobnumberGood="学号不能为空";   
      	return $jobnumber; 
	}  
    if(!preg_match("$jobnumberChars",$jobnumber))  
    {   
		$jobnumberGood="学号字符串检测不正确，请输入常用字符";  
		return $jobnumberGood; 
    }
	if(strlen($jobnumber)<$Min_Strlen_jobnumber || strlen($jobnumber)>$Max_Strlen_jobnumber) 
	{   
		$jobnumberGood="学号长度检测不正确，请输入（13-16位）学号";   
		return $jobnumber;  
	}
	return $jobnumber; 
	} 
	
	
//判断用户一卡通帐号是否合法函数 
function Check_onecard($onecard) { 
	//是否为空    字符串检测      长度检测  
	$Max_Strlen_onecard=16;//最大长度  
	$Min_Strlen_onecard=6;//最短长度  
	$onecardChars="/^[A-Za-z0-9_-]/";//字符串检测正则表达式  
	$onecardGood="一卡通号检测正确";//定义返回的字符串变量  
	if($onecard=="") 
	{   
      	$onecardGood="一卡通号不能为空";   
      	return $onecard; 
	}  
    if(!preg_match("$onecardChars",$onecard))  
    {   
		$onecardGood="一卡通号字符串检测不正确，请输入常用字符";  
		return $onecardGood; 
    }
	if(strlen($onecard)<$Min_Strlen_onecard || strlen($onecard)>$Max_Strlen_onecard) 
	{   
		$onecardGood="一卡通号长度检测不正确，请输入正确位数的一卡通号";   
		return $onecard;  
	}
	return $onecard; 
	} 
	
	
//判断邮箱是否合法函数 				 	 
function Check_email($email) 
	{  
		$emailChars="/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*$/";//正则表达式判断是否是合法邮箱地址  
		$emailGood="邮箱检测正确";  
		if($email=="")  
		{   
			$emailGood="邮箱不能为空";   
			return $emailGood; 
		}
		if(!preg_match("$emailChars",$email))//正则表达式匹配检查  
		{   
			$emailGood="邮箱格式不正确";   
			return $emailGood;  
		}  
		return $emailGood; 
	} 


//判断用户电话号码是否合法函数
/* 
function Check_tel($tel) { 
	//是否为空    字符串检测      长度检测  
	$Max_Strlen_tel=16;//最大长度  
	$Min_Strlen_tel=7;//最短长度  
	$telChars="/^[A-Za-z0-9_-]/";//字符串检测正则表达式  
	$telGood="电话号码检测正确";//定义返回的字符串变量  
	if($tel=="") 
	{   
      	$telGood="电话号码不能为空";   
      	return $tel; 
	}  
    if(!preg_match("$telChars",$tel))  
    {   
		$telGood="电话号码字符串检测不正确，请输入常用字符";  
		return $telGood; 
    }
	if(strlen($tel)<$Min_Strlen_tel || strlen($tel)>$Max_Strlen_tel) 
	{   
		$telGood="电话号码长度检测不正确，请输入正确位数的电话号码";   
		return $tel;  
	}
	return $tel; 
	} 
*/
	
//判断两次密码输入是否一致 
function Check_Confirmpassword($password,$Confirmpassword) 
	{  
		$ConfirmpasswordGood="两次密码输入一致";  
		if($password<>$Confirmpassword) 
		{   
			$ConfirmpasswordGood="两次密码输入不一致";
			return $ConfirmpasswordGood; 
		} 
		else  
			return $ConfirmpasswordGood; 
	}
 

//调用函数，检测用户输入的数据 
$usernameGood=Check_username($username1); 
$passwordGood=Check_password($password1); 
$emailGood=Check_email($email1); 
$jobnumberGood=Check_jobnumber($jobnumber1);
$onecardGood=Check_onecard($onecard1);
//$telGood=Check_tel($tel1);
$ConfirmpasswordGood=Check_Confirmpassword($password1,$confirmpassword1); 
$error=false;//定义变量判断注册数据是否出现错误 
if($usernameGood !="用户名检测正确") 
	{   
		$error=true;//改变error的值表示出现了错误      
		echo $usernameGood;//输出错误信息      
		echo "<br>"; 
	} 
/*
if($jobnumberGood !="学号检测正确") 
	{
		$$error=true;
		echo $jobnumberGood;  
       	echo "<br>";
	}
if($onecardGood !="一卡通号检测正确") 
	{
		$$error=true;
		echo $onecardGood;  
       	echo "<br>";
	}
*/	
/*
if($telGood !="电话号码检测正确") 
	{
		$$error=true;
		echo $telGood;  
       	echo "<br>";
	}
*/

if($passwordGood !="密码检测正确") 
	{
		$$error=true;
		echo $passwordGood;  
       	echo "<br>";
	} 
if($emailGood !="邮箱检测正确") 
	{
		$error=true;  
        echo $emailGood;  
        echo "<br>";
    } 
if ($ConfirmpasswordGood !="两次密码输入一致") 
    {
		$error=true;  
        echo $ConfirmpasswordGood;  
        echo "<br>"; 
    } 
	
//判断数据库中用户名和email是否已经存在 

$query="select * from user where username='$username1' or email='$email1'"; 
$result=mysql_query($query); 
$row=mysql_fetch_array($result); 
if(!empty($row))foreach ($row as $a) 
{
	if ($a["username"]==$username1) 
    {
		$error=true;
		echo "用户名已存在<br>";  
	}  
	if ($a["email"]==$email1) 
   {   
		$error=true;   
		echo "用户邮箱已经注册<br>";  
	} 
} 



//判断教师注册是否符合实情	

if($idgroup1!="student")
{
	mysql_query("set names 'utf8'");
	$query="select * from teacher where teachername='$realname1' and jobnumber='$jobnumber1'"; 
	$result=mysql_query($query,$conn); 
	//echo $result;
	$row=mysql_fetch_array($result); 
	if(empty($row))
	{
		$error=true;   
		echo "教师信息错误！<br>";  
	}
}


//如果数据检测都合法，则将用户资料写进数据库表 
if ($error==false) //$error==false表示没有错误 
   	{    
		$Datetime=date("d-m-y G:i");//获取注册时间，也就是数据写入到用户表的时间 
		mysql_query("set names utf8");
		$query="insert into user (username,realname,jobnumber,onecard,identity,sex,idgroup,email,tel,password,token,token_exptime,status,UserLevel,SignUpdate,LastLogin,LastLoginFail,NumLoginFail) values ('$username1','$realname1','$jobnumber1','$onecard1','$identity1','$sex1','$idgroup1','$email1','$tel1','$password1','$token','$token_exptime','0','1','$Datetime','0','0','0')";  
        $result=mysql_query($query); 
        $to=$email1;//用户注册的邮箱     
        $subject="激活码";     
        $message="感谢您在实验中心注册了新帐号。<br/>请点击链接激活您的帐号。<br/><a href='http://www.daijiale.cn/book_lab/manage/active_go.php?verify=".$token."' target='_blank'>http://www.daijiale.cn/book_lab/manage/active_go.php?verify=".$token."</a><br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。<br/>如果此次激活请求非你本人所发，请忽略本邮件。<br/><p style='text-align:right'>-------- 信软实验中心 敬上</p>";
        $header="From:system@daijiale.cn"."\r\n";//邮件头信息     
        if(mail($to,$subject,$message,$header))//php中mail()函数用来发送邮件，需要更改php.ini文件，最好安装SMTP服务器
		{      
                     	  	//产生链接，链接到激活页面      
			echo('恭喜您,已完成注册第一步,接下来请登陆您的邮箱获取激活链接，来激活帐号，5秒后自动将跳转到主页面。');   
	 
        } 
		echo('系统可能会报出mail的错误，不必担心，是因为在php中mail()函数用来发送邮件，主机需要更改php.ini文件，最好安装SMTP服务器。恭喜注册成功，5秒后将跳转到主页登录。');  
   } //等文件安装到装有SMTP服务器的主机时，就可以删掉这段错误提示
?>
<meta   http-equiv='refresh'content=5;URL='../index.html'>