<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');





//kind = 2 평단가(수도권) 
		
$now_time = date("Y-m-d H:i:s");
$today_time = date("Y-m-d H:i:s");
$singo_date = 210;



$beforeDay = date("Y-m-d", strtotime($today_time." -".$singo_date." day")); 
$beforeDay = explode("-",$beforeDay);
$beforeDay = $beforeDay[0]*100+$beforeDay[1];
$endDay = explode("-",$today_time);
$endDay = $endDay[0]*100+$endDay[1];

$check_array = array();

for($state_date_i = $beforeDay ; $state_date_i <$endDay +1 ; $state_date_i++ ){
	if($state_date_i== $beforeDay){
		array_push($check_array,$state_date_i);

	}
	else{
		$DealYear = floor($state_date_i/100);
		$DealMonth= $state_date_i-floor($state_date_i/100)*100;
		$del_sql = "
			delete from region_state_monthly where DealYear = '".$DealYear."'
						and DealMonth = '".$DealMonth."' ";
		$del_res = mysqli_query($real_sock,$del_sql);
		
		$date = $DealYear."-".$DealMonth."-01";

		$finder_sql = "
				select AVG(TransactionAmount/exclusiveUseArea) AS cal,a.regionCode_full
					FROM  rawdata_trade_apt as a
					where a.DealfullDate between DATE_ADD(LAST_DAY('".$date."'), INTERVAL -6 MONTH) and LAST_DAY('".$date."')
					and stateAreaCode in (11000,28000,41000)				
					GROUP BY a.regionCode_full
					ORDER BY cal DESC LIMIT 500";
		$finder_res = mysqli_query($real_sock,$finder_sql);
		$rank = 1;
		while($finder_info = mysqli_fetch_array($finder_res)){
			$insert_finder_sql = "
				insert region_state_monthly SET 
					DealYear	= '".$DealYear."',
					DealMonth	= '".$DealMonth."',
					kind		= 2,
					rank		= '".$rank."',
					StateValue	= '".$finder_info['cal']."',
					regionCode_full = '".$finder_info['regionCode_full']."',
					updateDate	= '".$now_time."'";
			$insert_finder_res = mysqli_query($real_sock,$insert_finder_sql);
			$rank += 1;
		}
		$pre_DealYear = floor($check_array[count($check_array)-1]/100);

		$pre_DealMonth= $check_array[count($check_array)-1]-floor($check_array[count($check_array)-1]/100)*100;
		$pre_sql = "
					SELECT a.idx,a.rank as arank,a.StateValue as aStateValue,b.rank as brank,b.StateValue as bStateValue
						FROM (SELECT * from region_state_monthly WHERE  DealYear = '".$DealYear."' and kind = 2	 and DealMonth = '".$DealMonth."') as a 
							JOIN (SELECT * from region_state_monthly WHERE  DealYear = '".$pre_DealYear."' and kind = 2	 and DealMonth = '".$pre_DealMonth."') as b 
					ON a.regionCode_full = b.regionCode_full	";
		$pre_res = mysqli_query($real_sock,$pre_sql);
		while($pre_info = mysqli_fetch_array($pre_res)){
			$temp1 = $pre_info['brank']-$pre_info['arank'];
			$temp2 = $pre_info['aStateValue']-$pre_info['bStateValue'];

			$updates_sql = "
					update region_state_monthly set 
						prevRank	= '".$temp1."',
						diff		='".$temp2."'
					where idx = ".$pre_info['idx']."
					
					";
			$updates_res = mysqli_query($real_sock,$updates_sql);
		}	
		array_push($check_array,$state_date_i);











	}
	if($state_date_i -  floor($state_date_i/100)*100 ==12){
			$state_date_i = 	(floor($state_date_i/100)+1)*100;
	}	
}



$check_array = array();

