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
						array('#','고객 관리')
					);
					breadcrumb($array);
					?>
			<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
							법정동 일부 정보 수정 		
					</div>

					<div class="panel-body">


						<table data-toggle="table"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
							<thead>
								<tr>
									<th data-field="s_0" data-sortable="true" >No </th>
									<th data-field="s_1" data-sortable="true" >수정한 사람</th>
									<th data-field="s_2" data-sortable="true" >수정 시간</th>
									<th data-field="s_3" data-sortable="true" >수정전 법정동</th>
									<th data-field="s_4" data-sortable="true" >수정후 법정동</th>

								</tr>
								</tr>
							</thead>
							<tbody>
							<?php 
								$count =0;
										$admin_region_history_sql = " 
										select 
											b.admin_name,
											a.preregionName,
											a.affregionName,
											a.updateTime
											
															
							
										from admin_region_history as a 
											Join  admin_member as b
										on a.admin_idx = b.idx

										
							
								;";
								$admin_region_history_res = mysqli_query($real_sock,$admin_region_history_sql);
								while($admin_region_history_info = mysqli_fetch_array($admin_region_history_res)){
									$count +=1;									
									echo "
										<tr>
											<td>".$count."</td>
											<td>".$admin_region_history_info['admin_name']."</td>
											<td>".$admin_region_history_info['updateTime']."</td>
											<td>".$admin_region_history_info['preregionName']."</td>
											<td>".$admin_region_history_info['affregionName']."</td>
									
										</tr>									
									";
								}
							
							
							
							?>
							</tbody>
						</table> 	
						








						※  원시 데이터, 법정동 데이터, 물건 데이터 모두 수정됨. 신중히

					<form name="frm" role="form" method="get" action="index_1_com.php">
						<label> 수정할 법정동명</label>
						<input type='text' value='압량면' name = 'preregionName'>
						<br>
						<label> 수정된 법정동명</label>
						<input type='text' value='압량읍' name = 'affregionName'>

						<input  type='submit' class="btn btn-success login-btn" type="submit" value="수정하기" style='width : 100%'>
					
					</form>



					</div>
				</div>
			</div>



		 
  

	
	</div>
</div>	<!--/.main-->

	
<!--Modal-->
<?php include_once('../contents_footer.php');


?>