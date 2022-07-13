<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');


$kbland_sql = "

update invest_master set
	tempCheck = 0
	WHERE location is null
	";
$kbland_res = mysqli_query($real_sock,$kbland_sql);

$kbland_sql = "

update invest_master set
	tempCheck = 1
	WHERE location is not null
	";
$kbland_res = mysqli_query($real_sock,$kbland_sql);


$updateDate = date("Y-m-d H:i:s");
$now = date("Y-m-d");

function hd_qq($qq,$type){
	$tt ="(select  ".$qq." FROM rawdata_trade_".$type." WHERE buildingNumber=a.buildingNumber	AND regionCode_full=a.regionCode_full 	AND exclusiveUseArea	=a.exclusiveUseArea	AND DealfullDate between a.StartCalDate and a.LastCalDate)";
	return $tt;
}
function hd_qq1($qq,$type){
	$tt ="(select  ".$qq." FROM rawdata_charter_".$type." WHERE buildingNumber=a.buildingNumber	AND regionCode_full=a.regionCode_full 	
	and Monthlyrent = 0
	AND exclusiveUseArea	=a.exclusiveUseArea	AND DealfullDate between a.StartCalDate and a.LastCalDate )";
	return $tt;
}


$kbland_sql = "

update invest_master AS a 
	SET a.dealVolumeforTrade = ".hd_qq('count(*)','tenementhouse').",
a.dealPriceAvg = ".hd_qq('AVG(TransactionAmount)','tenementhouse').",
a.Minrangetrade = ".hd_qq('min(TransactionAmount)','tenementhouse').",
a.Maxrangetrade = ".hd_qq('max(TransactionAmount)','tenementhouse').",
a.unitPriceAvg = ".hd_qq('AVG(TransactionAmount/exclusiveUseArea)','tenementhouse')."
	
	WHERE a.finderType = 'bil'
		and tempCheck !=0
	";



$kbland_res = mysqli_query($real_sock,$kbland_sql);

$kbland_sql = "

update invest_master AS a 
	SET a.dealVolumeforCharter = ".hd_qq1('count(*)','tenementhouse').",
	a.rentPriceAvg = ".hd_qq1('AVG(Deposit)','tenementhouse')."
	
	WHERE a.finderType = 'bil'
		and tempCheck !=0
	";




$kbland_res = mysqli_query($real_sock,$kbland_sql);






$type = 'apt';
$kbland_sql = "

update invest_master AS a 
	SET a.dealVolumeforTrade = ".hd_qq('count(*)',$type).",
a.dealPriceAvg = ".hd_qq('AVG(TransactionAmount)',$type).",
a.Minrangetrade = ".hd_qq('min(TransactionAmount)',$type).",
a.Maxrangetrade = ".hd_qq('max(TransactionAmount)',$type).",
a.unitPriceAvg = ".hd_qq('AVG(TransactionAmount/exclusiveUseArea)',$type)."
	
	WHERE a.finderType = '".$type."'
		and tempCheck !=0
	";

$kbland_res = mysqli_query($real_sock,$kbland_sql);
$kbland_sql = "

	update invest_master AS a 
	SET a.dealVolumeforCharter = ".hd_qq1('count(*)',$type).",
	a.rentPriceAvg = ".hd_qq1('AVG(Deposit)',$type)."
	
	WHERE a.finderType = '".$type."'
		and tempCheck !=0
	";
$kbland_res = mysqli_query($real_sock,$kbland_sql);



$type = 'op';
$kbland_sql = "

update invest_master AS a 
	SET a.dealVolumeforTrade = ".hd_qq('count(*)',$type).",
a.dealPriceAvg = ".hd_qq('AVG(TransactionAmount)',$type).",
a.Minrangetrade = ".hd_qq('min(TransactionAmount)',$type).",
a.Maxrangetrade = ".hd_qq('max(TransactionAmount)',$type).",
a.unitPriceAvg = ".hd_qq('AVG(TransactionAmount/exclusiveUseArea)',$type)."
	
	WHERE a.finderType = '".$type."'
		and tempCheck !=0
	"
	
	;

$kbland_res = mysqli_query($real_sock,$kbland_sql);
$kbland_sql = "

	update invest_master AS a 
	SET a.dealVolumeforCharter = ".hd_qq1('count(*)',$type).",
	a.rentPriceAvg = ".hd_qq1('AVG(Deposit)',$type)."
	
	WHERE a.finderType = '".$type."'
		and tempCheck !=0
	";
$kbland_res = mysqli_query($real_sock,$kbland_sql);









$kbland_sql = "
	update invest_master 
	SET investPrice = dealPriceAvg - rentPriceAvg,
		rentRateTotal = rentPriceAvg/dealPriceAvg*100
	
	where unitPriceAvg>0 and rentPriceAvg > 0
	";
$kbland_res = mysqli_query($real_sock,$kbland_sql);




$kbland_sql = "
	update invest_master 
	SET dealVolume = dealVolumeforTrade+dealVolumeforCharter,
		updateDate = '".$updateDate."'
	";

$kbland_res = mysqli_query($real_sock,$kbland_sql);


?>



 <p> <p> <p>
해당 페이지에서 작업 <p>
1. 물건의 통계 <br>


<br><p><br>
다음 버튼 클릭 해서 다음 작업 진행해야 함. 
<br><p><br>

<a href = '/BDP_ADMIN/cal_api_0/step4_cal_makemoolgun_proc_2.php' >최고가층 확인</a>
