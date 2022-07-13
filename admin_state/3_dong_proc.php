<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');




function hd_table_count_all($table_name,$startday,$endday){
	$c_table = "SELECT COUNT(idx) FROM  ".$table_name." 
		WHERE regionCode_full = a.regionCode_full
		AND DealfullDate Between '".$startday."' and LAST_DAY('".$endday."')

		";
	return $c_table;
}


function hd_sql($qq,$table_name,$startday,$endday,$stateAreaCode){

	$sql = "SELECT ".$qq." as cal, a.regionCode_full
					from ".$table_name." AS a
				JOIN region_code AS b 
					ON a.regionCode_full = b.regionCode_full		
			WHERE b.maplv1 = 1
				AND a.DealfullDate Between '".$startday."' and LAST_DAY('".$endday."')
				AND a.regionCode_full IS NOT NULL 
				and a.stateAreaCode = '".$stateAreaCode."'
			GROUP BY a.regionCode_full
			HAVING(cal>0)
			ORDER BY cal DESC
			Limit 500
			";
	return 	$sql;
}



function hd_sql1($qq,$table_name,$startday,$endday){

	$sql = "SELECT ".$qq." as cal, a.regionCode_full
					from ".$table_name." AS a
				JOIN region_code AS b 
					ON a.regionCode_full = b.regionCode_full		
			WHERE b.maplv1 = 1
				AND a.DealfullDate Between '".$startday."' and LAST_DAY('".$endday."')
				AND a.regionCode_full IS NOT NULL 
			GROUP BY regionCode_full
			HAVING(cal>0)
			ORDER BY cal DESC
			Limit 500
			";
	return 	$sql;
}



$updateDate = date("Y-m-d H:i:s");;

//이번달과 지난달 구하기 
$DealYear = date("Y");
$DealMonth = date("m");






if($DealMonth==1){
	$preDealYear = $DealYear-1;
	$preDealMonth=12;
}else{
	$preDealYear = $DealYear;
	$preDealMonth=$DealMonth-1;
}


$DealStart = $DealYear."-".$DealMonth."-01";
$preDealStart = $preDealYear."-".$preDealMonth."-01";














//매매 평단가

$insert_sql = "INSERT INTO region_code_detail_state(regionCode_full,DealYear,DealMonth,StateValue,kind,rank,stateAreaCode,updateDate)
				VALUES ";
$qq = " AVG(TransactionAmount/exclusiveUseArea) ";
$table_name = " rawdata_trade_apt ";
$sql = hd_sql1($qq,$table_name,$preDealStart,$DealStart);

$res = mysqli_query($real_sock,$sql);
$rank = 1;
$kind = 1;
while($info = mysqli_fetch_array($res)){
	$insert_sql =$insert_sql." ( '".$info['regionCode_full']."','".$DealYear."','".$DealMonth."','".$info['cal']."','".$kind."','".$rank."','0','".$updateDate."'),";
	$rank += 1;
}
$insert_sql=substr($insert_sql, 0, -1);
$insert_res = mysqli_query($real_sock,$insert_sql);






$pre_sql = "SELECT a.idx as aidx,a.rank as arank,a.StateValue as aStateValue,b.rank as brank,b.StateValue as bStateValue
		FROM 
		(SELECT * from region_code_detail_state	    WHERE  DealYear = '".$DealYear."' and kind = ".$kind."	 and DealMonth = '".$DealMonth."' and stateAreaCode = 0) as a 
	JOIN (SELECT * from region_code_detail_state WHERE  DealYear = '".$preDealYear."' and kind =".$kind."	 and DealMonth = '".$preDealMonth."' and stateAreaCode = 0) as b 
	ON a.regionCode_full = b.regionCode_full";
$pre_res = mysqli_query($real_sock,$pre_sql);
while($pre_info = mysqli_fetch_array($pre_res)){

	$updates_sql = "
			update region_code_detail_state set 
				prevRank	= '".$pre_info['brank']."',
				preStateValue		='".$pre_info['bStateValue']."'
			where idx = ".$pre_info['aidx']."
			
			";
	
	$updates_res = mysqli_query($real_sock,$updates_sql);

}	





//전세 평단가

$insert_sql = "INSERT INTO region_code_detail_state(regionCode_full,DealYear,DealMonth,StateValue,kind,rank,stateAreaCode,updateDate)
				VALUES ";

