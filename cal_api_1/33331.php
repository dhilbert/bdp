<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');




$now = date("Y-m-d");
$admin_Setting_sql = "select * from admin_Setting ";
$admin_Setting_res = mysqli_query($real_sock,$admin_Setting_sql);
$admin_Setting_info = mysqli_fetch_array($admin_Setting_res);
$StartdealDateT = date("Y-m-d", strtotime($now ." -".$admin_Setting_info['minmax_dateforT']." day")); //통계 기준
$StartdealDateC = date("Y-m-d", strtotime($now ." -".$admin_Setting_info['minmax_dateforC']." day")); //통계 기준


function hd_sql($insert_table,$table_name,$StartdealDateC,$minmaxtype,$qq){
	//동
	$sql1 = "insert ".$insert_table."(regionCode_full,rangeExclusiveUseArea,idx,name,ExclusiveUseArea,Amount,TradetradeDate)
				SELECT a.regionCode_full,FLOOR(a.exclusiveUseArea/10), a.idx,buildingName,a.exclusiveUseArea,".$minmaxtype."(".$qq."),a.DealfullDate
						FROM ".$table_name." as a 
				where  a.DealfullDate>='".$StartdealDateC."'
				group BY a.regionCode_full,a.rangeExclusiveUseArea;";
	//전세 읍
	$sql2 = "insert 	".$insert_table."(regionCode_full,rangeExclusiveUseArea,idx,name,ExclusiveUseArea,Amount,TradetradeDate)
				SELECT floor(a.regionCode_full/100)*100,FLOOR(a.exclusiveUseArea/10), a.idx,buildingName,a.exclusiveUseArea,".$minmaxtype."(".$qq.")
				,a.DealfullDate	FROM ".$table_name." as a 
				where  a.DealfullDate>='".$StartdealDateC."' 
				group BY a.myuncheck,a.rangeExclusiveUseArea;";

	//전세 구
	$sql3 = "insert ".$insert_table."(regionCode_full,rangeExclusiveUseArea,idx,name,ExclusiveUseArea,Amount,TradetradeDate)
				SELECT a.AreaCode*100000,FLOOR(a.exclusiveUseArea/10), a.idx,buildingName,a.exclusiveUseArea,".$minmaxtype."(".$qq."),a.DealfullDate
						FROM ".$table_name." as a 
				where  a.DealfullDate>='".$StartdealDateC."' 
				group BY a.AreaCode,a.rangeExclusiveUseArea;";

	//전세 작은 시
	$sql4 = "insert ".$insert_table."(regionCode_full,rangeExclusiveUseArea,idx,name,ExclusiveUseArea,Amount,TradetradeDate)
				SELECT a.sicheck*1000000,FLOOR(a.exclusiveUseArea/10), a.idx,buildingName,a.exclusiveUseArea,".$minmaxtype."(".$qq."),a.DealfullDate
						FROM ".$table_name." as a 
				where  a.DealfullDate>='".$StartdealDateC."' 
				group BY a.sicheck,a.rangeExclusiveUseArea;";

	//전세  시
	$sql5 = "insert ".$insert_table."(regionCode_full,rangeExclusiveUseArea,idx,name,ExclusiveUseArea,Amount,TradetradeDate)
				SELECT a.stateAreaCode*100000,FLOOR(a.exclusiveUseArea/10), a.idx,buildingName,a.exclusiveUseArea,".$minmaxtype."(".$qq."),a.DealfullDate
						FROM ".$table_name." as a 
				where  a.DealfullDate>='".$StartdealDateC."' 
				group BY a.stateAreaCode,a.rangeExclusiveUseArea;";
	$want_array = array($sql1,$sql2,$sql3,$sql4,$sql5)	;
	return $want_array;
}



