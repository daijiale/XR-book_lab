<?php 
				require("../pub/mysql_class.php");
				
				$conn_db = new mysql("localhost","root","","subscribe_lab","utf8");
				$id = $_POST['id'];
				$boolquery = $conn_db->select("lab_subscribe","*","lab_subscribe.id='$id'");
				$lrow =$conn_db->fetch_array($boolquery);
				$status = $lrow[status];//��ǰ����Ԥ����Ϣ��״̬
				
				if(isset($_POST['delete']))//�ж��Ƿ��������Ϊdelete�İ�ť			
					{
						
						$sql = "delete from lab_subscribe where lab_subscribe.id='$id'";
						$query = mysql_query($sql);
						if($query){
						echo "<script>alert('�˶��ɹ���');location.href='mysubscribe.php';</script>"; 
							}
					}else if(isset($_POST['signin']))//�ж��Ƿ��������Ϊsignin�İ�ť
						{
							
							if($status == 0)
								{
									$query = $conn_db->update("lab_subscribe","status = '1'","id = '$id'");
									if($query)
									{echo "<script>alert('ǩ��ɹ���');location.href='mysubscribe.php';</script>";}
								}
							else {
								echo "<script>alert('�Ѿ�ǩ�룬����Ҫ�ظ�����');location.href='mysubscribe.php';</script>";
								 }
							}
						else if(isset($_POST['signout']))//�ж��Ƿ��������Ϊsignout�İ�ť
							{
								
								if($status == 1)
									{
										$query = $conn_db->update("lab_subscribe","status = '2'","id = '$id'");
										if($query)
										{echo "<script>alert('ǩ���ɹ�!');location.href='mysubscribe.php';</script>";}
									}
								else if($status == 0 ){
										echo "<script>alert('��δǩ�룬����ǩ�룡');location.href='mysubscribe.php';</script>";
								 }
								 else if($status == 2){
										echo "<script>alert('�Ѿ�ǩ��������Ҫ�ظ�������');location.href='mysubscribe.php';</script>";
								 }
							}

?>