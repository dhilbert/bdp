<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');
$now =  date("Y-m-d H:i:s");

$idx = isset($_GET['idx'])	 ? $_GET['idx'] : Null;

$sql	 = "delete from admin_notice where idx = ".$idx."";
$res	=  mysqli_query($real_sock,$sql) or die(mysqli_error($real_sock));

	echo "<script>
		alert('삭제 완료');
		parent.location.replace('/BDP_ADMIN/admin_maintain/notice_maintain.php');
	</script> ";





	
?>