<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');

$selestadmin_setting_sql = "select  cal_date,calMaxdateT,calMaxdateC from admin_setting ";

$selestadmin_setting__res = mysqli_query($real_sock,$selestadmin_setting_sql);
$selestadmin_setting_info = mysqli_fetch_array($selestadmin_setting__res);
$calMaxdateT = $selestadmin_setting_info['calMaxdateT'];
$calMaxdateC = $selestadmin_setting_info['calMaxdateC'];




//0은 매매
function hd_qq($qq,$type,$num,$calMaxdateT,$calMaxdateC){
	if($num==0){
		$tt ="(
				select  ".$qq." FROM rawdata_trade_".$type."
					WHERE exclusiveUseArea = a.exclusiveUseArea	AND regionCode_full = a.regionCode_full
					AND buildingNumber = a.buildingNumber
					AND DealfullDate >= date_add(NOW(), INTERVAL - ".$calMaxdateT." day) 
					order by TransactionAmount DESC

					Limit 1
				)";
	}
	else{
			$tt ="(
				select  ".$qq." FROM rawdata_charter_".$type."
					WHERE exclusiveUseArea = a.exclusiveUseArea	AND regionCode_full = a.regionCode_full
													AND buildingNumber = a.buildingNumber
													AND DealfullDate >= date_add(NOW(), INTERVAL - ".$calMaxdateC." day) 
													AND Monthlyrent = 0

										order by deposit	DESC
					Limit 1
				)";
	}
	return $tt;
}

$type = 'op';
$update_charter_sql = "update invest_master as a set
					a.maxdealcharter		=".hd_qq('deposit',$type,1,$calMaxdateT,$calMaxdateC).",
					a.Maxdealcharterfloor	=".hd_qq('buildingfloor',$type,1,$calMaxdateT,$calMaxdateC)."
			where a.finderType='".$type."'
			and a.maxDealcharterdate >= date_add(NOW(), INTERVAL - ".$calMaxdateC." day) 
			
			";


$update_charter_res = mysqli_query($real_sock,$update_charter_sql);
$update_trade_sql = "update invest_master as a set
					a.Maxdealtrade			=".hd_qq('TransactionAmount',$type,0,$calMaxdateT,$calMaxdateC).",
					a.Maxdealteagefloor		=".hd_qq('buildingfloor',$type,0,$calMaxdateT,$calMaxdateC)."
			where a.finderType='".$type."'
			and a.maxDealtradedate >= date_add(NOW(), INTERVAL - ".$calMaxdateT." day) 
			
			";
$update_trade_res = mysqli_query($real_sock,$update_trade_sql);

$type = 'do';
$update_charter_sql = "update invest_master as a set
					a.maxdealcharter		=".hd_qq('deposit',$type,1,$calMaxdateT,$calMaxdateC).",
					a.Maxdealcharterfloor	=".hd_qq('buildingfloor',$type,1,$calMaxdateT,$calMaxdateC)."
			where a.finderType='".$type."'
			and a.maxDealcharterdate >= date_add(NOW(), INTERVAL - ".$calMaxdateC." day) 
			
			";
$update_charter_res = mysqli_query($real_sock,$update_charter_sql);
$update_trade_sql = "update invest_master as a set
					a.Maxdealtrade			=".hd_qq('TransactionAmount',$type,0,$calMaxdateT,$calMaxdateC).",
					a.Maxdealteagefloor		=".hd_qq('buildingfloor',$type,0,$calMaxdateT,$calMaxdateC)."
			where a.finderType='".$type."'
			and a.maxDealtradedate >= date_add(NOW(), INTERVAL - ".$calMaxdateT." day) 
			
			";
$update_trade_res = mysqli_query($real_sock,$update_trade_sql);

$type = 'apt';
$update_charter_sql = "update invest_master as a set
					a.maxdealcharter		=".hd_qq('deposit',$type,1,$calMaxdateT,$calMaxdateC).",
					a.Maxdealcharterfloor	=".hd_qq('buildingfloor',$type,1,$calMaxdateT,$calMaxdateC)."
			where a.finderType='".$type."'
			and a.maxDealcharterdate >= date_add(NOW(), INTERVAL - ".$calMaxdateC." day) 
			
			";
$update_charter_res = mysqli_query($real_sock,$update_charter_sql);
$update_trade_sql = "update invest_master as a set
					a.Maxdealtrade			=".hd_qq('TransactionAmount',$type,0,$calMaxdateT,$calMaxdateC).",
					a.Maxdealteagefloor		=".hd_qq('buildingfloor',$type,0,$calMaxdateT,$calMaxdateC)."
			where a.finderType='".$type."'
			and a.maxDealtradedate >= date_add(NOW(), INTERVAL - ".$calMaxdateT." day) 
			
			";
$update_trade_res = mysqli_query($real_sock,$update_trade_sql);





$type = 'tenementhouse';
$update_charter_sql = "update invest_master as a set
					a.maxdealcharter		=".hd_qq('deposit',$type,1,$calMaxdateT,$calMaxdateC).",
					a.Maxdealcharterfloor	=".hd_qq('buildingfloor',$type,1,$calMaxdateT,$calMaxdateC)."
			where a.finderType='bil'
			and a.maxDealcharterdate >= date_add(NOW(), INTERVAL - ".$calMaxdateC." day) 
			
			";
$update_charter_res = mysqli_query($real_sock,$update_charter_sql);
$update_trade_sql = "update invest_master as a set
					a.Maxdealtrade			=".hd_qq('TransactionAmount',$type,0,$calMaxdateT,$calMaxdateC).",
					a.Maxdealteagefloor		=".hd_qq('buildingfloor',$type,0,$calMaxdateT,$calMaxdateC)."
			where a.finderType='bil'
			and a.maxDealtradedate >= date_add(NOW(), INTERVAL - ".$calMaxdateT." day) 
			
			";
$update_trade_res = mysqli_query($real_sock,$update_trade_sql);



$update_sql = "update invest_master 
			set	investMoneyRange =Null

	;";
	$update_res = mysqli_query($real_sock,$update_sql);



?>



 <p> <p> <p>
해당 페이지에서 작업 <p>
1. 물건의 전세 매매 최고층 최고가 값 구하기 <br>


<br><p><br>
다음 버튼 클릭 해서 다음 작업 진행해야 함. 
<br><p><br>

<a href = '/BDP_ADMIN/cal_api_0/step4_cal_makemoolgun_proc_3.php' >kb매칭 및 실투자금 구간 구하기</a>
