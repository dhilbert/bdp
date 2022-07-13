<?php

/*

맥 원격
$real_hostname="192.168.0.61";
$real_username="gauss";
$real_password="kmathking0716";
$real_name="bdp_real";
$real_sock = mysqli_connect($real_hostname, $real_username, $real_password, $real_name);
$real_db = mysqli_select_db($real_sock, $real_name) or die ("복덕판 리얼 데이터베이스 서버에 연결할 수 없습니다.");
mysqli_set_charset($real_sock, 'utf8'); 

맥 개인 서버
$real_hostname="localhost";
$real_username="root";
$real_password="root";
$real_name="bdp_real";
$real_sock = mysqli_connect($real_hostname, $real_username, $real_password, $real_name);
$real_db = mysqli_select_db($real_sock, $real_name) or die ("복덕판 리얼 데이터베이스 서버에 연결할 수 없습니다.");
mysqli_set_charset($real_sock, 'utf8'); 




윈도우 개인 서버
$real_hostname="localhost";
$real_username="root";
$real_password="autoset";
$real_name="bdp_real";
$real_sock = mysqli_connect($real_hostname, $real_username, $real_password, $real_name);
$real_db = mysqli_select_db($real_sock, $real_name) or die ("복덕판 리얼 데이터베이스 서버에 연결할 수 없습니다.");
mysqli_set_charset($real_sock, 'utf8'); 

개발 서버
$real_hostname="106.10.54.99";
$real_username="root";
$real_password="DqhrEJRvks%@61Dbv";
$real_name="bdp_real";
$real_sock = mysqli_connect($real_hostname, $real_username, $real_password, $real_name);
$real_db = mysqli_select_db($real_sock, $real_name) or die ("복덕판 리얼 데이터베이스 서버에 연결할 수 없습니다.");
mysqli_set_charset($real_sock, 'utf8'); 

*/

$real_hostname="localhost";
$real_username="root";
$real_password="autoset";
$real_name="bdp_real";
$real_sock = mysqli_connect($real_hostname, $real_username, $real_password, $real_name);
$real_db = mysqli_select_db($real_sock, $real_name) or die ("복덕판 리얼 데이터베이스 서버에 연결할 수 없습니다.");
mysqli_set_charset($real_sock, 'utf8'); 





function hd_findertype($temp_name){
	$type = explode("_",$temp_name );
	if($type[2]=='multifamilyhouse'){
		$want = 'da';
	}
	elseif($type[2]=='tenementhouse'){
		$want = 'bil';
	}
	else{
		$want = $type[2];	
	}
	return $want;
}
function hd_findertype_invers($temp_name){
	if($temp_name=='da'){
		$want = 'multifamilyhouse';
	}
	elseif($temp_name=='bil'){
		$want = 'tenementhouse';
	}
	else{
		$want = $temp_name;	
	}
	return $want;
}


function hd_temp_print($value_0,$value_1,$value_2,$value_3){
	echo "<br><label>".$value_0."</label>";
	if($value_3==1){
		$temp = 'readonly ';
	}else{
		$temp = '';
	}
	echo "<input name ='".$value_1."' class='form-control' value = '".$value_2."' ".$temp.">";
}


function hd_int_to_date($temp){
	
	$year = floor($temp/10000);
	$month = floor(($temp-$year*10000)/100);
	$day = $temp-$year*10000-$month*100;
	if($day<10){
		$day = "0".$day;
	}else{
		$day = $day;
	}

	return $year."-".$month."-".$day;
}

function hd_int_to_date2($temp,$temp2){
	$beforeDay = date("Y-m-d", strtotime($temp." -".$temp2." day")); //통계 일자
	$beforeDay = explode("-",$beforeDay);
	$beforeDay = $beforeDay[0]*10000+$beforeDay[1]*100+$beforeDay[2];
	return $beforeDay;
}

function hd_int_to_date3($temp,$temp2){
	$beforeDay = date("Y-m-d", strtotime($temp." -".$temp2." day")); //통계 일자
	$beforeDay = explode("-",$beforeDay);
	$beforeDay = array($beforeDay[0],$beforeDay[1],$beforeDay[2]);
	return $beforeDay;
}



//BDP_ADMIN/cal_api/community_main.php 에서 사용하는 로직설명 
function hd_community_table($value0,$value1){
	echo "	<table width=100%>
				<tbody>
					<tr>
						<td> <h3> ".$value0."</h3></td>
						<td align='right'><details>
								<summary>로직</summary>
								<p>	".$value1."	</p>
							</details></td>
					</tr>
				</tbody>
			</table>";
}








function hd_text_to_int($deposit){
	$deposit = explode(",",$deposit);
	if(count($deposit)>1){
		$deposit = $deposit[0]*1000+$deposit[1];
	}
	else{
		$deposit = $deposit[0];
	}
	return $deposit;
}


?>