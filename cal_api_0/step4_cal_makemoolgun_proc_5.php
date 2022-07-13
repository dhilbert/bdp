<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');







$sql = " 
	SELECT COUNT(idx) AS cnt,roadName ,max(new_y_point) as new_y_points,new_x_point
	FROM invest_master
	WHERE  roadName IS NOT null
	and new_y_point is not null
	AND printCheck =1
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
		SELECT idx from invest_master where roadName= '".$info['roadName']."'
			AND printCheck =1
		;
	 ;";

	$search_res = mysqli_query($real_sock,$search_sql);
	while($search_info = mysqli_fetch_array($search_res)){

		$new_y_point =$new_y_point+$check;
		$check -= 0.0002;
		$update_sql = " 
			update invest_master set 
				new_x_point = '".$new_x_point."',
				new_y_point = '".$new_y_point."',
				
				location = point(".$new_x_point.",".$new_y_point.")
			where idx= '".$search_info['idx']."'
		 ;";

		$update_res = mysqli_query($real_sock,$update_sql);
	}



}


echo "<script>
		alert('아이콘 정제 완료');
		parent.location.replace('/BDP_ADMIN/cal_api_0/community_main.php');
</script> ";


?>