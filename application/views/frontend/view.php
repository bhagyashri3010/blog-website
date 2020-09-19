<div class="container">
	<div class="left floatleft" style="margin: 2%;">
		<a class="back-btn" href="<?php echo ( isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '' ? $_SERVER['HTTP_REFERER'] : site_url('blog/frontend') )?>"> <  Back </a>
	</div>

	<!-- blog content section start -->
	<section class="blog-area blog-two blog-margin section-padding">
		<div class="container">
			<div class="row">
				<?php if (isset($blog) && !empty($blog)) { ?>
					<div class="col-sm-12">
						<div class="blog-item">
							<div class="blog-img">
							<?php $dir = FCPATH . "uploads/blogs/images/" . $blog['id'] . "/";
							if( $blog['image_hash'] != "" && file_exists( $dir.$blog['image_hash'] ) )
							{ ?>
								<img style="width: 66%; max-height: 400px;" src="<?php echo site_url('uploads/blogs/images/' . $blog['id'] . '/' . $blog['image_hash'] ); ?>" alt="Blog" />
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
								<p><?php echo $blog['body']; ?></p>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</section>
	<!-- blog content section end -->
</div>

