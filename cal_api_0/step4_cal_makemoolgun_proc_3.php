<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');
?>
<style>
.checks {position: relative;} .checks input[type="checkbox"] { /* 실제 체크박스는 화면에서 숨김 */ position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip:rect(0,0,0,0); border: 0 } .checks input[type="checkbox"] + label { display: inline-block; position: relative; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; } .checks input[type="checkbox"] + label:before { /* 가짜 체크박스 */ content: ' '; display: inline-block; width: 21px; /* 체크박스의 너비를 지정 */ height: 21px; /* 체크박스의 높이를 지정 */ line-height: 21px; /* 세로정렬을 위해 높이값과 일치 */ margin: -2px 8px 0 0; text-align: center; vertical-align: middle; background: #fafafa; border: 1px solid #cacece; border-radius : 3px; box-shadow: 0px 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05); } .checks input[type="checkbox"] + label:active:before, .checks input[type="checkbox"]:checked + label:active:before { box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px 1px 3px rgba(0,0,0,0.1); } .checks input[type="checkbox"]:checked + label:before { /* 체크박스를 체크했을때 */ content: '\2714'; /* 체크표시 유니코드 사용 */ color: #99a1a7; text-shadow: 1px 1px #fff; background: #ff0000; border-color: #adb8c0; box-shadow: 0px 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05), inset 15px 10px -12px rgba(255,255,255,0.1); }


		</style>


<?php

	$update_sql = "update invest_master as a 
						join kbland.onland_sise_match as c 
					on  a.regionCode_full = c.regionCode_full
					and	a.buildingNumber	=c.buildingNumber
					and	a.exclusiveUseArea = c.exclusiveUseArea
	set		a.kbcheck = 1,
			a.kbinvestPrice		= c.oPrice2 - c.oPrice5,
			a.kbTradeMin		= c.oPrice1,
			a.kbTradeMax		= c.oPrice3,
			a.kbRentRateMin		= c.oPrice4/c.oPrice2*100,
			a.kbRentRateMax		= c.oPrice6/c.oPrice2*100,
			a.kbRentRatenormal	= c.oPrice5/c.oPrice2*100,
			a.kbUpdateDate		= c.oReleaseDate
	where c.oPrice4 != '-'	
	AND  c.oPrice2 != 0
	
	
	;";
	$update_res = mysqli_query($real_sock,$update_sql);






















$range_sql = "select * from member_invest_range ;";
$range_res = mysqli_query($real_sock,$range_sql);
while($range_info	 = mysqli_fetch_array($range_res)){
	
	$update_sql = "update invest_master 
			set	investMoneyRange = ".$range_info['id']."
			where investPrice between ".$range_info['rangemin']." and ".$range_info['rangemax']."
			and investPrice!=0 
			and investPrice!=Null	;";
	$update_res = mysqli_query($real_sock,$update_sql);
	

	$update_sql = "update invest_master 
			set	investMoneyRange = ".$range_info['id']."
			where kbinvestPrice between ".$range_info['rangemin']." and ".$range_info['rangemax']."
			and kbinvestPrice!=0 
			and kbinvestPrice!=Null	;";
	$update_res = mysqli_query($real_sock,$update_sql);
	
}






?>

해당 페이지에서 작업 <p>
1. kb 데이터 매칭<br>
2. 단지 정보 초기화, 다음 액션 무조건 진행해야 함. <br>
3. 실투자금에 따른 아이콘 보여줄거 <br>
<br><p><br>
다음 버튼 클릭 해서 다음 작업 진행해야 함. (단지 상세 정보 만들기 시간 오래 걸림)
<br><p><br>



<a href = '/BDP_ADMIN/cal_api_0/step4_cal_makemoolgun_proc_4.php' >아이콘 표시(실투자금과 kb 정보가 존재하는 경우, 단 월세만 있는 경우는 제외) </a>






