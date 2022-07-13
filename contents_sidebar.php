<?php
function hd_active($input){
	$uri=explode('/',$_SERVER['REQUEST_URI']);
		if($uri[2]==$input){
		echo "class='active'";}
}
function hd_drop($num,$grobal,$sub_name,$sub_url){
?>

<li class="parent ">
		<a href="#">
		<span data-toggle="collapse" href="#sub-item-<?php echo $num;?>"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg> <?php echo $grobal?> </span>
		</a>
		<ul class="children collapse" id="sub-item-<?php echo $num;?>">
		<?php
		for($i = 0 ; $i <count($sub_name);$i++){
		?>
			<li>
				<a class="" href="<?php echo $sub_url[$i];?>">
					<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> <?php echo $sub_name[$i];?>
				</a>
			</li>
		<?php
		}?>
		</ul>
	</li>
<?php
}
?>


	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<form role="search">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Search">
				
			</div>

		</form>

		<ul class="nav menu" >
			<li <?php hd_active("home.php");?>><a href="/BDP_ADMIN/home.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"/></svg>Home</a></li>
			<?php 
			// 본사 슈퍼 어드민일때 

	
				$num		='hq-1';
				$grobal		= '인원 관리';
				$sub_name	= array('직원 관리','고객 관리');
				$sub_url	= array("/BDP_ADMIN/admin_member/admin_member.php",
									"/BDP_ADMIN/admin_member/customer_member.php");
				hd_drop($num,$grobal,$sub_name,$sub_url);

				$num		='hq-2';
				$grobal		= '운영 관리';
				$sub_name	= array('문의사항 관리','공지 사항 관리','조정지역 색상 관리 ');
				$sub_url	= array("/BDP_ADMIN/admin_maintain/qa_maintain.php",
									
									"/BDP_ADMIN/admin_maintain/notice_maintain.php",
									"/BDP_ADMIN/admin_maintain/color_maintain.php"

				);

				hd_drop($num,$grobal,$sub_name,$sub_url);
			
				

				$num		='hq-6';
				$grobal		= '부동산 정보 관리';
				$sub_name	= array('api 삽입','0차 데이터 통계','1차 데이터 통계'
				//,'동별 통계 정보 확인',"대장주 확인"
				);
				$sub_url	= array("/BDP_ADMIN/cal_api/community_main.php",
									"/BDP_ADMIN/cal_api_0/community_main.php",
									"/BDP_ADMIN/cal_api_1/community_main.php"

				//"/BDP_ADMIN/cleansing/dong.php",
				//"/BDP_ADMIN/cleansing/Deajang.php"


				);

				hd_drop($num,$grobal,$sub_name,$sub_url);
				

				$num		='hq-7';
				$grobal		= '법정동관리';
				$sub_name	= array('모든 법정동 확인','일부 정보 수정');
				$sub_url	= array("/BDP_ADMIN/admin_region/index_0.php",
									"/BDP_ADMIN/admin_region/index_1.php"	
				
				);

				hd_drop($num,$grobal,$sub_name,$sub_url);



				

?>

<li <?php hd_active("check_kb.php");?>><a href="/BDP_ADMIN/check_kb/check_kb.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"/></svg>kb크롤링</a></li>

<li <?php hd_active("community_main1.php");?>><a href="/BDP_ADMIN/admin_state/community_main1.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"/></svg>랭킹</a></li>

<!--
	<li <?php hd_active("");?>><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"/></svg>센터 선생 위험 관리 지표</a></li>
	<li <?php hd_active("");?>><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"/></svg>물품 관리</a></li>
-->
	</ul>
</div>