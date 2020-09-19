<?php echo Assets::js("admin/js/plugins/bootstrap-filestyle/src/bootstrap-filestyle.js"); ?>
<?php echo Assets::js("admin/ckeditor/ckeditor.js"); ?>
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
					Add Blog
				</div>
				<div class="panel-body">
					<form role="form" class="form-horizontal form-groups-bordered" method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Title<span class="text-danger"> *</span> :</label>
									<input type="text" class="form-control" name="title" value="<?php echo ($this->input->post('title')) ?  $this->input->post('title') : "" ;?>"/>
									<div class="text-danger"><?php echo form_error('title');?></div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">URL<span class="text-danger"> *</span> :</label>
									<input type="text" class="form-control" name="url" value="<?php echo ($this->input->post('url')) ?  $this->input->post('url') : "" ;?>"/>
									<div class="text-danger"><?php echo form_error('url');?></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Page title <span class="text-danger"> *</span> :</label>
									<input type="text" class="form-control" name="page_title" value="<?php echo ($this->input->post('page_title')) ?  $this->input->post('page_title') : "" ;?>"/>
									<div class="text-danger"><?php echo form_error('page_title');?></div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Blog Category <span class="text-danger"> *</span> :</label>
									<select ui-jq="chosen" name="blog_category" id="blog-category" class="form-control">
										<option value="">Please select</option>
										<?php
											if(isset($blog_categories) && ! empty($blog_categories))
											{
												foreach($blog_categories as $bc)
												{?>
													<option value="<?php echo $bc['id']; ?>"
													<?php
														if($bc['id']==$this->input->post('blog_category'))
														{
															echo 'selected="selected"';
														}
													?>
													><?php echo $bc['name'] ?></option>
										<?php	}
											}
										?>
									</select>
									<div class="text-danger"><?php echo form_error('blog_category');?></div>
								</div>
							</div>
						</div>
						<div class="row ">
							<div class="col-sm-12">
								<div class="form-group">
									<label class="control-label">Body<span class="text-danger"> *</span> :</label>
									<textarea id="editor" cols="50" rows="5" class ="form-control" name="body" > <?php echo ($this->input->post('body')) ? $this->input->post('body') : ""; ?></textarea>
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
										CKEDITOR.add
									</script>
									<div class="text-danger"><?php echo form_error('body');?></div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Short description <span class="text-danger"> *</span> :</label>
									<textarea name="short_description" data-required="true" class="form-control"><?php echo ($this->input->post('short_description')) ?  $this->input->post('short_description') : "" ;?></textarea>
									<div class="text-danger"><?php echo form_error('short_description');?></div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Add Imgaes <span class="text-danger"> *</span> : </label>
									<input type="file" name="image" class="filestyle">
									<?php if(form_error('image')) { ?>
									<div class="text-danger"><?php echo form_error('image');?></div>
									<?php } ?>
								</div>
							</div>
						</div>
						<button type="submit" class="btn btn-sm btn-primary">Save</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
	.form-horizontal .form-group {
		margin-right: 0px!important;
		margin-left: 0px!important;
	}
</style>
