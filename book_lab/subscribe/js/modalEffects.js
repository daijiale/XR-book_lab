/**
 * modalEffects.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2013, Codrops
 * http://www.codrops.com
 */
//var ModalEffects = (function() {

	function init() {
		var overlay = document.querySelector( '.md-overlay' );
		[].slice.call( document.querySelectorAll( '.md-trigger' ) ).forEach( function( el, i ) {
			var modal = document.querySelector( '#' + el.getAttribute( 'data-modal' ) ),
				close = modal.querySelector( '.md-close' );
		
			function removeModal( hasPerspective ) {
				classie.remove( modal, 'md-show' );

				if( hasPerspective ) {
					classie.remove( document.documentElement, 'md-perspective' );
				}
			}

			function removeModalHandler() {
				removeModal( classie.has( el, 'md-setperspective' ) ); 
			}

			el.addEventListener( 'click', function( ev ) {
				var meeting = parseInt($("#reserveTable").attr("data-meeting"));
				var change = false;
				if(window.lastMeeting != meeting)
					change = true;
				window.lastMeeting = meeting;
				//修改模态对话框
				if(window.lastMeeting != 1)
				{
					//非会议预定
					if(change)
					{
						changeModle(false);
					}
					//获得当前按钮的行号和列号
					var row = parseInt($(this).attr("data-tableRow"));
					var cul = parseInt($(this).attr("data-tableCul"));
					//修改预定窗口的相关值
					$("#id_lab_name").val($("#reserveTable").find("tr").eq(0).children("th").eq(cul + 2).text());
					$("#id_start_class").attr("data-class", row * 2).val("第" + (row * 2 + 1) + "节课");
					$("#id_end_class").val("第" + (row * 2 + 2) + "节课").attr("data-class", row * 2 + 1);
				}
				else
				{
					//会议预定
					if(change)
					{
						changeModle(true);
					}
					$("#id_lab_name").val($("#reserveTable").find("tr").eq(0).children("th").eq(2).text());
					var row = parseInt($(this).attr("data-tableRow"));
					var timeStr = $("#reserveTable").find("tr").eq(row + 1).children("th").eq(1).text();
					var startTime = getTimeDate(timeStr.substr(0, timeStr.indexOf("-") - 1));
					var endTime = getTimeDate(timeStr.substr(timeStr.indexOf("-") + 1));
					window.endTime = endTime;
					var start = $("#id_start_time").empty();
					for(var i = startTime; i < endTime; i += 0.5)
					{
						start.append($("<option value=\"" + i + "\">" + Math.floor(i) +":" 
						+ (Math.floor(i) < i ? "30" : "00") + "</option>"));
					}
					$("#id_start_time").change();
				}

				classie.add( modal, 'md-show' );
				overlay.removeEventListener( 'click', removeModalHandler );
				overlay.addEventListener( 'click', removeModalHandler );

				if( classie.has( el, 'md-setperspective' ) ) {
					setTimeout( function() {
						classie.add( document.documentElement, 'md-perspective' );
					}, 25 );
				}
			});

			close.addEventListener( 'click', function( ev ) {
				ev.stopPropagation();
				removeModalHandler();
			});

		} );

	}
function changeModle(isMeeting)
{
	if(isMeeting)
	{
		$(".class").addClass("hide");
		$(".time").removeClass("hide");
	}
	else
	{
		$(".class").removeClass("hide");
		$(".time").addClass("hide");
	}
}

function getTimeDate(time)
{
	//将时间字符串转换成整数，如：八点半->8.5
	var timeDate = parseInt(time);
	timeDate += parseInt(time.substr(time.indexOf(":") + 1)) == 0 ? 0 : 0.5;
	return timeDate;
}

//})();