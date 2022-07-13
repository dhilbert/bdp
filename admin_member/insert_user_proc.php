<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');


$insert_admin_id = isset($_GET['admin_id'])	 ? $_GET['admin_id'] : Null;
$insert_admin_name = isset($_GET['admin_name']) ? $_GET['admin_name'] : Null;

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


?>