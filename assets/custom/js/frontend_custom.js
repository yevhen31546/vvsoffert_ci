//---------------------add by ras-bong-------------//
function change_invoice_type(){
    // alert("123");
    console.log("123");
    $("#invoice_type_state_title").text("Faktura"+"(" + event.target.value + ")");
}
//-------------------------------------------------//



function show_error(error_str) {
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

function show_success(msg) {
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

function loader_start() {
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

function loader_stop() {
    jQuery('#resultLoading .bg').height('100%');
    jQuery('#resultLoading').fadeOut(300);
    jQuery('body').css('cursor', 'default');
}
$(document).ready(function() {
    
    
    $("#sign_up_form").submit(function(e) {
        e.preventDefault();
        var formData = new FormData($("#sign_up_form")[0]);
        loader_start();
        $('.error-msg').html('');
        $.ajax({
            url: site_url + 'home/dosignup',
            dataType: 'json',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(resp) {
                loader_stop();
                if (resp.type == "success") {
                    show_success(resp.message);
                    setTimeout(function() {
                        window.location.href = resp.url;
                    }, 2000)
                } else if (resp.type == "warning") {
                    $.each(resp.message, function(index, elem) {
                        $("#err_" + index).html(elem);
                        window.console.log(elem);
                    });
                }
            }
        });
    });
    $("#product_update_form").submit(function(e) {
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
            success: function(resp) {
                loader_stop();
                $("#product_update_form").find('[type=submit]').removeAttr('disabled', 'disabled');
                if (resp.type == "success") {
                    show_success(resp.message);
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000)
                } else if (resp.type == "warning") {
                    $.each(resp.message, function(index, elem) {
                        $("#err_" + index).html(elem);
                        window.console.log(elem);
                    });
                }
            }
        });
    });
    
    
    $("#add_to_list_form").submit(function(e) {
        e.preventDefault();
        $('.help-block').html('');
        if ($('#list_id').val() == '' || $('#list_id').val() == 0) {
            $('.err-list_id').html('Please select a list');
            loader_stop();
            return false;
        }
        var formData = new FormData($("#add_to_list_form")[0]);
        $.ajax({
            url: site_url + 'user/ajaxproductaddtolist',
            dataType: 'json',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(resp) {
                window.console.log(resp);
                loader_stop();
                if (resp.type == "success") {
                    show_success(resp.msg);
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000)
                } else if (resp.type == "warning") {
                    $('.err-list_id').html(resp.msg);
                }
            }
        });
    });
});

function deleteProduct(id) {
    if (confirm("Are you sure? Do you want to delete this product?")) {
        loader_start();
        $.ajax({
            url: site_url + 'products/ajaxproductdelete?id=' + id,
            dataType: 'json',
            type: 'POST',
            data: id,
            contentType: false,
            processData: false,
            success: function(resp) {
                loader_stop();
                if (resp.type == "success") {
                    show_success(resp.message);
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000)
                } else if (resp.type == "warning") {
                    show_error(resp.message);
                }
            }
        });
    } else {
        return false;
    }
}







function addToList(event) {
    var _this = $("#" + event.id);
    var product_id = _this.attr("data-productId");
    var product_rsk = _this.attr("data-rskNo");
    $("#product_id").val(product_id);
    $("#product_rsk").val(product_rsk);
    $('#myModal').find(".help-block").html("");
    $("#myModal #list_id option:selected").prop("selected", false);
    $('#myModal').modal('show');
}
deleteProductGroup = function(event) {
    var selector = $("#" + event.id);
    var targetSlug = selector.attr("data-targetSlug");
    var url = site_url + "user/delete_list/" + targetSlug;
    $.confirm({
        closeIcon: true,
        animationBounce: 2.5,
        icon: 'fa fa-exclamation-triangle',
        title: 'Delete List',
        content: "Are you sure want to delete this List.",
        type: "dark",
        buttons: {
            Yes: {
                text: 'Yes',
                btnClass: 'btn-green',
                action: function() {
                    window.location.href = url;
                }
            },
            No: function() {}
        }
    });
}

deleteCustomer = function(event) {
    
    
    var url = site_url + "user/delete_customer/" + event.id;
    $.confirm({
        closeIcon: true,
        animationBounce: 2.5,
        icon: 'fa fa-exclamation-triangle',
        title: 'Delete Customer',
        content: "Are you sure want to delete this Customer?",
        type: "dark",
        buttons: {
            Yes: {
                text: 'Yes',
                btnClass: 'btn-green',
                action: function() {
                    window.location.href = url;
                }
            },
            No: function() {}
        }
    });
}



