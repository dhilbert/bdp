<?php

include_once('../lib/dbcon_bdp.php');









$sql	 = "select * from member_invest_range;";
$res	=  mysqli_query($real_sock,$sql) or die(mysqli_error($real_sock));

while($info	 = mysqli_fetch_array($res)){

	$rangemin	=	$info['rangemin'];
	$rangemax	=	$info['rangemax'];
		
	$update_sql = "update member_invest_range set 
			rangemin	= '".$rangemin."',
			rangemax	= '".$rangemax."',
			totalCount	= (select count(*) from invest_master where investPrice<= '".$rangemax."' ),
			etcCount	= (select count(*) from invest_master where investPrice<= '".$rangemax."' and stateAreaCode in (11000,28000,41000))
			where 	rangemin	= '".$rangemin."'
			and		rangemax	= '".$rangemax."'
			;";


	$update_res = mysqli_query($real_sock,$update_sql);
}


echo "<script>
			alert('계산 완료 ');
			parent.location.replace('/BDP_ADMIN/cal_api_1/community_main.php');
</script> ";



?>