<?php
include_once('lib/session.php');
include_once('lib/dbcon_bdp.php');




?>



<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- 메타 데이터 -->
<title>복덕판 시스템</title>
<meta name="description" content="" />
<meta name="author" content="복덕판 관리자 시스템" />


<link href="/BDP_ADMIN/css/bootstrap.min.css" rel="stylesheet">

<link href="/BDP_ADMIN/css/datepicker3.css" rel="stylesheet">
<link href="/BDP_ADMIN/css/styles.css" rel="stylesheet">


<link href="/BDP_ADMIN/css/bootstrap-table.css" rel="stylesheet">
<link href="/BDP_ADMIN/css/bootstrap-table.css" rel="stylesheet">

<script src="/BDP_ADMIN/js/lumino.glyphs.js"></script>

<script type="text/javascript" src="/BDP_ADMIN/js/loader.js"></script>

</head>






<?php


$admin_id = isset($_GET['admin_id']) ? $_GET['admin_id'] : 3;
$admin_pw = isset($_GET['admin_pw']) ? $_GET['admin_pw'] : 3;

$sql	 = "select * from admin_member where admin_id ='".$admin_id."';";
$res	=  mysqli_query($real_sock,$sql) or die(mysqli_error($real_sock));
$info	 = mysqli_fetch_array($res);


if($info==Null) {
		echo "<script>
				alert('아이디가 존재 하지 않습니다.');
				parent.location.replace('/BDP_ADMIN/');
			 </script> ";
}else {

	if($info['admin_pw']==MD5($admin_pw)){
			


			$_SESSION['admin_idx']	 = $info['idx'];
			$_SESSION['admin_id']	 = $info['admin_id'];
			$_SESSION['admin_name']  = $info['admin_name'];
			$_SESSION['admin_lv']		 = $info['admin_lv'];

			echo "<script>
				alert('환영합니다.');
				parent.location.replace('/BDP_ADMIN/home.php');
			</script> ";



	}else {
			echo "<script>
			alert('비밀번호를 확인하세요. ');
			parent.location.replace('/BDP_ADMIN/');
			</script> ";
	}

}






/*
if($실투자금 == 0 or null){
}






$emp_id			= $_GET[emp_id];
$emp_password	= $_GET[emp_password];


/*
$_SESSION['emp_num'] = $rs['emp_num'];
$_SESSION['company_num'] = $rs['company_num'];
$_SESSION['emp_id'] = $rs['emp_id'];
$_SESSION['gr_num']= $rs['gr_num'];
$_SESSION['emp_name']= $rs['emp_name'];




$_SESSION['emp_num'] = 1111;
$_SESSION['company_num'] = 1111;
$_SESSION['emp_id'] = 1111;
$_SESSION['gr_num']= 1111;
$_SESSION['emp_name']= 1111;


		echo "<script>
		alert('환영합니다.');
		parent.location.replace('/TW_MOMO/home.php');
		</script> ";

















$order_paper_sql = "select * from com_tkop where com_id ='$com_id' ";
$res = mysql_query($order_paper_sql, $cset_sock);
$rs = mysql_fetch_array($res);


if($rs==Null) {
		echo "<script>
		alert('그럼 아이디 없어');
		parent.location.replace('/PIRATES/');
		</script> ";
} else {
	if($rs[com_pw]==MD5($com_pw)){

		$com_name = $rs['com_name'];

		$_SESSION['session_com_id'] = $com_id;
		$_SESSION['session_com_level'] = $rs['com_level'];

		$pirates_log_check = 0;
		$pirates_log_sql = "select * from pirates_log where com_id ='$com_id' ";
		$pirates_log_res = mysql_query($pirates_log_sql, $cset_sock);
		while($pirates_log_rs = mysql_fetch_array($pirates_log_res)){
			$pirates_log_check+=1;
		}

		echo "<script>
			alert('".$com_name."님의 ".$pirates_log_check."번째 방문을 환영합니다.1000번째 방문에는 특별한 선물이 있습니다. ');
			parent.location.replace('/PIRATES/main.php');
			</script> ";

		$dates = date("Y-m-d h:i:s");
		$ip = $_SERVER["REMOTE_ADDR"];
		$order_paper_sql = "insert pirates_log set 
			com_id ='".$com_id."',
			log_ip ='".$ip."',
			log_dates ='".$dates."',
			log_type  = 0;";
		$res = mysql_query($order_paper_sql, $cset_sock);

	}	else {
			echo "<script>
			alert('비밀번호 확인해');
			parent.location.replace('/PIRATES/');
			</script> ";
	}
}

*/
?>	