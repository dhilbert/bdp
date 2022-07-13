<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');

$updateDate  = date("Y-m-d H:i:s");




$selestadmin_setting_sql = "select imjang_state from admin_setting ";
$selestadmin_setting__res = mysqli_query($real_sock,$selestadmin_setting_sql);
$selestadmin_setting_info = mysqli_fetch_array($selestadmin_setting__res);
$imjang_state = $selestadmin_setting_info['imjang_state'];



$member_invest_range_sql = " select * from member_invest_range ";
$member_invest_range_res = mysqli_query($real_sock,$member_invest_range_sql);
while($member_invest_range_info = mysqli_fetch_array($member_invest_range_res)){	

	//동부터 	
	$region_code_iconcount_sql = "
			insert region_code_iconcount(regionCode_full,member_invest_range_idx,rangemin,rangemax,countIcon)
			select a.regionCode_full,'".$member_invest_range_info['id']."','".$member_invest_range_info['rangemin']."','".$member_invest_range_info['rangemax']."',
			(select sum(printCheck) from invest_master where regionCode_full = a.regionCode_full and investPrice <= ".$member_invest_range_info['rangemax']." )
			from region_code as a
			where a.regionCode_full-floor(a.regionCode_full/100000)*100000>0 and a.maplv1 + a.maplv2 + a.maplv3 + a.maplv4 >0";
			

	$region_code_iconcount_res = mysqli_query($real_sock,$region_code_iconcount_sql);

	//읍/면
	$region_code_iconcount_sql = "
			insert region_code_iconcount(regionCode_full,member_invest_range_idx,rangemin,rangemax,countIcon)
			select a.regionCode_full,'".$member_invest_range_info['id']."','".$member_invest_range_info['rangemin']."','".$member_invest_range_info['rangemax']."',
			(select sum(printCheck) from invest_master where myuncheck = a.myuncheck and investPrice <= ".$member_invest_range_info['rangemax']." )
			from region_code as a
			where (a.regionName LIKE '%면' or a.regionName LIKE '%읍') and  a.maplv1 + a.maplv2 + a.maplv3 + a.maplv4 >0";



	$region_code_iconcount_res = mysqli_query($real_sock,$region_code_iconcount_sql);

	//구
	$region_code_iconcount_sql = "
			insert region_code_iconcount(regionCode_full,member_invest_range_idx,rangemin,rangemax,countIcon)
			select a.regionCode_full,'".$member_invest_range_info['id']."','".$member_invest_range_info['rangemin']."','".$member_invest_range_info['rangemax']."',
			(select sum(printCheck) from invest_master where areaCode = a.areaCode and investPrice <= ".$member_invest_range_info['rangemax']." )
			from region_code as a
			 where a.regionCode_full/100000 = a.areaCode AND a.areaCode != a.stateAreaCode and  a.maplv1 + a.maplv2 + a.maplv3 + a.maplv4 >0";	

	$region_code_iconcount_res = mysqli_query($real_sock,$region_code_iconcount_sql);

	//작은시
	$region_code_iconcount_sql = "
			insert region_code_iconcount(regionCode_full,member_invest_range_idx,rangemin,rangemax,countIcon)
			select a.regionCode_full,'".$member_invest_range_info['id']."','".$member_invest_range_info['rangemin']."','".$member_invest_range_info['rangemax']."',
			(select sum(printCheck) from invest_master where sicheck = a.sicheck and investPrice <= ".$member_invest_range_info['rangemax']." )
			from region_code as a
			 where a.regionName LIKE '%시' AND a.areaCode != a.stateAreaCode and  a.maplv1 + a.maplv2 + a.maplv3 + a.maplv4 >0";
	
	$region_code_iconcount_res = mysqli_query($real_sock,$region_code_iconcount_sql);


//큰시
	$region_code_iconcount_sql = "
			insert region_code_iconcount(regionCode_full,member_invest_range_idx,rangemin,rangemax,countIcon)
			select a.regionCode_full,'".$member_invest_range_info['id']."','".$member_invest_range_info['rangemin']."','".$member_invest_range_info['rangemax']."',
			(select sum(printCheck) from invest_master where stateAreaCode = a.stateAreaCode and investPrice <= ".$member_invest_range_info['rangemax']." )
			from region_code as a
			 where a.areaCode = a.stateAreaCode and a.regionCode_full/100000 = a.stateAreaCode and  a.maplv1 + a.maplv2 + a.maplv3 + a.maplv4 >0";
		
	
	$region_code_iconcount_res = mysqli_query($real_sock,$region_code_iconcount_sql);


}
$DEl_sql = "DELETE FROM region_code_iconcount WHERE countIcon = 0 OR countIcon IS null";
$DEl_res = mysqli_query($real_sock,$DEl_sql);




echo "<script>
		alert('지역 통계 완료');
		parent.location.replace('/BDP_ADMIN/cal_api_0/community_main.php');
</script> ";

?>