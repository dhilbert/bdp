<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');




$TargetDate = isset($_GET['TargetDate'])	 ? $_GET['TargetDate'] : Null;
$compareDate = isset($_GET['compareDate'])	 ? $_GET['compareDate'] : Null;





$DealYear = date('Y');

$DealMonth = date('m');
$weeknum = date('W',strtotime($DealYear.'-'.$DealMonth.'-01')); 
$kind = 1;

$now = date("Y-m-d");
$pre_now = date("Y-m-d", strtotime("-7 day", time()));


$DealYear = date('Y');
$DealMonth = date('m');

$pre_DealYear = explode('-',$pre_now )[0];
$pre_DealMonth = explode('-',$pre_now )[1];


$weeknum = date('W',strtotime($now)); 
$pre_weeknum = date('W',strtotime($pre_now)); 

$now = date("Y-m-d H:i:s");

$ALter_sql = "
		ALTER TABLE kbland.onland_sise
			ADD COLUMN `Courtbuilding` VARCHAR(50) NOT NULL DEFAULT '' AFTER `oAddr`,
			ADD COLUMN `buildingNumber` VARCHAR(50) NOT NULL DEFAULT '' AFTER `Courtbuilding`,
			ADD COLUMN `regionCode_full` VARCHAR(50) NOT NULL DEFAULT '' AFTER `buildingNumber`,
			ADD COLUMN sil INT(11) NOT NULL DEFAULT '0' AFTER `regionCode_full`;
			
			;";

$ALter_res = mysqli_query($real_sock,$ALter_sql);

$update_sql = "ALTER TABLE kbland.onland_sise
	CHANGE COLUMN `oAddr` `oAddr` VARCHAR(255) NOT NULL DEFAULT '' AFTER `oName`;";
$update_res = mysqli_query($real_sock,$update_sql);







$update_sql = "ALTER TABLE kbland.onland_sise
	ADD INDEX `oAddr` (`oAddr`),
	ADD INDEX `Courtbuilding` (`Courtbuilding`, `buildingNumber`, `exclusiveUseArea`);";
$update_res = mysqli_query($real_sock,$update_sql);












// 주소 정보 정제 
$update_sql = "
		update kbland.onland_sise set 
			oAddr = REPLACE(oAddr, '세종특별자치시 세종특별자치시', '세종특별자치시')
		where oAddr Like '%세종특별자치시 세종특별자치시%'
;";
$update_res = mysqli_query($real_sock,$update_sql);

$sql = "update 
			kbland.onland_sise set 
				oAddr = TRIM(trim(SUBSTRING_INDEX(oAddr, '생활권', 1)))
			where oAddr LIKE '%생활권%' ;";
$res = mysqli_query($real_sock,$sql);
$update_sql = "
		update kbland.onland_sise set 
			oAddr = TRIM(REPLACE(oAddr, '행정중심복합도시', ''))
		where oAddr Like '%행정중심복합도시%';";
$update_res = mysqli_query($real_sock,$update_sql);

//주소 분리 및 평형 분리 
$sql = "update kbland.onland_sise set 
			Courtbuilding =  trim(REPLACE(oAddr,     SUBSTRING_INDEX(oAddr, ' ', -1), '')),
			buildingNumber = SUBSTRING_INDEX(oAddr, ' ', -1),
			exclusiveUseArea = floor(oJeonArea/3.3),
			sil =  oPrice2 - oPrice5,
			oReleaseDate = CONCAT(SUBSTRING(oReleaseDate,1, 4),'-',SUBSTRING(oReleaseDate,6, 2),'-',SUBSTRING(oReleaseDate,9, 2))

			;";
$res = mysqli_query($real_sock,$sql);



$sql = "
	update kbland.onland_sise AS a SET 
	a.regionCode_full = (select regionCode_full from bdp_real.region_code where regionName = a.Courtbuilding ) 
where EXISTS (select regionCode_full from bdp_real.region_code where regionName = a.Courtbuilding)
	";
