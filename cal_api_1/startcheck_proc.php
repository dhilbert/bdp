<?php

include_once('../lib/dbcon_bdp.php');




$minvalue = isset($_GET['minvalue'])	 ? $_GET['minvalue'] : Null;
$maxvalue = isset($_GET['maxvalue'])	 ? $_GET['maxvalue'] : Null;
$updatesss_sql = "update admin_setting set 
	calminvalue  = '".$minvalue."',
	calmaxvalue = '".$maxvalue."'
;";
echo $updatesss_sql;
$updatesss_res = mysqli_query($real_sock,$updatesss_sql);








$invest_master_sql = "SELECT count(*) as cnt1,count(Distinct regionCode_full) as cnt2
							FROM invest_master
							WHERE printCheck = 1
							and investPrice BETWEEN ".$minvalue." and ".$maxvalue.";";
$invest_master_res = mysqli_query($real_sock,$invest_master_sql);
$invest_master_info = mysqli_fetch_array($invest_master_res);


$updatesss_sql = "update loading_member set 
	regionCount  = '".$invest_master_info['cnt2']."',
	inverstCount = '".$invest_master_info['cnt1']."'
;";
$updatesss_res = mysqli_query($real_sock,$updatesss_sql);


echo "<script>
			alert('계산 완료 ');
			parent.location.replace('/BDP_ADMIN/cal_api_1/community_main.php');
</script> ";

?>