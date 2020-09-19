<?php echo Assets::js("frontend/js/frontend_listing.js"); ?>
<div class="container">
	<div class="shop-menu clearfix">
		<?php if (isset($categories) && !empty($categories)) { ?>
			<div class="right floatright">
				<ul>
					<li>
						<div class="custom-select">
							<form name="blog_filter" method="get" action="<?php echo site_url('blog/frontend');?>" id="blog_filter">
								<select name="blog_category" class="form-control blog_category">
									<option value="">All</option>
									<?php foreach ($categories as $category) { ?>
										<option value="<?php echo $category['id']?>" <?php if(isset($blog_category) && $blog_category==$category['id']){echo "selected=selected";}?>><?php echo $category['name']?></option>
									<?php } ?>
								</select>
							</form>
						</div>
						<p style="">Sort By Category</p>
					</li>
				</ul>
			</div>
		<?php } ?>
	</div>
	<!-- blog content section start -->
	<section class="blog-area blog-two blog-margin section-padding">
		<div class="container">
			<div class="row">
				<?php if (isset($blogs) && !empty($blogs)) {
					foreach ($blogs as $blog) { ?>
						<div class="col-sm-4">
							<div class="blog-item">
								<div class="blog-img">
								<?php $dir = FCPATH . "uploads/blogs/images/" . $blog['id'] . "/";
								if( $blog['image_hash'] != "" && file_exists( $dir.$blog['image_hash'] ) )
								{ ?>
									<img style="width: 66%;" src="<?php echo site_url('uploads/blogs/images/' . $blog['id'] . '/' . $blog['image_hash'] ); ?>" alt="Blog" />
								<?php } else { ?>
									<img src="<?php echo site_url('resources/frontend/img/default_blog.png'); ?>">
								<?php } ?>
								</div>
								<div class="blog-text clearfix">
									<h4><?php echo $blog['title']; ?></h4>
									<p class="date-com"><?php if ($blog['added_on'] != '0000-00-00 00:00:00') {
										echo date('jS, F Y',strtotime($blog['added_on']));
									} ?></p>
									<p class="date-com"><?php echo $blog['category']; ?></p>
									<hr class="line"/>
									<p><?php echo $blog['short_description']; ?></p>
									<div class="view-more">
										<a class="shop-btn" href="<?php echo site_url('blog/view/'.$blog['url']); ?>">Read More</a>
									</div>
								</div>
							</div>
						</div>
					<?php }
				} else { ?>
					<div class="col-sm-12">
						<h2 class="text-center">No blogs found</h3>
					</div>
				<?php } ?>
			</div>
		</div>
	</section>
	<!-- blog content section end -->

	<div class="row">
		<div class="col-xs-12">
			<div class="shop-menu clearfix margin-close">
				<div class="right floatright text-center">
					<div class="pagnation-ul">
						<?php echo $links; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
