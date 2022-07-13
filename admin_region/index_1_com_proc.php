<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');



$preregionName = isset($_GET['preregionName']) ? $_GET['preregionName'] : Null;
$affregionName = isset($_GET['affregionName']) ? $_GET['affregionName'] : Null;
$updateTime = date("Y-m-d H:i:s");

$admin_region_history_sql = "

	insert admin_region_history set 
		preregionName	='".$preregionName."',
		affregionName	='".$affregionName."',
		admin_idx		= '".$admin_idx."',
		updateTime		= '".$updateTime."'
		
;";
$admin_region_history_res = mysqli_query($real_sock,$admin_region_history_sql);


//매매
$check_sql = "
		update rawdata_trade_apt set 
				Courtbuilding = REPLACE(Courtbuilding,'".$preregionName."','".$affregionName."')
		 where Courtbuilding Like '%".$preregionName."%';";

$check_res = mysqli_query($real_sock,$check_sql);
$check_sql = "
		update rawdata_trade_op set 
				Courtbuilding = REPLACE(Courtbuilding,'".$preregionName."','".$affregionName."')
		 where Courtbuilding Like '%".$preregionName."%';";

$check_res = mysqli_query($real_sock,$check_sql);
$check_sql = "
		update rawdata_trade_tenementhouse set 
				Courtbuilding = REPLACE(Courtbuilding,'".$preregionName."','".$affregionName."')
		 where Courtbuilding Like '%".$preregionName."%';";

$check_res = mysqli_query($real_sock,$check_sql);


//전세
$check_sql = "
		update rawdata_charter_apt set 
				Courtbuilding = REPLACE(Courtbuilding,'".$preregionName."','".$affregionName."')
		 where Courtbuilding Like '%".$preregionName."%';";

$check_res = mysqli_query($real_sock,$check_sql);
$check_sql = "
		update rawdata_charter_op set 
				Courtbuilding = REPLACE(Courtbuilding,'".$preregionName."','".$affregionName."')
		 where Courtbuilding Like '%".$preregionName."%';";

$check_res = mysqli_query($real_sock,$check_sql);
$check_sql = "
		update rawdata_charter_tenementhouse set 
				Courtbuilding = REPLACE(Courtbuilding,'".$preregionName."','".$affregionName."')
		 where Courtbuilding Like '%".$preregionName."%';";
$check_res = mysqli_query($real_sock,$check_sql);



//물건


$check_sql = "
		update invest_master set 
				Courtbuilding = REPLACE(Courtbuilding,'".$preregionName."','".$affregionName."')
		 where Courtbuilding Like '%".$preregionName."%';";
$check_res = mysqli_query($real_sock,$check_sql);


//법정동
$check_sql = "
		UPDATE region_code SET 
				regionName = REPLACE(regionName,'".$preregionName."','".$affregionName."'),
				printName = REPLACE(printName,'".$preregionName."','".$affregionName."')
		 where regionName Like '%".$preregionName."%';";
$check_res = mysqli_query($real_sock,$check_sql);
echo $check_sql ;


echo "<script>
		alert('수정 완료.');
		parent.location.replace('/BDP_ADMIN/admin_region/index_1.php');
	</script> ";





?>