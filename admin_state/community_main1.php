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
						array('#','직원 관리')
					);
					breadcrumb($array);
					?>
			<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">랭킹 1</div>
					<div class="panel-body">
					
					
						<a href = '0_moolweekly_proc.php' class='btn btn-success login-btn' style='width : 100%'>주별 랭킹 </a>
					</div>
				</div>
			</div>

		</div>



	<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">랭킹 2</div>
					<div class="panel-body">
					
					
						<a href = '2_dongmonthly_proc.php' class='btn btn-success login-btn' style='width : 100%'> 동 월별 랭킹 </a>
					</div>
				</div>
			</div>

		</div>

	<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">랭킹 3</div>
					<div class="panel-body">
					
					
						<a href = '3_dong_proc.php' class='btn btn-success login-btn' style='width : 100%'>동 주별 랭킹 </a>
					</div>
				</div>
			</div>

		</div>



<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
kb시세

					
					</div>

					<div class="panel-body">

















						<?php

							$sql	 = "select oReleaseDate,count(*) as cnt from kbland.onland_sise  group by oReleaseDate order by oReleaseDate DESC LIMIT 1;";
							$res	=  mysqli_query($real_sock,$sql) or die(mysqli_error($real_sock));
							$info	 = mysqli_fetch_array($res);
							$TargetDate = $info['oReleaseDate'];
							echo "<font color = 'red'>".$TargetDate."</font>(데이터 갯수 <font color = 'red'>".number_format($info['cnt'])."</font>개) 와 시세 비교할 일자 선택하시오.";
				

	
						
						?>
	
						<form name="frm" role="form" method="get" action="kb_proc.php">
								<input type='hidden' name='TargetDate' value='<?php echo $TargetDate?>'>
								<select name="compareDate" style='width : 30%'>
									<?php
										$sql	 = "select 
														oReleaseDate,TIMESTAMPDIFF(WEEK , oReleaseDate, '".$TargetDate."') as diff ,
														count(*) as cnt
										
													from kbland.onland_sise 
														where oReleaseDate != '".$TargetDate."'
															 group by oReleaseDate
														order by oReleaseDate DESC Limit 26 ;";
										
										$res	=  mysqli_query($real_sock,$sql) or die(mysqli_error($real_sock));
										while($info	 = mysqli_fetch_array($res)){
											if($info['diff']==1){$selected = 'selected';	}
											else{$selected = '';}
											
											echo "<option value='".$info['oReleaseDate']."'  ".$selected." >".$info['oReleaseDate']."(".$info['diff']." 주 전, 데이터 갯수 : ".number_format($info['cnt'])."개)</option>	";
										
										
										}
						
									?>



								</select>
								<p>
						<input  type='submit' class="btn btn-success login-btn" type="submit" value="연산하기" style='width : 30%'>


						</form>




					</div>
				</div>
			</div>



		 












		 
  

	
	</div>
</div>	<!--/.main-->

	
<!--Modal-->
<?php include_once('../contents_footer.php');


?>