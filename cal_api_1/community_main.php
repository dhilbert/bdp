<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');
include_once('../contents_header.php');
include_once('../contents_profile.php');
include_once('../contents_sidebar.php');


$limit1 = isset($_GET['limit1'])	 ? $_GET['limit1'] : 10;
$limit2 = isset($_GET['limit2'])	 ? $_GET['limit2'] : 10;
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
					<div class="panel-heading">
					대장주
							
					</div>
					<div class="panel-body">
						

						<form name="frm" role="form" method="get" action="Deajang_proc.php">
							
							
							<select name="deajang_state" style='width : 100%'>
								<?php 
									$admin_setting_sql = " select deajang_state from admin_setting;";
									$admin_setting_res = mysqli_query($real_sock,$admin_setting_sql);
									$admin_setting_info = mysqli_fetch_array($admin_setting_res);
									$check_value = $admin_setting_info['deajang_state']/365;

									for($deajang_year = 1 ; $deajang_year < 6 ; $deajang_year++){
										if($deajang_year==$check_value){$selected = 'selected';}
										else{$selected = '';}
										echo "<option value='".$deajang_year."'  ".$selected." >".$deajang_year."년</option>	";
									}							
								?>
							</select>
							<input  type='submit' class="btn btn-success login-btn" type="submit" value="연산하기(약 2분 정도 소요)" style='width : 100%'>
							※ 저장될때는 day 값으로 저장. 3*365 이런식으로

						</form>




					</div>
				</div>
			</div>

		</div>























	<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">복덕판 될 곳이 보인다.</div>
					<div class="panel-body">

						<h4>1차용						</h4>
						<?php
						
							$loading_member_sql = " select * from loading_member;";
							$loading_member_res = mysqli_query($real_sock,$loading_member_sql);
							$loading_member_info = mysqli_fetch_array($loading_member_res);
							echo "<font color='red'>".number_format($loading_member_info['regionCount'])."</font> 개 지역
							<font color='red'>".number_format($loading_member_info['inverstCount'])."</font>";
						
						?>
					



						
						
						<h4>설정값			</h4>

						<form name="frm" role="form" method="get" action="startcheck_proc.php">
							
							
							<table>
								<tbody>
									<?php 
									
									
									$admin_setting_sql = " select * from admin_setting;";
									$admin_setting_res = mysqli_query($real_sock,$admin_setting_sql);
									$admin_setting_info = mysqli_fetch_array($admin_setting_res);
									
									
									
									?>
									<tr>
										<td>최솟값</td>
										<td><input type = "text" name = 'minvalue' value = '<?php echo $admin_setting_info['calminvalue']?>'></td>
										
									</tr>
									<tr>
										<td>최댓값</td>
										<td><input type = "text" name = 'maxvalue' value = '<?php echo $admin_setting_info['calmaxvalue']?>'></td>
										
									</tr>

								</tbody>
							</table>
							※ 해당 구간 안의 값과 단지(일반)의 실투자금 값과 매칭. printCheck(지도에 표시되는 아이콘) 값이 1인 경우만 카운팅.<br>


							<input  type='submit' class="btn btn-success login-btn" type="submit" value="연산하기" style='width : 100%'>
							

						</form>






				</div>
				</div>
			</div>

	</div>





	<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">갯수</div>
					<div class="panel-body">

							<?php
								$loading_mypage_sql = "SELECT * from loading_mypage;";
								$loading_mypage_res = mysqli_query($real_sock,$loading_mypage_sql);
								$loading_mypage_info = mysqli_fetch_array($loading_mypage_res);

								echo "총 지역 : ".number_format($loading_mypage_info['totalRegion'])."<br>";
								echo "총 테이터 : ".number_format($loading_mypage_info['totalinvest'])."<br>";
								echo "총 검색 : ".number_format($loading_mypage_info['totalSearch'])."<br>";

							
							
							?>
							<a href='countAll_proc.php' class="btn btn-success login-btn" style='width : 100%'>연산하기</a>
			
			
			</div>
				</div>
			</div>

	</div>

	<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">아파트 실투자금</div>
					<div class="panel-body">
