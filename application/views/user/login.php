<!DOCTYPE html>
<html class="bg-black">
	<head>
		<meta charset="UTF-8">
		<title>My Blog Website | Log in</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<!-- bootstrap 3.0.2 -->

		<?php echo Assets::css("admin/css/animate.css"); ?>
		<?php echo Assets::css("admin/css/font-awesome.min.css"); ?>
		<?php echo Assets::css("admin/css/simple-line-icons.css"); ?>
		<?php echo Assets::css("admin/css/font.css"); ?>
		<?php echo Assets::css("admin/js/plugins/bootstrap/dist/css/bootstrap.css"); ?>
		<?php echo Assets::css("admin/js/plugins/datepicker/css/bootstrap-datepicker.css"); ?>
		<?php echo Assets::css("admin/css/app.css"); ?>

		<?php echo Assets::js("admin/js/jquery-1.11.3.min.js"); ?>
	</head>
	<body>
		<div class="app app-header-fixed">
			<div class="container w-xxl w-auto-xs">
				<a href class="navbar-brand block m-t">My Blog Website</a>
				<div class="m-b-lg">
					<?php  if($this->session->flashdata('success_msg')) { ?>
					<div class="alert alert-success">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<?php echo $this->session->flashdata('success_msg'); ?>
					</div>
					<?php } ?>
					<?php  if($this->session->flashdata('error_msg')) { ?>
					<div class="alert alert-danger">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<?php echo $this->session->flashdata('error_msg'); ?>
					</div>
					<?php } ?>
					<form name="form" method="post" action="">
						<div class="text-danger wrapper text-center"></div>
						<div class="list-group list-group-sm">
							<div class="list-group-item">
								<input type="text" name="email" class="form-control no-border" placeholder="Email" value="<?php echo $this->input->post('email'); ?>" />
								<font color = "red"><?php echo form_error('email', '<div class="error">', '</div>'); ?></font>
							</div>
							<div class="list-group-item">
								<input type="password" name="password" class="form-control no-border" placeholder="Password"/>
								<font color = "red"><?php echo form_error('password', '<div class="error">', '</div>'); ?></font>
							</div>
						</div>
						<button type="submit" class="btn btn-lg btn-primary btn-block">Log In</button>
					</form>
				</div>
			</div>
		</div>

		<?php echo Assets::js("admin/js/plugins/bootstrap/dist/js/bootstrap.js"); ?>
		<?php echo Assets::js("admin/js/ui-load.js"); ?>
		<?php echo Assets::js("admin/js/ui-jp.config.js"); ?>
		<?php echo Assets::js("admin/js/ui-jp.js"); ?>
		<?php echo Assets::js("admin/js/ui-nav.js"); ?>
		<?php echo Assets::js("admin/js/ui-toggle.js"); ?>
		<?php echo Assets::js("admin/js/ui-client.js"); ?>
	</body>
</html>