<?php
include_once('lib/session.php');
include_once('lib/dbcon_bdp.php');
include_once('contents_header.php');
include_once('contents_profile.php');
include_once('contents_sidebar.php');






?>





	
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">	
	
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="/BDP_ADMIN/home.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a> home				
				</li>

			</ol>
		</div>

	<div class="row">
			<div class="col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading">테이터 업데이트 현황</div>
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





					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading">문의 사항</div>
					<div class="panel-body">
					<h4> 항목별 문의 사항 </h4>
					<table border=1 width='100%'>
						<thead>
							<tr>
								<th width='20%'>구분 </th>
								<th>갯수 </th>
							</tr>
						</thead>
						<tbody>
						<?php
									
							$service_kind = array('','서비스 장애 문의','서비스 기능 문의','회원 관련 문의','제휴 마케팅 이벤트 문의','기타 문의 사항');					
							$sql	 = "select count(idx) as cnt, kindqna from admin_qna group by kindqna;";
							$res	=  mysqli_query($real_sock,$sql) or die(mysqli_error($real_sock));
							while($info	 = mysqli_fetch_array($res)){
								echo "
									<tr>
										<td>".$service_kind[$info['kindqna']]."										</td>
										<td>".$info['cnt']."										</td>
									</tr>								
								";
							
							};


						
						?>
						</tbody>
					</table>
					<h4> 현재 미처리 갯수 : 
					<?php 
							$sql	 = "select count(idx) as cnt from admin_qna where state = 0;";
							$res	=  mysqli_query($real_sock,$sql) or die(mysqli_error($real_sock));
							$info	 = mysqli_fetch_array($res);
							echo 	"<font color='red'>".$info['cnt']."</font>";
					?> 건 </h4>
		
					
					

					</div>
				</div>
			</div>

		</div><!--/.row-->
		





								
	</div>	<!--/.main-->
<?php include_once('contents_footer.php');?>