function hd_sql1($insert_table,$table_name,$StartdealDateC,$minmaxtype,$qq){
	//동
	$sql1 = "insert ".$insert_table."(regionCode_full,rangeExclusiveUseArea,idx,name,ExclusiveUseArea,Amount,TradetradeDate)
				SELECT a.regionCode_full,FLOOR(a.exclusiveUseArea/10), a.idx,buildingName,a.exclusiveUseArea,".$minmaxtype."(".$qq."),a.DealfullDate
						FROM ".$table_name." as a 
				where  a.DealfullDate>='".$StartdealDateC."'
				and a.Monthlyrent = 0
				group BY a.regionCode_full,a.rangeExclusiveUseArea;";
	//전세 읍
	$sql2 = "insert 	".$insert_table."(regionCode_full,rangeExclusiveUseArea,idx,name,ExclusiveUseArea,Amount,TradetradeDate)
				SELECT floor(a.regionCode_full/100)*100,FLOOR(a.exclusiveUseArea/10), a.idx,buildingName,a.exclusiveUseArea,".$minmaxtype."(".$qq.")
				,a.DealfullDate	FROM ".$table_name." as a 
				where  a.DealfullDate>='".$StartdealDateC."' 
				and a.Monthlyrent = 0
				group BY a.myuncheck,a.rangeExclusiveUseArea;";

	//전세 구
	$sql3 = "insert ".$insert_table."(regionCode_full,rangeExclusiveUseArea,idx,name,ExclusiveUseArea,Amount,TradetradeDate)
				SELECT a.AreaCode*100000,FLOOR(a.exclusiveUseArea/10), a.idx,buildingName,a.exclusiveUseArea,".$minmaxtype."(".$qq."),a.DealfullDate
						FROM ".$table_name." as a 
				where  a.DealfullDate>='".$StartdealDateC."' 
				and a.Monthlyrent = 0
				group BY a.AreaCode,a.rangeExclusiveUseArea;";

	//전세 작은 시
	$sql4 = "insert ".$insert_table."(regionCode_full,rangeExclusiveUseArea,idx,name,ExclusiveUseArea,Amount,TradetradeDate)
				SELECT a.sicheck*1000000,FLOOR(a.exclusiveUseArea/10), a.idx,buildingName,a.exclusiveUseArea,".$minmaxtype."(".$qq."),a.DealfullDate
						FROM ".$table_name." as a 
				where  a.DealfullDate>='".$StartdealDateC."' 
				and a.Monthlyrent = 0
				group BY a.sicheck,a.rangeExclusiveUseArea;";

	//전세  시
	$sql5 = "insert ".$insert_table."(regionCode_full,rangeExclusiveUseArea,idx,name,ExclusiveUseArea,Amount,TradetradeDate)
				SELECT a.stateAreaCode*100000,FLOOR(a.exclusiveUseArea/10), a.idx,buildingName,a.exclusiveUseArea,".$minmaxtype."(".$qq."),a.DealfullDate
						FROM ".$table_name." as a 
				where  a.DealfullDate>='".$StartdealDateC."' 
				and a.Monthlyrent = 0
				group BY a.stateAreaCode,a.rangeExclusiveUseArea;";
	$want_array = array($sql1,$sql2,$sql3,$sql4,$sql5)	;
	return $want_array;
}




$tt = hd_sql1('region_code_detail_temp_00','rawdata_charter_apt',$StartdealDateC,'max','Deposit');
for($i = 0 ; $i < count($tt) ; $i ++){
	$sql = $tt[$i];

	$res = mysqli_query($real_sock,$sql);
}



$tt = hd_sql1('region_code_detail_temp_01','rawdata_charter_apt',$StartdealDateC,'min','Deposit');
for($i = 0 ; $i < count($tt) ; $i ++){
	$sql = $tt[$i];
	$res = mysqli_query($real_sock,$sql);
}


$tt = hd_sql('region_code_detail_temp_10','rawdata_trade_apt',$StartdealDateT,'max','TransactionAmount');
for($i = 0 ; $i < count($tt) ; $i ++){
	$sql = $tt[$i];
	$res = mysqli_query($real_sock,$sql);
}


$tt = hd_sql('region_code_detail_temp_11','rawdata_trade_apt',$StartdealDateT,'max','TransactionAmount');
for($i = 0 ; $i < count($tt) ; $i ++){
	$sql = $tt[$i];
	$res = mysqli_query($real_sock,$sql);
}

















































