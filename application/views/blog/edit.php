<?php echo Assets::js("admin/js/plugins/bootstrap-filestyle/src/bootstrap-filestyle.js"); ?>
<?php echo Assets::js("admin/ckeditor/ckeditor.js"); ?>
<style type="text/css">
.delete_photo {
	position: relative;
	bottom: 36px;
	right: 22px;
}
</style>
<!-- content -->
<div id="content" class="app-content" role="main">
	<div class="app-content-body">
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
		<div class="row">
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
				Edit Blog
			</div>
			<div class="panel-body">
				<form role="form" class="form-horizontal form-groups-bordered" method="post" enctype="multipart/form-data">
					<?php if (isset($blog) && !empty($blog)) { ?>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Title<span class="text-danger"> *</span> :</label>
								<input type="text" class="form-control" name="title" value="<?php echo ($this->input->post('title')) ?  $this->input->post('title') : $blog['title'] ;?>">
								<div class="text-danger"><?php echo form_error('title');?></div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">URL<span class="text-danger"> *</span> :</label>
								<input type="text" class="form-control" name="url" value="<?php echo ($this->input->post('url')) ?  $this->input->post('url') : $blog['url'] ;?>"/>
								<div class="text-danger"><?php echo form_error('url');?></div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Title<span class="text-danger"> *</span> :</label>
								<input type="text" class="form-control" name="page_title" value="<?php echo ($this->input->post('page_title')) ?  $this->input->post('page_title') : $blog['page_title'] ;?>"/>
								<div class="text-danger"><?php echo form_error('page_title');?></div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Blog Category <span class="text-danger"> *</span> :</label>
									<select name="blog_category" id="blog-category" class="required form_control" ui-jq="chosen">
										<?php
											if(isset($blog_categories) && ! empty($blog_categories))
											{
												foreach($blog_categories as $bc)
												{?>
													<option value="<?php echo $bc['id'] ?>" <?php echo ($this->input->post('blog_category') == $bc['id']) ? 'selected' : (($blog['category_id'] == $bc['id']) ? 'selected' : ''); ?>><?php echo $bc['name'] ?></option>
										<?php	}
											}
										?>
									</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label class="control-label">Body<span class="text-danger"> *</span> :</label>
								<textarea id="editor" cols="50" rows="5" class ="form-control" name="body" > <?php echo ($this->input->post('body')) ? $this->input->post('body') : $blog['body']; ?></textarea>
								<script type="text/javascript">
								  CKEDITOR.replace( 'editor',
									{
										allowedContent: {
											// Allow all content.
											$1: {
												elements: CKEDITOR.dtd,
												attributes: true,
												styles: true,
												classes: true
											}
										}
									});
								  CKEDITOR.edit
								</script>
								<div class="text-danger"><?php echo form_error('body');?></div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Short description<span class="text-danger"> *</span> :</label>
								<textarea class="form-control" name="short_description"><?php echo ($this->input->post('short_description')) ?  $this->input->post('short_description') : $blog['short_description'] ;?></textarea>
								<div class="text-danger"><?php echo form_error('short_description');?></div>
							</div>
						</div>
						<?php
						$dir = FCPATH . "uploads/blogs/images/" . $blog['id'] . "/";

						if( $blog['image_hash'] != "" && file_exists( $dir.$blog['image_hash'] ) )
						{
						?>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Image : </label>
									<img class="blog-img" src="<?php echo site_url('uploads/blogs/images/' . $blog['id'] . '/' . $blog['image_hash'] ); ?>">
									<a href="#delete_photo_popup" data-toggle="modal" data-blog-id="<?php echo $blog['id']; ?>" title="Delete image" class="delete_photo btn m-b-xs btn-xs btn-danger"><i class="fa fa-times"></i></a>
								</div>
							</div>
						<?php
							} else { ?>
							<!-- Add Image -->
							<div class="col-sm-6">
								<div class="form-group">
									<label>Add Image <span class="text-danger"> *</span> : </label>
									<input type="file" name="image" class="filestyle">
									<div class="text-danger"><?php echo form_error('image');?></div>
								</div>
							</div>
						<?php } ?>
					</div>
					<button type="submit" class="btn btn-sm btn-primary">Update</button>
				<?php } ?>
				</form>
			</div>
		</div>
	</div>
	</div>
</div>

<!-- delete_photo_popup Modal -->
<div id="delete_photo_popup" class="modal fade" data-backdrop="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 style="margin:0px;">Delete Image</h3>
			</div>
			<form id="delet_photo_form" action="<?php echo site_url('blog/delete_image'); ?>" method="post">
				<div class="modal-body">
					<input type="hidden" class="blog_id" name="blog_id" value="">
					<div class="row">
						<div class="col-md-12">
							Are you sure you want to delete this image?
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="delete_photo_btn btn btn-default">OK</button>
					<button type="button" class="btn btn-default close_modal" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div><!-- End of delete_photo_popup Modal -->

<style>
	.blog-img {
		height: 20%;
		width:	20%;
		margin: 5%;
	}
	.form-horizontal .form-group {
		margin-right: 0px!important;
		margin-left: 0px!important;
	}

	.chosen-container{
		width:100%!important;
	}
</style>
<script type="text/javascript">
$(document).ready(function(){

	$(document).on("click", ".delete_photo", function(e){
		var blog_id = $(this).attr('data-blog-id');
		$(".blog_id").val(blog_id);
	});
});
</script>