<!DOCTYPE html>
<html>
		<head>
			<title>
				<?php
				if (isset($title) && $title != '') {
					echo $title;
				}

				?>
			</title>
			<meta charset="UTF-8">
			<title>My Blogs Website | Admin Panel</title>
			<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

			<!-- template css files -->
			<?php echo Assets::css("admin/css/animate.css"); ?>
			<?php echo Assets::css("admin/css/font-awesome.min.css"); ?>
			<?php echo Assets::css("admin/css/simple-line-icons.css"); ?>
			<?php echo Assets::css("admin/css/font.css"); ?>
			<?php echo Assets::css("admin/js/plugins/bootstrap/dist/css/bootstrap.css"); ?>
			<?php //echo Assets::css("admin/js/plugins/datepicker/css/bootstrap-datepicker.css"); ?>
			<?php echo Assets::css("admin/css/app.css"); ?>

			<?php echo Assets::css("admin/css/waitMe.min.css"); ?>
			<?php echo Assets::css("admin/css/jquery-confirm.min.css"); ?>
			<?php //echo Assets::css("admin/css/custom/table_sort.css"); ?>

			<?php echo Assets::js("admin/js/jquery-1.11.3.min.js"); ?>

			<?php echo Assets::js("admin/js/plugins/jquery-ui.min.js"); ?>

			<?php //echo Assets::js("admin/js/plugins/slimscroll/jquery.slimscroll.min.js"); ?>

			<?php //echo Assets::js("admin/js/plugins/jquery-timepicker/jquery.timepicker.js"); ?>
			<?php //echo Assets::css("admin/js/plugins/jquery-timepicker/jquery.timepicker.css"); ?>

			<?php //echo Assets::js("admin/js/plugins/jquery-timepicker/lib/bootstrap-datepicker.js"); ?>
			<?php //echo Assets::css("admin/js/plugins/jquery-timepicker/lib/bootstrap-datepicker.css"); ?>

			<?php //echo Assets::js("admin/js/plugins/jquery-timepicker/datepair.min.js"); ?>
			<?php //echo Assets::js("admin/js/plugins/datepicker/js/bootstrap-datepicker.js"); ?>
			<?php echo Assets::js("admin/js/plugins/jquery.blockUI.js"); ?>

			<?php //echo Assets::js("admin/js/global.js"); ?>
			<?php //echo Assets::js("admin/js/plugins/jquery_tab/jquery.tabbedcontent.min.js"); ?>
			<?php //echo Assets::js("admin/js/jquery.validate.min.js"); ?>
			<?php //echo Assets::js("admin/js/jquery.cookie.js"); ?>
			<?php //echo Assets::js("admin/js/simpleform.min.js"); ?>
			<?php echo Assets::js("admin/js/jquery.fileupload.js"); ?>
			<?php echo Assets::js("admin/js/jquery.fileupload-image.js"); ?>
			<?php //echo Assets::js("admin/js/bootbox.min.js"); ?>
			<?php echo Assets::js("admin/js/waitMe.min.js"); ?>
			<?php //echo Assets::js("admin/js/jquery-confirm.min.js"); ?>
			<?php //echo Assets::css("admin/js/plugins/farbtastic/farbtastic.css"); ?>

			<?php //echo Assets::js("admin/js/custom/activity_notification.js"); ?>
			<script>
				var BASE_URL = "<?php echo base_url(); ?>";
                var FCPATH = "<?php echo addslashes(FCPATH); ?>";
			</script>
		</head>
		<body>
			<div class="app app-header-fixed">
				<!-- header -->
				<header id="header" class="app-header navbar" role="menu">
						<!-- navbar header -->
						<div class="navbar-header bg-dark" style="margin: -1px 0 0 -1px;">
							<button class="pull-right visible-xs dk" ui-toggle-class="show" target=".navbar-collapse">
								<i class="glyphicon glyphicon-cog"></i>
							</button>
							<button class="pull-right visible-xs " ui-toggle-class="off-screen" target=".app-aside" ui-scroll="app">
								<i class="glyphicon glyphicon-align-justify"></i>
							</button>

							<a href="<?php echo base_url()."user/dashboard"; ?>" class="navbar-brand text-lt">
								<!-- <img src="<?php //echo base_url()."resources/admin/img/favicon.ico"; ?>">
								<img src="<?php //echo base_url()."resources/admin/img/logo.png"; ?>" alt="." class="hide"> -->
								<span class="hidden-folded m-l-xs">My Blog Website</span>
							</a>
							<!-- / brand -->
						</div>
						<!-- / navbar header -->

						<!-- navbar collapse -->
						<div class="collapse pos-rlt navbar-collapse box-shadow bg-white-only">
							<!-- buttons -->
							<div class="nav navbar-nav hidden-xs">
								<a href="#" class="btn no-shadow navbar-btn" ui-toggle-class="app-aside-folded" target=".app">
									<i class="fa fa-dedent fa-fw text"></i>
									<i class="fa fa-indent fa-fw text-active"></i>
								</a>
							</div>
							<!-- / buttons -->


							<!-- nabar right -->
							<ul class="nav navbar-nav navbar-right">
								<li class="dropdown">
									<a href="#" data-toggle="dropdown" class="dropdown-toggle clear" data-toggle="dropdown">
										<span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm">
											<img src="<?php echo base_url('resources/admin/img/user.png') ?>"  alt="...">
											<i class="on md b-white bottom"></i>
										</span>
										<span class="hidden-sm hidden-md"><?php echo $this->user['name']; ?></span> <b class="caret"></b>
									</a>
									<!-- dropdown -->
									<ul class="dropdown-menu animated fadeInRight w">
										<li>
											<a href="<?php echo base_url("logout") ?>">Log out</a>
										</li>
									</ul>
									<!-- / dropdown -->
								</li>
							</ul>
							<!-- / navbar right -->
						</div>
						<!-- / navbar collapse -->
				</header>
				<!-- / header -->

<style>
.nav-btn
{
	margin-top: 10px;
	margin-bottom: 8px;
	margin-right:8px;
}
@media (max-width: 340px){
		.navbar-header > button {
			padding: 10px 8px!important;
	}
}
.setting
{
	background-color: #bce8f1;
}
.logout
{
	background-color: #EBF085;
	/*color: #FFFFFF;*/
}
</style>