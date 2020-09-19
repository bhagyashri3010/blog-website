<!doctype html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title>My Blog Website</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- favicon -->
		<!-- <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico"> -->
		<!-- Place favicon.ico in the root directory -->
		<!-- all css here -->
		<!-- style css -->
		<?php echo Assets::css("frontend/css/bootstrap.min.css"); ?>
		<?php echo Assets::css("frontend/css/animate.css"); ?>
		<?php echo Assets::css("frontend/css/font-awesome.min.css"); ?>
		<?php echo Assets::css("frontend/css/pe-icon-7-stroke.min.css"); ?>
		<?php echo Assets::css("frontend/css/meanmenu.min.css"); ?>
		<?php echo Assets::css("frontend/css/magnific-popup.css"); ?>
		<?php echo Assets::css("frontend/css/slick.min.css"); ?>
		<?php echo Assets::css("frontend/css/camera.css"); ?>
		<?php echo Assets::css("frontend/css/jquery-ui.min.css"); ?>
		<?php echo Assets::css("frontend/css/responsive.css"); ?>
		<?php echo Assets::css("frontend/css/style.css"); ?>
		<!-- modernizr js -->
		<?php echo Assets::js("frontend/js/vendor/modernizr-2.8.3.min.js"); ?>
		<?php echo Assets::js("frontend/js/jquery-3.5.1.min.js"); ?>
	</head>
	<body>
		<!--[if lt IE 8]>
			<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->

		<!-- Preloader Start -->
		<div class="preloader">
			<div class="loading-center">
				<div class="loading-center-absolute">
					<div class="object object_one"></div>
					<div class="object object_two"></div>
					<div class="object object_three"></div>
				</div>
			</div>
		</div>
		<!-- Preloader End -->

		<!-- header section start -->
		<header>
			<div class="header-top">
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<div class="left floatleft">
								<ul>
									<li>
										<i class="fa fa-phone"></i>
										<a href="tel:+123456">123456</a>
									</li>
									<li>
										<i class="fa fa-envelope-o"></i>
										<a href="mailto:myblogwebsite@gmail.com">myblogwebsite@gmail.com</a>
									</li>
								</ul>
							</div>
							<!-- <div class="right floatright">
								<ul>
									<li>
										<form action="#">
											<button type="submit">
												<i class="fa fa-search"></i>
											</button>
											<input type="search" placeholder="Search" />
										</form>
									</li>
								</ul>
							</div> -->
						</div>
					</div>
				</div>
			</div>
		</header>
		<!-- header section end -->
		<!-- page banner area start -->
		<div class="page-banner">
			<!-- <img class="banner-img" src="<?php echo site_url('resources/frontend/img/banner_image.svg'); ?>" alt="Page Banner" /> -->
			<div class="centered">My Blog Website</div>
		</div>
		<!-- page banner area end -->