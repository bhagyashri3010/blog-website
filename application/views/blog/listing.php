<style>
	.tftable th
	{
		border-bottom: 1px solid #ddd;
	}
	.blog-img img {
		height: 100px;
	}
</style>
<!-- content -->
<div id="content" class="app-content" role="main">
	<div class="app-content-body ">
		<!-- main header -->
		<div class="bg-light lter b-b wrapper-md">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<h1 class="m-n font-thin h3 text-black">Blogs</h1>
				</div>
			</div>
		</div>
		<!-- / main header -->
		<div class="wrapper-md">
			<div class="">
				<?php  if($this->session->flashdata('success')) { ?>
				<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong></strong> <?php echo $this->session->flashdata('success'); ?>
				</div>
				<?php } ?>
				<?php  if($this->session->flashdata('error')) { ?>
				<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<?php echo $this->session->flashdata('error'); ?>
				</div>
				<?php } ?>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<a class="btn btn-primary btn-md pull-right btn-xs" href="<?php echo site_url("blog/add");?>" style="float:right;">Add BLog</a>
					Blog Listing
				</div>
				<form action="<?php echo site_url('blog/listing'); ?>" method="get" class="clearfix">
					<div class="">
						<div class="col-md-4" style="margin-bottom:15px;">
							<input class="form-control" type="text" name="search_term" value="<?php if($this->input->get('search_term') && $this->input->get('search_term') != ""){echo $this->input->get('search_term');}?>" placeholder="Type or paste here">
						</div>
						<div class="col-md-4">
							<button  class="btn btn-success search-button">Search</button>
						</div>
					</div>
				</form>
				<div class="blog-table table-responsive">
					<table class="tftable table table-striped m-b-none">
						<tr>
							<th>Image</th>
							<th style="width:40%">Description</th>
							<th>Category</th>
							<th>Added on</th>
							<th>Action</th>
						</tr>

						<?php if(!empty($blogs)){ foreach ($blogs as $blog){ ?>

						<tr class="blog">
							<td class="blog-img">
								<?php if(file_exists(FCPATH.'uploads/blogs/images/'.$blog['id']."/".$blog['image_hash'])) :?>
									<img src = "<?php echo base_url();?>uploads/blogs/images/<?php echo $blog['id']."/".$blog['image_hash']?>">
								<?php endif; ?>
							</td>
							<td class="blog-content">
								<h2><?php echo $blog['title']?></h2>
								<div class="blog-para">
									<?php echo trim(strip_tags($blog['short_description']));?>
								</div>
							</td>
							<td class="blog-category">
								<?php echo $blog['category'] ?>
							</td>
							<td class= "added_on ">
								<?php echo date('jS, F Y',strtotime($blog['added_on']));?>
							</td>
							<td class="blog-action ">
								<a class="btn btn-info btn-xs" href="<?php echo site_url("blog/edit/".$blog['id']);?>">Edit</a>
								<a href="#delete_blog_popup" data-toggle="modal" data-blog-id="<?php echo $blog['id']; ?>" class="delete_blog btn btn-xs btn-danger">Delete</a>
								</td>
							</tr>
							<?php }} else { ?>
							<td colspan="4" class="text-center">No blogs added yet</td>
							<?php }?>
					</table>
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-sm-12 text-right text-center-xs">
							<?php echo $links; ?>
						</div>
					</div>
				</footer>
			</div>
		</div>
	</div>
</div>

<!-- delete_blog_popup Modal -->
<div id="delete_blog_popup" class="modal fade" data-backdrop="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="h3">Delete Blog</h3>
			</div>
			<form id="delete_blog_form" action="<?php echo site_url('blog/delete_blog'); ?>" method="post">
				<div class="modal-body">
					<input type="hidden" class="blog_id" name="blog_id" value="">
					<div class="row">
						<div class="col-md-12">
							Are you sure you want to delete this blog
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-default">OK</button>
					<button type="button" class="btn btn-default close_modal" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End of delete_blog_popup Modal -->

<script>
	$(document).ready(function(){
		$(document).on("click", ".delete_blog", function(e){
			var blog_id = $(this).attr('data-blog-id');
			$(".blog_id").val(blog_id);
		});
	});
</script>