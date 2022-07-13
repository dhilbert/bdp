<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');


$col1 = isset($_GET['col1'])	 ? $_GET['col1'] : Null;
$col2 = isset($_GET['col2'])	 ? $_GET['col2'] : Null;
$col3 = isset($_GET['col3'])	 ? $_GET['col3'] : Null;
$sql	 = "update region_code_speculation set color = '".$col1."'	where idx = 1;";
$res	=  mysqli_query($real_sock,$sql) or die(mysqli_error($real_sock));

$sql	 = "update region_code_speculation set color = '".$col2."'	where idx = 2;";
$res	=  mysqli_query($real_sock,$sql) or die(mysqli_error($real_sock));

$sql	 = "update region_code_speculation set color = '".$col3."'	where idx = 3;";
$res	=  mysqli_query($real_sock,$sql) or die(mysqli_error($real_sock));

	echo "<script>
		alert('변경 완료 ');
		parent.location.replace('/BDP_ADMIN/admin_maintain/color_maintain.php');
	</script> ";




/*
if($insert_admin_id == Null or $insert_admin_name==Null){
	echo "<script>
		alert('이름과 아이디를 입력해야 합니다..');
		parent.location.replace('/BDP_ADMIN/admin_member/admin_member.php');
	</script> ";
}
else{
	$sql	 = "insert admin_member set 
					admin_id    = '".$insert_admin_id."'	,
					admin_pw    = '".md5(1234)."'	,
					admin_name  = '".$insert_admin_name."'	,
					admin_lv	= 5	,
					state = 1;";
echo 	$sql;
	$res	=  mysqli_query($real_sock,$sql) or die(mysqli_error($real_sock));

	echo "<script>
		alert('추가 되었습니다.');
		parent.location.replace('/BDP_ADMIN/admin_member/admin_member.php');
	</script> ";

}

*/
?>