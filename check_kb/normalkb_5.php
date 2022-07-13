<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');




$sql = "
	update invest_master as a
		Join kbland.naverland_danji as b
	on  a.buildingNumber = b.buildingNumber
	and a.Courtbuilding  = b.Courtbuilding
	SET finderType = 'do'

	where b.oName LIKE '%(도시형)%'
	
;";
$res = mysqli_query($real_sock,$sql);




$sql = "truncate rawdata_charter_do;";
$res = mysqli_query($real_sock,$sql);
$sql = "truncate rawdata_trade_do;";
$res = mysqli_query($real_sock,$sql);








?>

해당 페이지에서 작업 <p>
1. 도생 찾기<br>
2. 도생 실거래 데이터 지우기<br>
<br><p><br>
다음 버튼 클릭 해서 다음 작업 진행해야 함. (도시형으로 바꾸기)
<br><p><br>

<a href = 'normalkb_6.php' >다음</a>





