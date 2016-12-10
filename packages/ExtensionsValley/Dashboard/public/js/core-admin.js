//Admin core action custom Js
//This function is used for add/Edit toolbars
function findRoute(route_name) {
    var protocol = window.location.protocol;
    var host_name = window.location.host;
    var main_uri = protocol + "//" + host_name + "/admin/";
    if (route_name == 'add') {
        var route_path = $('#add_route').val();
        //document.location.href = main_uri + route_path;
        action_url = main_uri + route_path;
        jQuery('#addeditview').attr('action',action_url);
        jQuery('#addeditview').submit();
    } else {

        var sel_length = $('.cid_checkbox:checked').length;
        var sel_value = $('.cid_checkbox:checked').val();
        if (sel_length <= 0) {
            alert('Please select any record!');
            return false;
        }
        if (sel_length > 1) {
            alert('You cannot modify more than 1 record at a time!');
            return false;
        } else {
            if (route_name == 'edit') {
                var route_path = $('#edit_route').val();
            } else {
                var route_path = $('#view_route').val();
            }

           var action_url = main_uri + route_path + sel_value;
           jQuery('#addeditview').attr('action',action_url);
           jQuery('#addeditview').submit();
        }

    }
    return false;
}

// function for managing global actions publish/unpublish/remove.
function findAction(action_name) {
    var sel_length = $('.cid_checkbox:checked').length;
    if (sel_length <= 0) {
        alert("Please select at least one record to perform an action!");
        return false;
    }
    if (action_name == 'enable') {
        jQuery('#action_type').val('enable');
        jQuery('#admin_listing').submit();
    } else if (action_name == "disable") {
        jQuery('#action_type').val('disable');
        jQuery('#admin_listing').submit();
    } else if (action_name == 'remove') {
        if (confirm("This action cannot be undo. Are you sure to continue ?")) {
            jQuery('#action_type').val('remove');
            jQuery('#admin_listing').submit();
        }
    } else if (action_name == 'forcedelete') {
        if (confirm("This action cannot be undo . Are you sure to continue ?")) {
            jQuery('#action_type').val('forcedelete');
            jQuery('#admin_listing').submit();
        }
    } else if (action_name == 'restore') {
        if (confirm("Are you sure to continue ?")) {
            jQuery('#action_type').val('restore');
            jQuery('#admin_listing').submit();
        }
    }
}

jQuery(document).ready(function () {
    /*jQuery("#checkall").on('click',function(){
     if(jQuery('#checkall').is(':checked')){
     jQuery('.cid_checkbox').prop('checked','checked');
     }else{
     jQuery('.cid_checkbox').removeAttr('checked')
     }
     });*/
    jQuery(document).on('ifChecked', 'input', function (event) {
        if (this.id == "checkall") {
            jQuery('.cid_checkbox').prop('checked', 'checked');
            jQuery('.icheckbox_flat-green').addClass('checked');

        }
    });

    jQuery(document).on('ifUnchecked', 'input', function (event) {
        if (this.id == "checkall") {
            jQuery('.cid_checkbox').removeAttr('checked');
            jQuery('.icheckbox_flat-green').removeClass('checked');
        }
    });
});

function findView(action_name) {
    var sel_length = $('.cid_checkbox:checked').length;
    if (sel_length <= 0) {
        alert("Please select at least one record to perform an action!");
        return false;
    }
    jQuery('#action_type').val('view');
    jQuery('#admin_listing').submit();
}

jQuery(document).ready(function () {
    if (jQuery('.js-department').length) {
        jQuery('#department').val(jQuery('#department').val());
    }

    jQuery('[data-toggle="tooltip"]').tooltip();
})

jQuery(document).ready(function () {
    jQuery('.js-permission-role').on('change', function () {

        document.location.href = "aclmanager?id=" + jQuery('.js-permission-role').val();
    });
})

jQuery(document).ready(function () {
    jQuery("#check_all_permissions").on('click', function () {
        if (jQuery('#check_all_permissions').is(':checked')) {
            jQuery('.permission_checkbox').prop('checked', 'checked');
        } else {
            jQuery('.permission_checkbox').removeAttr('checked')
        }
    });
});

