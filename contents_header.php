<?php
if(!$_SESSION['admin_lv']){
	echo "<script>alert('잘못된 접근입니다.');parent.location.replace('/BDP_ADMIN/');</script> ";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- 메타 데이터 -->
<title>복덕판 시스템</title>
<meta name="description" content="" />
<meta name="author" content="복덕판 관리자 시스템" />


<link href="/BDP_ADMIN/css/bootstrap.min.css" rel="stylesheet">

<link href="/BDP_ADMIN/css/datepicker3.css" rel="stylesheet">
<link href="/BDP_ADMIN/css/styles.css" rel="stylesheet">


<link href="/BDP_ADMIN/css/bootstrap-table.css" rel="stylesheet">
<link href="/BDP_ADMIN/css/bootstrap-table.css" rel="stylesheet">

<script src="/BDP_ADMIN/js/lumino.glyphs.js"></script>

<script type="text/javascript" src="/BDP_ADMIN/js/loader.js"></script>

</head>



<?php
function breadcrumb($array){
?>
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="/JB_SYSTEM/home.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				

				<?php
				for($i = 0 ; $i < count($array)-1 ; $i++ ){
					echo "<li><a href='".$array[$i][0]."'>".$array[$i][1]."</a></li>";
				}
				echo "<li class='active'>".$array[count($array)-1][1]."</a></li>";
				?>
			</ol>
		</div><!--/.row-->
<?php
}
?>