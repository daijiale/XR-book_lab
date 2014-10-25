<?php


// ------------------------------------------------------------------------

/**
 * 预定信息页面
 *
 * 用户查询各个实验室的预定情况
 *
 * @作者			胡可奇
 * @时间			2013-11-16
 */

// ------------------------------------------------------------------------
//加载函数
require 'reserve_function.php';
//加载数据库类
include 'mysql_class.php';
//判断是否登录
include '../pub/login session.php';
$user = $_SESSION["user_id"]; 

//AJAX标志
$onlyTable = false;
//会议室查询标志
$isMeeting = false;

//是否为AJAX
if(isset($_POST["isAjax"]))
{
	$onlyTable = true;
}
//检查时间参数
if(!isset($_POST["时间"]) || !dateCheck($_POST["时间"]))
{
	$currentTime = getdate();
	$date = $currentTime["year"]."-".$currentTime["mon"]."-".$currentTime["mday"];
}
else
{
	$date = $_POST["时间"];
}
require_once 'lab_config.php';
//检查实验室类别参数
if(!isset($_POST["实验室类别"]) || !isset($labTypeArr[$_POST["实验室类别"]]))
{
	$labType = $labTypeArr["base_lab"];
}
else
{
	$labType = $labTypeArr[$_POST["实验室类别"]];
}
//检查实验室区域参数
if(!isset($_POST["实验室区域"]) || !isset($labBuildingArr[$_POST["实验室区域"]]))
{
	$labBuilding = $labBuildingArr["xinruan_building"];
}
else 
{
	$labBuilding = $labBuildingArr[$_POST["实验室区域"]];
}

if($labType == "会议室")
	$isMeeting = true;

if($isMeeting)
{
	$tableInfo = getMeetingTableInfo($db, $date);
}
else
{
	$tableInfo = getTableInfo($db, $date, $labType, $labBuilding);
}


if(is_null($tableInfo))
{
	echo "<p>参数输入错误!</p>";
	exit(0);
}



//加载页面前半部分
if(!$onlyTable)
	include 'reserve_header.html';
	echo("<input type='hidden' id='user_session' value='$user' />");
createTable($tableInfo[0], $tableInfo[1], $date, $isMeeting);
//加载页面后半部分
if(!$onlyTable)
	include 'reserve_footer.html';