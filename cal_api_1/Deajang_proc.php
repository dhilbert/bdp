<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');


$sql = "UPDATE  rawdata_trade_apt SET  rangeExclusiveUseArea = 5 WHERE rangeExclusiveUseArea>5;";
$res = mysqli_query($real_sock,$sql);

//이전 데이터 다 0으로 만들 기 
$sql1 = "update invest_master_leading set state = 0;";
$res1 = mysqli_query($real_sock,$sql1);






$UpdateDate = date("Y-m-d H:i:s");






$deajang_state = isset($_GET['deajang_state'])	 ? $_GET['deajang_state'] : Null;
$deajang_state = 365*$deajang_state;
$sql2 = "update admin_setting set 
	deajang_state = '".$deajang_state."'
";

$res2 = mysqli_query($real_sock,$sql2);

$limit_date = 365*$deajang_state;
$beforeDay = date("Y-m-d", strtotime(date('Y-m-d') ." -".$limit_date." day")); //통계 기준
	
$today_y = date('Y'); 
$today_m = date('m'); 
$DealDate = $today_y.$today_m;
$today_d = date('d');

$check_week = $today_y ."-".$today_m ."-".$today_d;

$mk_date = strtotime($check_week); 
$weeknum = date("W", $mk_date);

//대장주 찾기
$sql3 = "
	insert into invest_master_leading(DealDate,weeknum,regionCode_full,rangeExclusiveUseArea,TreadeDealDate,Treadefloor,TreadeAmount,buildingNumber,exclusiveUseArea,state,UpdateDate)
		SELECT '".$DealDate."','".$weeknum."',regionCode_full,rangeExclusiveUseArea,concat(DealYear,'-',DealMonth,'-',Dealday),
		buildingfloor,MAX(TransactionAmount),buildingNumber,exclusiveUseArea,1,'".$UpdateDate."'
			FROM rawdata_trade_apt
		WHERE rangeExclusiveUseArea>0
		and DealfullDate >= '".$beforeDay."'
		GROUP BY rangeExclusiveUseArea,regionCode_full;";

$res3 = mysqli_query($real_sock,$sql3);


//물건 디비와 연결 및 아이콘 밀기
$sql4 = "
	update invest_master_leading as a 
		Join invest_master as b
	on 	a.exclusiveUseArea  = b.exclusiveUseArea
	and a.buildingNumber	= b.buildingNumber
	and a.regionCode_full	= b.regionCode_full
	set a.invest_master_idx = b.idx,
	a.new_x_point =b.new_x_point+0.002,
	a.new_y_point =b.new_y_point,
	a.location    =point(b.new_x_point+0.002,b.new_y_point);";

$res4 = mysqli_query($real_sock,$sql4);



//전세 찾기
$charter_sql = "
	select 
		idx,regionCode_full,buildingNumber,exclusiveUseArea	from invest_master_leading where charterDealDate is null 

	;";

$charter_res = mysqli_query($real_sock,$charter_sql);
while($charter_info = mysqli_fetch_array($charter_res)){

	
	$rawdata_charter_apt_sql = "
		select 
			* from 	rawdata_charter_apt 
		where	regionCode_full		= '".$charter_info['regionCode_full']."'
		and 	buildingNumber		= '".$charter_info['buildingNumber']."'
		and		exclusiveUseArea	= '".$charter_info['exclusiveUseArea']."'
		and	    DealfullDate >= '".$beforeDay."'
		and		Monthlyrent  =0
			order by deposit DESC
		Limit 1
		;";
	
	$rawdata_charter_apt_res = mysqli_query($real_sock,$rawdata_charter_apt_sql);
	$rawdata_charter_apt_info = mysqli_fetch_array($rawdata_charter_apt_res);
	if($rawdata_charter_apt_info!=Null){
		$charterDealDate	=	$rawdata_charter_apt_info['DealYear']."-".$rawdata_charter_apt_info['DealMonth']."-".$rawdata_charter_apt_info['Dealday'];
		$charterfloor		=	$rawdata_charter_apt_info['buildingfloor'];
		$charterdeposit		=	$rawdata_charter_apt_info['deposit'];
		$chartercalDeposit	=	$rawdata_charter_apt_info['calDeposit'];
		$charterMonthlyrent	=	$rawdata_charter_apt_info['Monthlyrent'];

		$update_sql = "
			update invest_master_leading set 
				charterDealDate		=	'".$charterDealDate."',
				charterfloor		=	'".$charterfloor."',
				charterdeposit		=	'".$charterdeposit."',
				chartercalDeposit	=	'".$chartercalDeposit."',
				charterMonthlyrent	=	'".$charterMonthlyrent."'
			where idx = '".$charter_info['idx']."'

			;";
		$update_res = mysqli_query($real_sock,$update_sql);
	
	}


}



echo "<script>
			alert('계산 완료 ');
			parent.location.replace('/BDP_ADMIN/cal_api_1/community_main.php');
</script> ";

?>