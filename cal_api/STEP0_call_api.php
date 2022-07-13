<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');




// 데이터 많은 경우 끊어서 넣기
$value_count = 50;
$key_num = isset($_GET['key_num'])	 ? $_GET['key_num'] : Null;
$DEAL_YMD = isset($_GET['DEAL_YMD']) ? $_GET['DEAL_YMD'] : Null;
$today_time = date("Y-m-d H:i:s");
$sqlss = "	
	insert admin_apidata set 
		adminmember_idx = '".$admin_idx."',
		startDate		= '".$today_time."',
		DEAL_YMD		='".$DEAL_YMD."',
		serviceKey		= '".$key_num."'
	";
$resss = mysqli_query($real_sock,$sqlss);




// 해당 월의 데이터 지우고 시작
$DealMonth = $DEAL_YMD - floor($DEAL_YMD/100)*100;
$DealYear  = floor($DEAL_YMD/100);
$table_name = array('rawdata_charter_multifamilyhouse','rawdata_charter_op','rawdata_charter_tenementhouse','rawdata_trade_apt','rawdata_trade_multifamilyhouse',
					'rawdata_trade_op','rawdata_trade_tenementhouse','rawdata_charter_apt');


for($i = 0 ; $i< count($table_name) ; $i++){
		$sqlss = "	DELETE FROM ".$table_name[$i]." WHERE DealMonth ='".$DealMonth."' AND DealYear = '".$DealYear."';";
		$resss = mysqli_query($real_sock,$sqlss);
}



$admin_servicekey_sql = "select * from admin_servicekey where idx = '".$key_num ."' ";

$admin_servicekey_res = mysqli_query($real_sock,$admin_servicekey_sql);
$admin_servicekey_info = mysqli_fetch_array($admin_servicekey_res);
$serviceKey = $admin_servicekey_info['servicekey'];


$sqlss = "	select * from region_code as a
	where a.regionCode_full-floor(a.regionCode_full/100000)*100000 = 0 and a.regionCode_full-floor(a.regionCode_full/100000000)*100000000 != 0 and state = 'Y'
	";
$resss = mysqli_query($real_sock,$sqlss);
while($infoss = mysqli_fetch_array($resss)){
	$LAWD_CD	=$infoss['areaCode'];
	include('STEP0_call_api_ft.php');
}



$sqlss = "	
	select idx from  admin_apidata 
order by idx DESC Limit 1";
$resss = mysqli_query($real_sock,$sqlss);
$info = mysqli_fetch_array($resss);
$idx =$info['idx'];
$updateDate = date("Y-m-d H:i:s");

$sqlss = "	
	update admin_apidata set 
		updateDate		= '".$updateDate."'
		where idx = '".$idx."'
	";


$resss = mysqli_query($real_sock,$sqlss);


echo "<script>
		alert('물건 받기 끝');
		parent.location.replace('/BDP_ADMIN/cal_api/community_main.php');
</script> ";







?>