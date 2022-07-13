<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');

// oName LIKE '%(도시형)%' and
//도생 찾기 



//네이버
$naver_sql = "select * from kbland.naverland_danji;";
$naver_res = mysqli_query($real_sock,$naver_sql);
while($naver_info = mysqli_fetch_array($naver_res)){


	

	$temp_juso =  explode(" ",$naver_info['oAddr']);

	$jibun = $temp_juso[count($temp_juso)-1];
	$juso = '';

	for($i = count($temp_juso)-2 ; $i>count($temp_juso)-4 ;$i-- ){
		$juso =	$temp_juso[$i]." ".$juso;
	}
	$juso =	trim($juso);

	
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
	$invest_master_sql = "SELECT idx from invest_master where Courtbuilding Like '%".$juso."%' and buildingNumber = '".$jibun."';";

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
		echo 	$insert_sql;
	}

}

//kb
$naver_sql = "select * from kbland.onland_danji;";
$naver_res = mysqli_query($real_sock,$naver_sql);
while($naver_info = mysqli_fetch_array($naver_res)){


	

	$temp_juso =  explode(" ",$naver_info['oAddr']);
	$jibun = $temp_juso[count($temp_juso)-1];
	$juso = '';
	for($i = count($temp_juso)-2 ; $i>count($temp_juso)-4 ;$i-- ){
		$juso =	$temp_juso[$i]." ".$juso;
	}
	$juso =	trim($juso);

	$hhldCnt = $naver_info['oAmount'];
	$oYongjuk = str_replace('%','',$naver_info['oYongjuk']);
	$codeHeatNm = $naver_info['oHeating'];
	$oYongjuk = str_replace('%','',$naver_info['oYongjuk']);
	$oGunpe = str_replace('%','',$naver_info['oGunpe']);
	$totPkngCnt = str_replace('대','',$naver_info['oTotalParking']);
	$totPkngCntforv = str_replace('대','',$naver_info['oParkingPerHouse']);
	$crtnDay = str_replace('.','',$naver_info['oBuiltDate']);
	$invest_master_sql = "SELECT idx from invest_master where Courtbuilding Like '%".$juso."%' and buildingNumber = '".$jibun."';";
	$invest_master_res = mysqli_query($real_sock,$invest_master_sql);
	while($invest_master_info = mysqli_fetch_array($invest_master_res)){
			$insert_sql = "insert invest_master_detail set 
						idx			= '".$invest_master_info['idx']."',
						codeAptNm	= '".$naver_info['oType']."',
						crtnDay		= '".$crtnDay."',						
						hhldCnt		= '".$hhldCnt."',
						vlRat		= '".$oYongjuk."',
						codeHeatNm	= '".$codeHeatNm."',
						bcRat		= '".$oGunpe."',
						totPkngCnt	= '".$totPkngCnt."',
						totPkngCntforv	= '".$totPkngCntforv."'
			;";
			$insert_res = mysqli_query($real_sock,$insert_sql);
	
	}

}















/*

$onland_sise_sql = " 
	SELECT * from kbland.onland_sise;";
$onland_sise_res = mysqli_query($real_sock,$onland_sise_sql);
while($onland_sise_info = mysqli_fetch_array($onland_sise_res)){

	$temp_juso =  explode(" ",$onland_sise_info['oAddr']);
	$jibun = $temp_juso[count($temp_juso)-1];
	$juso = '';
	for($i = count($temp_juso)-2 ; $i>count($temp_juso)-4 ;$i-- ){
		$juso =	$temp_juso[$i]." ".$juso;
	}
	$juso =	trim($juso);

	$kbinvestPrice		= $onland_sise_info['oPrice2'] - $onland_sise_info['oPrice5'];
	$kbTradeMin			= $onland_sise_info['oPrice1'];
	$kbTradeMax			= $onland_sise_info['oPrice3'];
	$kbRentRateMin		= $onland_sise_info['oPrice4']/$onland_sise_info['oPrice2'];
	$kbRentRatenormal	= $onland_sise_info['oPrice5']/$onland_sise_info['oPrice2'];
	$kbRentRateMax		= $onland_sise_info['oPrice6']/$onland_sise_info['oPrice2'];
	$kbUpdateDate		= $onland_sise_info['oReleaseDate'];
	$invest_master_sql = " 
			update invest_master set 
				kbcheck = 1,
				kbinvestPrice = ".$kbinvestPrice.",
				kbTradeMin = ".$kbTradeMin.",
				kbTradeMax = ".$kbTradeMax.",
				kbRentRateMin = ".$kbRentRateMin.",
				kbRentRateMax	= ".$kbRentRateMax.",
				kbRentRatenormal= ".$kbRentRatenormal.",
				kbUpdateDate = '".$kbUpdateDate."'
			where Courtbuilding Like '%".$juso."%' and buildingNumber = '".$jibun."' and exclusiveUseArea = '".$onland_sise_info['exclusiveUseArea']."';";
	$invest_master_res = mysqli_query($real_sock,$invest_master_sql);
}





/*

$naver_sql = "select * from kbland.onland_danji where oName Like '%(도시형)%';";
$naver_res = mysqli_query($real_sock,$naver_sql);
while($naver_info = mysqli_fetch_array($naver_res)){
	$temp_juso =  explode(" ",$naver_info['oAddr']);

	$jibun = $temp_juso[count($temp_juso)-1];
	$juso = '';
	for($i = count($temp_juso)-2 ; $i>count($temp_juso)-4 ;$i-- ){
		$juso =	$temp_juso[$i]." ".$juso;
	}
	$juso =	trim($juso);


	$invest_master_sql = "SELECT * from invest_master where Courtbuilding Like '%".$juso."%' and buildingNumber = '".$jibun."';";
	$invest_master_res = mysqli_query($real_sock,$invest_master_sql);
	while($invest_master_info = mysqli_fetch_array($invest_master_res)){	


		$insert_sql = "insert kbland.maching set 
					checks = 1, 
					idx = '".$invest_master_info['idx']."'
		;";
		$insert_res = mysqli_query($real_sock,$insert_sql);
	}
}


*/













?>