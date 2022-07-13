<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');
include_once('../contents_header.php');
include_once('../contents_profile.php');
include_once('../contents_sidebar.php');




		?>

			<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
					<?php
					$array = array(
						array('#','kb 정보 매칭')
					);
					breadcrumb($array);
					?>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						사전작업
					</div>
					<div class="panel-body">

					<label>크롤링 매칭</label>
					<a href='normalkb.php' class="btn btn-success login-btn" style='width : 100%'>매칭</a>
					<p> ※ 네이버 시세 정보 성능 문제로 당분간 제외 하여 로직 돌림. 

							






					</div>
				</div>
			</div>		</div>

		</div>
				</div>
			</div>
	</div>
</div>	<!--/.main-->

	
<!--Modal-->
<?php include_once('../contents_footer.php');



?>  