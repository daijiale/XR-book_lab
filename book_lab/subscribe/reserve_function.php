<?php
// ------------------------------------------------------------------------

/**
 * reserve页面中的函数
 *
 *
 * @作者			胡可奇
 * @时间			2013-11-16
 */

// ------------------------------------------------------------------------


if(!function_exists('createTable'))
{
	//isMeeting变量表示是否是会议室数据
	function createTable($nameList, $table, $date, $isMeeting)
	{
		echo "<table data-meeting=\"$isMeeting\" data-date=\"$date\" id=\"reserveTable\"  class=\"table table-bordered\">\n";
		echo "<tr><th>日期/星期</th><th>时间</th>";
		foreach ($nameList as $name)
		{
			if($name)
				echo "<th>$name[1]</th>";
		}
		echo "</tr>\n";
		
		//初始化时间
		$items = explode("-", $date);
		foreach ($items as $item)
		{
			$times[] = intval($item, 10);
		}
		$time = mktime(0, 0, 0, $times[1], $times[2], $times[0]);
		
		$weekarray = array("日","一","二","三","四","五","六");
		$weekDay = "星期".$weekarray[date("w", $time)];
		$currentDay = date("n", $time)."月".date("j", $time)."日"."($weekDay)";
		//生成表格主体
		if(!$isMeeting)
		{
			for($i = 0; $i < 5; $i++)
			{
				$currentCou = 0;//记录当前列数
				echo "<tr><th>$currentDay</th><th>".(($i + 1) * 2 - 1)."-".(($i + 1) * 2)."节</th>";
				foreach ($table[$i] as $reserveList)
				{
					echo $reserveList? "<th>已预订</th>" : 
					"<th><button data-tableRow=\"$i\" data-tableCul=\"".$currentCou++."\" data-modal=\"modal-15\" class=\"md-trigger button medium blue\">预定</button></th>";
				}
				echo "</tr>\n";
			}
		}
		else 
		{
			$subTimeZ = ":00";
			$subTimeT = ":30";
			$i = 0;
			$lastEndTime = 8.0;
			$currentEndTime = 8.0;
			$strTime = "";
			foreach ($table as $reserveList)
			{	
				if($reserveList)
				{
					//半点用.5表示，如：八点半为8.5
					$currentStartTime = intval(substr($reserveList[0], 0, 2));
					$currentStartTime += intval(substr($reserveList[0], 3, 1)) == 0 ? 0 : 0.5;
					$currentEndTime = intval(substr($reserveList[1], 0, 2));
					$currentEndTime += intval(substr($reserveList[1], 3, 1)) == 0 ? 0 : 0.5;
					if($currentStartTime > $lastEndTime)
					{
						echo "<tr><th>$currentDay</th>";
						$strTime = getTimeStr($lastEndTime);
						echo "<th>".floor($lastEndTime).(floor($lastEndTime) < $lastEndTime ? $subTimeT : $subTimeZ)."-".floor($currentStartTime).(floor($currentStartTime) < $currentStartTime ? $subTimeT : $subTimeZ)."</th>";
						echo "<th><button data-tableRow=\"$i\" data-modal=\"modal-15\" class=\"md-trigger button medium blue\">预定</button></th>";
						echo "</tr>\n";
						$i++;
					}
					echo "<tr><th>$currentDay</th>";
					echo "<th>".floor($currentStartTime).(floor($currentStartTime) < $currentStartTime ? $subTimeT : $subTimeZ)."-".floor($currentEndTime).(floor($currentEndTime) < $currentEndTime ? $subTimeT : $subTimeZ)."</th>";
					echo "<th>已预订</th></tr>\n";
				//	echo "<tr><th>$currentDay</th>";
				//	echo "<th>".$currentStartTime.$subTime."-".$currentEndTime.$subTime."</th>";
				//	echo "<th>已预订</th></tr>\n";
				}
				else 
				{
					if($lastEndTime != 22.0)
					{
						echo "<tr><th>$currentDay</th>";
						echo "<th>".floor($lastEndTime).(floor($lastEndTime) < $lastEndTime ? $subTimeT : $subTimeZ)."-22:00</th>";
						echo "<th><button data-tableRow=\"$i\" data-modal=\"modal-15\" class=\"md-trigger button medium blue\">预定</button></th>";
						echo "</tr>\n";
					}
				}
				$i++;
				$lastEndTime = $currentEndTime;
			}
		}
		echo "</table>\n";
	}
	
}


if(!function_exists("getTableInfo"))
{
	function &getTableInfo(&$db, $date, $labType, $labBuilding)
	{
		require 'lab_config.php';
		//从数据库中取出查询的实验室名称和ID
		$labName = $db->select("lab_info", "id, name", 
						"building = \"$labBuilding\" AND type = \"$labType\"");
		$nameSize = $db->num_rows($labName);
		if($nameSize == 0)
		{
			$ret = null;
			return $ret;
		}
		while($labNameList[] = $db->fetch_row($labName));
		$sql_WhereTime = "date=\"$date\" AND ";
		//查询各个实验室的预定信息，并填入二维数组$table中，0代表未预定，1代表已预订
		for($i = 0; $i < 5; $i++)
		{
			$table[$i] = array_fill(0, $nameSize, 0);
		}
		for($i = 0; $i < $nameSize; $i++)
		{
			$sql_Where = $sql_WhereTime."lab_id=".$labNameList[$i][0];
			$_reserveList = $db->select("lab_subscribe", "start_time, end_time", $sql_Where);
			while($reserveList = $db->fetch_row($_reserveList))
			{
				$startTime = (intval(substr($reserveList[0], 0, 2), 10)) / 2;
				$endTime = (intval(substr($reserveList[1], 0, 2), 10)) / 2;
		
				for(; $startTime < $endTime; $startTime++)
				{
					$table[$startTime][$i] = 1;
				}
			}
		}
		$ret = array($labNameList, $table);
		return $ret;
	}
}


if(!function_exists("getMeetingTableInfo"))
{
	function &getMeetingTableInfo(&$db, $date)
	{
		require 'lab_config.php';
		$meetingRoom = $db->select("lab_info", "id, name", 
				"type = \"$meetingRoomType\"");
		if($meetingRoom == null)
		{
			$ret = null;
			return $ret;
		}
		$meetingRoomInfo[] = $db->fetch_row($meetingRoom);
		
		$reserve = $db->select("lab_subscribe", "start_time, end_time",
			 "lab_id=".$meetingRoomInfo[0][0]." AND date=\"$date\" ORDER BY start_time");
		while($reserveInfo[] = $db->fetch_row($reserve));
		
		$ret = array($meetingRoomInfo, $reserveInfo);
		return $ret;
		
	}
}


if(!function_exists("dateCheck"))
{
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
}


if(!function_exists("getTimeStr"))
{
	function getTimeStr($time)
	{
		//分析时间(整数)构造字符串
		$subTimeZ = ":00";
		$subTimeT = ":30";
		$str = floor($time);
		$str = $str.(floor($time) < $time ? $subTimeT : $subTimeZ);
		$str = $str.$subTimeZ;
		return $str;
	}
}