$region_code_sql = " SELECT *	from region_code Limit 1;";
$region_code_res = mysqli_query($real_sock,$region_code_sql);
while($region_code_info = mysqli_fetch_array($region_code_res)){

	for($rangeExclusiveUseArea = 0 ; $rangeExclusiveUseArea < 6;$rangeExclusiveUseArea++){
		$t_sql = " 
			SELECT * from region_code_detail_temp_10 where regionCode_full = '".$region_code_info['regionCode_full']."' and rangeExclusiveUseArea = '".$rangeExclusiveUseArea."'  order by Amount DESC  Limit 1
		 ;";

		$t_res = mysqli_query($real_sock,$t_sql);
		$t_info = mysqli_fetch_array($t_res);
		$maxTradeidx				=$t_info['idx'];
		$maxTradename				=$t_info['name'];
		$maxTradeExclusiveUseArea	=$t_info['ExclusiveUseArea'];
		$maxTradeAmount				=$t_info['Amount'];
		$maxTradetradeDate			=$t_info['TradetradeDate'];

		$t_sql = " 
			SELECT * from region_code_detail_temp_11 where regionCode_full = '".$region_code_info['regionCode_full']."' and rangeExclusiveUseArea = '".$rangeExclusiveUseArea."'  order by Amount ASC Limit 1
		 ;";
		$t_res = mysqli_query($real_sock,$t_sql);
		$t_info = mysqli_fetch_array($t_res);
		$minTradeidx				=$t_info['idx'];
		$minTradename				=$t_info['name'];
		$minTradeExclusiveUseArea	=$t_info['ExclusiveUseArea'];
		$minTradeAmount				=$t_info['Amount'];
		$minTradetradeDate			=$t_info['TradetradeDate'];
	

		$t_sql = " 
			SELECT * from region_code_detail_temp_00 where regionCode_full = '".$region_code_info['regionCode_full']."' and rangeExclusiveUseArea = '".$rangeExclusiveUseArea."' order by Amount DESC Limit 1
		 ;";
		$t_res = mysqli_query($real_sock,$t_sql);
		$t_info = mysqli_fetch_array($t_res);

		$maxCharteridx					=$t_info['idx'];
		$maxChartername					=$t_info['name'];
		$maxCharterExclusiveUseArea		=$t_info['ExclusiveUseArea'];
		$maxCharterAmount				=$t_info['Amount'];
		$maxCharterDate			=$t_info['TradetradeDate'];


		$t_sql = " 
			SELECT * from region_code_detail_temp_01 where regionCode_full = '".$region_code_info['regionCode_full']."' and rangeExclusiveUseArea = '".$rangeExclusiveUseArea."'  order by Amount ASC Limit 1
		 ;";
		$t_res = mysqli_query($real_sock,$t_sql);
		$t_info = mysqli_fetch_array($t_res);
	
		$minCharteridx					=$t_info['idx'];
		$minChartername					=$t_info['name'];
		$minCharterExclusiveUseArea		=$t_info['ExclusiveUseArea'];
		$minCharterAmount				=$t_info['Amount'];
		$minCharterDate			       =$t_info['TradetradeDate'];
		$want_rangeExclusiveUseArea = $rangeExclusiveUseArea*10;

			$update_sql = " 
				insert region_code_detail set 
					regionCode_full= '".$region_code_info['regionCode_full']."',
					RangeExclusiveUseArea = '".$want_rangeExclusiveUseArea."',
					maxTradeidx='".$maxTradeidx."',
					maxTradename='".$maxTradename."',
					maxTradeExclusiveUseArea='".$maxTradeExclusiveUseArea."',
					maxTradeAmount='".$maxTradeAmount."',
					maxTradetradeDate='".$maxTradetradeDate."',
					maxCharteridx='".$maxCharteridx."',
					maxChartername='".$maxChartername."',
					maxCharterExclusiveUseArea='".$maxCharterExclusiveUseArea."',
					maxCharterAmount='".$maxCharterAmount."',
					maxCharterDate='".$maxCharterDate."',
					minTradeidx='".$minTradeidx."',
					minTradeExclusiveUseArea='".$minTradeExclusiveUseArea."',
					minTradename='".$minTradename."',
					minTradeAmount='".$minTradeAmount."',
					minTradetradeDate='".$minTradetradeDate."',
					minCharteridx='".$minCharteridx."',
					minChartername='".$minChartername."',
					minCharterExclusiveUseArea='".$minCharterExclusiveUseArea."',
					minCharterAmount='".$minCharterAmount."',
					minCharterDate='".$minCharterDate."',
					StartdealDateC='".$StartdealDateC."',
					StartdealDateT='".$StartdealDateT."',
					updateDate='".$now."';";


		if($maxTradeAmount	+ $maxCharterAmount>0){
			
			$update_res = mysqli_query($real_sock,$update_sql);
		
		}
	
	}
}


echo "<script>
			alert('계산 완료 ');
			parent.location.replace('/BDP_ADMIN/cal_api_1/community_main.php');
</script> ";

?>