$res = mysqli_query($real_sock,$sql);



$sql = "
ALTER TABLE  kbland.onland_sise
	CHANGE COLUMN `oReleaseDate` `oReleaseDate` DATE NOT NULL AFTER `oPrice8`,

	ADD INDEX `oReleaseDate` (`oReleaseDate`),
	ADD INDEX `moolgun` (`buildingNumber`, `regionCode_full`, `exclusiveUseArea`);
	";
$res = mysqli_query($real_sock,$sql);




$insert_sql = "INSERT INTO invest_master_weekly(
					investmaster_idx,DealYear,DealMonth,weeknum,kind,StateValue,rank,finderType,updateDate,diff,BuildYear,
					exclusiveUseArea,buildingName

				)
				VALUES ";

$sql = "
SELECT 
c.idx,(b.oPrice2-a.oPrice2) AS diff,b.oPrice2 as StateValue,c.buildingName,c.exclusiveUseArea,c.finderType,c.BuildYear
	
	FROM (SELECT buildingNumber,regionCode_full,exclusiveUseArea,AVG(sil) AS cal,oPrice2 from kbland.onland_sise
		 WHERE oReleaseDate = '".$compareDate."'
	 AND regionCode_full !=''
	 GROUP BY buildingNumber ,regionCode_full, exclusiveUseArea
	
	
	) AS a
		JOIN (SELECT buildingNumber,regionCode_full,exclusiveUseArea,AVG(sil) AS cal,oPrice2 from kbland.onland_sise
				 WHERE oReleaseDate = '".$TargetDate."'
			 AND regionCode_full !=''
	 GROUP BY buildingNumber ,regionCode_full, exclusiveUseArea			 
		) AS b

	ON a.buildingNumber = b.buildingNumber
	AND a.regionCode_full = b.regionCode_full
	AND a.exclusiveUseArea = b.exclusiveUseArea
	Join bdp_real.invest_master AS c 
		ON a.buildingNumber = c.buildingNumber
		AND a.regionCode_full = c.regionCode_full
		AND a.exclusiveUseArea = c.exclusiveUseArea
ORDER BY diff DESC ,b.oPrice2 DESC
LIMIT 500
	";
$res = mysqli_query($real_sock,$sql);
$rank = 1;

while($info = mysqli_fetch_array($res)){

	
	$insert_sql = $insert_sql."('".$info['idx']."','".$DealYear."','".$DealMonth."','".$weeknum."','".$kind."','".$info['StateValue']."','".$rank."','".$info['finderType']."','".$now."','".$info['diff']."','".$info['BuildYear']."','".$info['exclusiveUseArea']."','".$info['buildingName']."'),";
	
	$rank+=1;



}echo $insert_sql;
$insert_sql=substr($insert_sql, 0, -1);
$insert_res = mysqli_query($real_sock,$insert_sql);











$sql = "
SELECT (nowt.rank - pret.rank) AS diffrank,nowt.idx from 
(select rank,investmaster_idx,idx from invest_master_weekly
where DealYear= '".$pre_DealYear."' and DealMonth= '".$pre_DealMonth."' and weeknum = '".$pre_weeknum."' and kind = 1 ) AS pret 
JOIN (select rank,investmaster_idx,idx from invest_master_weekly
where DealYear= '".$DealYear."' and DealMonth= '".$DealMonth."' and weeknum = '".$weeknum."' and kind = 1 ) AS nowt
 ON pret.investmaster_idx = nowt.investmaster_idx;";

$res = mysqli_query($real_sock,$sql);
while($info = mysqli_fetch_array($res)){

	$update_sql = "
			update invest_master_weekly set prevRank = '".$info['diffrank']."' where idx ='".$info['idx']."'

		;";
	$update_res = mysqli_query($real_sock,$update_sql);


}








echo "<script>
		alert(' 통계 완료');
		parent.location.replace('/BDP_ADMIN/admin_state/community_main1.php');
	</script> ";

?>