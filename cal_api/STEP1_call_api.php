<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');







$table_names = array('apt','op','tenementhouse');  // 다가구 제외
for($mol_i = 0; $mol_i <count($table_names);$mol_i++){
	$table_name = $table_names[$mol_i];

	$cal_charter_table = "rawdata_charter_".$table_name;
	$cal_trade_table  = "rawdata_trade_".$table_name;	


	$sqlss = "	select areaCode from region_code group by areaCode
		";
	$resss = mysqli_query($real_sock,$sqlss);
	while($infoss = mysqli_fetch_array($resss)){
		
		$charter_sql = "
		
		UPDATE ".$cal_charter_table." a,
				region_code AS b
		SET  a.Courtbuilding  =b.regionName,
			a.regionCode_full =	 b.regionCode_full,
			a.stateAreaCode = (case when a.AreaCode=36110 then 36110 ELSE floor(a.AreaCode/1000)*1000 END),
			a.exclusiveUseArea = floor(a.AreaforExclusiveUse/3.3)
		WHERE b.regionName like CONCAT('%',trim(a.Courtbuilding), '%') 
		AND b.areaCode = a.AreaCode 
		AND b.state = 'Y'
		and a.regionCode_full is null
		and b.areaCode = '".$infoss ['areaCode']."';
		
		";


		$charter_res = mysqli_query($real_sock,$charter_sql);
		$charter_sql = "
		UPDATE ".$cal_trade_table." a,
		region_code AS b
		SET  a.Courtbuilding  =b.regionName,
			a.regionCode_full =	 b.regionCode_full,
			a.stateAreaCode = (case when a.AreaCode=36110 then 36110 ELSE floor(a.AreaCode/1000)*1000 END),
			a.exclusiveUseArea = floor(a.AreaforExclusiveUse/3.3)
		WHERE b.regionName like CONCAT('%',trim(a.Courtbuilding), '%') 
		AND b.areaCode = a.AreaCode 
		AND b.state = 'Y'
		and a.regionCode_full is null
		and b.areaCode = '".$infoss ['areaCode']."';
		
		";
		
		$charter_res = mysqli_query($real_sock,$charter_sql);



		$charter_sql = "
		UPDATE ".$cal_charter_table." a
		SET a.DealfullDate = concat(a.DealYear,'-',a.DealMonth,'-',a.DealDay) 
		WHERE a.DealfullDate is null;
		";
		$charter_res = mysqli_query($real_sock,$charter_sql);

		$charter_sql = "
		UPDATE ".$cal_trade_table." a
		SET a.DealfullDate = concat(a.DealYear,'-',a.DealMonth,'-',a.DealDay) 
		WHERE a.DealfullDate is null ;
		";
		$charter_res = mysqli_query($real_sock,$charter_sql);

	}
		
}


$trade_sql = "
	UPDATE rawdata_charter_apt as  a
	SET a.rangeExclusiveUseArea = floor(a.exclusiveUseArea/10),
			a.myuncheck = floor(a.regionCode_full/100),
			a.sicheck = floor(a.AreaCode/10) 
	WHERE a.rangeExclusiveUseArea is null;
";
$trade_res = mysqli_query($real_sock,$trade_sql);



	
$trade_sql = "
	UPDATE rawdata_trade_apt as  a
	SET a.rangeExclusiveUseArea = floor(a.exclusiveUseArea/10),
			a.myuncheck = floor(a.regionCode_full/100),
			a.sicheck = floor(a.AreaCode/10)
	WHERE a.rangeExclusiveUseArea is null;
";
$trade_res = mysqli_query($real_sock,$trade_sql);








	
$trade_sql = "
	UPDATE rawdata_trade_apt as  a
	SET a.rangeExclusiveUseArea =5
	WHERE a.rangeExclusiveUseArea>5;
";
$trade_res = mysqli_query($real_sock,$trade_sql);


$trade_sql = "
	UPDATE rawdata_charter_apt as  a
	SET a.rangeExclusiveUseArea =5
	WHERE a.rangeExclusiveUseArea>5;
";
$trade_res = mysqli_query($real_sock,$trade_sql);


























echo "<script>
		alert('물건 정제 완료');
		parent.location.replace('/BDP_ADMIN/cal_api/community_main.php');
	</script> ";




?>