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
						array('#','문의사항')
					);
					breadcrumb($array);
					?>
			<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
					<table width = '100%'>
						<tbody >
							<tr>
								<td>조정 지역 색상 관리</td>
								<td align='right'><a href="#" data-toggle="modal" data-target="#myModal3" class="btn btn-success login-btn">색상 변경</a></td>
							</tr>
						</tbody>
					</table>
					
					</div>

					<div class="panel-body">

<table data-toggle="table"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
	<thead>
		<tr>
			<th data-field="s_99" data-sortable="true" >#</th>
			<th data-field="s_0" data-sortable="true" >이름</th>
			<th data-field="s_1" data-sortable="true" >색상</th>


		</tr>
	</thead>
	<tbody>
	<?php
		$count_n = 0;
		$sql	 = "select * from region_code_speculation;";
		$res	=  mysqli_query($real_sock,$sql) or die(mysqli_error($real_sock));
		while($info	 = mysqli_fetch_array($res)){
		$count_n+=1;
			echo "
				<tr>
					<td data-field='s_99' data-sortable='true' >".$count_n."</td>
					<td data-field='s_0' data-sortable='true' >".$info['title']."</td>
					<td data-field='s_1' data-sortable='true' ><div style='background-color:".$info['color']."'><font color='white'>".$info['color']."</font></div></td>

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
				직원 추가
			</div>
			<div class="modal-body">
				일반 흰색 고정<br>


				<form name="frm" role="form" method="get" action="insert_user_proc.php">
						
				<?php 
				
				$sql	 = "select * from region_code_speculation;";
				$res	=  mysqli_query($real_sock,$sql) or die(mysqli_error($real_sock));
				while($info	 = mysqli_fetch_array($res)){
					echo "
						<label>".$info['title']."</label>
							<input type='color' name='col".$info['idx']."' value = '".$info['color']."'>
							<br>
					
					
					" ;



				}

				
				
				
				
				?>
						

				


			</div>
			<div class="modal-footer">
				<input  type='submit' class="btn btn-success login-btn" type="submit" value="추가">
				</form>

				 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>





