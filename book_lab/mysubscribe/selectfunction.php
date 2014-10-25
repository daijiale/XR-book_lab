<?php 
				require("../pub/mysql_class.php");
				
				$conn_db = new mysql("localhost","root","","subscribe_lab","utf8");
				$id = $_POST['id'];
				$boolquery = $conn_db->select("lab_subscribe","*","lab_subscribe.id='$id'");
				$lrow =$conn_db->fetch_array($boolquery);
				$status = $lrow[status];//当前该条预订信息的状态
				
				if(isset($_POST['delete']))//判断是否点了名字为delete的按钮			
					{
						
						$sql = "delete from lab_subscribe where lab_subscribe.id='$id'";
						$query = mysql_query($sql);
						if($query){
						echo "<script>alert('退订成功！');location.href='mysubscribe.php';</script>"; 
							}
					}else if(isset($_POST['signin']))//判断是否点了名字为signin的按钮
						{
							
							if($status == 0)
								{
									$query = $conn_db->update("lab_subscribe","status = '1'","id = '$id'");
									if($query)
									{echo "<script>alert('签入成功！');location.href='mysubscribe.php';</script>";}
								}
							else {
								echo "<script>alert('已经签入，不需要重复操作');location.href='mysubscribe.php';</script>";
								 }
							}
						else if(isset($_POST['signout']))//判断是否点了名字为signout的按钮
							{
								
								if($status == 1)
									{
										$query = $conn_db->update("lab_subscribe","status = '2'","id = '$id'");
										if($query)
										{echo "<script>alert('签出成功!');location.href='mysubscribe.php';</script>";}
									}
								else if($status == 0 ){
										echo "<script>alert('尚未签入，请先签入！');location.href='mysubscribe.php';</script>";
								 }
								 else if($status == 2){
										echo "<script>alert('已经签出，不需要重复操作！');location.href='mysubscribe.php';</script>";
								 }
							}

?>