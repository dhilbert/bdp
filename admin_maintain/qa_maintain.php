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
								<td>문의사항</td>
							</tr>
						</tbody>
					</table>
					
					</div>

					<div class="panel-body">

<table data-toggle="table"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
	<thead>
		<tr>
			<th data-field="s_99" data-sortable="true" >#</th>
			<th data-field="s_0" data-sortable="true" >서비스 구분</th>
			<th data-field="s_1" data-sortable="true" >내용 요약</th>
			<th data-field="s_2" data-sortable="true" >직원 레벨</th>
			<th data-field="s_3" data-sortable="true" >상태</th>



		</tr>
	</thead>
	<tbody>
	<?php
		$count_n = 0;
		$sql	 = "select * from admin_qna order by idx DESC;";
		$res	=  mysqli_query($real_sock,$sql) or die(mysqli_error($real_sock));
		while($info	 = mysqli_fetch_array($res)){
			$count_n += 1;
			$service_kind = array('','서비스 장애 문의','서비스 기능 문의','회원 관련 문의','제휴 마케팅 이벤트 문의','기타 문의 사항');
			if($info['state']==0){
				$temp = '<font color="red">미처리</font>';
			}
			else{
				$temp = '처리';		
			}
			echo "
				<tr>
					<td data-field='s_99' data-sortable='true' >".$count_n."</td>
					<td data-field='s_0' data-sortable='true' >".$service_kind [$info['kindqna']]."</td>
					<td data-field='s_1' data-sortable='true' ><a href = 'qa_maintain_detail.php?idx=".$info['idx']."'>".substr($info['text'],0,20)."....</a></td>
					<td data-field='s_2' data-sortable='true' >".$temp."</td>
					<td data-field='s_3' data-sortable='true' >".$info['regDate']."</td>
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





