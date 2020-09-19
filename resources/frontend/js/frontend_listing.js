$(document).ready(function() {
	$(document).on('change', '#blog_filter', function() {

		var category = $('.blog_category').find(":selected").val();
		var form = $("#blog_filter");
		form.submit();
	});
});