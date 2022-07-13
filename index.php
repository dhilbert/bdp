<?php
include_once('g_header.php');
?>
<body>
	<div id="wrapper">
		<!-- start header -->
		<header>
			<div class="navbar navbar-default navbar-static-top">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="index.php"><span>BDP</span> 관리자 페이지</a>
					</div>
				
				</div>
			</div>
		</header>
	


	<section id="featured">
	<!-- start slider -->
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
	<!-- Slider -->
        <div id="main-slider" class="flexslider">
            <ul class="slides">

                <img src="img/slides/1.jpg" alt="" />
            </ul>
        </div>
			</div>
		</div>
	</div>	
	
	

	</section>

<section class="callaction">
	<div class="container">
		<div class="row">
						<h2>
						<form name="frm" role="form" method="get" action="index_proc.php">

							   <input class="form-control" placeholder="아이디를 입력 하세요" name="admin_id">
						       <input class="form-control" type='password' placeholder="비밀번호를 입력하세요" name="admin_pw">
						       <input  type='submit' class="btn btn-success login-btn" type="submit" value="Log in">

							     </form>
						 </h2>


		</div>
	</div>
	</section>


	

<?php
include_once('g_footer.php');



?>