$qq = " AVG(calDeposit/exclusiveUseArea) ";
$table_name = " rawdata_charter_apt ";
$sql = hd_sql1($qq,$table_name,$preDealStart,$DealStart);
$res = mysqli_query($real_sock,$sql);
$rank = 1;
$kind = 2;
while($info = mysqli_fetch_array($res)){
	$insert_sql =$insert_sql." ( '".$info['regionCode_full']."','".$DealYear."','".$DealMonth."','".$info['cal']."','".$kind."','".$rank."','0','".$updateDate."'),";
	$rank += 1;
}
$insert_sql=substr($insert_sql, 0, -1);
$insert_res = mysqli_query($real_sock,$insert_sql);

$pre_sql = "SELECT a.idx as aidx,a.rank as arank,a.StateValue as aStateValue,b.rank as brank,b.StateValue as bStateValue
		FROM 
		(SELECT * from region_code_detail_state	    WHERE  DealYear = '".$DealYear."' and kind = ".$kind."	 and DealMonth = '".$DealMonth."' and stateAreaCode = 0) as a 
	JOIN (SELECT * from region_code_detail_state WHERE  DealYear = '".$preDealYear."' and kind =".$kind."	 and DealMonth = '".$preDealMonth."' and stateAreaCode = 0 ) as b 
	ON a.regionCode_full = b.regionCode_full";

$pre_res = mysqli_query($real_sock,$pre_sql);
while($pre_info = mysqli_fetch_array($pre_res)){

	$updates_sql = "
			update region_code_detail_state set 
				prevRank	= '".$pre_info['brank']."',
				preStateValue		='".$pre_info['bStateValue']."'
			where idx = ".$pre_info['aidx']."
			
			";
	
	$updates_res = mysqli_query($real_sock,$updates_sql);


}	





$insert_sql = "INSERT INTO region_code_detail_state(regionCode_full,DealYear,DealMonth,StateValue,kind,rank,stateAreaCode,updateDate)
				VALUES ";


$t_1 = hd_table_count_all('rawdata_charter_apt',$preDealStart,$DealStart);
$t_2 = hd_table_count_all('rawdata_charter_op',$preDealStart,$DealStart);
$t_3 = hd_table_count_all('rawdata_charter_tenementhouse',$preDealStart,$DealStart);
$t_4 = hd_table_count_all('rawdata_trade_apt',$preDealStart,$DealStart);
$t_5 = hd_table_count_all('rawdata_trade_op',$preDealStart,$DealStart);
$t_6 = hd_table_count_all('rawdata_trade_tenementhouse',$preDealStart,$DealStart);

$sql = "SELECT 
		(".$t_1.") +(".$t_2.") +(".$t_3.") +(".$t_4.") +(".$t_5.") +(".$t_6.")  AS cal, 
			a.regionCode_full,a.printName
				FROM region_code AS a 
			WHERE a.maplv1 = 1
		 HAVING(cal>0) 
			
			ORDER BY cal DESC 
					 Limit 500
";
$rank = 1;
$kind = 3;
$res = mysqli_query($real_sock,$sql);
while($info = mysqli_fetch_array($res)){
	$insert_sql =$insert_sql." ( '".$info['regionCode_full']."','".$DealYear."','".$DealMonth."','".$info['cal']."','".$kind."','".$rank."','0','".$updateDate."'),";
	$rank += 1;
}
$insert_sql=substr($insert_sql, 0, -1);
$insert_res = mysqli_query($real_sock,$insert_sql);
$pre_sql = "SELECT a.idx as aidx,a.rank as arank,a.StateValue as aStateValue,b.rank as brank,b.StateValue as bStateValue
		FROM 
		(SELECT * from region_code_detail_state	 WHERE  DealYear = '".$DealYear."' and kind = ".$kind."	 and DealMonth = '".$DealMonth."' and stateAreaCode = 0) as a 
	JOIN (SELECT * from region_code_detail_state WHERE  DealYear = '".$preDealYear."' and kind =".$kind."	 and DealMonth = '".$preDealMonth."' and stateAreaCode = 0) as b 
	ON a.regionCode_full = b.regionCode_full";
$pre_res = mysqli_query($real_sock,$pre_sql);

while($pre_info = mysqli_fetch_array($pre_res)){
	$updates_sql = "
			update region_code_detail_state set 
				prevRank	= '".$pre_info['brank']."',
				preStateValue		='".$pre_info['bStateValue']."'
			where idx = ".$pre_info['aidx']."
			
			";
	
	$updates_res = mysqli_query($real_sock,$updates_sql);


}	