editCustomer = function(event){
    // console.log(event.id);
    var selector = $("#" + event.id);
    var targetSlug = JSON.parse(selector.attr("data-targetSlug"));
    var url = "https://vvsoffert.se/user/edit_customer/?id=" + event.id ;
    $('#add_customer_form').attr("action", url);
    $('#first_name').val(targetSlug.first_name);
    $('#last_name').val(targetSlug.last_name);
    $('#email').val(targetSlug.email);
    $('#webaddress').val(targetSlug.web_address);
    $('#phonenumber').val(targetSlug.phone_number);
    $('#postcode').val(targetSlug.post_code);
    $('#company').val(targetSlug.company);
    $('#addCusotmertLabel').text('Edit Customer');
    $('#add_customer_btn').css('display', 'none');
    $('#edit_customer_btn').css('display', 'initial');
    $("#addCustomer").modal("show");
}


editProject = function(event){
    var selector = $("#" + event.id);
    // console.log(event.data-targetSlug);
    var targetSlug = selector.attr("data-targetSlug");
    var url = "https://vvsoffert.se/user/edit_project/?id=" + event.id ;
    
    $('#add_project_form').attr("action", url);
    $('#name').val(targetSlug);
    $('#addProjectLabel').text('Edit Project');
    $('#add_project_btn').css('display', 'none');
    $('#edit_project_btn').css('display', 'initial');
    $("#addProject").modal("show");
}


addProject = function(event){
    var url = site_url + 
    $.confirm({
        title: 'Add Project',
        content: '' +
        '<form action="https://vvsoffert.se/add-list-form" class="formName">' +
        '<div class="form-group">' +
        '<label>Enter Your Project Name.</label>' +
        '<input type="text" placeholder="Project Name" id = "name" name = "name" class="name form-control" required />' +
        '</div>' +
        '</form>',
        buttons: {
            formSubmit: {
                text: 'Create',
                btnClass: 'btn-blue',
                action: function () {
                    var name = this.$content.find('.name').val();
                    if(!name){
                        $.alert('provide a valid project');
                        return false;
                    }
                    $.alert('Your Project is ' + name);
                }
            },
            cancel: function () {
                //close
            },
        },
        onContentReady: function () {
            // bind to events
            var jc = this;
            this.$content.find('form').on('submit', function (e) {
                // if the user submits the form by pressing enter in the field.
                e.preventDefault();
                jc.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
    });
}



deleteProductFromUserList = function(event) {
    var selector = $("#" + event.id);
    var targetSlug = selector.attr("data-targetSlug");
    var list_id = selector.attr("data-list-id");
    var url = site_url + "user/delete_list_product?id=" + targetSlug + '&list_id=' + list_id;
    $.confirm({
        closeIcon: true,
        animationBounce: 2.5,
        icon: 'fa fa-warning',
        title: 'Delete Product',
        content: "Are you sure want to delete this Product from your list?",
        type: "dark",
        buttons: {
            Yes: {
                text: 'Yes',
                btnClass: 'btn-green',
                action: function() {
                    window.location.href = url;
                }
            },
            No: function() {}
        }
    });
}
$(document).ready(function() {});
$("#import_product_rsk_file").change(function() {
    loader_start();
    var selector = $(this);
    var ext = selector.val().split('.').pop().toLowerCase();
    var name = selector.val().split('\\').pop();
    if ($.inArray(ext, ['xls', 'xlsx', 'csv']) == -1) {
        selector.parent().addClass('has-error');
        selector.parent().find(".help-block").html("Only files with the following extensions are accepted: xls, xlsx, csv");
        loader_stop();
        $("#import_product_rsk_file_name").val("");
        $("#btn-submit").prop("disabled", true);
    } else {
        $("#import_product_rsk_file_name").val(name);
        if (selector.parent().hasClass('has-error')) {
            selector.parent().removeClass('has-error');
        }
        selector.parent().find(".help-block").html("");
        $("#btn-submit").prop("disabled", false);
        loader_stop();
    }
});
$("#import_product_rsk_file_form").submit(function(e) {
    $("#downloading_progress_estore").fadeIn("slow");
});
$("#download-excel-pro-list").click(function() {
    var href = $(this).attr("data-href");
    loader_start();
    window.open(href);
    setTimeout(function() {
        window.location.reload();
    }, '2000');
});

function searchProduct(data) {
    var keyword = data.value;
    if (keyword.trim() == '') {
        $('#searchContainer').hide();
        return false;
    }
    var url = site_url + 'home/searchProductAjax';
    $.post(url, {
        term: keyword
    }, function(resp) {
        if (resp.response == true) {
            $('#searchContainer').show();
            $('#left_side').html(resp.html_product);
            $('#right_side').html(resp.html_category);
            $('#right_side').append(resp.html_manufacturer);
        } else {
            $('#searchContainer').hide();
        }
    }, 'json');
}
checkpostdata = function(event) {
    var _this = $("#" + event.id);
    if ($("#user_list").val() === "") {
        show_error("Vänligen välj en lista.");
        return false;
    } else {
        var element = document.getElementById("form_loader");
        element.classList.remove("noDisplay");
    }
}

