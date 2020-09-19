$(document).ready(function() {

    var $validator = $("#commentForm").validate({
          rules: {
            lead: {
              // required: true
            }
          }
        });


    $('#rootwizard').bootstrapWizard({
        onTabShow: function(tab, navigation, index) {
        var $total = navigation.find('li').length;
        var $current = index+1;
        var $percent = ($current/$total) * 100;
        $('#rootwizard .progress-bar').css({width:$percent+'%'});
    },
    'onNext': function(tab, navigation, index) {
                var $valid = $("#commentForm").valid();
                if(!$valid) {
                    $validator.focusInvalid();
                    return false;
                }
            }
    });
    init_droppable();

    $(document).on('click', '#leadUpdate', function(){
        lead_id = $('.lead_id').val();
        $.ajax({
            url:BASE_URL+'lead/ajax_update_notes',
            data:$( "#frmLeadUpdate" ).serialize(),
            type:'POST',
            dataType:'json',
            success:function(response)
            {
                if(response.rc)
                {
                    $('.lead_name').html('');
                    $('#notes').val('');
                    $('.from-lead-status').html('');
                    $('.to-lead-status').html('');
                    $('.lead_id').val('');
                    $.colorbox.close();
                }
            }
        });
    });

    $(document).on('click', '#assignSalesperson', function(){

        if($('#salesperson_user_id').val() != '')
        {

            var salesperson_user_id = $('#salesperson_user_id').val();
            var lead_id = $('.sales_lead_id').val();
            var status = $('.to-lead-status').html();
            var notes = $('#salesperson_notes').val();
            $.ajax({
                url:BASE_URL+'lead/ajax_assign_salesperson',
                data:{lead_id: lead_id, salesperson_user_id:salesperson_user_id, status:status, notes:notes},
                type:'POST',
                dataType:'json',
                success:function(response)
                {
                    if(response.rc)
                    {
                        $('.lead_name').html('');
                        $('#notes').val('');
                        $('.from-lead-status').html('');
                        $('.to-lead-status').html('');
                        $('.lead_id').val('');

                        $.colorbox.close();
                    }
                }
            });
        }
        else
        {
            alert('Please select anyone');
        }
        
    });

    $(document).on("change", ".choose-location", function(){

        var _this = $(this);
        var val = _this.val();

        fetch_leads();

    });

    function fetch_leads()
    {
        $.ajax({
            dataType: "json",
            type: "post",
            url: BASE_URL+'lead/ajax_fetch_leads',
            success: function(response) {
                $(".lead-status-container").replaceWith(response.data.lead_status);
                $(".tftable").replaceWith(response.data.lead_table);
                init_droppable();
            }
        });
    }

    function update_lead_status(lead_id,status)
    {
        $.ajax({
            url:BASE_URL+'lead/ajax_update_status',
            data:{ lead_id: lead_id, status : status},
            type:'POST',
            dataType:'json',
            success:function(response)
            {
                if(response.rc)
                {
                    // Now check for case
                    if(response.case == 1)
                    {
                        // Get the from status
                        from_status = $('#'+lead_id).attr('data-fromStatus');
                        to_status = status;
                        $('#'+lead_id).attr('data-fromStatus',status)
                        console.log(response.data.first_name);
                        $('.lead_name').html(response.data.first_name+' '+response.data.last_name);

                        $('#notes').html(response.data.notes);
                        $('.from-lead-status').html(from_status);
                        $('.to-lead-status').html(to_status);
                        $('.lead_id').val(lead_id);
                        $.colorbox({
                            inline:true, 
                            href:"#inline_content", 
                            width:"350",
                            onClosed: function () {
                                fetch_leads();
                            }
                        });
                    }
                    else if(response.case == 2)
                    {
                        from_status = $('#'+lead_id).attr('data-fromStatus');
                        to_status = status;

                        $('#salesperson_status').val(status)
                        $('#'+lead_id).attr('data-fromStatus',status)
                        console.log(response.data.first_name);
                        $('.lead_name').html(response.data.first_name+' '+response.data.last_name);

                        $('#notes').html(response.data.notes);
                        $('.from-lead-status').html(from_status);
                        $('.to-lead-status').html(to_status);
                        $('.sales_lead_id').val(lead_id);

                        //Generate the salesperson dropdown
                        var salesperson_html = '';
                        salesperson_html +="<select name='salesperson_user_id' id='salesperson_user_id'>"; 
                        $.each(response.data,function(i,v){
                            salesperson_html +="<option value='"+v.id+"'>"+v.first_name+" "+v.last_name+"</option>";
                        });

                        $('#salsesPerson').html(salesperson_html);

                        $.colorbox({
                            inline:true, 
                            href:"#inline_assign_salesperson", 
                            width:"400",
                            onClosed: function () {
                                fetch_leads();
                            }
                        });
                    }
                }
                else
                {
                    $('.error_msg').html('');
                    $('.error_msg').html(response.msg);
                    $.colorbox({
                        inline:true, 
                        href:"#inline_error", 
                        width:"350",
                        onClosed: function () {
                        }
                    });
                }
            }
        });
    }

    function init_droppable()
    {
        $( ".droppable" ).droppable({
            start : function(){
                $(this).css('width',"100%");
            },
            drop:function(event, ui) {

                if($(event.target).attr('id') != ui.draggable.data('fromstatus'))
                {
                    lead_id = ui.draggable.attr('id');

                    status = $(this).attr('id');
                    $(this).css('width',"100%");
                    update_lead_status(lead_id,status)
                }

            }
        });
        
        $(".draggable").draggable({
            helper:"clone",
            containment:"document" ,
            zIndex: 10000
        });
    }
});

   $(document).on("click",".remove_logo",function(){

    var _this = $(this);
    if(window.confirm("Are you sure you want to remove this logo?"))
    {
       var logo_path = $(this).siblings(".default_logos").attr("data-id");

             //logo_path = logo_path.replace(/ /g,'');
             $.ajax({
                data:"logo_path="+logo_path,
                dataType: "json",
                type: "post",
                url: BASE_URL+"car/delete_make_offer_logo",
                success: function(response){
                    if(response.success)
                    {
                        if(logo_path == $("input[name='logo_selected']").val())
                        {
                            $("input[name='logo_selected']").val("");
                            $("input[name='logo_selected_absolute']").val("");
                        }

                        _this.parents(".default_logo_outer").remove();
                    }
                }
            })
         }


     })
   $(document).on("click",".default_logos", function(e){
    e.preventDefault();
    var _this = $(this);
    if(_this.find("img").hasClass("active_red"))
    {
        $("input[name='logo_selected']").val("");
        $("input[name='logo_selected_absolute']").val("");
        _this.find("img").removeClass("active_red");
    }
    else
    {
        var selected_logo = _this.attr("data-id");
        var selected_logo_absolute = _this.find("img").attr("src");
        $("input[name='logo_selected']").val(selected_logo);
        $("input[name='logo_selected_absolute']").val(selected_logo_absolute);
        $('.default_logos').find('img').removeClass("active_red");
        _this.find("img").addClass("active_red");
    }
})


    /*$(document).on("click",".submit-button", function(e){
            e.preventDefault();
            //var type = $(this).attr("data-id");
            //$("#make_offer_type").val(type);
           
            //$('#offer_popup').bPopup().close();
              $("#generate-proposal-form").submit();
          })*/
