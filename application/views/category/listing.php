<?php echo Assets::js("admin/js/custom/category_listing.js"); ?>
<!-- content -->
<div id="content" class="app-content" role="main">
	<div class="app-content-body ">
		<!-- main header -->
		<div class="bg-light lter b-b wrapper-md">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<h1 class="m-n font-thin h3 text-black">Categories</h1>
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
					<a href="#add_category_popup" data-toggle="modal" class="btn btn-primary btn-md pull-right btn-xs" style="float:right;">Add Category</a>
					Category Listing
				</div>
				<form action="<?php echo site_url('category/listing'); ?>" method="get" class="clearfix">
					<div class="">
						<div class="col-md-4" style="margin-bottom:15px;">
							<input class="form-control" type="text" name="search_term" value="<?php if($this->input->get('search_term') && $this->input->get('search_term') != ""){echo $this->input->get('search_term');}?>" placeholder="Type or paste here">
						</div>
						<div class="col-md-4">
							<button  class="btn btn-success search-button">Search</button>
						</div>
					</div>
				</form>
				<div class="table-responsive">
					<table class="tftable table table-striped m-b-none">
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Added on</th>
							<th>Action</th>
						</tr>

						<?php if(!empty($categories)){ foreach ($categories as $category){ ?>

						<tr>
							<td></td>
							<td>
								<?php echo $category['name'] ?>
							</td>
							<td class= "added_on ">
								<?php if ($category['added_on'] != '0000-00-00 00:00:00') {
									echo date('jS, F Y',strtotime($category['added_on']));
								} ?>
							</td>
							<td class="category-action ">
								<a href="#edit_category_popup" data-toggle="modal" data-category-id="<?php echo $category['id']; ?>" data-category-name="<?php echo $category['name'] ?>" class="edit_category btn btn-xs btn-info">Edit</a>
								</td>
							</tr>
							<?php }} else { ?>
							<td colspan="4" class="text-center">No categories yet added yet</td>
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

<div id="add_category_popup" class="modal fade" data-backdrop="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="h3">Add Category</h3>
			</div>
			<form id="add_category" action="<?php echo site_url('category/add'); ?>" method="post">
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Name<span class="text-danger"> *</span> :</label>
								<input type="text" class="form-control" name="name" value=""/>
								<div class="text-danger error"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success add_category_btn">Add</button>
					<button type="button" class="btn btn-default close_modal" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="edit_category_popup" class="modal fade" data-backdrop="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="h3">Edit Category</h3>
			</div>
			<form id="edit_category_form" action="<?php echo site_url('category/edit'); ?>" method="post">
				<div class="modal-body">
					<input type="hidden" class="category_id" name="category_id" value="">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Name<span class="text-danger"> *</span> :</label>
								<input type="text" class="form-control category_name" name="category_name" value=""/>
								<div class="text-danger error"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-info">Edit</button>
					<button type="button" class="btn btn-default close_modal" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<style>
	.tftable th
	{
		border-bottom: 1px solid #ddd;
	}
</style>