$insert_sql = "INSERT INTO region_code_detail_state(regionCode_full,DealYear,DealMonth,StateValue,kind,rank,stateAreaCode,updateDate)
				VALUES ";
//전세 평단가
$qq = " AVG(a.rentRateTotal) ";
$table_name = " invest_master ";

$sql = "SELECT ".$qq." as cal, a.regionCode_full
					from ".$table_name." AS a
				JOIN region_code AS b 
					ON a.regionCode_full = b.regionCode_full		
			WHERE b.maplv1 = 1
				and a.LastCalDate between '".$preDealStart."' and LAST_DAY('".$DealStart."')
				AND a.regionCode_full IS NOT NULL 
				and a.rentRateTotal>0
				and a.rentRateTotal<100
			GROUP BY regionCode_full
			HAVING(cal>0)
			ORDER BY cal DESC
			Limit 500
			";


$res = mysqli_query($real_sock,$sql);
$rank = 1;
$kind = 4;
while($info = mysqli_fetch_array($res)){
	$insert_sql =$insert_sql." ( '".$info['regionCode_full']."','".$DealYear."','".$DealMonth."','".$info['cal']."','".$kind."','".$rank."','0','".$updateDate."'),";
	$rank += 1;
}
$insert_sql=substr($insert_sql, 0, -1);
$insert_res = mysqli_query($real_sock,$insert_sql);


$pre_sql = "SELECT a.idx as aidx,a.rank as arank,a.StateValue as aStateValue,b.rank as brank,b.StateValue as bStateValue
		FROM 
		(SELECT * from region_code_detail_state	    WHERE  DealYear = '".$DealYear."' and kind = ".$kind."	 and DealMonth = '".$DealMonth."' and stateAreaCode = 0) as a 
	JOIN (SELECT * from region_code_detail_state WHERE  DealYear = '".$preDealYear."' and kind =".$kind."	 and DealMonth = '".$preDealMonth."' and stateAreaCode = 0) as b 
	ON a.regionCode_full = b.regionCode_full";

$pre_res = mysqli_query($real_sock,$pre_sql);
while($pre_info = mysqli_fetch_array($pre_res)){

	$updates_sql = "
			update region_code_detail_state set 
				prevRank	= '".$pre_info['brank']."',
				preStateValue		='".$pre_info['bStateValue']."'
			where idx = ".$pre_info['aidx']."
			
			";
	
	$updates_res = mysqli_query($real_sock,$updates_sql);

}	





















































