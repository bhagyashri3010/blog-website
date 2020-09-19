$(document).ready(function(){
    check_sub_permissions();
    get_extra_permissions();
    
    

	 $(document).on("click",".main-role",function() {

	 	// Declaration
	 	var $this;
	 	var role_id;
	 	var permissions;

	 	// Save this instnace
	 	$this = $(this);

        // Get the role id
        role_id = $this.val();
        
        // Check if its checked or not
        if($this.is(":checked"))
        {
        	
        	
        	// Check all the permission below it, If there are any
        	if($this.parent('li').children('ul.permission-list').length)
        	{
        		permissions = $this.parent('li').children('ul.permission-list').find('.permissions');
        		permissions.prop('checked', true);
        	}
        	
           role(role_id,"add");
           owners(owner_id,"add");
        }
        else
        {
            // Unchecked all the checbox
            if($this.parent('li').children('ul.permission-list').length)
            {
                permissions = $this.parent('li').children('ul.permission-list').find('.permissions');
                permissions.prop('checked', false);
            }

            role(role_id,"remove");
        }

        get_extra_permissions();
    });

    $(document).on("click",".extra-permission",function() {

        // Declaration
        var $this;
        var $permission_id;

        // Save this instnace
        $this = $(this);

        // Get the permission id
        $permission_id = $this.val();
        var role_id = $(this).closest('ul').parent().find('input').val();

         // Check if its checked or not
        if($this.is(":checked"))
        {

            // Add role if the main role is not checked
            if(!$(this).closest('ul').parent().find('.main-role').is(':checked'))
            {
                $(this).closest('ul').parent().find('.main-role').prop('checked', true);
                role(role_id,"add");
            }

            var $permission_id_array = new Array();

            $(this).closest('ul').find('input[type="checkbox"]:checked').each(function(){
                $permission_id_array.push($(this).val());
            })
            $(this).closest('ul').find('input[type="checkbox"]').prop('checked', true);
            permission(role_id,$permission_id_array,"add");
            

            $(".main-role:checkbox:checked").parent('li').find(".extra-permission:checkbox[value="+$permission_id+"]").prop('checked', true);
        }
        else
        {
            if($(this).closest('ul').find('input[type="checkbox"]:checked').length == 0)
            {
                $(this).closest('ul').parent().find('.main-role').prop('checked', false);
                role(role_id,"remove");
            }

            permission(role_id,$permission_id,"remove");
        }

        

    });

    $(document).on("click",".extra-permission-list",function() {

        // Declaration
        var $this;
        var $permission_id;

        // Save this instnace
        $this = $(this);

        // Get the permission id
        $permission_id = $this.val();

         // Check if its checked or not
        if($this.is(":checked"))
        {
            permission(0,$permission_id,"add");
        }
        else
        {
            permission(0,$permission_id,"remove");
        }

    })


     function get_extra_permissions()
     {
        // Get all the permissions which are checked
        
        $checked_permission = new Array();
        $('.permissions:checked').each(function(){
            $checked_permission.push($(this).val())
        });
        
        // Get all the extra permission which are checked
        $extra_checked_permission = new Array();
        
        
        $('.extra-permission-list:checked').each(function(){
            $extra_checked_permission.push($(this).val())
        });

        var unique_permissions = $checked_permission.filter( onlyUnique );

        var extra_permission_html = '';
        var user_id = $('.user_id').val();
        $.ajax({
            url:BASE_URL+'role/ajax_get_extra_permission',
            data:{ data: user_id},
            type:'POST',
            dataType:'json',
            success:function(response)
            {
                extra_permission_html += "<ul class='extra_permission_listing'>";
                if(response.rc)
                {
                    $.each( response.data, function( i, v ) {
                        extra_permission_html += "<div class='checkbox'><label class='i-checks'><input type='checkbox' class = 'extra-permission-list' value='"+v.id+"' ><i></i>"+v.permission_name+"</label></div>";
                    });
                }
                extra_permission_html += "</ul>";
                $('.extra-permission-container').html(extra_permission_html);

                // Make previous extra permission checked
                $.each($extra_checked_permission,function(index,data){
                    $(".extra-permission-list:checkbox[value="+data+"]").prop('checked', true)
                });
                
                get_extra_permission_assigned_to_user();
            }
        })
     }


    function onlyUnique(value, index, self) 
    { 
        return self.indexOf(value) === index;
    }

    function role(role_id,owner_id='',action_type,jGrowlNotification)
    {
        jGrowlNotification = typeof jGrowlNotification !== 'undefined' ? jGrowlNotification : true;
        // Get the user_id
        var user_id = $('.user_id').val();

        var data = { role_id:role_id,action_type:action_type,user_id:user_id}

        $.ajax({
            url:BASE_URL+'role/ajax_role_action',
            data:data,
            type:'POST',
            dataType:'json',
            success:function(response)
            {
                if(jGrowlNotification)
                {
                    if(response.rc)
                    {
                        $.jGrowl(response.msg);
                    }
                    else
                    {
                        $.jGrowl(response.msg);
                    }
                }
                
            }
        });

    }

    function permission(role_id,permission_id,action_type)
    {
        // Get the user_id
        var user_id = $('.user_id').val();
        
        var data = { role_id:role_id,permission_id:permission_id,action_type:action_type,user_id:user_id}

        $.ajax({
            url:BASE_URL+'permission/ajax_permission_action',
            data:data,
            type:'POST',
            dataType:'json',
            success:function(response)
            {
                if(response.rc)
                {
                    $.jGrowl(response.msg);
                }
                else
                {
                    $.jGrowl(response.msg);
                }

                if(role_id != 0)
                {
                    get_extra_permissions();
                }
                
            }
        });
    }

    function check_sub_permissions()
    {
        $('.main-role:checked').each(function(){
            $this = $(this);

            var user_id = $('.user_id').val();
            var role_id = $this.val();
                    
            if($this.parent('li').children('ul.permission-list').length)
            {
                var data = {role_id : role_id, user_id:user_id}
                //permissions = $this.parent('li').children('ul.permission-list').find('.permissions');
                //permissions.prop('checked', true);

                $.ajax({
                url:BASE_URL+'admin/permission/ajax_get_extra_permission_by_role_id',
                data:data,
                type:'POST',
                dataType:'json',
                success:function(response)
                {
                    
                    if(response.rc)
                    {
                        $.each( response.data, function( i, v ) {
                            
                            // Uncheck the checkbox which are removed
                            if(v.status == 'removed')
                            {
                                $(".extra-permission-list:checkbox[value="+v.permission_id+"]").prop('checked', false);
                                $(".main-role:checkbox[value = "+v.role_id+"]").parent('li').find(".extra-permission:checkbox[value="+v.permission_id+"]").prop('checked', false);
                            }
                            else if(v.status == 'added')
                            {
                                $(".extra-permission-list:checkbox[value="+v.permission_id+"]").prop('checked', true);
                                $(".main-role:checkbox[value = "+v.role_id+"]").parent('li').find(".extra-permission:checkbox[value="+v.permission_id+"]").prop('checked', true);
                            }
                            
                        });
                    }
                    
                    if($(".main-role:checkbox[value = "+role_id+"]").parent('li').find(".extra-permission:checked").length == 0)
                    {
                        $(".main-role:checkbox[value = "+role_id+"]").prop('checked', false);
                    }

                    get_extra_permissions();
                }

                });
            }
        });
        
        
    }

    function owners(owner_id,action_type,jGrowlNotification)
    {
        jGrowlNotification = typeof jGrowlNotification !== 'undefined' ? jGrowlNotification : true;
        // Get the user_id
        var user_id = $('.user_id').val();
        var owner_id = $('.owner_id').val();
        var data = { role_id:role_id,action_type:action_type,user_id:user_id,owner_id:owner_id}

        $.ajax({
            url:BASE_URL+'role/ajax_assign_owner',
            data:data,
            type:'POST',
            dataType:'json',
            success:function(response)
            {
                if(jGrowlNotification)
                {
                    if(response.rc)
                    {
                        $.jGrowl(response.msg);
                    }
                    else
                    {
                        $.jGrowl(response.msg);
                    }
                }
                
            }
        });

    }


})