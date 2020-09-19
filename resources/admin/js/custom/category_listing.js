$(document).ready(function(){
	//add_category_btn

	$(document).on("click", ".add_category_btn", function(e){
		e.preventDefault();
		var cat_name = $('#add_category_popup input[name="name"]').val();
		if (cat_name == "") {
			$('#add_category_popup').find('.error').html('Name is reqiured');
		} else {
			var form = $("#add_category");
			form.submit();
		}
	});

	$(document).ready(function(){
		$(document).on("click", ".edit_category", function(e){
			var category_id = $(this).attr('data-category-id');
			var category_name = $(this).attr('data-category-name');
			$(".category_id").val(category_id);
			$(".category_name").val(category_name);
		});
	});
});