for($state_date_i = $beforeDay ; $state_date_i <$endDay +1 ; $state_date_i++ ){
	if($state_date_i== $beforeDay){
		array_push($check_array,$state_date_i);

	}
	else{
		$DealYear = floor($state_date_i/100);
		$DealMonth= $state_date_i-floor($state_date_i/100)*100;
		$del_sql = "
			delete from region_state_monthly where DealYear = '".$DealYear."'
						and DealMonth = '".$DealMonth."' ";
		$del_res = mysqli_query($real_sock,$del_sql);
		
		$date = $DealYear."-".$DealMonth."-01";

		$finder_sql = "
				select AVG(TransactionAmount/exclusiveUseArea) AS cal,a.regionCode_full
					FROM  rawdata_trade_apt as a
					where a.DealfullDate between DATE_ADD(LAST_DAY('".$date."'), INTERVAL -6 MONTH) and LAST_DAY('".$date."')
					and stateAreaCode not in (11000,28000,41000)				
					GROUP BY a.regionCode_full
					ORDER BY cal DESC LIMIT 500";
		$finder_res = mysqli_query($real_sock,$finder_sql);
		$rank = 1;
		while($finder_info = mysqli_fetch_array($finder_res)){
			$insert_finder_sql = "
				insert region_state_monthly SET 
					DealYear	= '".$DealYear."',
					DealMonth	= '".$DealMonth."',
					kind		= 3,
					rank		= '".$rank."',
					StateValue	= '".$finder_info['cal']."',
					regionCode_full = '".$finder_info['regionCode_full']."',
					updateDate	= '".$now_time."'";
			$insert_finder_res = mysqli_query($real_sock,$insert_finder_sql);
			$rank += 1;
		}
		$pre_DealYear = floor($check_array[count($check_array)-1]/100);

		$pre_DealMonth= $check_array[count($check_array)-1]-floor($check_array[count($check_array)-1]/100)*100;
		$pre_sql = "
					SELECT a.idx,a.rank as arank,a.StateValue as aStateValue,b.rank as brank,b.StateValue as bStateValue
						FROM (SELECT * from region_state_monthly WHERE  DealYear = '".$DealYear."' and kind = 3	 and DealMonth = '".$DealMonth."') as a 
							JOIN (SELECT * from region_state_monthly WHERE  DealYear = '".$pre_DealYear."' and kind = 3	 and DealMonth = '".$pre_DealMonth."') as b 
					ON a.regionCode_full = b.regionCode_full	";
		$pre_res = mysqli_query($real_sock,$pre_sql);
		while($pre_info = mysqli_fetch_array($pre_res)){
			$temp1 = $pre_info['brank']-$pre_info['arank'];
			$temp2 = $pre_info['aStateValue']-$pre_info['bStateValue'];

			$updates_sql = "
					update region_state_monthly set 
						prevRank	= '".$temp1."',
						diff		='".$temp2."'
					where idx = ".$pre_info['idx']."
					
					";
			$updates_res = mysqli_query($real_sock,$updates_sql);
		}	
		array_push($check_array,$state_date_i);











	}
	if($state_date_i -  floor($state_date_i/100)*100 ==12){
			$state_date_i = 	(floor($state_date_i/100)+1)*100;
	}	
}




$check_array = array();

for($state_date_i = $beforeDay ; $state_date_i <$endDay +1 ; $state_date_i++ ){
	if($state_date_i== $beforeDay){
		array_push($check_array,$state_date_i);

	}
	else{
		$DealYear = floor($state_date_i/100);
		$DealMonth= $state_date_i-floor($state_date_i/100)*100;
		
		
		$del_sql = "
			delete from region_state_monthly where DealYear = '".$DealYear."'
						and DealMonth = '".$DealMonth."' ";
		$del_res = mysqli_query($real_sock,$del_sql);
		
		$date = $DealYear."-".$DealMonth."-01";

		$finder_sql = "
				select count(idx) AS cal,a.AreaCode
					FROM  rawdata_trade_apt as a
					where a.DealfullDate between '".$date."'and LAST_DAY('".$date."')
					and a.AreaCode not in (36110)
					GROUP BY a.AreaCode
					ORDER BY cal DESC LIMIT 500";
		$finder_res = mysqli_query($real_sock,$finder_sql);
		$rank = 1;
		while($finder_info = mysqli_fetch_array($finder_res)){
			$regionCode_full = $finder_info['AreaCode']*100000;
			$insert_finder_sql = "
				insert region_state_monthly SET 
					DealYear	= '".$DealYear."',
					DealMonth	= '".$DealMonth."',
					kind		= 13,
					rank		= '".$rank."',
					StateValue	= '".$finder_info['cal']."',
					regionCode_full = '".$regionCode_full."',
					updateDate	= '".$now_time."'";
			$insert_finder_res = mysqli_query($real_sock,$insert_finder_sql);
			$rank += 1;
		}
		$pre_DealYear = floor($check_array[count($check_array)-1]/100);

		$pre_DealMonth= $check_array[count($check_array)-1]-floor($check_array[count($check_array)-1]/100)*100;
		$pre_sql = "
					SELECT a.idx,a.rank as arank,a.StateValue as aStateValue,b.rank as brank,b.StateValue as bStateValue
						FROM (SELECT * from region_state_monthly WHERE  DealYear = '".$DealYear."' and kind = 13	 and DealMonth = '".$DealMonth."') as a 
							JOIN (SELECT * from region_state_monthly WHERE  DealYear = '".$pre_DealYear."' and kind = 13	 and DealMonth = '".$pre_DealMonth."') as b 
					ON a.regionCode_full = b.regionCode_full	";
		$pre_res = mysqli_query($real_sock,$pre_sql);
		while($pre_info = mysqli_fetch_array($pre_res)){
			$temp1 = $pre_info['brank']-$pre_info['arank'];
			$temp2 = $pre_info['aStateValue']-$pre_info['bStateValue'];

			$updates_sql = "
					update region_state_monthly set 
						prevRank	= '".$temp1."',
						diff		='".$temp2."'
					where idx = ".$pre_info['idx']."
					
					";
			$updates_res = mysqli_query($real_sock,$updates_sql);
		}	
		array_push($check_array,$state_date_i);











	}
	if($state_date_i -  floor($state_date_i/100)*100 ==12){
			$state_date_i = 	(floor($state_date_i/100)+1)*100;
	}	
}




echo "<script>
		alert(' 통계 완료');
		parent.location.replace('/BDP_ADMIN/admin_state/community_main1.php');
	</script> ";



?>