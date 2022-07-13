<?php
include_once('../lib/dbcon_bdp.php');





$apt_sql = "SELECT count(investPrice) as cnt,sum(investPrice) as sm
				FROM invest_master
				where (finderType = 'apt')
				and printCheck = 1
				and stateAreaCode in (11000,28000,41000)";
$apt_res = mysqli_query($real_sock,$apt_sql);
$apt_info = mysqli_fetch_array($apt_res);

$op_sql = "SELECT count(investPrice) as cnt,sum(investPrice) as sm
				FROM invest_master
				where (finderType = 'op')
				and printCheck = 1
				and stateAreaCode in (11000,28000,41000)";
$op_res = mysqli_query($real_sock,$op_sql);
$op_info = mysqli_fetch_array($op_res);

$bil_sql = "SELECT count(investPrice) as cnt,sum(investPrice) as sm
				FROM invest_master
				where (finderType = 'bil')
				and printCheck = 1
				and stateAreaCode in (11000,28000,41000)";
$bil_res = mysqli_query($real_sock,$bil_sql);
$bil_info = mysqli_fetch_array($bil_res);

$do_sql = "SELECT count(investPrice) as cnt,sum(investPrice) as sm
				FROM invest_master
				where (finderType = 'do')
				and printCheck = 1
				and stateAreaCode in (11000,28000,41000)";
$do_res = mysqli_query($real_sock,$do_sql);
$do_info = mysqli_fetch_array($do_res);



$investAVG				=$apt_info['sm']/$apt_info['cnt'];
$aptcount				=$apt_info['cnt'];
$bilcount				=$bil_info['cnt'];
$opcount				=$op_info['cnt'];
$docount				=$do_info['cnt'];



$aptinvestPricetotal	=$apt_info['sm'];
$bilinvestPricetotal	=$bil_info['sm'];
$opinvestPricetotal		=$op_info['sm'];
$doinvestPricetotal		=$do_info['sm'];

if($apt_info['cnt']==0){$aptinvestAVG=0;}else{$aptinvestAVG=$apt_info['sm']/$apt_info['cnt'];}
if($bil_info['cnt']==0){$bilinvestAVG=0;}else{$bilinvestAVG=$bil_info['sm']/$bil_info['cnt'];}
if($op_info['cnt']==0){$opinvestAVG=0;}else{$opinvestAVG=$op_info['sm']/$op_info['cnt'];}
if($do_info['cnt']==0){$doinvestAVG=0;}else{$doinvestAVG=$op_info['sm']/$do_info['cnt'];}





$update_sql = "update loading_member set 
				investAVG = '".$investAVG."',
				aptcount='".$aptcount."',
				bilcount='".$bilcount."',
				opcount='".$opcount."',
				docount='".$docount."',
				aptinvestPricetotal='".$aptinvestPricetotal."',
				bilinvestPricetotal='".$bilinvestPricetotal."',
				opinvestPricetotal='".$opinvestPricetotal."',
				doinvestPricetotal='".$doinvestPricetotal."',
				aptinvestAVG='".$aptinvestAVG."',
				bilinvestAVG='".$bilinvestAVG."',
				opinvestAVG='".$opinvestAVG."',
				doinvestAVG='".$doinvestAVG."'

				";
		
$update_res = mysqli_query($real_sock,$update_sql);


echo "<script>
			alert('계산 완료 ');
			parent.location.replace('/BDP_ADMIN/cal_api_1/community_main.php');
</script> ";


?>