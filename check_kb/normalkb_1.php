<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');


$table_names = array('naverland_danji','naverland_sise','onland_danji','onland_sise');
$table_names = array('naverland_danji','onland_danji','onland_sise');

$naver_names = array('naverland_danji','naverland_sise');
$naver_names = array('naverland_danji');


$sise_names    = array('naverland_sise','onland_sise');
$sise_names    = array('onland_sise');

$kb_names    = array('onland_danji','onland_sise');



//네이버 주소 
$update_list = array(	array('광주시','광주광역시'),array('대구시','대구광역시'),array('대전시','대전광역시'),array('부산시','부산광역시'),
						array('서울시','서울특별시'),array('세종시','세종특별자치시'),array('울산시','울산광역시'),array('인천시','인천광역시'),
						array('제주도','제주특별자치도'),array('경기도','경기도'));



for($i = 0 ;$i < count($update_list) ; $i++){
	$a_text = $update_list[$i][0];
	$b_text = $update_list[$i][1];
	
	for($j = 0 ; $j < count($naver_names) ; $j ++){
		$tablename = $table_names[$j];
		$invest_master_sql = "update kbland.".$tablename." set 
					newoAddr = REPLACE(oAddr, '".$a_text."', '".$b_text."')
				where  oAddr Like '%".$a_text."%'  ;";
		$invest_master_res = mysqli_query($real_sock,$invest_master_sql);


		$invest_master_sql = "update kbland.".$tablename." set 
					newoAddr = REPLACE(oAddr, '".$a_text."', '".$b_text."')
				where  oAddr Like '%".$a_text."%'  ;";
		$invest_master_res = mysqli_query($real_sock,$invest_master_sql);
	}

}


for($i = 0 ; $i < count($table_names) ; $i ++){
	$tablename = $table_names[$i];
	
	
	$sql = "update kbland.".$tablename." set 
				newoAddr = TRIM(trim(SUBSTRING_INDEX(newoAddr, '생활권', 1)))
			where newoAddr LIKE '%생활권%' ;";
	$res = mysqli_query($real_sock,$sql);
	$update_sql = "update kbland.".$tablename." set 
			newoAddr = TRIM(REPLACE(newoAddr, '행정중심복합도시 ', ''))
		where oAddr Like '%행정중심복합도시%';";
	$update_res = mysqli_query($real_sock,$update_sql);
	$update_sql = "update kbland.".$tablename." set 
			newoAddr = TRIM(REPLACE(newoAddr, '행정중심복합도시', ''))
		where newoAddr Like '%행정중심복합도시%';";
	$update_res = mysqli_query($real_sock,$update_sql);

	$update_sql = "update kbland.".$tablename." set 
			newoAddr = TRIM(REPLACE(newoAddr, '행복중심복합도시 ', ''))
		where newoAddr Like '%행복중심복합도시%';";
	$update_res = mysqli_query($real_sock,$update_sql);
	$update_sql = "update kbland.".$tablename." set 
			newoAddr = TRIM(REPLACE(newoAddr, '행복중심복합도시', ''))
		where newoAddr Like '%행복중심복합도시%';";
	$update_res = mysqli_query($real_sock,$update_sql);

	$update_sql = "update kbland.".$tablename." set 
			newoAddr = REPLACE(newoAddr, '세종특별자치시 세종특별자치시', '세종특별자치시')
		where newoAddr Like '%세종특별자치시 세종특별자치시%'
	;";
	$update_res = mysqli_query($real_sock,$update_sql);
	

	$update_sql = "update kbland.".$tablename."  as a set 
				a.buildingNumber	= trim(SUBSTRING_INDEX(trim(a.newoAddr),' ', -1)),
				a.Courtbuilding	= trim(REPLACE(a.newoAddr,SUBSTRING_INDEX(trim(a.newoAddr),' ', -1),''));";

	$update_res = mysqli_query($real_sock,$update_sql);

	$tablename = $table_names[$i];

	$update_sql = " update kbland.".$tablename."  as a  
						JOIN bdp_real.region_code AS b 
					ON 	 b.regionName = a.Courtbuilding 
						SET 
					a.regionCode_full =  b.regionCode_full  ;

				
				
				;";


	
	$update_res = mysqli_query($real_sock,$update_sql);



	
}









?>


해당 페이지에서 작업 <p>
1. 네이버의 법정동 데이터를 국토부의 법정동 데이터로 변환 <br>
2. 이 일부 법정동 데이터 변환(EX) 행정중심복합도시 삭제, )  <br>
<br><p><br>
다음 버튼 클릭 해서 다음 작업 진행해야 함. 
<br><p><br>

<a href = 'normalkb_2.php' >다음</a>