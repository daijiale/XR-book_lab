// ------------------------------------------------------------------------

/**
 * 预定查询页面JS
 *
 * 页面的动态逻辑
 *
 * @作者			胡可奇
 * @时间			2013-11-16
 */

// ------------------------------------------------------------------------
var xrOptions;
var thirdOptions
$(document).ready(function(e) {
	//初始化时间
	var date = new Date();
	var year = date.getFullYear();
	var mon = date.getMonth();
	var day = date.getDate();
	$( "#datepicker" ).datepicker();
    $("#datepicker").val(year + "-" + (mon + 1) + "-" + day);
	//初始化动态下拉框
	xrOptions = $(".xinruan_building");
	thirdOptions = $(".third_building");
	changeType();
	$("#labBuilding").change(function(){
		changeType();
	});
	//初始化消息响应
	$("#search").click(onSearch);
	$("#submit").click(onSubmit);
	$("#id_start_time").change(onChange);
	$("#errClose").click(function(){
		$("#modal-4").removeClass("md-show");
		$("#close").click();
	});
	//初始化模态对话框的相关变量
	window.lastMeeting = parseInt($("#reserveTable").attr("data-meeting"));
	init();
});

function changeType()
{
	$("#labType").empty();
	switch($("#labBuilding").val())
	{
		case "xinruan_building":
			$("#labType").append(xrOptions);
			break;
		case "third_building":
			$("#labType").append(thirdOptions);
			break;
	}
}
function onSearch()
{
	//$(this).prop({disabled:true});
	$(".loadingBK").addClass("show");
	$.post("reserve.php",
			{
				实验室区域:$("#labBuilding").val(),
				实验室类别:$("#labType").val(),
				时间:$("#datepicker").val(),
				isAjax:1
			},
			function(data, textStatus)
			{
				//alert(data);
				$("#table").empty().append($(data));
				//$("#search").prop({disabled:false});
				init();
				$(".loadingBK").removeClass("show");
			}
	);
}
function onSubmit()
{
	$(".loadingBK").addClass("show");
	var postData;
	var userid=document.getElementById("user_session").value;
	if(window.lastMeeting != 1)
	{
		postData = {
						labName:$("#id_lab_name").val(),
						startTime:$("#id_start_class").attr("data-class"),
						endTime:$("#id_end_class").attr("data-class"),
						date:$("#datepicker").val(),
						user:userid,
						labNumber:75,
						comment:$("#id_comment").val(),
						labType:$("#labType").val(),
						labBuilding:$("#labBuilding").val()
					};
	}
	else
	{
		postData = {
						labName:$("#id_lab_name").val(),
						isMeeting:1,
						startTime:$("#id_start_time").val(),
						endTime:$("#id_end_time").val(),
						date:$("#datepicker").val(),
						user:userid,
						labNumber:75,
						comment:$("#id_comment").val(),
						labType:$("#labType").val(),
						labBuilding:$("#labBuilding").val()
					};
	}
	$.post("subscribe.php", postData,
			function(data, textStatus)
			{
				//alert("hello" + data + "======" + textStatus + "---------");
				$(".loadingBK").removeClass("show");
				if(data == "no")
				{
					//alert("a");
					$("#modal-4").addClass("md-show");
				}
				else
				{
					$("#table").empty().append($(data));
					init();
					$("#close").click();
					
				}
			}
	);
}
function onChange()
{
	var startTime = parseFloat($(this).select().val()) + 0.5;
	$("#id_end_time").empty();
	for(var i = startTime; i <= window.endTime; i += 0.5)
	{
		$("#id_end_time").append($("<option value=\"" + i + "\">" + Math.floor(i) + ":"
							 + (Math.floor(i) < i ? "30" : "00") + "</option>"));
	}
}
