<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');


$selestadmin_setting_sql = " 
	update invest_master set 
		printCheck = 1
	where (maxDealtradedate != '1900-01-01' or maxDealcharterdate != '1900-01-01') and (kbcheck = 1 or investPrice != 0)
";
$selestadmin_setting__res = mysqli_query($real_sock,$selestadmin_setting_sql);












?>


해당 페이지에서 작업 <p>
1. 물건 출력하는거 분류 <br>

<br><p><br>
다음 버튼 클릭 해서 다음 작업 진행해야 함.
<br><p><br>



<a href = '/BDP_ADMIN/cal_api_0/step4_cal_makemoolgun_proc_5.php' >아이콘 밀기 </a>






