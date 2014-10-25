<?php

// ------------------------------------------------------------------------

/**
 * 实验室信息配置
 *
 * 定义实验室名称及楼层和参数的对应关系
 *
 * @作者			胡可奇
 * @时间			2013-11-16
 */

// ------------------------------------------------------------------------
if(!isset($labTypeArr))
{
	$labTypeArr = array(
			"base_lab" 				=> "基础实验室",
			"web_lab" 				=> "网络实验室",
			"informationsafe_lab" 	=> "信息安全实验室",
			"digit_lab" 			=> "数学实验室",
			"meetiong_room"			=> "会议室"
	);
}
if(!isset($labBuildingArr))
{
	$labBuildingArr = array(
			"xinruan_building"		=> "信软学院",
			"third_building"		=> "第三教学楼"
	);
}

if(!isset($meetingRoomType))
{
	$meetingRoomType = "会议室";
}
