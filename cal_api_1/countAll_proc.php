<?php

include_once('../lib/dbcon_bdp.php');



$invest_master_sql = "SELECT count(*) as cnt
							FROM region_code";
$invest_master_res = mysqli_query($real_sock,$invest_master_sql);
$invest_master_info = mysqli_fetch_array($invest_master_res);
$cnt1 = $invest_master_info['cnt'];

$invest_master_sql = "SELECT sum(printCheck) as cnt
							FROM invest_master";
$invest_master_res = mysqli_query($real_sock,$invest_master_sql);
$invest_master_info = mysqli_fetch_array($invest_master_res);
$cnt2 = $invest_master_info['cnt'];


$invest_master_sql = "SELECT count(*) as cnt
							FROM search_region_history";
$invest_master_res = mysqli_query($real_sock,$invest_master_sql);
$invest_master_info = mysqli_fetch_array($invest_master_res);
$cnt3 = $invest_master_info['cnt'];


$update_sql = "update loading_mypage set 
				totalRegion = '".$cnt1."',
				totalinvest = '".$cnt2."',
				totalSearch = '".$cnt3."'
				";
$update_res = mysqli_query($real_sock,$update_sql);


echo "<script>
			alert('계산 완료 ');
			parent.location.replace('/BDP_ADMIN/cal_api_1/community_main.php');
</script> ";

?>