<div id="content" class="app-content" role="main">
	<div class="app-content-body ">
	<div class="hbox hbox-auto-xs hbox-auto-sm" ng-init="
		app.settings.asideFolded = false;
		app.settings.asideDock = false;
	  ">
	  <!-- main -->
	  <div class="col">
		<!-- main header -->
		<div class="bg-light lter b-b wrapper-md">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<h1 class="m-n font-thin h3 text-black">Dashboard</h1>
				</div>
			</div>
		</div>
		<!-- / main header -->
		<div class="wrapper-md" ng-controller="FlotChartDemoCtrl">
			<div class="">
				<?php  if($this->session->flashdata('success_msg')) { ?>
				<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong></strong> <?php echo $this->session->flashdata('success_msg'); ?>
				</div>
				<?php } ?>
				<?php  if($this->session->flashdata('error_msg')) { ?>
				<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<?php echo $this->session->flashdata('error_msg'); ?>
				</div>
				<?php } ?>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					Welcome to My Blog Website Dashboard
				</div>
			</div>

			<!-- <div class="panel panel-default"> -->
				<div class="row text-center">
					<div class="col-md-6">
					  <div class="panel padder-v item">
						<div class="h1 text-info font-thin h1 block cars-in-stock"><?php echo $blog_count['rc'] ? $blog_count['data'] : 0; ?></div>
						<span class="text-xs">Blogs</span>
						<div class="top text-right w-full">
						</div>
					  </div>
					</div>
					<div class="col-md-6">
					  <div href class="block panel padder-v bg-primary item">
						<span class="text-white font-thin h1 block cars-queued"><?php echo $category_count['rc'] ? $category_count['data'] : 0; ?></span>
						<span class="text-muted text-xs">Category</span>
						<span class="bottom text-right w-full">
						</span>
					  </div>
					</div>
			</div>
		</div>
		</div>
		</div>
	</div>
</div>