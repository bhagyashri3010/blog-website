<?php
if(!isset($active)) {
	$active = '';
}
?>

<!-- aside -->
<aside id="aside" class="app-aside hidden-xs bg-dark">
	<div class="aside-wrap">
		<div class="navi-wrap">
			<!-- nav -->
			<nav ui-nav class="navi clearfix" id = "scrollable">
				<ul class="nav">
					<li class="line dk"></li>
					<li class="<?php if($active !="" && $active == 'dashboard') echo 'active'; ?>" >
						<a href="<?php echo base_url()."user/dashboard"; ?>">
							<span class="pull-right text-muted">
								<i class="fa fa-fw fa-angle-down text-active"></i>
							</span>
							<i class="fa fa-home"></i>
							<span><?php echo 'Dashboard';?></span>
						</a>
					</li>

					<li class="<?php if($active !="" && $active == 'Blogs') echo 'active'; ?>" >
						<a href class="auto">
							<span class="pull-right text-muted">
								<i class="fa fa-fw fa-angle-right text"></i>
								<i class="fa fa-fw fa-angle-down text-active"></i>
							</span>
							<i class="fa fa-newspaper-o"></i>
							<span>Blogs</span>
						</a>
						<ul class="nav nav-sub dk">
							<li>
								<a href="<?php echo site_url('blog/listing'); ?>"><i class="fa fa-fw fa-angle-right text"></i><span>Listing</span>
								</a>
							</li>
						</ul>
					</li>
					<li class="line dk"></li>

					<li class="<?php if($active !="" && $active == 'Category') echo 'active'; ?>" >
						<a href class="auto">
							<span class="pull-right text-muted">
								<i class="fa fa-fw fa-angle-right text"></i>
								<i class="fa fa-fw fa-angle-down text-active"></i>
							</span>
							<i class="fa fa-clipboard"></i>
							<span>Category</span>
						</a>
						<ul class="nav nav-sub dk">
							<li>
								<a href="<?php echo site_url('category/listing'); ?>">
								<i class="fa fa-fw fa-angle-right text"></i>
									<span>Listing</span>
								</a>
							</li>
						</ul>
					</li>
					<li class="line dk"></li>
				</ul>
			</nav>
		</div>
	</div>
</aside>
<!-- / aside -->

<style>
.app-aside-folded #aside
{
	overflow-y: visible!important;
	overflow-x: visible!important;
}
.app-header-fixed #aside
{
	position: fixed;
	/*height: 370px;*/
	overflow-y: auto;
	top: 49px;
	overflow-x: hidden;
	bottom: 0px;
	z-index: 700;
}
.navi ul.nav li li a
{
	padding: 10px 20px!important;
}
.content
{
	display: -webkit-box;
}
.fa-clipboard
{
	color: #17A589;
}
.fa-clipboard:hover
{
	color: cyan;
}
.fa-line-chart
{
	color: #6EF204;
}
.fa-line-chart:hover
{
	color: #A5F308;
}
.fa-car
{
	color: #FA5882;
}
.fa-car:hover
{
	color:#C38FD8;
}
.fa-pie-chart
{
	color: yellow;
}
.glyphicon-user
{
	color: #F79F81;
}
.fa-bar-chart
{
	color: #2EFE2E;
}
.glyphicon-briefcase
{
	color: #C3F74B;
}
.fa-users
{
	color: #23b7e5;
}
.fa-file
{
	color: #7266ba;
}
.fa-home
{
	color: #23b7e5;
}
#aside > li.active > .nav-sub .dk
{
	position: relative;
	content: "\e580";
	list-style-type: square!important;
	color: #FFFFFF!important;
}
.glyphicon-wrench
{
	color: violet;
}
</style>