$(function() {

        /*var slider = $('.bxslider').bxSlider({
          minSlides: 4,
          maxSlides: 4,
          slideWidth: 80,
          slideMargin: 8,
          pager: false,
          controls : true
      });*/

'use strict';

var url = window.location.hostname === 'blueimp.github.io' ?
'//jquery-file-upload.appspot.com/' : BASE_URL + 'car/upload_logo/';
$('#fileupload').fileupload({
 url: BASE_URL + 'car/upload_logo/',
 autoUpload: true,
 dataType: "json",
 done: function(e, data) {

    $.each(data.result.files, function(index, file) {

      var html = '<div class="default_logo_outer"><div class="remove_logo"> ×</div><a href="javascript:void(0)" class="default_logos custom_logos" data-id="'+file.relativeUrl+'"><img src="'+file.thumbnailUrl+'"></a></div>';
                    //
                        //$('.bxslider').bxSlider().destroySlider();
                        $("#new_logo_progress").after(html);

                       // init_logo_slider();
                   });

    $("#new_logo_progress").hide();
    $("#new_logo").show();

},
progressall: function(e, data) {
    $("#new_logo").hide();
    $("#new_logo_progress").show();

}
}).prop('disabled', !$.support.fileInput)
.parent().addClass($.support.fileInput ? undefined : 'disabled');
});

