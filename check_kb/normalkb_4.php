<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');





$naver_sql = "select a.oAmount,a.oYongjuk,a.oHeating,a.oFuel,a.oYongjuk,a.oGunpe,a.oTotalParking,a.oParkingPerHouse,a.oBuiltDate,a.oHigher,a.buildingNumber,a.regionCode_full,a.oType
					from kbland.naverland_danji as a
						Join invest_master as b 
					on  a.buildingNumber = b.buildingNumber
					and a.regionCode_full = b.regionCode_full;";
$naver_res = mysqli_query($real_sock,$naver_sql);
while($naver_info = mysqli_fetch_array($naver_res)){	
	$temp_hhldCnt = explode("세대 (임대 ",$naver_info['oAmount']);
	if(count($temp_hhldCnt)==1){
		$hhldCnt = str_replace('세대','',$temp_hhldCnt[0]);
		$hldCnt = Null;
	}
	else{
		$hhldCnt = $temp_hhldCnt[0];
		$hldCnt = str_replace('세대 포함)','',$temp_hhldCnt[1]);
	}
	$oYongjuk = str_replace('%','',$naver_info['oYongjuk']);
	$codeHeatNm = $naver_info['oHeating'];
	if($naver_info['oFuel']!= Null or $naver_info['oFuel']!=''){
		$codeHeatNm = $naver_info['oHeating']."(".$naver_info['oFuel'].")";	
	}
	$oYongjuk = str_replace('%','',$naver_info['oYongjuk']);
	$oGunpe = str_replace('%','',$naver_info['oGunpe']);

	$totPkngCnt = str_replace('대','',$naver_info['oTotalParking']);
	$totPkngCntforv = str_replace('대','',$naver_info['oParkingPerHouse']);
	$crtnDay = str_replace('년 ','',$naver_info['oBuiltDate']);
	$crtnDay = str_replace('월','',$crtnDay);
	$highfloor = $naver_info['oHigher'];
	$highfloor = str_replace('층','',$naver_info['oHigher']);


	$crtnDay = str_replace('월','',$crtnDay);
	$invest_master_sql = "SELECT idx from invest_master where regionCode_full ='".$naver_info ['regionCode_full']."' and buildingNumber = '".$naver_info ['buildingNumber']."';";
	$invest_master_res = mysqli_query($real_sock,$invest_master_sql);
	while($invest_master_info = mysqli_fetch_array($invest_master_res)){



		$insert_sql = "insert invest_master_detail set 
					idx			= '".$invest_master_info['idx']."',
					codeAptNm	= '".$naver_info['oType']."',
					crtnDay		= '".$crtnDay."',
					hhldCnt		= '".$hhldCnt."',
					hldcnt		= '".$hldCnt."',
					vlRat		= '".$oYongjuk."',
					highfloor	= '".$highfloor."',						
					codeHeatNm	= '".$codeHeatNm."',
					bcRat		= '".$oGunpe."',
					totPkngCnt	= '".$totPkngCnt."',
					totPkngCntforv	= '".$totPkngCntforv."'
		;";
		$insert_res = mysqli_query($real_sock,$insert_sql);
	

	}
}




$naver_sql = "select a.oAmount,a.oYongjuk,a.oHeating,a.oYongjuk,a.oGunpe,a.oTotalParking,a.oParkingPerHouse,a.oBuiltDate,a.buildingNumber,a.regionCode_full,a.oType
					from kbland.onland_danji as a
						Join invest_master as b 
					on  a.buildingNumber = b.buildingNumber
					and a.regionCode_full = b.regionCode_full;";
$naver_res = mysqli_query($real_sock,$naver_sql);
while($naver_info = mysqli_fetch_array($naver_res)){	
	$temp_hhldCnt = explode("세대 (임대 ",$naver_info['oAmount']);
	if(count($temp_hhldCnt)==1){
		$hhldCnt = str_replace('세대','',$temp_hhldCnt[0]);
		$hldCnt = Null;
	}
	else{
		$hhldCnt = $temp_hhldCnt[0];
		$hldCnt = str_replace('세대 포함)','',$temp_hhldCnt[1]);
	}
	$oYongjuk = str_replace('%','',$naver_info['oYongjuk']);
	$codeHeatNm = $naver_info['oHeating'];

	$oYongjuk = str_replace('%','',$naver_info['oYongjuk']);
	$oGunpe = str_replace('%','',$naver_info['oGunpe']);

	$totPkngCnt = str_replace('대','',$naver_info['oTotalParking']);
	$totPkngCntforv = str_replace('대','',$naver_info['oParkingPerHouse']);
	$crtnDay = str_replace('년 ','',$naver_info['oBuiltDate']);
	$crtnDay = str_replace('월','',$crtnDay);



	$crtnDay = str_replace('월','',$crtnDay);
	$invest_master_sql = "SELECT idx from invest_master where regionCode_full ='".$naver_info ['regionCode_full']."' and buildingNumber = '".$naver_info ['buildingNumber']."';";
	$invest_master_res = mysqli_query($real_sock,$invest_master_sql);
	while($invest_master_info = mysqli_fetch_array($invest_master_res)){



		$insert_sql = "insert invest_master_detail set 
					idx			= '".$invest_master_info['idx']."',
					codeAptNm	= '".$naver_info['oType']."',
					crtnDay		= '".$crtnDay."',
					hhldCnt		= '".$hhldCnt."',
					hldcnt		= '".$hldCnt."',
					vlRat		= '".$oYongjuk."',
					
					codeHeatNm	= '".$codeHeatNm."',
					bcRat		= '".$oGunpe."',
					totPkngCnt	= '".$totPkngCnt."',
					totPkngCntforv	= '".$totPkngCntforv."'
		;";
		$insert_res = mysqli_query($real_sock,$insert_sql);


	}
}














?>

해당 페이지에서 작업 <p>
1. 단지 상세 정보 생성<br>
<br><p><br>
다음 버튼 클릭 해서 다음 작업 진행해야 함. (도시형으로 바꾸기)
<br><p><br>

<a href = 'normalkb_5.php' >다음</a>


