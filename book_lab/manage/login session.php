<?php 
//  ��ֹȫ�ֱ�����ɰ�ȫ���� 
$admin = false; 
//  �����Ự���ⲽ�ز����� 
session_start(); 
//  �ж��Ƿ��½ 
if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) { 
    echo "���Ѿ��ɹ���½"; 
} else { 
    //  ��֤ʧ�ܣ��� $_SESSION["admin"] ��Ϊ false
    $_SESSION["admin"] = false; 
    header("refresh:1;url=http://localhost/book_lab/manage/login.htm");
    exit();
} 
?>