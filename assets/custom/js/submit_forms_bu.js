function show_error(error_str)
{
    notif({
        msg: error_str,
        type: "error",
        position: "center",
        opacity: 0.9,
        timeout: 50000,
        clickable: true,
        multiline: true,
        bgcolor: "#ca3131",
    });
}


function show_success(msg)
{

    notif({
        msg: msg,
        type: "success",
        position: "center",
        opacity: 0.9,
        timeout: 5000,
        clickable: true,
        multiline: true,
        bgcolor: "#45883d",
    });
}
function loader_start()
{
    if (jQuery('body').find('#resultLoading').attr('id') != 'resultLoading') {
        jQuery('body').append('<div id="resultLoading" style="display:none"><div><i style="font-size: 46px;color: #F74949; " class="fa fa-spinner fa-spin fa-3x fa-fw" aria-hidden="true"></i></div><div class="bg"></div></div>');
    }

    jQuery('#resultLoading').css({
        'width': '100%',
        'height': '100%',
        'position': 'fixed',
        'z-index': '10000000',
        'top': '0',
        'left': '0',
        'right': '0',
        'bottom': '0',
        'margin': 'auto'
    });

    jQuery('#resultLoading .bg').css({
        'background': '#ffffff',
        'opacity': '0.8',
        'width': '100%',
        'height': '100%',
        'position': 'absolute',
        'top': '0'
    });

    jQuery('#resultLoading>div:first').css({
        'width': '250px',
        'height': '75px',
        'text-align': 'center',
        'position': 'fixed',
        'top': '0',
        'left': '0',
        'right': '0',
        'bottom': '0',
        'margin': 'auto',
        'font-size': '16px',
        'z-index': '10',
        'color': '#ffffff'

    });

    jQuery('#resultLoading .bg').height('100%');
    jQuery('#resultLoading').fadeIn(300);
    jQuery('body').css('cursor', 'wait');
}

function loader_stop()
{
    jQuery('#resultLoading .bg').height('100%');
    jQuery('#resultLoading').fadeOut(300);
    jQuery('body').css('cursor', 'default');
}
$(document).ready(function () {
    $("#product_add_form").submit(function (e) {
        e.preventDefault();
        $("#product_add_form").find('[type=submit]').attr('disabled', 'disabled');
        var formData = new FormData($("#product_add_form")[0]);
        //loader_start();
        //$('.error-msg').html('');

        $.ajax({
            url: site_url + 'products/ajaxproductadd',
            dataType: 'json',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (resp) {
                loader_stop();
                $("#product_add_form").find('[type=submit]').removeAttr('disabled', 'disabled');
                if (resp.type == "success") {
                    var form = document.getElementById("product_add_form");
                    form.reset();
                    show_success(resp.message);

                } else if (resp.type == "warning") {
                    $.each(resp.message, function (index, elem) {
                        $("#err_" + index).html(elem);
                        window.console.log(elem);
                    });
                }
            }
        });
    });
    $("#product_update_form").submit(function (e) {
        e.preventDefault();
        $("#product_update_form").find('[type=submit]').attr('disabled', 'disabled');
        var formData = new FormData($("#product_update_form")[0]);
        loader_start();
        $('.error-msg').html('');

        $.ajax({
            url: site_url + 'products/ajaxproductupdate',
            dataType: 'json',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (resp) {
                loader_stop();
                $("#product_update_form").find('[type=submit]').removeAttr('disabled', 'disabled');
                if (resp.type == "success") {
                    show_success(resp.message);
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000)

                } else if (resp.type == "warning") {
                    $.each(resp.message, function (index, elem) {
                        $("#err_" + index).html(elem);
                        window.console.log(elem);
                    });
                }
            }
        });
    });
//    $( "#deleteProduct" ).click(function() {
//        var id= $(this).attr('data-val');
//        window.console.log(id);
//          if(confirm("Are you sure? Do you want to delete this product?"))
//          {
//                  return true;
//          }
//          else
//                return false;
//        });

 $("#user_update_form").submit(function (e) {
        e.preventDefault();
        $("#user_update_form").find('[type=submit]').attr('disabled', 'disabled');
        var formData = new FormData($("#user_update_form")[0]);
        loader_start();
        $('.error-msg').html('');

        $.ajax({
            url: site_url + 'users/ajaxupdate',
            dataType: 'json',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (resp) {
                 window.console.log(resp);
                loader_stop();
                $("#user_update_form").find('[type=submit]').removeAttr('disabled', 'disabled');
                if (resp.type == "success") {
                    show_success(resp.message);
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000)

                } else if (resp.type == "warning") {
                    $.each(resp.message, function (index, elem) {
                        $("#err_" + index).html(elem);
                        window.console.log(elem);
                    });
                }
            }
        });
    });
});

   

function deleteProduct(id) {
    if(confirm("Are you sure to delete this product?")){
        loader_start();
        $('.error-msg').html('');
    $.ajax({
            url: site_url + 'products/ajaxproductdelete?id='+id,
            dataType: 'json',
            type: 'POST',
            data: id,
            contentType: false,
            processData: false,
            success: function (resp) {
                loader_stop();
                if (resp.type == "success") {
                    show_success(resp.message);
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000)

                } else if (resp.type == "warning") {
                   show_error(resp.message);
                }
            }
        });
    }else{
        return false;
    }
}

function deleteUser(id) {
    if(confirm("Are you sure? Do you want to delete this User?")){
        loader_start();
    $.ajax({
            url: site_url + 'users/ajaxuserdelete?id='+id,
            dataType: 'json',
            type: 'POST',
            data: id,
            contentType: false,
            processData: false,
            success: function (resp) {
                loader_stop();
                if (resp.type == "success") {
                    show_success(resp.message);
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000)

                } else if (resp.type == "warning") {
                   show_error(resp.message);
                }
            }
        });
    }else{
        return false;
    }
}
     








