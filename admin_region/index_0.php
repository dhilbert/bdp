<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');
include_once('../contents_header.php');
include_once('../contents_profile.php');
include_once('../contents_sidebar.php');



function hd_check_print($num){
	if($num==1){
		$want = "<font color ='red'>표시</font>";
	}
	else{
		$want = "미표시";	
	}
	return $want;

}

?>

			<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
					<?php
					$array = array(
						array('#','직원 관리')
					);
					breadcrumb($array);
					?>
			<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					
					<div class="panel-body">
						<div class="tab-content">



							
							<ul class="nav nav-pills">
								<li class="active"><a href="#pilltab1" data-toggle="tab">모든 법정동 정보</a></li>
								<li><a href="#pilltab2" data-toggle="tab">maplv1</a></li>
								<li><a href="#pilltab3" data-toggle="tab">maplv2</a></li>
								<li><a href="#pilltab4" data-toggle="tab">maplv3</a></li>
								<li><a href="#pilltab5" data-toggle="tab">maplv4</a></li>


							<!--	<li ><a href="#pilltab4" data-toggle="tab">기존 물건중 새로 데이터 들어온거  통계</a></li>
								<li ><a href="#pilltab5" data-toggle="tab">물건 월별 통계</a></li>
								<li ><a href="#pilltab6" data-toggle="tab">동 통계</a></li>
								<li ><a href="#pilltab7" data-toggle="tab">동 월별 통계</a></li>-->
							</ul>

						
							
							<div class="tab-content">
								<?php include_once('community_main_tab_1.php');?>

								<?php include_once('community_main_tab_2.php');?>
								<?php include_once('community_main_tab_3.php');?>
								<?php include_once('community_main_tab_4.php');?>
								<?php include_once('community_main_tab_5.php');?>
				
				
							</div>


						</div>

					</div>
				</div>
			</div>



		 
  

	
	</div>
</div>	<!--/.main-->

	
<!--Modal-->
<?php include_once('../contents_footer.php');


?>