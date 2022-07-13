<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');





$truncate_sql = " truncate region_code_detail";
$truncate_res = mysqli_query($real_sock,$truncate_sql);

$truncate_sql = " truncate region_code_detail_temp_00";
$truncate_res = mysqli_query($real_sock,$truncate_sql);

$truncate_sql = " truncate region_code_detail_temp_01";
$truncate_res = mysqli_query($real_sock,$truncate_sql);

$truncate_sql = " truncate region_code_detail_temp_10";
$truncate_res = mysqli_query($real_sock,$truncate_sql);

$truncate_sql = " truncate region_code_detail_temp_11";
$truncate_res = mysqli_query($real_sock,$truncate_sql);





$minmax_dateforC = isset($_GET['minmax_dateforC'])	 ? $_GET['minmax_dateforC'] : 10;
$minmax_dateforT = isset($_GET['minmax_dateforT'])	 ? $_GET['minmax_dateforT'] : 10;
$temp_1 = $minmax_dateforC*365;
$temp_2 =  $minmax_dateforT*365;

$update_sql = "
			update admin_Setting set 
					minmax_dateforC = '".$temp_1."',
					minmax_dateforT= '".$temp_2."'

";
$update_res = mysqli_query($real_sock,$update_sql);



?>

해당 페이지에서 작업 <p>
1. 최고가 최저가 테이블 초기화 <br>

<br><p><br>
다음 버튼 클릭 해서 다음 작업 진행해야 함.
<br><p><br>



<a href = '/BDP_ADMIN/cal_api_1/33331.php' >최고가 최저가 구하기 </a>





