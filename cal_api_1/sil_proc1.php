<?php

include_once('../lib/dbcon_bdp.php');

$investAVG = isset($_GET['investAVG'])	 ? $_GET['investAVG'] : Null;


$update_sql = "update loading_member set 
				investAVG = '".$investAVG."'
				";
$update_res = mysqli_query($real_sock,$update_sql);


echo "<script>
			alert('수정 완료 ');
			parent.location.replace('/BDP_ADMIN/cal_api_1/community_main.php');
</script> ";

?>