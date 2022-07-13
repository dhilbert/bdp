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
고객 관리			
					</div>

					<div class="panel-body">


<table data-toggle="table"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
	<thead>
		<tr>
			<th data-field="s_99" data-sortable="true" >#</th>
			<th data-field="s_0" data-sortable="true" >고객 아이디</th>
			<th data-field="s_1" data-sortable="true" >닉네임</th>
			<th data-field="s_2" data-sortable="true" >총사용시간</th>
			<th data-field="s_3" data-sortable="true" >총방문횟수</th>
			<th data-field="s_4" data-sortable="true" >성별</th>
			<th data-field="s_5" data-sortable="true" >전화</th>
			<th data-field="s_6" data-sortable="true" >생일</th>
			<th data-field="s_7" data-sortable="true" >나의 실투자금</th>

		</tr>
	</thead>
	<tbody>
	<?php
		$count_n = 0;
		$sql	 = "select * from member;";
		$res	=  mysqli_query($real_sock,$sql) or die(mysqli_error($real_sock));
		while($info	 = mysqli_fetch_array($res)){
			$count_n += 1;
		
			echo "
				<tr>
					<td data-field='s_99' data-sortable='true' >".$count_n."</td>
					<td data-field='s_0' data-sortable='true' >".$info['email']."</td>
					<td data-field='s_1' data-sortable='true' >".$info['nickname']."</td>
					<td data-field='s_2' data-sortable='true' >".$info['totalUseTime']."</td>
					<td data-field='s_3' data-sortable='true' >".$info['totalVisitCount']."</td>
					<td data-field='s_4' data-sortable='true' >".$info['gender']."</td>
					<td data-field='s_5' data-sortable='true' >".$info['phone']."</td>
					<td data-field='s_6' data-sortable='true' >".$info['birthDay']."</td>
					<td data-field='s_7' data-sortable='true' >".$info['investMoney']."</td>
				</tr>		
			";
		}
	?>
	</tbody>
<table>



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
				고객 추가
			</div>
			<div class="modal-body">
				공사중
			
			</div>
			<div class="modal-footer">
				
				 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>





