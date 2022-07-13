<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');


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



$truncate_sql = "truncate invest_master_detail  ;";
$truncate_res = mysqli_query($real_sock,$truncate_sql);

?>

해당 페이지에서 작업 <p>
1. kb 데이터 매칭<br>
2. 단지 정보 초기화, 다음 액션 무조건 진행해야 함. <br>
<br><p><br>
다음 버튼 클릭 해서 다음 작업 진행해야 함. (단지 상세 정보 만들기 시간 오래 걸림)
<br><p><br>

<a href = 'normalkb_4.php' >다음</a>