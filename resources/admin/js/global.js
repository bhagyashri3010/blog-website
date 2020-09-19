// $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
$(document).ready(function() {
    $("#activities").on("click", function() {
        $("#unread-activity-count").text("");
        $.ajax({
            type: "POST",
            url: BASE_URL + "activity/update_activity_seen_for_user",
            success: function(response) {}
        });
    });

    $('#activities-list').slimScroll({
        height: '300px'
    });

    $(document).on('click', '.close_modal', function(e) {
        $(this).closest('form').find("input[type=text], textarea").val("");
    });

    $(document).on('click', '.change-language', function(e) {
        e.preventDefault();
        var lang = $(this).attr('id');
        $.cookie("lang", lang, {
            path: '/'
        });
        window.language = lang;
        window.location.reload();
    });

    $('#sendCarPictures').on('shown.bs.modal', function() {
        var id = $('#curr_user_id').val();
        $.ajax({
            dataType: 'json',
            data: {
                user_id: id
            },
            type: 'POST',
            url: BASE_URL + 'car/ajax_get_user_published_channel_id',
            success: function(response) {
                if (response.data) {
                    $('.email_template_list').replaceWith(response.emails_template);
                }
            }
        });
    });
})

function reset_form(selector) {
    $(selector).find('.error').html('');
    $(selector).find('.error').html('');
    $(selector).find('.error').html('');
    // $(selector).find('input').val('');
    $(selector).find('select').val('');
    $(selector).find('textarea').val('');
}