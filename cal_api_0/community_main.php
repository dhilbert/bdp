<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');
include_once('../contents_header.php');
include_once('../contents_profile.php');
include_once('../contents_sidebar.php');


$admin_setting_sql = " select * from admin_setting;";
$admin_setting_res = mysqli_query($real_sock,$admin_setting_sql);
$admin_setting_info = mysqli_fetch_array($admin_setting_res);




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
					<div class="panel-heading">물건 통계 </div>
					<div class="panel-body">
					
						<form name="frm" role="form" method="get" action="step4_cal_makemoolgun_proc.php">
							
							<label>단지 연산 기준일							</label>
							<select name="cal_date" style='width : 40%'>
								<?php 
										$check_value = $admin_setting_info['cal_date']/30;
									for($month = 1 ; $month < 13 ; $month++){
										if($month==$check_value){$selected = 'selected';}
										else{$selected = '';}
										echo "<option value='".$month."'  ".$selected." >".$month."월</option>	";
									}							
								?>
							</select>
							<br>
							※ 월*30으로 연산, 12개월하면 12*30으로 연산됨. 365아님

							<p>							<br>
							매매 연산 : 기준일
							<select name="calMaxdateT" style='width : 40%'>
								<?php 
									
								$check_value = $admin_setting_info['calMaxdateT']/365;
									for($deajang_year = 1 ; $deajang_year < 6 ; $deajang_year++){
										if($deajang_year==$check_value){$selected = 'selected';}
										else{$selected = '';}
										echo "<option value='".$deajang_year."'  ".$selected." >".$deajang_year."년</option>	";
									}							
								?>
							</select>
							<p>							<br>
							전세 연산 : 기준일
							<select name="calMaxdateC" style='width : 40%'>
								<?php 
							
									$check_value = $admin_setting_info['calMaxdateC']/365;
									for($deajang_year = 1 ; $deajang_year < 6 ; $deajang_year++){
										if($deajang_year==$check_value){$selected = 'selected';}
										else{$selected = '';}
										echo "<option value='".$deajang_year."'  ".$selected." >".$deajang_year."년</option>	";
									}							
								?>
							</select>

							<input  type='submit' class="btn btn-success login-btn" type="submit" value="단지통계 처음부터 내기(오래 걸림)" style='width : 100%'>
							※ 저장될때는 day 값으로 저장. 3*365 이런식으로

						</form>


					</div>
				</div>
			</div>

			</div>





		
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">지역  통계 </div>
					<div class="panel-body">
					
						<form name="frm" role="form" method="get" action="step5_cal_makedong_proc.php">
							
							<label>지역 통계 기준							</label>
							<select name="imjang_state" style='width : 40%'>
								<?php 
									$check_value = $admin_setting_info['imjang_state']/90;
									for($month = 1 ; $month < 13 ; $month++){
										if($month==$check_value){$selected = 'selected';}
										else{$selected = '';}
										$months = $month*3;
										echo "<option value='".$month."'  ".$selected." >".$months."개월</option>	";
									}							
								?>
							</select>
							<br>
							※ 6개월*30으로 연산, 12개월하면 12*30으로 연산됨. 365아님

							

							<input  type='submit' class="btn btn-success login-btn" type="submit" value="단지통계 처음부터 내기(오래 걸림)" style='width : 100%'>


						</form>


					</div>
				</div>
			</div>




























		 
  

	
	</div>
</div>	<!--/.main-->

	
<!--Modal-->
<?php include_once('../contents_footer.php');


?>

  <!-- Modal -->
<div class="modal fade" id="myModal3" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				직원 추가
			</div>
			<div class="modal-body">
				※ 생성시 비밀번호는 1234<br>
				※ 생성시 레벨은 5<br>

				<form name="frm" role="form" method="get" action="insert_user_proc.php">
						
						<label>아이디</label>
							<input class='form-control' placeholder='이름를 입력하세요' name = 'admin_id'	value='<?php echo $info['admin_id']?>'	style='background-color:'>
						
						<label>이름</label>
							<input class='form-control'  placeholder='이름' name = 'admin_name'	value='<?php echo $info['admin_name']?>'	style='background-color:'>

				


			</div>
			<div class="modal-footer">
				<input  type='submit' class="btn btn-success login-btn" type="submit" value="추가">
				</form>

				 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>