$region_code_sql = "select stateAreaCode from region_code group by stateAreaCode ;";
$region_code_res = mysqli_query($real_sock,$region_code_sql);
while($region_code_info = mysqli_fetch_array($region_code_res)){
		$stateAreaCode = $region_code_info['stateAreaCode'];
		
		
		
		////1
		$insert_sql = "INSERT INTO region_code_detail_state(regionCode_full,DealYear,DealMonth,StateValue,kind,rank,stateAreaCode,updateDate)
						VALUES ";
		$qq = " AVG(TransactionAmount/exclusiveUseArea) ";
		$table_name = " rawdata_trade_apt ";
		$sql = hd_sql($qq,$table_name,$preDealStart,$DealStart,$stateAreaCode);
		
		$res = mysqli_query($real_sock,$sql);
		$rank = 1;
		$kind = 1;
		while($info = mysqli_fetch_array($res)){
			$insert_sql =$insert_sql." ( '".$info['regionCode_full']."','".$DealYear."','".$DealMonth."','".$info['cal']."','".$kind."','".$rank."','".$stateAreaCode."','".$updateDate."'),";
			$rank += 1;
		}
		$insert_sql=substr($insert_sql, 0, -1);
		$insert_res = mysqli_query($real_sock,$insert_sql);

		$pre_sql = "SELECT a.idx as aidx,a.rank as arank,a.StateValue as aStateValue,b.rank as brank,b.StateValue as bStateValue
				FROM 
				(SELECT * from region_code_detail_state	    WHERE  DealYear = '".$DealYear."' and kind = ".$kind."	 and DealMonth = '".$DealMonth."' 
					and stateAreaCode= '".$stateAreaCode."'
				) as a 
			JOIN (SELECT * from region_code_detail_state WHERE  DealYear = '".$preDealYear."' and kind =".$kind."	 and DealMonth = '".$preDealMonth."'
								and stateAreaCode= '".$stateAreaCode."'
			) as b 
			ON a.regionCode_full = b.regionCode_full
			and a.stateAreaCode = b.stateAreaCode
			";
		$pre_res = mysqli_query($real_sock,$pre_sql);
		while($pre_info = mysqli_fetch_array($pre_res)){

			$updates_sql = "
					update region_code_detail_state set 
						prevRank	= '".$pre_info['brank']."',
						preStateValue		='".$pre_info['bStateValue']."'
					where idx = ".$pre_info['aidx']."
					
					";
			
			$updates_res = mysqli_query($real_sock,$updates_sql);

		}	


		////2
		$insert_sql = "INSERT INTO region_code_detail_state(regionCode_full,DealYear,DealMonth,StateValue,kind,rank,stateAreaCode,updateDate)
						VALUES ";

		$qq = " AVG(calDeposit/exclusiveUseArea) ";
		$table_name = " rawdata_charter_apt ";
		$sql = hd_sql($qq,$table_name,$preDealStart,$DealStart,$stateAreaCode);

		$res = mysqli_query($real_sock,$sql);
		$rank = 1;
		$kind = 2;
		while($info = mysqli_fetch_array($res)){
			$insert_sql =$insert_sql." ( '".$info['regionCode_full']."','".$DealYear."','".$DealMonth."','".$info['cal']."','".$kind."','".$rank."','".$stateAreaCode."','".$updateDate."'),";
			$rank += 1;
		}
		$insert_sql=substr($insert_sql, 0, -1);
		$insert_res = mysqli_query($real_sock,$insert_sql);






		$pre_sql = "SELECT a.idx as aidx,a.rank as arank,a.StateValue as aStateValue,b.rank as brank,b.StateValue as bStateValue
				FROM 
				(SELECT * from region_code_detail_state	    WHERE  DealYear = '".$DealYear."' and kind = ".$kind."	 and DealMonth = '".$DealMonth."' 
					and stateAreaCode= '".$stateAreaCode."'
				) as a 
			JOIN (SELECT * from region_code_detail_state WHERE  DealYear = '".$preDealYear."' and kind =".$kind."	 and DealMonth = '".$preDealMonth."'
								and stateAreaCode= '".$stateAreaCode."'
			) as b 
			ON a.regionCode_full = b.regionCode_full
			and a.stateAreaCode = b.stateAreaCode
			";
		$pre_res = mysqli_query($real_sock,$pre_sql);
		while($pre_info = mysqli_fetch_array($pre_res)){

			$updates_sql = "
					update region_code_detail_state set 
						prevRank	= '".$pre_info['brank']."',
						preStateValue		='".$pre_info['bStateValue']."'
					where idx = ".$pre_info['aidx']."
					
					";
			
			$updates_res = mysqli_query($real_sock,$updates_sql);

		}	


			////3
		$insert_sql = "INSERT INTO region_code_detail_state(regionCode_full,DealYear,DealMonth,StateValue,kind,rank,stateAreaCode,updateDate)
						VALUES ";


		$t_1 = hd_table_count_all('rawdata_charter_apt',$preDealStart,$DealStart);
		$t_2 = hd_table_count_all('rawdata_charter_op',$preDealStart,$DealStart);
		$t_3 = hd_table_count_all('rawdata_charter_tenementhouse',$preDealStart,$DealStart);
		$t_4 = hd_table_count_all('rawdata_trade_apt',$preDealStart,$DealStart);
		$t_5 = hd_table_count_all('rawdata_trade_op',$preDealStart,$DealStart);
		$t_6 = hd_table_count_all('rawdata_trade_tenementhouse',$preDealStart,$DealStart);

		$sql = "SELECT 
				(".$t_1.") +(".$t_2.") +(".$t_3.") +(".$t_4.") +(".$t_5.") +(".$t_6.")  AS cal, 
					a.regionCode_full,a.printName
						FROM region_code AS a 
					WHERE a.maplv1 = 1
					and a.stateAreaCode= '".$stateAreaCode."'
					 HAVING(cal>0) ORDER BY cal DESC
					 Limit 500
					 ";

	
		$rank = 1;
		$kind = 3;

	
		$res = mysqli_query($real_sock,$sql);
		while($info = mysqli_fetch_array($res)){
			$insert_sql =$insert_sql." ( '".$info['regionCode_full']."','".$DealYear."','".$DealMonth."','".$info['cal']."','".$kind."','".$rank."','".$stateAreaCode."','".$updateDate."'),";
			$rank += 1;
		}
		$insert_sql=substr($insert_sql, 0, -1);
		$insert_res = mysqli_query($real_sock,$insert_sql);
	
		$pre_sql = "SELECT a.idx as aidx,a.rank as arank,a.StateValue as aStateValue,b.rank as brank,b.StateValue as bStateValue
				FROM 
				(SELECT * from region_code_detail_state	    WHERE  DealYear = '".$DealYear."' and kind = ".$kind."	 and DealMonth = '".$DealMonth."' 
					and stateAreaCode= '".$stateAreaCode."'
				) as a 
			JOIN (SELECT * from region_code_detail_state WHERE  DealYear = '".$preDealYear."' and kind =".$kind."	 and DealMonth = '".$preDealMonth."'
								and stateAreaCode= '".$stateAreaCode."'
			) as b 
			ON a.regionCode_full = b.regionCode_full
			and a.stateAreaCode = b.stateAreaCode
			";
		$pre_res = mysqli_query($real_sock,$pre_sql);
		while($pre_info = mysqli_fetch_array($pre_res)){

			$updates_sql = "
					update region_code_detail_state set 
						prevRank	= '".$pre_info['brank']."',
						preStateValue		='".$pre_info['bStateValue']."'
					where idx = ".$pre_info['aidx']."
					
					";
			
			$updates_res = mysqli_query($real_sock,$updates_sql);

		}	



		$insert_sql = "INSERT INTO region_code_detail_state(regionCode_full,DealYear,DealMonth,StateValue,kind,rank,stateAreaCode,updateDate)
						VALUES ";
		//전세 평단가
		$qq = " AVG(a.rentRateTotal) ";
		$table_name = " invest_master ";

		$sql = "SELECT ".$qq." as cal, a.regionCode_full
							from ".$table_name." AS a
						JOIN region_code AS b 
							ON a.regionCode_full = b.regionCode_full		
					WHERE b.maplv1 = 1
						and a.LastCalDate between '".$preDealStart."' and LAST_DAY('".$DealStart."')
						AND a.regionCode_full IS NOT NULL 
						and a.rentRateTotal>0
						and a.rentRateTotal<100
						and a.stateAreaCode= '".$stateAreaCode."'
					GROUP BY regionCode_full
					ORDER BY cal DESC
					Limit 500
					";


		$res = mysqli_query($real_sock,$sql);
		$rank = 1;
		$kind = 4;
		while($info = mysqli_fetch_array($res)){
			$insert_sql =$insert_sql." ( '".$info['regionCode_full']."','".$DealYear."','".$DealMonth."','".$info['cal']."','".$kind."','".$rank."','".$stateAreaCode."','".$updateDate."'),";
			$rank += 1;
		}
		$insert_sql=substr($insert_sql, 0, -1);
		$insert_res = mysqli_query($real_sock,$insert_sql);


		$pre_sql = "SELECT a.idx as aidx,a.rank as arank,a.StateValue as aStateValue,b.rank as brank,b.StateValue as bStateValue
				FROM 
				(SELECT * from region_code_detail_state	    WHERE  DealYear = '".$DealYear."' and kind = ".$kind."	 and DealMonth = '".$DealMonth."' and stateAreaCode = '".$stateAreaCode."') as a 
			JOIN (SELECT * from region_code_detail_state WHERE  DealYear = '".$preDealYear."' and kind =".$kind."	 and DealMonth = '".$preDealMonth."' and stateAreaCode = '".$stateAreaCode."') as b 
			ON a.regionCode_full = b.regionCode_full";

		$pre_res = mysqli_query($real_sock,$pre_sql);
		while($pre_info = mysqli_fetch_array($pre_res)){

			$updates_sql = "
					update region_code_detail_state set 
						prevRank	= '".$pre_info['brank']."',
						preStateValue		='".$pre_info['bStateValue']."'
					where idx = ".$pre_info['aidx']."
					
					";
			
			$updates_res = mysqli_query($real_sock,$updates_sql);

		}	








}




$updates_sql = "
			update region_code_detail_state set 
				
				diff	   =  StateValue-preStateValue,
				Rankchange = rank-prevRank

		where DealYear = '".$DealYear."' and DealMonth = '".$DealMonth."'
		
		";

$updates_res = mysqli_query($real_sock,$updates_sql);






echo "<script>
		alert(' 통계 완료');
		parent.location.replace('/BDP_ADMIN/admin_state/community_main1.php');
	</script> ";


?>