$(document).ready(function(){

    jQuery(document).on("click",".delete-lead",function(){
     if (confirm("Are you sure, you want to delete this lead?")) {
        window.location= jQuery(this).attr('data-href');
        return true;
    }
    else{
        return false;
    }
});

    $(document).on("click","#create-pdf", function(e){
        e.preventDefault();
            //var type = $(this).attr("data-id");
            $("#generate-proposal-type").val(0);

            //$('#offer_popup').bPopup().close();
            $("#generate-proposal-form").submit();
            $(".generate-proposals").bPopup().close();
              //window.setTimeout(window.location.href = BASE_URL + 'lead/listing',5000);
          })
    $(document).on("click","#print", function(e){
        e.preventDefault();
            //var type = $(this).attr("data-id");
            $("#generate-proposal-type").val(1);

            //$('#offer_popup').bPopup().close();
            $("#generate-proposal-form").submit();
            $(".generate-proposals").bPopup().close();
              //window.setTimeout(window.location.href = BASE_URL + 'lead/listing',5000);
          })
    /*$(document).on("click",".next-fieldset", function(){
        
    });*/
    //$("#generate-proposal-form").formToWizard({ submitButton: 'SaveAccount' });
    $(document).on("click",".generate-proposals", function(){
        console.log('abc');
        $('#generate-proposal-popup').bPopup({
            easing: 'easeOutBack', //uses jQuery easing plugin
            speed: 450,
            transition: 'slideDown',
            positionStyle: 'fixed',
            modalClose: false ,
            onClose: function(){

            } 
        });
        console.log('abc');
        var lead_id = $(this).attr('data-lead-id');
        $('#lead-id').val(lead_id);
        $.ajax({
            url:BASE_URL + 'lead/ajax_get_lead_details_by_id',
            data:{
                'lead_id': lead_id
            },
            method:'post',
            dataType: 'json',
            success: function(data){
                $("#lead-first-name").val(data.lead.first_name);
                $("#lead-last-name").val(data.lead.last_name);
                var car_id = $("#lead-interested-car :selected").val();
                var select = '';
                select += '<select class="form-control" id="lead-interested-car" name="car_id">';
                select += '<option value=""></option>';
                if(data.cars_count > 0){
                  $.each(data.cars, function(i, c){
                     select +=  '<option value="'+ c.id +'" data-purchase-price="'+ c.purchase_price +'"';
                     if(car_id==c.id)
                     {
                        select += 'selected';
                    }
                    select += '>'+ c.brand + ' ' + c.model + ' ' + c.type +'</option>';
                });
              }
              select += '</select>';
                    //$("#lead-interested-cars").html(select)
                    $("#lead-interested-cars").html(select);
                }
            });
});



$(document).on("change","#lead-interested-car", function(){
    alert('a');console.log('a');
  var car_purchase_price = $("#lead-interested-car :selected").attr("data-purchase-price");
  $("#car-purchase-price-input").val(car_purchase_price);
  $("#car-purchase-price").append(car_purchase_price);
  $("#total-price").val(car_purchase_price);

  var car_status = $("#lead-interested-car :selected").attr("data-car-status");
  alert(car_status);
  if(car_status == "used")
  {
       $('.guarantee_finance_div').css('display', 'block');
  }

});

$(document).on("change","#margin",function(){

    var price = $("#car-purchase-price-input").val();
    var margin = $("#margin").val();
    var your_price = $("#your-price").val();
    var vat = $("#vat").val();
    var vat_amount = $("#vat-amount").val();
    var total_price = $("#total-price").val();

    if(isNaN(margin)|| margin.trim()=="")
    {
        margin = "0.00";
        $("#margin").val(margin);
    }
    console.log(margin);
    console.log(price);
    your_price = parseFloat(price) + parseFloat(margin);
    console.log(your_price);
    $("#your-price").val("");
    $("#your-price").val(parseFloat(your_price).toFixed(2));

    vat_amount = (vat/100)*your_price;
    $("#vat-amount").val("");
    $("#vat-amount").val(parseFloat(vat_amount).toFixed(2));

    total_price = your_price + parseFloat(vat_amount);
    $("#total-price").val("");
    $("#total-price").val(parseFloat(total_price).toFixed(2));
});


$(document).on("change","#your-price",function(){
 var price = $("#car-purchase-price-input").val();
 var margin = $("#margin").val();
 var your_price = $("#your-price").val();
 var vat = $("#vat").val();
 var vat_amount = $("#vat-amount").val();
 var total_price = $("#total-price").val();

 if(isNaN(your_price)|| your_price.trim()=="")
 {
    your_price = "0.00";
    $("#your-price").val(your_price);
}
if(parseFloat(your_price) < parseFloat(price))
{
    your_price = price;
    $("#your-price").val(your_price);
}
margin = parseFloat(your_price) - parseFloat(price);
$("#margin").val("");
$("#margin").val(parseFloat(margin).toFixed(2));

vat_amount = (vat/100)* parseFloat(your_price);
$("#vat-amount").val("");
$("#vat-amount").val(parseFloat(vat_amount).toFixed(2));

total_price = parseFloat(your_price) + parseFloat(vat_amount);
$("#total-price").val("");
$("#total-price").val(parseFloat(total_price).toFixed(2));
});

$(document).on("change","#total-price",function(){
    var price = $("#car-purchase-price-input").val();
    var margin = $("#margin").val();
    var your_price = $("#your-price").val();
    var vat = $("#vat").val();
    var vat_amount = $("#vat-amount").val();
    var total_price = $("#total-price").val();

    if(isNaN(total_price)|| total_price.trim()=="")
    {
        total_price = "0.00";
        $("#total-price").val(total_price);
    }

    vat_amount = (vat/(100+vat))*total_price;
    $("#vat-amount").val("");
    $("#vat-amount").val(parseFloat(vat_amount).toFixed(2));

    your_price = total_price - parseFloat(vat_amount);
    $("#your-price").val("");
    $("#your-price").val(parseFloat(your_price).toFixed(2));

    margin = parseFloat(your_price) - parseFloat(price);
    $("#margin").val("");
    $("#margin").val(parseFloat(margin).toFixed(2));
});

$(document).on("change","#vat",function(){
    var price = $("#car-purchase-price-input").val();
    var margin = $("#margin").val();
    var your_price = $("#your-price").val();
    var vat = $("#vat").val();
    var vat_amount = $("#vat-amount").val();
    var total_price = $("#total-price").val();

    vat_amount = (vat/100)* parseFloat(your_price);
    $("#vat-amount").val("");
    $("#vat-amount").val(parseFloat(vat_amount).toFixed(2));

    total_price = parseFloat(your_price) + parseFloat(vat_amount);
    $("#total-price").val("");
    $("#total-price").val(parseFloat(total_price).toFixed(2));

    margin = parseFloat(your_price) - parseFloat(price);
    $("#margin").val("");
    $("#margin").val(parseFloat(margin).toFixed(2));
});
});

