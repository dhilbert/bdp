<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');
include_once('../contents_header.php');
include_once('../contents_profile.php');
include_once('../contents_sidebar.php');



$idx = isset($_GET['idx']) ? $_GET['idx'] : Null;

$sql	 = "select * from admin_qna where idx ='".$idx."';";
$res	=  mysqli_query($real_sock,$sql) or die(mysqli_error($real_sock));
$info	 = mysqli_fetch_array($res);


$service_kind = array('','서비스 장애 문의','서비스 기능 문의','회원 관련 문의','제휴 마케팅 이벤트 문의','기타 문의 사항');



?>


			<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
					<?php
					$array = array(
						array('#','문의사항 처리')
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
								<td>문의 사항 상세</td>
								<td align='right'><a href = "mailto:<?php echo $info['email']?>" class="btn btn-success login-btn">고객 이메일 보내기</a></td>
							</tr>
						</tbody>
					</table>


					</div>

					<div class="panel-body">
			

				


						<table width = '80%' border=1>
							<tbody>
								<tr >
									<td width = '20%'> 처리 상태 </td>
									<td width = '80%'> <?php 
											if($info['state']==0){
												echo "<font color='red'>미 처리</font>";
											}
											else{
												echo "<font >처리</font>";											
											}
											


									?></td>
								</tr>
								<tr >
									<td width = '20%'> 문의 일자 </td>
									<td width = '80%'><?php echo $info['regDate'];?></td>
								</tr>

								<tr >
									<td width = '20%'> 문의 종류</td>
									<td width = '80%'> <?php echo $service_kind[$info['kindqna']];

									?></td>
								</tr>
								<tr>
									<td> 문의 내용</td>
									<td> <?php echo $info['text'];?></td>
								</tr>
								<tr>
									<td> 첨부 이미지</td>
									<td><img src ='<?php echo $info['imageUrl'];?>' height='50%'></td>
								</tr>
							</tbody>							
						</table>


			


					</div>
				</div>
			</div>		</div>

	<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
							처리 사항
					</div>
					
					<div class="panel-body">
						글 남기면 바로 처리됨

										  
					  
<table data-toggle="table"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
	<thead>
		<tr>
			<th data-field="s_99" data-sortable="true" >#</th>
			<th data-field="s_0" data-sortable="true" >처리자</th>
			<th data-field="s_1" data-sortable="true" >처리 내용</th>
			<th data-field="s_2" data-sortable="true" >처리 일자</th>

		</tr>
		</tr>
	</thead>
	<tbody>
	<?php
		$sql	 = "select * from admin_qna
		
		
		;";
		$count_n = 0;
		$sql	 = "
				select a.text , a.regDate, b.admin_name,a.adminqa_idx
				
				from admin_qa_detail as a
					Join admin_member as b
				on b.idx = a.adminmember_idx
				where a.adminqa_idx ='".$idx."';
		
		
		;";
		$res	=  mysqli_query($real_sock,$sql) or die(mysqli_error($real_sock));
		while($info	 = mysqli_fetch_array($res)){
			$count_n += 1;			
			echo "
				<tr>
					<td data-field='s_99' data-sortable='true' >".$count_n."</td>
					<td data-field='s_0' data-sortable='true' >".$info['admin_name']."</td>
					<td data-field='s_1' data-sortable='true' >".$info['text']."</td>
					<td data-field='s_2' data-sortable='true' >".$info['regDate']."</td>	
				</tr>		
			";
		}

	?>

	</tbody>
</table>
<br>
<h2> 처리 사항 남기기</h2>
<form name="frm" role="form" method="get" action="qa_maintain_detail_proc.php">
	<textarea name = 'text' class='form-control' ></textarea>
	<input  type='hidden' name='idx' value="<?php echo $idx?>">
	
	<input  type='submit' class="btn btn-success login-btn" type="submit" value="한줄 남기기" width='100%'>


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
  <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
			
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>







