<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');
$today_time = date("Y-m-d");
$now = date("Y-m-d H:i:s");



$sql = " 
	SELECT a.prefinderType, a.exclusiveUseArea, a.regionCode_full, a.buildingNumber,a.idx
	FROM bdp_real.invest_master AS a 
		JOIN kbland.naverland_danji AS b
	ON a.Courtbuilding = b.Courtbuilding
	AND a.buildingNumber = b.buildingNumber
	WHERE b.oName LIKE '%도시형%'
	

	;

	 ;";

$res = mysqli_query($real_sock,$sql);
while($info = mysqli_fetch_array($res)){
	$type =$info['prefinderType'];
	if($type=='bil'){
		$charter_table = 'rawdata_charter_tenementhouse';
		$trade_table	= 'rawdata_trade_tenementhouse';
	}
	else{
		$charter_table = 'rawdata_charter_'.$type;
		$trade_table	= 'rawdata_trade_'.$type;
	}


	$charter_sql = " 
		insert into rawdata_charter_do( Courtbuilding,buildingName,buildingNumber,buildingfloor,BuildYear,DealYear,DealMonth,Dealday,
										AreaforExclusiveUse,Contractarea,deposit,calDeposit,Monthlyrent,AreaCode,regionCode_full,UpdateDate,
										stateAreaCode,exclusiveUseArea,DealfullDate)

		SELECT Courtbuilding,buildingName,buildingNumber,buildingfloor,BuildYear,DealYear,DealMonth,Dealday,
				AreaforExclusiveUse,Contractarea,deposit,calDeposit,Monthlyrent,AreaCode,regionCode_full,UpdateDate,
			stateAreaCode,exclusiveUseArea,DealfullDate
		FROM ".$charter_table."

		where exclusiveUseArea = '".$info['exclusiveUseArea']."'
		and regionCode_full		= '".$info['regionCode_full']."'
		and buildingNumber		= '".$info['buildingNumber']."'
	

	 ;";

	$charter_res = mysqli_query($real_sock,$charter_sql);

	$trade_sql = " 
		insert into rawdata_trade_do(Courtbuilding,buildingName,buildingNumber,buildingfloor,BuildYear,DealYear,DealMonth,
									Dealday,AreaforExclusiveUse,landArea,TransactionAmount,houseType,AreaCode,regionCode_full,UpdateDate,stateAreaCode,exclusiveUseArea,DealfullDate)

		SELECT Courtbuilding,buildingName,buildingNumber,buildingfloor,BuildYear,DealYear,DealMonth,
									Dealday,AreaforExclusiveUse,landArea,TransactionAmount,houseType,AreaCode,regionCode_full,UpdateDate,stateAreaCode,exclusiveUseArea,DealfullDate
		FROM ".$trade_table."

		where exclusiveUseArea = '".$info['exclusiveUseArea']."'
		and regionCode_full		= '".$info['regionCode_full']."'
		and buildingNumber		= '".$info['buildingNumber']."'
	

	 ;";

	$trade_res = mysqli_query($real_sock,$trade_sql);
	$update_sql = " 
		update invest_master set 
			finderType = 'do'
		where idx =".$info['idx']."
		

	 ;";

	$update_res = mysqli_query($real_sock,$update_sql);
	
	
}




?>






해당 페이지에서 작업 <p>
1. 도생 찾아서 도생 정보 넣기 <br>
2. 네이버가 도생이라고 한것만 적용
<br><p><br>
다음 버튼 클릭 해서 다음 작업 진행해야 함. 
<br><p><br>
<?php

echo "<script>
		alert('물건 생성  완료');
		parent.location.replace('/BDP_ADMIN/cal_api/community_main.php');
</script> ";


?>

