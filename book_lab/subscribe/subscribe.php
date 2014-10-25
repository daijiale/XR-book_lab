<?php
// ------------------------------------------------------------------------

/**
 * 预定操作页面
 *
 * 接收用户的预定请求
 *
 * @作者			胡可奇
 * @时间			2013-11-16
 */

// ------------------------------------------------------------------------
//加载数据库类
include 'mysql_class.php';
//判断是否登录
include("../pub/login session.php");



$isMeeting = false;


if(isset($_POST["isMeeting"]))
{
	$isMeeting = true;
}
//检测参数是否完整
if(!isset($_POST["labName"]) || !isset($_POST["startTime"]) || !isset($_POST["labNumber"])
		|| !isset($_POST["endTime"]) || !isset($_POST["date"]) || !isset($_POST["user"])
		|| !isset($_POST["labType"]) || !isset($_POST["labBuilding"]))
{
	echo "no";
	exit(0);
}



//获得实验室信息
require_once 'lab_config.php';
if(!isset($labTypeArr[$_POST["labType"]]) || !isset($labBuildingArr[$_POST["labBuilding"]]))
{
	echo "no";
	exit(0);
}
//echo "no";
//exit(0);



$labType = $labTypeArr[$_POST["labType"]];
$labBuilding = $labBuildingArr[$_POST["labBuilding"]];


if(!dateCheck($_POST["date"]))
{
	echo "no";
	exit(0);
}
//过滤参数，防注入
if(($labName = mysql_real_escape_string($_POST["labName"])) === false || 
	($startTime = mysql_real_escape_string($_POST["startTime"])) === false ||
	($endTime = mysql_real_escape_string($_POST["endTime"])) === false ||
	($date = mysql_real_escape_string($_POST["date"])) === false ||
	($comment = isset($_POST["comment"]) ? mysql_real_escape_string($_POST["comment"]) : "") === false ||
	($labNumber = mysql_real_escape_string($_POST["labNumber"])) === false
	||($user = mysql_real_escape_string($_POST["user"])) === false)
{
	echo "no";
	exit(0);
}

require_once 'lab_config.php';
//查找实验室ID
$ret = $db->select("lab_info", "id", "name=\"$labName\" AND building=\"$labBuilding\" AND type=\"$labType\"");
if($db->num_rows($ret) == 0)
{
	echo "no";
	exit(0);
}
$labInfo = $db->fetch_row($ret);

//锁定预定信息表
for($i = 0; $i < 3; $i++)
{
	if($db->lockTable("lab_subscribe"))
		break;
}
//尝试3次不成功则退出
if($i == 3)
{
	echo "no";
	exit(0);
}

$startTimeStr = getTimeStr(intval($startTime));
$endTimeStr = getTimeStr(intval($endTime));
if($db->num_rows($db->select("lab_subscribe", "*", "date=\"$date\" AND lab_id=$labInfo[0] AND start_time=$startTimeStr")) != 0)
{
	echo "no";
	$db->unlockTable();
	exit(0);
}

if(!$db->insert("lab_subscribe", "lab_id, user_id, number, date, start_time, end_time, commands, status",
	 "$labInfo[0], $user, $labNumber, \"$date\", \"$startTimeStr\", \"$endTimeStr\", \"$comment\", 0"))
{
	echo "no";
	$db->unlockTable();
	exit(0);
}
$db->unlockTable();
include 'reserve_function.php';

if($isMeeting)
{
	$tableInfo = getMeetingTableInfo($db, $date);
}
else
{
	$tableInfo = getTableInfo($db, $date, $labType, $labBuilding);
}
createTable($tableInfo[0], $tableInfo[1], $date, $isMeeting);




//辅助函数
function getTimeStr($time)
{
	$str = floor($time).(floor($time) < $time ? ":30" : ":00").":00";
	return $str;
}


function dateCheck($date)
{
	if(!preg_match("/[0-9]+-[0-9]+-[0-9]+/", $date))
	{
		return false;
	}
	$items = explode("-", $date);
	foreach ($items as $item)
	{
		$nums[] = intval($item, 10);
	}
	//调用系统函数checkdate（月，日，年）检查时间
	return checkdate($nums[1], $nums[2], $nums[0]);
}