<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');
$today_time = date("Y-m-d");
$now = date("Y-m-d H:i:s");



$sql = " 
	SELECT COUNT(idx) AS cnt,roadName ,max(new_y_point) as new_y_points,new_x_point
	FROM invest_master
	WHERE  roadName IS NOT null
	and new_y_point is not null
	 GROUP BY roadName
	 
	 HAVING(cnt>1) ORDER BY cnt DESC;

		 ;

	 ;";

$res = mysqli_query($real_sock,$sql);
while($info = mysqli_fetch_array($res)){
	
	$new_y_point = $info['new_y_points'];
	$new_x_point = $info['new_x_point'];
	$check = 0;
	$search_sql = " 
		SELECT idx from invest_master where roadName= '".$info['roadName']."';
	 ;";

	$search_res = mysqli_query($real_sock,$search_sql);
	while($search_info = mysqli_fetch_array($search_res)){

		$new_y_point =$new_y_point+$check;
		$check -= 0.0002;
		$update_sql = " 
			update invest_master set 
				new_x_point = '".$new_x_point."',
				new_y_point = '".$new_y_point."',
				x_point = '".$new_x_point."',
				y_point = '".$new_y_point."',
				location = point(".$new_x_point.",".$new_y_point.")
			where idx= '".$search_info['idx']."'
		 ;";

		$update_res = mysqli_query($real_sock,$update_sql);
	}



}




$sql = " truncate rawdata_charter_do;";

$res = mysqli_query($real_sock,$sql);

$sql = " truncate rawdata_trade_do;";

$res = mysqli_query($real_sock,$sql);


?>






해당 페이지에서 작업 <p>
1. 위경도 밀기 <br>
2. 도로명이 겹치는거 경도 0.0002씩 밀기
<br><p><br>
다음 버튼 클릭 해서 다음 작업 진행해야 함. <br>
※ 도생 테이블 비웠음. 완료까지 작업이 완료 되어야 함. 
<br><p><br>
