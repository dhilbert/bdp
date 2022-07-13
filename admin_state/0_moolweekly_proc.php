<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');

function hd_SQL($DealYear,$DealMonth,$cal_values,$limit,$tables,$area,$weeknum){

	$finder_sql = "";
	for($i = 0 ; $i < count($tables) ; $i++){
	$type = explode("_",$tables[$i]);
	$type = $type[2];
			$finder_sql = $finder_sql."
				(
				select 
				 ".$cal_values." AS cal,'".$type."' as trade_tpye ,a.exclusiveUseArea,a.regionCode_full,a.buildingNumber,a.BuildYear,a.buildingName
					  FROM ".$tables[$i]." AS a
				 where a.DealYear = '".$DealYear."'
				and a.DealMonth = '".$DealMonth."'
				and  DATE_FORMAT(CONCAT(a.DealYear,'-',a.DealMonth,'-',a.Dealday), '%U') = '".$weeknum."'
				and a.buildingNumber is not null
				".$area."
				GROUP BY a.exclusiveUseArea,a.regionCode_full,a.buildingNumber
				ORDER BY cal DESC LIMIT ".$limit."
				 ) 
				UNION ";
	}
	$finder_sql=substr($finder_sql, 0, -9);
	$finder_sql = $finder_sql."ORDER BY cal DESC	LIMIT ".$limit.";";
	return $finder_sql;
}



$trade	= array('rawdata_trade_apt','rawdata_trade_op','rawdata_trade_tenementhouse');
$charter=array('rawdata_charter_apt','rawdata_charter_op','rawdata_charter_tenementhouse');
$table_array=array($trade,$charter);




$now_time = date("Y-m-d H:i:s");



