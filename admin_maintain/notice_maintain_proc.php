<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');
$now =  date("Y-m-d H:i:s");

$title = isset($_GET['title'])	 ? $_GET['title'] : Null;
$text = isset($_GET['text']) ? $_GET['text'] : Null;

if($text == Null or $title == null){

	echo "<script>
		alert('처리 내역을 입력하세요 ');
		parent.location.replace('/BDP_ADMIN/admin_maintain/notice_maintain.php');
	</script> ";
}


else{

	$sql	 = "insert admin_notice set 
					title    = '".$title."'	,
					texts     = '".nl2br($text)."'	,
					regDate  = '".$now."',
					reguser = '".$admin_name."'
					";;


	$res	=  mysqli_query($real_sock,$sql);

	echo "<script>
		alert('처리 되었습니다. ');
		parent.location.replace('/BDP_ADMIN/admin_maintain/notice_maintain.php');
	</script> ";



}





?>