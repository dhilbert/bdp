<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');
$today_time = date("Y-m-d");
$now = date("Y-m-d H:i:s");
$table_names = array('rawdata_charter_op','rawdata_charter_apt','rawdata_charter_tenementhouse','rawdata_trade_apt','rawdata_trade_op','rawdata_trade_tenementhouse');  // 다가구 제외
$names = array('op','apt','bil','apt','op','bil');  // 다가구 제외



/* 물건 만들기 법정동 코드, 번지, 평형을 기준으로 새로운 문건 만들기 */

for($i=0;$i < count($table_names);$i++){
	$table = $table_names[$i];
	$type = $names[$i];
	$search_sql = "
		INSERT INTO  invest_master(finderType,prefinderType,stateAreaCode,AreaCode,buildingName,exclusiveUseArea,regionCode_full,Courtbuilding,buildingNumber,BuildYear,regdatetime)
			SELECT '".$type."','".$type."',a.stateAreaCode,a.AreaCode,a.buildingName,a.exclusiveUseArea,a.regionCode_full,a.Courtbuilding,a.buildingNumber,a.BuildYear,'".$now."'
					FROM ".$table." AS a
						Left JOIN invest_master AS b
					ON a.regionCode_full= b.regionCode_full
					AND a.buildingNumber	= b.buildingNumber
					AND a.exclusiveUseArea	= b.exclusiveUseArea
			WHERE b.idx is null 
			and a.buildingNumber != ''
			GROUP BY a.regionCode_full,a.buildingNumber,a.exclusiveUseArea";
	$search_res = mysqli_query($real_sock,$search_sql);

}
$search_sql = "
		update  invest_master AS a set 
			a.roadName = (
				select 
				if(b.col13=0,concat(b.col2,' ',b.col3,' ',b.col10,' ',b.col12),concat(b.col2,' ',b.col3,' ',b.col10,' ',b.col12,'-',b.col13))
				from roadname.searchroadname as b where b.regionCode_full = a.regionCode_full
				and b.buildingNumber = a.buildingNumber
				lIMIT 1				
			),
			a.sicheck = floor(a.AreaCode/10),
			a.myuncheck = floor(a.regionCode_full/100)";
$search_res = mysqli_query($real_sock,$search_sql);
?>



해당 페이지에서 작업 <p>
1. 실거래 데이터와 물건 데이터를 비교하여, 없는 물건 찾아 물건 테이블에 넣기(기준 : 평형, 법정동 코드, 번지로 구분)<br>
2. 도로명 주소 만들기(http://www.juso.go.kr/openIndexPage.do 에서 제공하는 데이터 이용, 해당 정보 roadname.searchroadname 테이블에서 관리 ) <br>
2-1. 도로명 주소는 할때 마다 업데이트
<br><p><br>
다음 버튼 클릭 해서 다음 작업 진행해야 함. 
<br><p><br>

<a href = 'STEP3_cal_makemoolgun_proc_1.php' >다음</a>