<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');
$now =  date("Y-m-d H:i:s");

$text = isset($_GET['text'])	 ? $_GET['text'] : Null;
$idx = isset($_GET['idx']) ? $_GET['idx'] : Null;
echo $admin_idx;
if($text == Null){

	echo "<script>
		alert('처리 내역을 입력하세요 ');
		parent.location.replace('/BDP_ADMIN/admin_maintain/qa_maintain_detail.php?idx=".$idx."');
	</script> ";
}


else{
	$sql	 = "insert admin_qa_detail set 
					adminmember_idx    = '".$admin_idx."'	,
					text     = '".nl2br($text)."'	,
					regDate  = '".$now."',
					adminqa_idx =  '".$idx."'
					
					";

	$res	=  mysqli_query($real_sock,$sql) or die(mysqli_error($real_sock));
	
	$sql	 = "update admin_qna set 
					state = 1
					where idx  =  '".$idx."'";

	$res	=  mysqli_query($real_sock,$sql) or die(mysqli_error($real_sock));

	
	echo "<script>
		alert('처리 되었습니다. ');
		parent.location.replace('/BDP_ADMIN/admin_maintain/qa_maintain_detail.php?idx=".$idx."');
	</script> ";

}









?>