//Permission Manager
jQuery(document).ready(function () {
    jQuery(document).on('ifChecked', 'input', function (event) {
        if (this.id == "view_all_permissions") {
            jQuery('.view_chk').prop('checked', 'checked');
            jQuery('.view_chk').parent().addClass('checked');

        }
    });
    jQuery(document).on('ifUnchecked', 'input', function (event) {
        if (this.id == "view_all_permissions") {
            jQuery('.view_chk').removeAttr('checked');
            jQuery('.view_chk').parent().removeClass('checked');
        }
    });
    jQuery(document).on('ifChecked', 'input', function (event) {
        if (this.id == "add_all_permissions") {
            jQuery('.add_chk').prop('checked', 'checked');
            jQuery('.add_chk').parent().addClass('checked');

        }
    });
    jQuery(document).on('ifUnchecked', 'input', function (event) {
        if (this.id == "add_all_permissions") {
            jQuery('.add_chk').removeAttr('checked');
            jQuery('.add_chk').parent().removeClass('checked');
        }
    });
    jQuery(document).on('ifChecked', 'input', function (event) {
        if (this.id == "edit_all_permissions") {
            jQuery('.edit_chk').prop('checked', 'checked');
            jQuery('.edit_chk').parent().addClass('checked');

        }
    });
    jQuery(document).on('ifUnchecked', 'input', function (event) {
        if (this.id == "edit_all_permissions") {
            jQuery('.edit_chk').removeAttr('checked');
            jQuery('.edit_chk').parent().removeClass('checked');
        }
    });
    jQuery(document).on('ifChecked', 'input', function (event) {
        if (this.id == "delete_all_permissions") {
            jQuery('.del_chk').prop('checked', 'checked');
            jQuery('.del_chk').parent().addClass('checked');

        }
    });
    jQuery(document).on('ifUnchecked', 'input', function (event) {
        if (this.id == "delete_all_permissions") {
            jQuery('.del_chk').removeAttr('checked');
            jQuery('.del_chk').parent().removeClass('checked');
        }
    });
    jQuery(document).on('ifChecked', 'input', function (event) {
        if (this.id == "check_all_permissions") {
            jQuery('.ch_box').prop('checked', 'checked');
            jQuery('.ch_box').parent().addClass('checked');

        }
    });
    jQuery(document).on('ifUnchecked', 'input', function (event) {
        if (this.id == "check_all_permissions") {
            jQuery('.ch_box').removeAttr('checked');
            jQuery('.ch_box').parent().removeClass('checked');
        }
    });
    jQuery(document).on('ifChecked', 'input', function (event) {
        var current_row_id = this.id.replace('check_current_row_', '');
        if (jQuery('.view_' + current_row_id).length) {
            jQuery('.view_' + current_row_id).prop('checked', 'checked');
            jQuery('.view_' + current_row_id).parent().addClass('checked');
            jQuery('.add_' + current_row_id).prop('checked', 'checked');
            jQuery('.add_' + current_row_id).parent().addClass('checked');
            jQuery('.edit_' + current_row_id).prop('checked', 'checked');
            jQuery('.edit_' + current_row_id).parent().addClass('checked');
            jQuery('.del_' + current_row_id).prop('checked', 'checked');
            jQuery('.del_' + current_row_id).parent().addClass('checked');
        }


    });
    jQuery(document).on('ifUnchecked', 'input', function (event) {
        var current_row_id = this.id.replace('check_current_row_', '');
        if (jQuery('.view_' + current_row_id).length) {
            jQuery('.view_' + current_row_id).removeAttr('checked');
            jQuery('.view_' + current_row_id).parent().removeClass('checked');
            jQuery('.add_' + current_row_id).removeAttr('checked');
            jQuery('.add_' + current_row_id).parent().removeClass('checked');
            jQuery('.edit_' + current_row_id).removeAttr('checked');
            jQuery('.edit_' + current_row_id).parent().removeClass('checked');
            jQuery('.del_' + current_row_id).removeAttr('checked');
            jQuery('.del_' + current_row_id).parent().removeClass('checked');
        }
    });
});

function uninstallPackage(route_path){

    if(confirm("It will remove Package data completelyand cannot be undo. Are you sure to continue ? ")){
        document.location.href=route_path;
    }
}
jQuery(document).ready(function(){
    jQuery('.buildslug').on('keyup',function(){
        var slug  = jQuery(this).val();
        var url =  slug.toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'');
        var target = jQuery(this).attr('data-target');
        jQuery('.'+target).val(url);
    });
    jQuery('.buildpageurl').on('change',function(){
        var slug  = jQuery(this).val();
        var target = jQuery(this).attr('data-target');
        jQuery('.'+target).val(slug);
    });
});

