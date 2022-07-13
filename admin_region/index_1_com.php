<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');
include_once('../contents_header.php');
include_once('../contents_profile.php');
include_once('../contents_sidebar.php');




$preregionName = isset($_GET['preregionName']) ? $_GET['preregionName'] : Null;
$affregionName = isset($_GET['affregionName']) ? $_GET['affregionName'] : Null;
$check_sql = "

		select 
		(select count(*) from rawdata_trade_apt where Courtbuilding Like '%".$preregionName."%') as cnt1,
		(select count(*) from rawdata_trade_op where Courtbuilding Like '%".$preregionName."%') as cnt2,
		(select count(*) from rawdata_trade_tenementhouse where Courtbuilding Like '%".$preregionName."%') as cnt3,
		(select count(*) from rawdata_charter_apt where Courtbuilding Like '%".$preregionName."%') as cnt4,
		(select count(*) from rawdata_charter_op where Courtbuilding Like '%".$preregionName."%') as cnt5,
		(select count(*) from rawdata_charter_tenementhouse where Courtbuilding Like '%".$preregionName."%') as cnt6



		
		";

$check_res = mysqli_query($real_sock,$check_sql);
$check_info = mysqli_fetch_array($check_res);




?>


			<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
					<?php
					$array = array(
						array('#','고객 관리')
					);
					breadcrumb($array);
					?>
			<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
							법정동 일부 정보 확인		
					</div>

					<div class="panel-body">
						<h4> 원시 데이터 </h4>
							<table border=1>
								<thead>	
									<tr>
										<th> 매매 종류</th>
										<th> 물건 유형</th>
										<th> 변경될 데이터 갯수</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td rowspan = 3> 매매</th>
										<td>아파트</td>
										<td><?php echo $check_info['cnt1'];?></td>
									</tr>
									<tr>
										<td>오피스텔</td>
										<td><?php echo $check_info['cnt2'];?></td>
									</tr>
									<tr>
										<td>빌라</td>
										<td><?php echo $check_info['cnt3'];?></td>
									</tr>
									<tr>
										<td rowspan = 3>전세</th>
										<td>아파트</td>
										<td><?php echo $check_info['cnt4'];?></td>
									</tr>
									<tr>
										<td>오피스텔</td>
										<td><?php echo $check_info['cnt5'];?></td>
									</tr>
									<tr>
										<td>빌라</td>
										<td><?php echo $check_info['cnt6'];?></td>
									</tr>

								</tbody>
							</table>
							총 <font color ='red'><?php 
								echo $check_info['cnt1']+$check_info['cnt2']+$check_info['cnt3']+$check_info['cnt4']+$check_info['cnt5']+$check_info['cnt6'];
							
							?></font>의 원시 데이터 
						<h4>물건 데이터 </h4>
						<?php
							$check_sql = "
									select 
									(select count(*) from invest_master where Courtbuilding Like '%".$preregionName."%' and finderType='apt') as cnt1,
									(select count(*) from invest_master where Courtbuilding Like '%".$preregionName."%' and finderType='op') as cnt2,
									(select count(*) from invest_master where Courtbuilding Like '%".$preregionName."%' and finderType='bil') as cnt3


									
									";

							$check_res = mysqli_query($real_sock,$check_sql);
							$check_info = mysqli_fetch_array($check_res);

						
						
						?>

							<table border=1>
								<thead>	
									<tr>
										<th> 물건 유형</th>
										<th> 변경될 데이터 갯수</th>
									</tr>
								</thead>
								<tbody>
									<tr>

										<td>아파트</td>
										<td><?php echo $check_info['cnt1'];?></td>
									</tr>
									<tr>
										<td>오피스텔</td>
										<td><?php echo $check_info['cnt2'];?></td>
									</tr>
									<tr>
										<td>빌라</td>
										<td><?php echo $check_info['cnt3'];?></td>
									</tr>
									
								</tbody>
							</table>
							총 <font color ='red'><?php 
								echo $check_info['cnt1']+$check_info['cnt2']+$check_info['cnt3'];
							
							?></font>의 물건 데이터 



							<h4>법정동 데이터 </h4>


							<table border=1>
								<thead>	
									<tr>
		
										<th>시스템법정동명 - 수정 전</th>
										<th>시스템법정동명 - 수정 후</th>
										<th>출력법정동명 - 수정 전</th>
										<th>출력법정동명 - 수정 후</th>
									</tr>
								</thead>
								<tbody>
								<?php 
									

									$count = 0;
									$region_code_sql = "
										select regionName,printName from region_code where regionName Like '%".$preregionName."%';";

									$region_code_res = mysqli_query($real_sock,$region_code_sql);
									while($region_code_info = mysqli_fetch_array($region_code_res)){
										$count += 1;
										$temp1 = 	str_replace($preregionName,$affregionName, $region_code_info['regionName']); 
										$temp2 = 	str_replace($preregionName,$affregionName, $region_code_info['printName']); 


										echo "
											<tr>
												<td>".$region_code_info['regionName']."</td>
												<td><font color = 'red'>".$temp1."</font></td>												
												<td>".$region_code_info['printName']."</td>
												<td><font color = 'red'>".$temp2."</font></td>												
										
											</tr>										
										";
									
									
									};
								
								
								?>	
								</tbody>
							</table>
								

							<p>
						<br>
						<br>
						<form name="frm" role="form" method="get" action="index_1_com_proc.php">
							<input type='hidden' name = "preregionName" value ='<?php echo $preregionName?>'>
							<input type='hidden' name = "affregionName" value ='<?php echo $affregionName?>'>
							위와 같이 정보가 수정됩니다. 한번 수정하면 되돌리기 힘드니 꼭 확인하세요.
							<p>
						<br>
							<input  type='submit' class="btn btn-success login-btn" type="submit" value="수정하기" style='width : 30%'>


						</form>





					</div>
				</div>
			</div>



		 
  

	
	</div>
</div>	<!--/.main-->

	
<!--Modal-->
<?php include_once('../contents_footer.php');


?>