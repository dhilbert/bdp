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
					<div class="panel-heading">STEP0.국토부 API 불러오기</div>
					<div class="panel-body">
					
						<table data-toggle="table"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
							<thead>
								<tr>
									<th data-field="s_99" data-sortable="true" >No </th>
									<th data-field="s_00" data-sortable="true" >실행자</th>
									<th data-field="s_0" data-sortable="true" >데이터 일자</th>
									<th data-field="s_1" data-sortable="true" >사용 서비스키</th>
									<th data-field="s_2" data-sortable="true" >실행 일자</th>

								</tr>
								</tr>
							</thead>
							<tbody>
						<?php
								$count_n = 0;	
								$sql	 = "
											select b.admin_name, a.adminmember_idx, a.updateDate, a.DEAL_YMD, a.serviceKey
											from admin_apidata as a
												Join admin_member as b 
											on b.idx = a.adminmember_idx
											ORDER BY a.idx desc	
										;";
								$res	=  mysqli_query($real_sock,$sql) or die(mysqli_error($real_sock));
								while($info	 = mysqli_fetch_array($res)){
									$count_n += 1;
									echo "
										<tr>
											<td data-field='s_99' data-sortable='true'>".$count_n."</td>
											<td data-field='s_00' data-sortable='true'>".$info['admin_name']."</td>
											<td data-field='s_0' data-sortable='true'>".$info['DEAL_YMD']."</td>
											<td data-field='s_1' data-sortable='true'>".$info['serviceKey']."</td>
											<td data-field='s_2' data-sortable='true'>".$info['updateDate']."</td>

										</tr>								
									";

								};
						?>


							</tbody>
						</table>
						<!-- api 불러오기 -->
						<h3> API 불러오기</h3>
						<form name="frm" role="form" method="get" action="STEP0_call_api.php">
							<table width='100%'>
								<tr>
									<td width = '15%'> 서비스키 : </td>
									<td width = '85%'><select name="key_num">
										<?php
										
											$admin_servicekey_sql = "select * from admin_servicekey ";
											$admin_servicekey_res = mysqli_query($real_sock,$admin_servicekey_sql);
											while($admin_servicekey_info = mysqli_fetch_array($admin_servicekey_res)){
											
												echo "<option value='".$admin_servicekey_info['idx']."'>서비스키-".$admin_servicekey_info['idx']." ".$admin_servicekey_info['etc']."</option>";
											
											};
										
										
										?></select>
									</td>
								</tr>
								<tr>
									<td> 달입력</td>
									<td><select name="DEAL_YMD">
									<?php 
										$today_time = date("Y-m-d H:i:s");
										$temp_array = explode("-",$today_time);
										$year =$temp_array[0];
										$month =$temp_array[1];
										
										$count = 0;
										while($count<14){
											$count+=1;
											$want = $year*100+$month;
											echo "<option value='".$want."'>".$want."</option>";



											$month-=1;
											if($month==0){
												$month=12;
												$year-=1;
											}
										}


									
									
									?>
									
									</select>
									
									
								
									
									
									
									
									
									
									
									</td>
								</tr>
								<tr>
									<td colspan=2><input  type='submit' class="btn btn-success login-btn" type="submit" value="불러오기" style='width : 100%'></td>
								</tr>
							</table>																


						</form>




					</div>
				</div>
			</div>

		</div>






		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">STEP1. 데이터 정제  구하기</div>
					<div class="panel-body">
						

						<h3>정제 필요 데이터</h3>

						<?php 
								$sql="select 
										(select count(*) from rawdata_charter_apt where regionCode_full is null ) as cnt1,
										(select count(*) from rawdata_charter_op where regionCode_full is null ) as cnt2,
										(select count(*) from rawdata_charter_tenementhouse where regionCode_full is null ) as cnt3,
										(select count(*) from rawdata_trade_apt where regionCode_full is null ) as cnt4,
										(select count(*) from rawdata_trade_op where regionCode_full is null ) as cnt5,
										(select count(*) from rawdata_trade_tenementhouse where regionCode_full is null ) as cnt6
										;";
								$res	=  mysqli_query($real_sock,$sql) or die(mysqli_error($real_sock));
								$info	 = mysqli_fetch_array($res);
								$total = $info['cnt1'] + $info['cnt2'] + $info['cnt3'] + $info['cnt4'] + $info['cnt5'] + $info['cnt6'];
								if($total>0){
									echo "<p>총 ".$total." 데이터 정제 필요<br>	<a href = 'STEP1_call_api.php' class='btn btn-success login-btn' style='width : 100%'> 데이터 정제  구하기</a>";
								
								}

							




						?>


					</div>
				</div>
			</div>
		</div>







		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">물건만들기</div>
					<div class="panel-body">
						
						<a href = 'STEP3_cal_makemoolgun_proc.php' class='btn btn-success login-btn' style='width : 100%'>새로운 물건 만들기 </a>
						
				

					</div>
				</div>
			</div>

			</div>




















		 
  

	
	</div>
</div>	<!--/.main-->

	
<!--Modal-->
<?php include_once('../contents_footer.php');


?>