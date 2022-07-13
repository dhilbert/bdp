<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');

$updateDate  = date("Y-m-d H:i:s");


$imjang_state = isset($_GET['imjang_state']) ? $_GET['imjang_state'] : Null;
$imjang_state = $imjang_state*90;

$update_invest_master_sql = "
			update admin_setting set 
				imjang_state	= '".$imjang_state."'
";
$update_invest_master_res = mysqli_query($real_sock,$update_invest_master_sql);

$admin_Setting_sql = "select * from admin_setting";
$admin_Setting_res = mysqli_query($real_sock,$admin_Setting_sql);
$admin_Setting_info = mysqli_fetch_array($admin_Setting_res);

$null_sql = "
			update region_code set 
			unitPriceAvgTotal	=	null,
			unitRentPriceAvgTotal=	null,
			volumeTotal=	null,
			dealVolumeforTrade=	null,
			dealVolumeforCharter=	null,
			dealPriceAvgTotal=	null,
			rentPriceAvgTotal=	null,
			investPriceforbil=	null,
			investPriceforapt=	null,
			rentRateTotal=	null,
			LastdealDate=	null,
			LastdealDateforTrade=	null,
			LastdealDateforChater=	null,
			updateDate=	null,
			iconTotal=	null,
			minInvestpriceforapt=	null,
			minInvestpriceforbil=	null,
			minInvestpriceforop=	null,
			minInvestpricefordo=	null

			
			
			
			;";
$null_res = mysqli_query($real_sock,$null_sql);
?>


 <p> <p> <p>
해당 페이지에서 작업 <p>
1. 지역 통계 초기화 <br>


<br><p><br>
다음 버튼 클릭 해서 다음 작업 진행해야 함. 
<br><p><br>

<a href = '/BDP_ADMIN/cal_api_0/step5_cal_makedong_proc_1.php' >다음</a>