$setting_sql = "select * from invest_master_kind_setting where state = 1";
$setting_res = mysqli_query($real_sock,$setting_sql);
while($setting_info = mysqli_fetch_array($setting_res)){
	$statearea = 'and (';
	if($setting_info['state11']==1){$statearea = $statearea."a.stateAreaCode =11000 or  ";}
	if($setting_info['state26']==1){$statearea = $statearea."a.stateAreaCode =26000 or  ";}
	if($setting_info['state27']==1){$statearea = $statearea."a.stateAreaCode =27000 or  ";}
	if($setting_info['state28']==1){$statearea = $statearea."a.stateAreaCode =28000 or  ";}
	if($setting_info['state29']==1){$statearea = $statearea."a.stateAreaCode =29000 or  ";}
	if($setting_info['state30']==1){$statearea = $statearea."a.stateAreaCode =30000 or  ";}
	if($setting_info['state31']==1){$statearea = $statearea."a.stateAreaCode =31000 or  ";}
	if($setting_info['state36110']==1){$statearea = $statearea."a.stateAreaCode =36110 or  ";}
	if($setting_info['state41']==1){$statearea = $statearea."a.stateAreaCode =41000 or  ";}
	if($setting_info['state42']==1){$statearea = $statearea."a.stateAreaCode =42000 or  ";}
	if($setting_info['state43']==1){$statearea = $statearea."a.stateAreaCode =43000 or  ";}
	if($setting_info['state44']==1){$statearea = $statearea."a.stateAreaCode =44000 or  ";}
	if($setting_info['state45']==1){$statearea = $statearea."a.stateAreaCode =45000 or  ";}
	if($setting_info['state46']==1){$statearea = $statearea."a.stateAreaCode =46000 or  ";}
	if($setting_info['state47']==1){$statearea = $statearea."a.stateAreaCode =47000 or  ";}
	if($setting_info['state48']==1){$statearea = $statearea."a.stateAreaCode =48000 or  ";}
	if($setting_info['state50']==1){$statearea = $statearea."a.stateAreaCode =50000 or  ";}
	$statearea=substr($statearea, 0, -4);
	$statearea=$statearea.")";
	
	if($setting_info['tablekind']==0){
		$temp_table_name = 'rawdata_trade_';
	}
	else{
		$temp_table_name = 'rawdata_charter_';	
	}
	
	$table_name = array();
	if($setting_info['apt']==1){array_push($table_name,$temp_table_name."apt");}
	if($setting_info['tenementhouse']==1){array_push($table_name,$temp_table_name."tenementhouse");}
	if($setting_info['op']==1){array_push($table_name,$temp_table_name."op");}


	//통계 시작
	$today_time = date("Y-m-d H:i:s");;
	$beforeDay = date("Y-m-d", strtotime($today_time." -".$setting_info['singo_date']." day")); 
	$beforeDay = explode("-",$beforeDay);
	$beforeDay = $beforeDay[0]*100+$beforeDay[1];
	$endDay = explode("-",$today_time);
	$endDay = $endDay[0]*100+$endDay[1];
	
	
	$check_array=array();
	$checks_array=array();
	for($state_date_i = $beforeDay ; $state_date_i <$endDay +2 ; $state_date_i++ ){
		if($state_date_i== $beforeDay){
			$DealYear = floor($state_date_i/100);
			$DealMonth= $state_date_i-floor($state_date_i/100)*100;
		
			$week1 = date('W',strtotime($DealYear.'-'.$DealMonth.'-01')); 

			array_push($check_array,$state_date_i);
			array_push($checks_array,$week1);
		}
		else{
		$DealYear = floor($state_date_i/100);
		$DealMonth= $state_date_i-floor($state_date_i/100)*100;
		$week1 = date('W',strtotime($DealYear.'-'.$DealMonth.'-01')); 
		for($weeknum=$week1;$weeknum<$week1+5;$weeknum++){
			$del_sql = "
				delete from invest_master_weekly where DealYear = '".$DealYear."'
							and DealMonth = '".$DealMonth."' and kind = ".$setting_info['idx']." and weeknum = '".$weeknum."'";
			$del_res = mysqli_query($real_sock,$del_sql);

			$finder_sql = hd_SQL($DealYear,$DealMonth,$setting_info['qqq'],$setting_info['callimit'],$table_name,$statearea,$weeknum);


			$finder_res = mysqli_query($real_sock,$finder_sql);
			$rank = 1;

			while($finder_info = mysqli_fetch_array($finder_res)){
				$insert_finder_sql = "
					insert invest_master_weekly SET 
						DealYear	= '".$DealYear."',
						DealMonth	= '".$DealMonth."',
						kind		= ".$setting_info['idx'].",
						rank		= '".$rank."',
						finderType		= '".$finder_info['trade_tpye']."',
						StateValue	= '".$finder_info['cal']."',
						weeknum = '".$weeknum."',
						BuildYear	='".$finder_info['BuildYear']."',
						exclusiveUseArea	='".$finder_info['exclusiveUseArea']."',
						buildingName	='".$finder_info['buildingName']."',
						investmaster_idx = (select idx from invest_master where exclusiveUseArea = '".$finder_info['exclusiveUseArea']."' and regionCode_full='".$finder_info['regionCode_full']."' and buildingNumber='".$finder_info['buildingNumber']."' ),
						updateDate	= '".$now_time."'";
				$insert_finder_res = mysqli_query($real_sock,$insert_finder_sql);
				$rank += 1;
			}
			$pre_DealYear = floor($check_array[count($check_array)-1]/100);
			$pre_DealMonth= $check_array[count($check_array)-1]-floor($check_array[count($check_array)-1]/100)*100;
			$pre_weeknum= $checks_array[count($checks_array)-1]-floor($checks_array[count($checks_array)-1]/100)*100;
			$pre_sql = "
					SELECT a.idx,a.rank as arank,a.StateValue as aStateValue,b.rank as brank,b.StateValue as bStateValue
						FROM (SELECT * from invest_master_weekly WHERE  DealYear = '".$DealYear."' and kind = ".$setting_info['idx']."	 and DealMonth = '".$DealMonth."' and weeknum = '".$weeknum."') as a 
							JOIN (SELECT * from invest_master_weekly WHERE  DealYear = '".$pre_DealYear."' and kind = ".$setting_info['idx']."	 and DealMonth = '".$pre_DealMonth."' and weeknum = '".$pre_weeknum."') as b 
					ON a.investmaster_idx = b.investmaster_idx	";
			$pre_res = mysqli_query($real_sock,$pre_sql);
			while($pre_info = mysqli_fetch_array($pre_res)){
				$temp1 = $pre_info['brank']-$pre_info['arank'];
				$temp2 = $pre_info['aStateValue']-$pre_info['bStateValue'];

				$updates_sql = "
						update invest_master_weekly set 
							prevRank	= '".$temp1."',
							diff		='".$temp2."'
						where idx = ".$pre_info['idx']."
						
						";
				$updates_res = mysqli_query($real_sock,$updates_sql);
			}	
		
		
		
		array_push($check_array,$state_date_i);
		array_push($checks_array,$weeknum);
		
		
	}
	
	}
	if($state_date_i -  floor($state_date_i/100)*100 ==12){
			$state_date_i = 	(floor($state_date_i/100)+1)*100;
	}	
}
}














/*
echo "<script>
		alert('주별 통계 산출 완료었습니다.');
		parent.location.replace('/BDP_ADMIN/admin_state/community_main1.php');
	</script> ";



*/




?>