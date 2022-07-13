<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');


function hd_condition($a,$b){ 
	$condition = "
			where ".$a.".buildingNumber   = ".$b.".buildingNumber 
			and   ".$a.".regionCode_full  = ".$b.".regionCode_full 
			and   ".$a.".exclusiveUseArea = ".$b.".exclusiveUseArea";
	return $condition;
}



$cal_date = isset($_GET['cal_date']) ? $_GET['cal_date'] : Null;
$calMaxdateT = isset($_GET['calMaxdateT']) ? $_GET['calMaxdateT'] : Null;
$calMaxdateC = isset($_GET['calMaxdateC']) ? $_GET['calMaxdateC'] : Null;

$cal_date = $cal_date*30;
$calMaxdateT = $calMaxdateT*365;
$calMaxdateC = $calMaxdateC*365;

$update_invest_master_sql = "
			update admin_setting set 
				cal_date	= '".$cal_date."',
				calMaxdateT	= '".$calMaxdateT."',
				calMaxdateC	= '".$calMaxdateC."'
";


$update_invest_master_res = mysqli_query($real_sock,$update_invest_master_sql);


$table_name = array('apt','op','bil','do');

for($i = 0 ; $i < count($table_name);$i++){
	if($table_name[$i]=='bil'){
		$table_type = "tenementhouse";
		$type = $table_name[$i];
	}
	else{
		$table_type = $table_name[$i];
		$type = $table_name[$i];	
	}
	$condition = hd_condition('b','a');
	$update_invest_master_sql = "
		update invest_master as a set 
			a.maxDealtradedate		= (select b.DealfullDate from rawdata_trade_".$table_type." as b  ".$condition."  order by b.DealfullDate DESC Limit 1 ),
			a.maxDealcharterdate	= (select b.DealfullDate from rawdata_charter_".$table_type."   as b  ".$condition."  and Monthlyrent=0 order by b.DealfullDate DESC Limit 1 )
			

		where a.finderType = '".$type."'
	";

	
	$update_invest_master_res = mysqli_query($real_sock,$update_invest_master_sql);


}


$update_invest_master_sql = "
	update invest_master set 
		LastCalDate = GREATEST(ifnull(maxDealtradedate,'1900-01-01'),ifnull(maxDealcharterdate,'1900-01-01')) ,
		StartCalDate = if(LastCalDate='1900-01-01','1900-01-01',date_add(LastCalDate,INTERVAL - ".$cal_date." DAY))
";

$update_invest_master_res = mysqli_query($real_sock,$update_invest_master_sql);

$update_invest_master_sql = "
	update invest_master set 
		tempCheck=1
	where LastCalDate !='1900-01-01'";

$update_invest_master_res = mysqli_query($real_sock,$update_invest_master_sql);



?> <p> <p> <p>
해당 페이지에서 작업 <p>
1. 마지막 거래 일자 확인<br>
2. 월세 거래 일자는 확인 하지 않음.<br>

<br><p><br>
다음 버튼 클릭 해서 다음 작업 진행해야 함. 
<br><p><br>

<a href = '/BDP_ADMIN/cal_api_0/step4_cal_makemoolgun_proc_1.php' >통계내기</a>