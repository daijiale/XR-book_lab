<?php
//��ֹSQLע�빥���ļ�
function checkIllegalWord ()
{
    // ���岻�����ύ��SQL����ؼ���
    $words = array();
    $words[]    = " add ";
    $words[]    = " count ";
    $words[]    = " create ";
    $words[]    = " delete ";
    $words[]    = " drop ";
    $words[]    = " from ";
    $words[]    = " grant ";
    $words[]    = " insert ";
    $words[]    = " select ";
    $words[]    = " truncate ";
    $words[]    = " update ";
    $words[]    = " use ";
    $words[]    = "-- ";
   
    // �ж��ύ���������Ƿ�������Ϲؼ���, $_REQUEST�к��������ύ����
    foreach($_REQUEST as $strGot) {
        $strGot = strtolower($strGot); // תΪСд
        foreach($words as $word) {
            if (strstr($strGot, $word)) {
                echo "����������ݺ��зǷ��ַ���";
                exit; // �˳�����
            }
        }
    }// foreach
}
checkIllegalWord(); // �ڱ��ļ�������ʱ���Զ�����
?>
