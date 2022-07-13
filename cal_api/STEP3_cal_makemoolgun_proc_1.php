<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');
$today_time = date("Y-m-d");
$now = date("Y-m-d H:i:s");
?>

<p> vworld 에서 도로명에 대한 위경도 정보가 없는 경우 에러 발생. 오류아님. 스크롤하여 다음 작업 진행해야 함. <p>


<?php


/*  위경도 찾기  */
/* 새로운 도로명 추가 */
$search_sql = "
	insert 	INTO roadname.Longitude(roadName) 
		select a.roadName 
			from invest_master AS a
				Left Join roadname.Longitude as b 
			ON a.roadName  = b.roadName 					
		where b.idx IS NULL 
		AND a.roadName IS NOT NULL 
		GROUP BY a.roadName

	";
$search_res = mysqli_query($real_sock,$search_sql);




/*vworld 통신*/
function hd_url($ro,$key_num){
	$vworldKeys = array('F28BF0F9-1C1A-3876-A065-11F6732E6328','6C60D3E3-FECE-377B-8204-8ED500D8F0FF','09F4DBAD-64AD-3775-8F6B-1401FCA58D40','CDB35263-7BBD-3CBB-8A78-E99B12DB9516',
					'5E11C65F-D49F-3681-95A1-E602D9747BA5','E03A9043-4FB2-31EE-A94B-5F7B63448BA9','90CEC9C4-68C6-3687-9F47-13AECCAD29E7','6E1A5A5F-7F44-3092-922B-76855971AF2C',
					'5E80A4CB-466E-3F3A-A0C4-5D4CE97F2FEE','5B97F1D0-1D40-32AB-9AA1-F919AD01DE44');
	$api_url = "http://api.vworld.kr/req/address?service=address&request=getcoord&version=2.0&crs=epsg:4326&address=".URLEncode($ro)."&refine=false&simple=false&format=json&type=road&key=".$vworldKeys[$key_num]."";
	return $api_url;
}


function convertArray($object)
{
    return json_decode( json_encode( $object ), 1 );
}

$count_n = 0;
$roadnameLongitude_sql = "SELECT roadName,idx
							FROM roadName.Longitude
						where 	vworldcheck=0 ;	";
$roadnameLongitude_res = mysqli_query($real_sock,$roadnameLongitude_sql);
while($roadnameLongitude_info = mysqli_fetch_array($roadnameLongitude_res)){
	$count_n+=1;
	$url = hd_url($roadnameLongitude_info['roadName'],$count_n%10);
	$json_string = file_get_contents($url);
	$R = json_decode($json_string, true);
	$x_point	 = $R['response']['result']['point']['y'];
	$y_point	 = $R['response']['result']['point']['x'];
	if($x_point==null){
		$update_roadnameLongitude_sql = "
					update roadName.Longitude set 
							vworldcheck=2
					where idx = ".$roadnameLongitude_info['idx']."	";
		$update_roadnameLongitude_res = mysqli_query($real_sock,$update_roadnameLongitude_sql);
	
	}
	else{
		$update_roadnameLongitude_sql = "
					update roadName.Longitude set 
							x_point   ='".$x_point."',
							y_point   ='".$y_point."',
							vworldcheck=1
					where idx = ".$roadnameLongitude_info['idx']."	";
		$update_roadnameLongitude_res = mysqli_query($real_sock,$update_roadnameLongitude_sql);
	}

};


/* 물건 데이터에 위경도 넣기 */
$Longitude_sql = "
					UPDATE bdp_real.invest_master AS a 
						JOIN roadname.Longitude AS b
					ON a.roadName = b.roadName
					SET 
						a.x_point = b.x_point,
						a.y_point = b.y_point,
						a.new_x_point= b.x_point,
						a.new_y_point= b.y_point,
						a.location=POINT(b.x_point,b.y_point)";
$Longitude_res = mysqli_query($real_sock,$Longitude_sql);

?>


해당 페이지에서 작업 <p>
1. 추가된 물건의 도로명 주소 확인 <br>
2. 추가된 물건의 위경도 찾기(1도로명당 1번의 통신이므로 도로명이 많은 경우 통신 오래 걸림)<br>
2-1. 에러는 vworld 페이지에서 해당 도로명의 위경도 정보가 없는 경우.(발생하는 경우 많음. 시스템 오류 아님)
<br><p><br>
다음 버튼 클릭 해서 다음 작업 진행해야 함. 
<br><p><br>

<a href = 'STEP3_cal_makemoolgun_proc_5.php' >크롤링 매칭 건너띄기(크롤링 매칭 시간 오래 걸림)</a>
<p>
<a href = 'STEP3_cal_makemoolgun_proc_3.php' >크롤링 매칭 </a>