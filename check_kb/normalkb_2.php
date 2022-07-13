<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');


$update_invest_master_sql = "
				update invest_master set 
					kbcheck = null, 
					kbinvestPrice = null, 
					kbTradeMin= null, 
					kbTradeMax= null, 
					kbRentRateMin= null, 
					kbRentRatenormal= null, 
					kbRentRateMax= null, 
					kbUpdateDate= null;";
$update_invest_master_res = mysqli_query($real_sock,$update_invest_master_sql);




$onland_sise_match_sql = "
CREATE TABLE `kbland`.`onland_sise_match` (
	`idx` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`oIDX` TEXT NOT NULL,
	`oType` TEXT NOT NULL,
	`oName` TEXT NOT NULL,
	`oAddr` TEXT NOT NULL,
	`newoAddr` VARCHAR(50) NOT NULL DEFAULT '',
	`Courtbuilding` VARCHAR(50) NOT NULL DEFAULT '',
	`buildingNumber` VARCHAR(50) NOT NULL DEFAULT '',
	`regionCode_full` VARCHAR(50) NOT NULL DEFAULT '',
	`oGongArea` TEXT NOT NULL,
	`oJeonArea` TEXT NOT NULL,
	`supplyArea` INT(11) NOT NULL DEFAULT '0',
	`exclusiveUseArea` INT(11) NOT NULL DEFAULT '0',
	`oPrice1` TEXT NOT NULL,
	`oPrice2` TEXT NOT NULL,
	`oPrice3` TEXT NOT NULL,
	`oPrice4` TEXT NOT NULL,
	`oPrice5` TEXT NOT NULL,
	`oPrice6` TEXT NOT NULL,
	`oPrice7` TEXT NOT NULL,
	`oPrice8` TEXT NOT NULL,
	`oReleaseDate` TEXT NOT NULL,
	PRIMARY KEY (`idx`),
	INDEX `searchfinder` (`buildingNumber`, `Courtbuilding`),
	INDEX `newoAddr` (`newoAddr`),
	INDEX `moolgun` (`buildingNumber`, `regionCode_full`, `exclusiveUseArea`)
)
 COLLATE 'euckr_korean_ci' ENGINE=InnoDB ROW_FORMAT=Dynamic AUTO_INCREMENT=537987;

";
$onland_sise_match_sql_res = mysqli_query($real_sock,$onland_sise_match_sql);



$onland_sise_match_sql = "ALTER TABLE kbland.onland_sise_match
		ADD UNIQUE INDEX `uniqueKey` (`regionCode_full`, `exclusiveUseArea`, `buildingNumber`);";

$onland_sise_match_sql_res = mysqli_query($real_sock,$onland_sise_match_sql);

$sql	 = "insert into kbland.onland_sise_match(idx,oIDX,oType,oName,oAddr,newoAddr,Courtbuilding,buildingNumber,regionCode_full,
									oGongArea,oJeonArea,supplyArea,exclusiveUseArea,oPrice1,oPrice2,oPrice3,oPrice4,oPrice5,oPrice6,oPrice7,oPrice8,oReleaseDate)
			select max(idx),oIDX,oType,oName,oAddr,newoAddr,Courtbuilding,buildingNumber,regionCode_full,
									oGongArea,oJeonArea,supplyArea,exclusiveUseArea,oPrice1,oPrice2,oPrice3,oPrice4,oPrice5,oPrice6,oPrice7,oPrice8,oReleaseDate
			from kbland.onland_sise 
			group by buildingNumber,regionCode_full,exclusiveUseArea
			order by idx DESC;";
$res	=  mysqli_query($real_sock,$sql) or die(mysqli_error($real_sock));

$sql	 = "	update kbland.onland_sise_match as a
					join  kbland.onland_sise as b
				on a.idx = b.idx  set 
				a.oIDX					= b.oIDX,
				a.oType					= b.oType,
				a.oName					= b.oName,
				a.oAddr					= b.oAddr,
				a.newoAddr				= b.newoAddr,
				a.Courtbuilding			= b.Courtbuilding,
				a.buildingNumber		= b.buildingNumber,
				a.regionCode_full		= b.regionCode_full,
				a.oGongArea				= b.oGongArea,
				a.oJeonArea				= b.oJeonArea,
				a.supplyArea			= b.supplyArea,
				a.exclusiveUseArea		= b.exclusiveUseArea,
				a.oPrice1				= b.oPrice1,
				a.oPrice2				= b.oPrice2,
				a.oPrice3				= b.oPrice3,
				a.oPrice4				= b.oPrice4,
				a.oPrice5				= b.oPrice5,
				a.oPrice6				= b.oPrice6,
				a.oPrice7				= b.oPrice7,
				a.oPrice8				= b.oPrice8,
				a.oReleaseDate			= b.oReleaseDate
					;";
$res	=  mysqli_query($real_sock,$sql) or die(mysqli_error($real_sock));

?>

해당 페이지에서 작업 <p>
1. kb 데이터 매칭 준비(기존 매칭된 데이터 null 처리후 다시 매칭)<br>
2. oReleaseDate 오래된 순으로 정렬하여 새로운 테이블 만듬.( 물건1의 시세 정보가 11일 21일에 있으면 21일로 업데이트 ==> 최신 정보 반영)<br>

<br><p><br>
다음 버튼 클릭 해서 다음 작업 진행해야 함. (kb 정보 매칭 시간 오래 걸림)
<br><p><br>

<a href = 'normalkb_3.php' >다음</a>