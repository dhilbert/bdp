<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');



$table_names = array('naverland_danji','naverland_sise','onland_danji','onland_sise','onland_sise2');
$table_names = array('naverland_danji','onland_danji','onland_sise','onland_sise2');

$naver_names = array('naverland_danji','naverland_sise');
$naver_names = array('naverland_danji');


$sise_names    = array('naverland_sise','onland_sise','onland_sise2');
$sise_names    = array('onland_sise','onland_sise2');

$kb_names    = array('onland_danji','onland_sise','onland_sise2');



for($i = 0 ; $i < count($table_names) ; $i ++){
	$tablename = $table_names[$i];
	$ALter_sql = "
			ALTER TABLE kbland.".$tablename."
				ADD COLUMN `newoAddr` VARCHAR(50) NOT NULL DEFAULT '' AFTER `oAddr`,
				ADD COLUMN `Courtbuilding` VARCHAR(50) NOT NULL DEFAULT '' AFTER `newoAddr`,
				ADD COLUMN `buildingNumber` VARCHAR(50) NOT NULL DEFAULT '' AFTER `Courtbuilding`,
				ADD COLUMN `regionCode_full` VARCHAR(50) NOT NULL DEFAULT '' AFTER `buildingNumber`,
				ADD INDEX `searchfinder` (`buildingNumber`,`Courtbuilding`),
				ADD INDEX `newoAddr` (`newoAddr`)
				;";
	
	$ALter_res = mysqli_query($real_sock,$ALter_sql);
	$insert_newoAddr_sql = "
		update kbland.".$tablename." set 
				newoAddr = oAddr;
			;";

	$insert_newoAddr_res = mysqli_query($real_sock,$insert_newoAddr_sql);
}

for($i = 0 ; $i < count($sise_names) ; $i ++){
	$tablename = $sise_names[$i];
	$ALter_sql = "
			ALTER TABLE kbland.".$tablename."
				ADD INDEX `moolgun` (`buildingNumber`,`regionCode_full`,`exclusiveUseArea`)
				;";

	$ALter_res = mysqli_query($real_sock,$ALter_sql);
}









?>


해당 페이지에서 작업 <p>
1. 크롤링 데이터의 인덱스 부여 및 매칭할 데이터의 1차 표준화 <br>
<br><p><br>
다음 버튼 클릭 해서 다음 작업 진행해야 함. 
<br><p><br>

<a href = 'normalkb_1.php' >다음</a>