<form name="frm" role="form" method="get" action="sil_proc1.php">
							<table>
								<tr>
									<td>서울 경기 인천의 아파트 실투자금의 평균</td>
									<td><input type='number' value='<?php echo 	$loading_member_info['investAVG']?>' name = 'investAVG'></td>
									<td><input  type='submit' class="btn btn-success login-btn" type="submit" value="임의 수정" style='width : 100%'></td>
								



								</tr>
							</table>
	</form>
							<a href='sil_proc.php' class="btn btn-success login-btn" style='width : 100%'>연산하기</a>
			
			
					</div>
				</div>
			</div>

		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">동 최고가/최저가 </div>
					<div class="panel-body">



					<form name="frm" role="form" method="get" action="3333.php">
							
							매매 연산 : 기준일
							<select name="minmax_dateforT" style='width : 40%'>
								<?php 
									$admin_setting_sql = " select * from admin_setting;";
									$admin_setting_res = mysqli_query($real_sock,$admin_setting_sql);
									$admin_setting_info = mysqli_fetch_array($admin_setting_res);
									$check_value = $admin_setting_info['minmax_dateforT']/365;

									for($deajang_year = 1 ; $deajang_year < 6 ; $deajang_year++){
										if($deajang_year==$check_value){$selected = 'selected';}
										else{$selected = '';}
										echo "<option value='".$deajang_year."'  ".$selected." >".$deajang_year."년</option>	";
									}							
								?>
							</select>
							<p>							<br>
							전세 연산 : 기준일
							<select name="minmax_dateforC" style='width : 40%'>
								<?php 
									$admin_setting_sql = " select * from admin_setting;";
									$admin_setting_res = mysqli_query($real_sock,$admin_setting_sql);
									$admin_setting_info = mysqli_fetch_array($admin_setting_res);
									$check_value = $admin_setting_info['minmax_dateforC']/365;

									for($deajang_year = 1 ; $deajang_year < 6 ; $deajang_year++){
										if($deajang_year==$check_value){$selected = 'selected';}
										else{$selected = '';}
										echo "<option value='".$deajang_year."'  ".$selected." >".$deajang_year."년</option>	";
									}							
								?>
							</select>

							<input  type='submit' class="btn btn-success login-btn" type="submit" value="연산하기(30분 정도 소요)" style='width : 100%'>
							※ 저장될때는 day 값으로 저장. 3*365 이런식으로

						</form>




						
			
			
					</div>
				</div>
			</div>

		</div>





		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading"> 실투자금 사전 연산 범위 </div>
					<div class="panel-body">





<table data-toggle="table"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
				<thead>
					<tr>
						<th data-field="s_0" data-sortable="true" >No</th>
						<th data-field="s_1" data-sortable="true" >최솟값 </th>
						<th data-field="s_2" data-sortable="true" >최댓값</th>
						<th data-field="s_3" data-sortable="true" >전국 가능 매물 </th>
						<th data-field="s_4" data-sortable="true" >수도권 가능 매물</th>



						</tr>
				</thead>
		<tbody>
<?php
							$count_n = 0;
							$member_invest_range_sql = " select * from member_invest_range;;";
							$member_invest_range_res = mysqli_query($real_sock,$member_invest_range_sql);
							while($member_invest_range_info = mysqli_fetch_array($member_invest_range_res)){
								
								$count_n += 1;
								echo "
									<tr>
										<td  data-field='s_0' data-sortable='true'>".$count_n."</td>
										<td  data-field='s_1' data-sortable='true'>".$member_invest_range_info['rangemin']."</td>
										<td  data-field='s_2' data-sortable='true'>".$member_invest_range_info['rangemax']."</td>
										<td  data-field='s_3' data-sortable='true'>".$member_invest_range_info['totalCount']."</td>
										<td  data-field='s_4' data-sortable='true'>".$member_invest_range_info['etcCount']."</td>

									</tr>

										
							
								";

							
							}
						
						?>

		

		</tbody>
			</table>


<a href='sa_proc.php' class="btn btn-success login-btn" style='width : 100%'>연산하기</a>
			
			
					</div>
				</div>
			</div>

		</div>



			</div>
		</div>
	</div>
</div>





<!--Modal-->
<?php include_once('../contents_footer.php');


?>