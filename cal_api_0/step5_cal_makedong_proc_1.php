<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');

$updateDate  = date("Y-m-d H:i:s");


$selestadmin_setting_sql = "select imjang_state from admin_setting ";
$selestadmin_setting__res = mysqli_query($real_sock,$selestadmin_setting_sql);
$selestadmin_setting_info = mysqli_fetch_array($selestadmin_setting__res);
$imjang_state = $selestadmin_setting_info['imjang_state'];






// 마지막 거래 일자 찾기(최하위)
$naver_sql = "UPDATE region_code AS a SET 
	a.LastdealDateforTrade = (SELECT MAX(b.DealfullDate) FROM rawdata_trade_apt AS b WHERE b.regionCode_full=a.regionCode_full),
	a.LastdealDateforChater = (SELECT MAX(c.DealfullDate) FROM rawdata_charter_apt AS c WHERE c.regionCode_full=a.regionCode_full and c.Monthlyrent=0 )";
$naver_res = mysqli_query($real_sock,$naver_sql);


// 마지막 거래 일자 찾기(읍면)
$naver_sql = "UPDATE region_code AS a SET 
	a.LastdealDateforTrade = (SELECT MAX(b.DealfullDate) FROM rawdata_trade_apt AS b WHERE b.myuncheck=floor(a.regionCode_full/100)),
	a.LastdealDateforChater = (SELECT MAX(c.DealfullDate) FROM rawdata_charter_apt AS c WHERE c.myuncheck=floor(a.regionCode_full/100) and c.Monthlyrent=0
	) 
WHERE a.regionName LIKE '%면' or a.regionName LIKE '%읍'


	
	";
$naver_res = mysqli_query($real_sock,$naver_sql);




// 마지막 거래 일자 찾기(구 단위 )
$naver_sql = "UPDATE region_code AS a SET 
	a.LastdealDateforTrade = (SELECT MAX(b.DealfullDate) FROM rawdata_trade_apt AS b WHERE b.areaCode=a.areaCode),
	a.LastdealDateforChater = (SELECT MAX(c.DealfullDate) FROM rawdata_charter_apt AS c WHERE c.areaCode=a.areaCode and c.Monthlyrent=0)
WHERE a.regionCode_full/100000 = a.areaCode AND a.areaCode != a.stateAreaCode	
	
	";
$naver_res = mysqli_query($real_sock,$naver_sql);



// 마지막 거래 일자 찾기(작은 시 )


$naver_sql = "UPDATE region_code AS a SET 
	a.LastdealDateforTrade = (SELECT MAX(b.DealfullDate) FROM rawdata_trade_apt AS b WHERE b.sicheck=a.sicheck),
	a.LastdealDateforChater = (SELECT MAX(c.DealfullDate) FROM rawdata_charter_apt AS c WHERE c.sicheck=a.sicheck and c.Monthlyrent=0)
WHERE a.regionName LIKE '%시' AND a.areaCode != a.stateAreaCode


	
	";
$naver_res = mysqli_query($real_sock,$naver_sql);




// 마지막 거래 일자 찾기(큰시 )
$naver_sql = "UPDATE region_code AS a SET 
	a.LastdealDateforTrade = (SELECT MAX(b.DealfullDate) FROM rawdata_trade_apt AS b WHERE b.stateAreaCode=a.stateAreaCode),
	a.LastdealDateforChater = (SELECT MAX(c.DealfullDate) FROM rawdata_charter_apt AS c WHERE c.stateAreaCode=a.stateAreaCode and c.Monthlyrent=0)
WHERE  a.areaCode = a.stateAreaCode	
	
	";
$naver_res = mysqli_query($real_sock,$naver_sql);












?>

 <p> <p> <p>
해당 페이지에서 작업 <p>
1.지역의 최근 거래일 찾기  <br>


<br><p><br>
다음 버튼 클릭 해서 다음 작업 진행해야 함. 
<br><p><br>

<a href = '/BDP_ADMIN/cal_api_0/step5_cal_makedong_proc_2.php' >다음</a>