$("#generate-proposal-form").simpleform({
 speed : 500,
 transition : 'fade',
 progressBar : true,
 showProgressText : true,
 validate: true,
 resetForm: true
});

function validateForm(formID, Obj){

 switch(formID){
    case 'generate-proposal-form' :
    Obj.validate({
      rules: {
         first_name: {
            required: true
        },
        last_name: {
            required: true
        },
        street: {
            required: true
        },
        town: {
            required: true
        },
        house_number: {
            required: true
        },
        phone_number: {
            required: true
        },
        postal_code: {
            required: true
        },
        car_id: {
            required: true
        }
    },
    messages: {
     first_name: {
        required: "Please enter your first name"
    },
    last_name: {
       required: "Please enter your last name"
   },
   street: {
    required: "Please enter street name"
},
town: {
    required: "Please enter town name"
},
house_number: {
    required: "Please enter house number"
},
phone_number: {
    required: "Please enter phone number"
},
postal_code: {
    required: "Please enter postal code"
},
car_id: {
    required: "Please, select car."
}
}
});
    return Obj.valid();
    break;
}

$(document).on("click", "a[href='#generate-proposal']", function()
    {
        reset_form("#form-make-offer");

        var first_name = $("#lead-list option:selected").data('first-name');
        var last_name = $("#lead-list option:selected").data('last-name');
        var selling_cost = $("#car-selling-cost").val();

        $("#lead-first-name").val(first_name);
        $("#lead-last-name").val(last_name);
        $("#car-purchase-price-input").val(selling_cost);

        $(".no_logo").trigger("click");
    });

    $('#rootwizard').bootstrapWizard({
        onTabShow: function(tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index+1;
            var $percent = ($current/$total) * 100;
            $('#rootwizard .progress-bar').css({width:$percent+'%'});
        },
        'onNext': function(tab, navigation, index) {
            var $valid = $("#form-make-offer").valid();
            if(!$valid) {
                $validator.focusInvalid();
                return false;
            }
        },
        'onTabClick': function(tab, navigation, index) {
            return false;
        }
    });
}
