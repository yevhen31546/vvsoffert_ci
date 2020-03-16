$(document).ready(function () {
    var groupOptions = {
        url: function (phrase) {
            return site_url + 'groups/ajax_search_field_autocomplete';
        },
        getValue: function (element) {
            return element;
        },
        ajaxSettings: {
            dataType: "json",
            method: "POST",
            data: {
                dataType: "json"
            }
        },
        preparePostData: function (data) {

            data._s_key = $("#group_s_key").val();
            return data;
        },
        template: {
            type: "custom",
            method: function (value, item) {
                return "<div data-item-id='" + item.toLowerCase() + "' >" + value + "</div>";
            }
        },
        list: {
            onSelectItemEvent: function () {
//                $("#group_s_key").val($("#group_s_key").val());
            },
            onChooseEvent: function () {
                var selectedItemId = $(".easy-autocomplete").find("ul li.selected .eac-item div").attr("data-item-id");
                if (selectedItemId === "no result found") {
                    $("#group_s_key").val("");
                } else {
                    $("#search_form").submit();
                }
            }
        },
        requestDelay: 100
    };
    $("#group_s_key").easyAutocomplete(groupOptions);

    var menufactureOptions = {
        url: function (phrase) {
            return site_url + 'manufacturers/ajax_search_field_autocomplete';
        },
        getValue: function (element) {
            return element;
        },
        ajaxSettings: {
            dataType: "json",
            method: "POST",
            data: {
                dataType: "json"
            }
        },
        preparePostData: function (data) {

            data._s_key = $("#menufacture_s_key").val();
            return data;
        },
        template: {
            type: "custom",
            method: function (value, item) {
                return "<div data-item-id='" + item.toLowerCase() + "' >" + value + "</div>";
            }
        },
        list: {
            onSelectItemEvent: function () {
//                $("#menufacture_s_key").val($("#menufacture_s_key").val());
            },
            onChooseEvent: function () {
                var selectedItemId = $(".easy-autocomplete").find("ul li.selected .eac-item div").attr("data-item-id");
                if (selectedItemId === "no result found") {
                    $("#menufacture_s_key").val("");
                } else {
                    $("#menufacture_search_form").submit();
                }
            }
        },
        requestDelay: 100
    };
    $("#menufacture_s_key").easyAutocomplete(menufactureOptions);

    var productTypeOptions = {
        url: function (phrase) {
            return site_url + 'ProductTypes/ajax_search_field_autocomplete';
        },
        getValue: function (element) {
            return element;
        },
        ajaxSettings: {
            dataType: "json",
            method: "POST",
            data: {
                dataType: "json"
            }
        },
        preparePostData: function (data) {

            data._s_key = $("#protype_s_key").val();
            return data;
        },
        template: {
            type: "custom",
            method: function (value, item) {
                return "<div data-item-id='" + item.toLowerCase() + "' >" + value + "</div>";
            }
        },
        list: {
            onSelectItemEvent: function () {
//                $("#menufacture_s_key").val($("#menufacture_s_key").val());
            },
            onChooseEvent: function () {
                var selectedItemId = $(".easy-autocomplete").find("ul li.selected .eac-item div").attr("data-item-id");
                if (selectedItemId === "no result found") {
                    $("#protype_s_key").val("");
                } else {
                    $("#protype_search_form").submit();
                }
            }
        },
        requestDelay: 100
    };
    $("#protype_s_key").easyAutocomplete(productTypeOptions);

    var productOptions = {
        url: function (phrase) {
            return site_url + 'Products/ajax_search_field_autocomplete';
        },
        getValue: function (element) {
            return element;
        },
        ajaxSettings: {
            dataType: "json",
            method: "POST",
            data: {
                dataType: "json"
            }
        },
        preparePostData: function (data) {

            data._s_key = $("#product_s_key").val();
            return data;
        },
        template: {
            type: "custom",
            method: function (value, item) {
                return "<div data-item-id='" + item.toLowerCase() + "' >" + value + "</div>";
            }
        },
        list: {
            onSelectItemEvent: function () {
//                $("#menufacture_s_key").val($("#menufacture_s_key").val());
            },
            onChooseEvent: function () {
                var selectedItemId = $(".easy-autocomplete").find("ul li.selected .eac-item div").attr("data-item-id");
                if (selectedItemId === "no result found") {
                    $("#product_s_key").val("");
                } else {
                    $("#product_search_form").submit();
                }
            }
        },
        requestDelay: 100
    };
    $("#product_s_key").easyAutocomplete(productOptions);

    //===================User Search ========================//

    var userOptions = {
        url: function (phrase) {
            return site_url + 'Users/ajax_search_field_autocomplete';
        },
        getValue: function (element) {
            return element;
        },
        ajaxSettings: {
            dataType: "json",
            method: "POST",
            data: {
                dataType: "json"
            }
        },
        preparePostData: function (data) {

            data._s_key = $("#user_s_key").val();
            return data;
        },
        template: {
            type: "custom",
            method: function (value, item) {
                return "<div data-item-id='" + item.toLowerCase() + "' >" + value + "</div>";
            }
        },
        list: {
            onSelectItemEvent: function () {
//                $("#menufacture_s_key").val($("#menufacture_s_key").val());
            },
            onChooseEvent: function () {
                var selectedItemId = $(".easy-autocomplete").find("ul li.selected .eac-item div").attr("data-item-id");
                if (selectedItemId === "no result found") {
                    $("#user_s_key").val("");
                } else {
                    $("#user_search_form").submit();
                }
            }
        },
        requestDelay: 100
    };
    $("#user_s_key").easyAutocomplete(userOptions);


    var categoryOptions = {
        url: function (phrase) {
            return site_url + 'categories/ajax_search_field_autocomplete';
        },
        getValue: function (element) {
            return element;
        },
        ajaxSettings: {
            dataType: "json",
            method: "POST",
            data: {
                dataType: "json"
            }
        },
        preparePostData: function (data) {
            data._s_key = $("#category_s_key_").val();
            data._pid = $("#cat_pid").val();
            data._pid2 = $("#cat_pid2").val();
            return data;
        },
        template: {
            type: "custom",
            method: function (value, item) {
                return "<div data-item-id='" + item.toLowerCase() + "' >" + value + "</div>";
            }
        },
        list: {
            onSelectItemEvent: function () {
//                console.log('here-1');
            },
            onChooseEvent: function (e) {
                var selectedItemId = $(".easy-autocomplete").find("ul li.selected .eac-item div").attr("data-item-id");
                if (selectedItemId === "no result found") {
                    $("#category_s_key_").val("");
                } else {
                    $("#category_search_form_").submit();
                }
            }
        },
        requestDelay: 100
    };
    $("#category_s_key_").easyAutocomplete(categoryOptions);

    var estoreOptions = {
        url: function (phrase) {
            return site_url + 'estore/ajax_search_field_autocomplete';
        },
        getValue: function (element) {
            return element;
        },
        ajaxSettings: {
            dataType: "json",
            method: "POST",
            data: {
                dataType: "json"
            }
        },
        preparePostData: function (data) {
            data._s_key = $("#estore_s_key_").val();
            return data;
        },
        template: {
            type: "custom",
            method: function (value, item) {
                return "<div data-item-id='" + item.toLowerCase() + "' >" + value + "</div>";
            }
        },
        list: {
            onSelectItemEvent: function () {
//                console.log('here-1');
            },
            onChooseEvent: function (e) {
                var selectedItemId = $(".easy-autocomplete").find("ul li.selected .eac-item div").attr("data-item-id");
                if (selectedItemId === "no result found") {
                    $("#estore_s_key_").val("");
                } else {
                    $("#estore_search_form_").submit();
                }
            }
        },
        requestDelay: 100
    };
    $("#estore_s_key_").easyAutocomplete(estoreOptions);

    var estoreProductOptions = {
        url: function (phrase) {
            return site_url + 'estore/ajax_store_product_search_field_autocomplete';
        },
        getValue: function (element) {
            return element;
        },
        ajaxSettings: {
            dataType: "json",
            method: "POST",
            data: {
                dataType: "json"
            }
        },
        preparePostData: function (data) {
            data._s_key = $("#estore_product_s_key_").val();
            data._s_store = $("#estore_product_s_store_id_").val();
            return data;
        },
        template: {
            type: "custom",
            method: function (value, item) {
                return "<div data-item-id='" + item.toLowerCase() + "' >" + value + "</div>";
            }
        },
        list: {
            onSelectItemEvent: function () {
//                console.log('here-1');
            },
            onChooseEvent: function (e) {
                var selectedItemId = $(".easy-autocomplete").find("ul li.selected .eac-item div").attr("data-item-id");
                if (selectedItemId === "no result found") {
                    $("#estore_product_s_key_").val("");
                } else {
                    $("#estore_product_search_form_").submit();
                }
            }
        },
        requestDelay: 100
    };
    $("#estore_product_s_key_").easyAutocomplete(estoreProductOptions);
});

show_search_loader = function () {
    $("#search_loader").removeClass("noDisplay");
};

hide_search_loader = function () {
    $("#search_loader").addClass("noDisplay");
};

show_form_loader = function () {
    $("#form_loader").removeClass("noDisplay");
};

hide_form_loader = function () {
    $("#form_loader").addClass("noDisplay");
};

//================ pagination functionality ===================
getpaginationData = function (event) {
    var _this = $("#" + event.id);
    var pageNo = _this.attr("data-pageNumber");
    $("#_page_no").val(pageNo);
    $("#search_form").submit();
};

$("#search_form").submit(function (e) {
    e.preventDefault();
    show_search_loader();
    var _s_key = $("#group_s_key").val();
    var _s_sort_by = $("#group_s_sort_by").val();
    var _s_order_by = $("#group_s_order_by").val();
    var _page_no = $("#_page_no").val();
    var url = site_url + 'groups/ajax_search';
    $.post(url,
            {
                _s_key: _s_key,
                _page_no: _page_no,
                _s_sort_by: _s_sort_by,
                _s_order_by: _s_order_by
            },
            function (resp) {
                $("#searchGroupResult").html(resp.respHtml);
                hide_search_loader();
            }, "json");
});

getmanufacturepaginationData = function (event) {
    var _this = $("#" + event.id);
    var pageNo = _this.attr("data-pageNumber");
    $("#_page_no").val(pageNo);
    $("#menufacture_search_form").submit();
};

$("#menufacture_search_form").submit(function (e) {
    show_search_loader();
    e.preventDefault();
    var _s_key = $("#menufacture_s_key").val();
    var _s_sort_by = $("#menufacture_s_sort_by").val();
    var _s_order_by = $("#menufacture_s_order_by").val();
    var _page_no = $("#_page_no").val();
    var url = site_url + 'manufacturers/ajax_search';
    $.post(url,
            {
                _s_key: _s_key,
                _page_no: _page_no,
                _s_sort_by: _s_sort_by,
                _s_order_by: _s_order_by
            },
            function (resp) {
                $("#manufactures_Search_Res").html(resp.respHtml);
                hide_search_loader();
            }, "json");
});

getProTypePaginationData = function (event) {
    var _this = $("#" + event.id);
    var pageNo = _this.attr("data-pageNumber");
    $("#_page_no").val(pageNo);
    $("#protype_search_form").submit();
};

$("#protype_search_form").submit(function (e) {
    show_search_loader();
    e.preventDefault();
    var _s_key = $("#protype_s_key").val();
    var _s_sort_by = $("#protype_s_sort_by").val();
    var _s_order_by = $("#protype_s_order_by").val();
    var _page_no = $("#_page_no").val();
    var url = site_url + 'ProductTypes/ajax_search';
    $.post(url,
            {
                _s_key: _s_key,
                _page_no: _page_no,
                _s_sort_by: _s_sort_by,
                _s_order_by: _s_order_by
            },
            function (resp) {
                $("#producttypes_search_res").html(resp.respHtml);
                hide_search_loader();
            }, "json");
});

getProductPaginationData = function (event) {
    var _this = $("#" + event.id);
    var pageNo = _this.attr("data-pageNumber");
    $("#_page_no").val(pageNo);
    $("#product_search_form").submit();
};

getUserPaginationData = function (event) {
    var _this = $("#" + event.id);
    var pageNo = _this.attr("data-pageNumber");
    $("#_page_no").val(pageNo);
    $("#user_search_form").submit();
};

$("#product_search_form").submit(function (e) {
    e.preventDefault();
    show_search_loader();
    var _s_key = $("#product_s_key").val();
    var _s_sort_by = $("#product_s_sort_by").val();
    var _s_order_by = $("#product_s_order_by").val();
    var _page_no = $("#_page_no").val();
    var url = site_url + 'Products/ajax_search_product';
    $.post(url,
            {
                _s_key: _s_key,
                _page_no: _page_no,
                _s_sort_by: _s_sort_by,
                _s_order_by: _s_order_by
            },
            function (resp) {
                $("#searchProductResult").html(resp.respHtml);
                hide_search_loader();
            }, "json");
});


$("#user_search_form").submit(function (e) {
    e.preventDefault();
    show_search_loader();
    var _s_key = $("#user_s_key").val();
    var _s_sort_by = $("#user_s_sort_by").val();
    var _s_order_by = $("#user_s_order_by").val();
    var _page_no = $("#_page_no").val();
    var url = site_url + 'users/ajax_search';
    $.post(url,
            {
                _s_key: _s_key,
                _page_no: _page_no,
                _s_sort_by: _s_sort_by,
                _s_order_by: _s_order_by
            },
            function (resp) {
                $("#searchUserResult").html(resp.respHtml);
                hide_search_loader();
            }, "json");
});

getCategoeyPaginationData = function (event) {
    var _this = $("#" + event.id);
    var pageNo = _this.attr("data-pageNumber");
    $("#_page_no").val(pageNo);
    $("#category_search_form_").submit();
};

$('body').on('submit', '#category_search_form_', function (e) {
    e.preventDefault();
    show_search_loader();
    var _this = $(this);
    var data = _this.serialize();
    var url = site_url + 'categories/ajax_search_category';
    $.post(url, data,
            function (resp) {
                $("#searchCategoryResult").html(resp.respHtml);
                hide_search_loader();
            }, "json");
});

getEstorePaginationData = function (event) {
    var _this = $("#" + event.id);
    var pageNo = _this.attr("data-pageNumber");
    $("#_page_no").val(pageNo);
    $("#estore_search_form_").submit();
};

$('body').on('submit', '#estore_search_form_', function (e) {
    e.preventDefault();
    show_search_loader();
    var _this = $(this);
    var data = _this.serialize();
    var url = site_url + 'estore/ajax_search';
    $.post(url, data,
            function (resp) {
                $("#searchEStoreResult").html(resp.respHtml);
                hide_search_loader();
            }, "json");
});

getEstoreProductPaginationData = function (event) {
    var _this = $("#" + event.id);
    var pageNo = _this.attr("data-pageNumber");
    $("#_page_no").val(pageNo);
    $("#estore_product_search_form_").submit();
};

$('body').on('submit', '#estore_product_search_form_', function (e) {
    e.preventDefault();
    show_search_loader();
    var _this = $(this);
    var data = _this.serialize();
    var url = site_url + 'estore/ajax_store_product_search';
    $.post(url, data,
            function (resp) {
                $("#searchEStoreProductResult").html(resp.respHtml);
                hide_search_loader();
            }, "json");
});


//================= create / update /delete functionality on group portion =====================
$("#create-group #group_name").keyup(function () {
    var text = $(this).val();
    if ($.trim(text) == "") {
        $("#create-group-btn").prop("disabled", true);
    } else {
        $("#create-group-btn").prop("disabled", false);
    }
});

$("#group_image").change(function () {
    show_form_loader();
    var selector = $(this);
    var ext = selector.val().split('.').pop().toLowerCase();
    var name = selector.val().split('\\').pop();
    if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
        if (!$("#view_upload_image").find('img.img-preview').hasClass("noDisplay")) {
            $("#view_upload_image").find('img.img-preview').addClass("noDisplay");
            $("#group_image_name").val("");
        }
        selector.parent().addClass('has-error');
        selector.parent().find(".help-block").html("Only files with the following extensions are accepted: png, jpg, jpeg");

        $("#create-group-btn").prop("disabled", true);
        hide_form_loader();
    } else {
        $("#group_image_name").val(name);
        if (selector.parent().hasClass('has-error')) {
            selector.parent().removeClass('has-error');
        }
        selector.parent().find(".help-block").html("");
        $("#create-group-btn").prop("disabled", false);
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#view_upload_image").find('img.img-preview')
                        .attr('src', e.target.result);
                if ($("#view_upload_image").find('img.img-preview').hasClass("noDisplay")) {
                    $("#view_upload_image").find('img.img-preview').removeClass("noDisplay");
                }
            };
            reader.readAsDataURL(this.files[0]);
        }
        hide_form_loader();
    }
});

$("#create-group").submit(function (e) {
    e.preventDefault();
    show_form_loader();
    var _selector = $(this);
    _selector.find(".has-error").removeClass('has-error');
    _selector.find(".help-block").html("");
    if ($.trim($("#group_name").val()) == "") {
        $("#group_name").parent().addClass("has-error");
        $("#group_name").parent().find(".help-block").html("Please provide a group name");
        $("#create-group-btn").prop("disabled", true);
        hide_form_loader();
    } else if ($.trim($("#group_image").val()) == "") {
        $("#group_image").parent().addClass("has-error");
        $("#group_image").parent().find(".help-block").html("Please provide an group name.");
        $("#create-group-btn").prop("disabled", true);
        hide_form_loader();
    } else {
        $("#create-group-btn").prop("disabled", true);
        var url = site_url + "Groups/create";

        $.ajax({
            url: url,
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (resp) {
                if (resp.flag == true) {
                    window.location.href = resp.redirectUrl;
                } else {
                    $("#create-group-btn").prop("disabled", false);
                    if (resp.respMessage != "") {
                        _selector.find("#group_image").parent().addClass("has-error");
                        _selector.find("#group_image").parent().find(".help-block").html(resp.respMessage);
                    }
                    $.each(resp.errors, function (item, value) {
                        _selector.find("#" + item).parent().addClass("has-error");
                        _selector.find("#" + item).parent().find(".help-block").html(value);
                    });
                    hide_form_loader();
                }
            }
//            error: function (err) {
//                alert(err.statusText);
//            }
        });
    }
});


$("#update-group #update_group_name").keyup(function () {
    var text = $(this).val();
    if ($.trim(text) == "") {
        $("#update-group-btn").prop("disabled", true);
    } else {
        $("#update-group-btn").prop("disabled", false);
    }
});

$("#update_group_image").change(function () {
    show_form_loader();
    var selector = $(this);
    var ext = selector.val().split('.').pop().toLowerCase();
    var name = selector.val().split('\\').pop();
    if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
        if (!$("#update_view_upload_image").find('img.img-preview').hasClass("noDisplay")) {
            $("#update_view_upload_image").find('img.img-preview').addClass("noDisplay");
            $("#update_group_image_name").val("");
        }
        selector.parent().addClass('has-error');
        selector.parent().find(".help-block").html("Only files with the following extensions are accepted: png, jpg, jpeg");
        hide_form_loader();

//        $("#update-group-btn").prop("disabled", true);
    } else {
        $("#update_group_image_name").val(name);
        if (selector.parent().hasClass('has-error')) {
            selector.parent().removeClass('has-error');
        }
        selector.parent().find(".help-block").html("");
//        $("#update-group-btn").prop("disabled", false);
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#update_view_upload_image").find('img.img-preview')
                        .attr('src', e.target.result);
                if ($("#update_view_upload_image").find('img.img-preview').hasClass("noDisplay")) {
                    $("#update_view_upload_image").find('img.img-preview').removeClass("noDisplay");
                }
            };
            reader.readAsDataURL(this.files[0]);
        }
        hide_form_loader();
    }
});

$("#update-group").submit(function (e) {
    e.preventDefault();
    show_form_loader();
    var _selector = $(this);
    _selector.find(".has-error").removeClass('has-error');
    _selector.find(".help-block").html("");
    if ($.trim($("#update_group_name").val()) == "") {
        $("#update_group_name").parent().addClass("has-error");
        $("#update_group_name").parent().find(".help-block").html("Please provide an group name.");
        $("#update-group-btn").prop("disabled", true);
        hide_form_loader();
    } else {
        $("#update-group-btn").prop("disabled", true);
        var url = site_url + "Groups/update";

        $.ajax({
            url: url,
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (resp) {
                if (resp.flag == true) {
                    window.location.href = resp.redirectUrl;
                } else {
                    $("#create-group-btn").prop("disabled", false);
                    if (resp.respMessage != "") {
                        _selector.find("#update_group_image").parent().addClass("has-error");
                        _selector.find("#update_group_image").parent().find(".help-block").html(resp.respMessage);
                    }
                    $.each(resp.errors, function (item, value) {
                        _selector.find("#update_" + item).parent().addClass("has-error");
                        _selector.find("#update_" + item).parent().find(".help-block").html(value);
                    });
                    hide_form_loader();
                }
            }
//            error: function (err) {
//                alert(err.statusText);
//            }
        });
    }
});

deleteProductGroup = function (event) {
    var selector = $("#" + event.id);
    var targetSlug = selector.attr("data-targetSlug");
    var url = site_url + "groups/delete/" + targetSlug;
    //var url = '/usermanagement/deleteRegUser'; 
    $.confirm(
            {
                closeIcon: true,
                animationBounce: 2.5,
                icon: 'fa fa-warning',
                title: 'Delete Group',
                content: "Are you sure want to delete this group.",
                type: "dark",
                buttons: {
                    Yes: {
                        text: 'Yes',
                        btnClass: 'btn-green',
                        action: function () {
                            show_form_loader();
                            window.location.href = url;
                        }
                    },
                    No: function () { }
                }
            });
}

$("#import_group_file").change(function () {
    show_form_loader();
    var selector = $(this);
    var ext = selector.val().split('.').pop().toLowerCase();
    var name = selector.val().split('\\').pop();
    if ($.inArray(ext, ['xls', 'xlsx']) == -1) {
        selector.parent().addClass('has-error');
        selector.parent().find(".help-block").html("Only files with the following extensions are accepted: xls, xlsx");
        hide_form_loader();

        $("#group_file_name").val("");
        $("#btn-submit").prop("disabled", true);
    } else {
        $("#group_file_name").val(name);
        if (selector.parent().hasClass('has-error')) {
            selector.parent().removeClass('has-error');
        }
        selector.parent().find(".help-block").html("");
        $("#btn-submit").prop("disabled", false);
        hide_form_loader();
    }
});

$("#import_group_file_form").submit(function (e) {
    show_form_loader();
    $("#btn-submit").prop("disabled", true);
});
//================= import manufactures  =====================
$("#import_manufacturers_file").change(function () {
    show_form_loader();
    var selector = $(this);
    var ext = selector.val().split('.').pop().toLowerCase();
    var name = selector.val().split('\\').pop();
    if ($.inArray(ext, ['xls', 'xlsx']) == -1) {
        selector.parent().addClass('has-error');
        selector.parent().find(".help-block").html("Only files with the following extensions are accepted: xls, xlsx");
        hide_form_loader();

        $("#manufacturers_file_name").val("");
        $("#btn-submit").prop("disabled", true);
    } else {
        $("#manufacturers_file_name").val(name);
        if (selector.parent().hasClass('has-error')) {
            selector.parent().removeClass('has-error');
        }
        selector.parent().find(".help-block").html("");
        $("#btn-submit").prop("disabled", false);
        hide_form_loader();
    }
});

$("#import_manufacturers_file_form").submit(function (e) {
    show_form_loader();
    $("#btn-submit").prop("disabled", true);
});
//================= import category  =====================
$("#import_categories_file").change(function () {
    show_form_loader();
    var selector = $(this);
    var ext = selector.val().split('.').pop().toLowerCase();
    var name = selector.val().split('\\').pop();
    if ($.inArray(ext, ['xls', 'xlsx']) == -1) {
        selector.parent().addClass('has-error');
        selector.parent().find(".help-block").html("Only files with the following extensions are accepted: xls, xlsx");
        hide_form_loader();

        $("#categories_file_name").val("");
        $("#btn-submit").prop("disabled", true);
    } else {
        $("#categories_file_name").val(name);
        if (selector.parent().hasClass('has-error')) {
            selector.parent().removeClass('has-error');
        }
        selector.parent().find(".help-block").html("");
        $("#btn-submit").prop("disabled", false);
        hide_form_loader();
    }
});

$("#import_categories_file_form").submit(function (e) {
    show_form_loader();
    $("#btn-submit").prop("disabled", true);
});
//================= import product type files  =====================
$("#import_products_types_file").change(function () {
    show_form_loader();
    var selector = $(this);
    var ext = selector.val().split('.').pop().toLowerCase();
    var name = selector.val().split('\\').pop();
    if ($.inArray(ext, ['xls', 'xlsx']) == -1) {
        selector.parent().addClass('has-error');
        selector.parent().find(".help-block").html("Only files with the following extensions are accepted: xls, xlsx");
        hide_form_loader();

        $("#product_type_file_name").val("");
        $("#btn-submit").prop("disabled", true);
    } else {
        $("#product_type_file_name").val(name);
        if (selector.parent().hasClass('has-error')) {
            selector.parent().removeClass('has-error');
        }
        selector.parent().find(".help-block").html("");
        $("#btn-submit").prop("disabled", false);
        hide_form_loader();
    }
});

$("#import_products_types_file_form").submit(function (e) {
    show_form_loader();
    $("#btn-submit").prop("disabled", true);
});
//================= import product files  =====================
$("#import_products_file").change(function () {
    show_form_loader();
    var selector = $(this);
    var ext = selector.val().split('.').pop().toLowerCase();
    var name = selector.val().split('\\').pop();
    if ($.inArray(ext, ['xls', 'xlsx']) == -1) {
        selector.parent().addClass('has-error');
        selector.parent().find(".help-block").html("Only files with the following extensions are accepted: xls, xlsx");
        hide_form_loader();

        $("#product_type_file_name").val("");
        $("#btn-submit").prop("disabled", true);
    } else {
        $("#product_type_file_name").val(name);
        if (selector.parent().hasClass('has-error')) {
            selector.parent().removeClass('has-error');
        }
        selector.parent().find(".help-block").html("");
        $("#btn-submit").prop("disabled", false);
        hide_form_loader();
    }
});

$("#import_products_file_form").submit(function (e) {
    show_form_loader();
    $("#btn-submit").prop("disabled", true);
});
//================= create / update /delete functionality on estore portion =====================
$('body').on('submit', '#create_store_', function (e) {
    e.preventDefault();
    show_form_loader();
    var _selector = $(this);
    _selector.find(".has-error").removeClass('has-error');
    _selector.find(".help-block").html("");

    $("#btn-submit").prop("disabled", true);

    var url = site_url + "estore/create";

    $.ajax({
        url: url,
        type: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        dataType: 'json',
        success: function (resp) {
            if (resp.flag == true) {
                window.location.href = resp.redirectUrl;
            } else {
                $.each(resp.errors, function (item, value) {
                    _selector.find("#estore-" + item).parent().addClass("has-error");
                    _selector.find("#estore-" + item).parent().find(".help-block").html(value);
                });
                $("#btn-submit").prop("disabled", false);
                hide_form_loader();
            }
        },
//        error: function (err) {
//            alert(err.statusText);
//        }
    });
});

$('body').on('submit', '#update_store_', function (e) {
    e.preventDefault();
    show_form_loader();
    var _selector = $(this);
    _selector.find(".has-error").removeClass('has-error');
    _selector.find(".help-block").html("");
    $("#btn-submit").prop("disabled", true);
    var url = site_url + "estore/edit";
    $.ajax({
        url: url,
        type: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        dataType: 'json',
        success: function (resp) {
            if (resp.flag == true) {
                window.location.href = resp.redirectUrl;
            } else {
                $.each(resp.errors, function (item, value) {
                    _selector.find("#estore-" + item).parent().addClass("has-error");
                    _selector.find("#estore-" + item).parent().find(".help-block").html(value);
                });
                $("#btn-submit").prop("disabled", false);
                hide_form_loader();
            }
        },
//        error: function (err) {
//            alert(err.statusText);
//        }
    });
});

deleteStore = function (event) {
    var selector = $("#" + event.id);
    var targetId = selector.attr("data-targetId");
    var url = site_url + "estore/delete/" + targetId;
    $.confirm(
            {
                closeIcon: true,
                animationBounce: 2.5,
                icon: 'fa fa-warning',
                title: 'Delete Store',
                content: "Are you sure want to delete this store.",
                type: "dark",
                buttons: {
                    Yes: {
                        text: 'Yes',
                        btnClass: 'btn-green',
                        action: function () {
                            show_form_loader();
                            window.location.href = url;
                        }
                    },
                    No: function () { }
                }
            });
}


$("#product_file").change(function () {
    show_form_loader();
    var selector = $(this);
    var ext = selector.val().split('.').pop().toLowerCase();
    var name = selector.val().split('\\').pop();
    if ($.inArray(ext, ['xls', 'xlsx']) == -1) {
        selector.parent().addClass('has-error');
        selector.parent().find(".help-block").html("Only files with the following extensions are accepted: xls, xlsx");
        hide_form_loader();

        $("#product_file_name").val("");
        $("#btn-submit").prop("disabled", true);
    } else {
        $("#product_file_name").val(name);
        if (selector.parent().hasClass('has-error')) {
            selector.parent().removeClass('has-error');
        }
        selector.parent().find(".help-block").html("");
        $("#btn-submit").prop("disabled", false);
        hide_form_loader();
    }
});

$("#upload_store_products").submit(function (e) {
    var _this = $(this);
    _this.find(".has-error").removeClass("has-error");
    _this.find(".help-block").html("");
    var importType = $("#pro_import_type").val();
    if (importType == "") {
        $("#pro_import_type").parent().addClass("has-error");
        $("#pro_import_type").parent().find(".help-block").html("Please select import type");
        return false;
    } else {
        show_form_loader();
        $("#btn-submit").prop("disabled", true);
    }
});

//================= end all functionalites on estore portion =====================
delete_pro_category = function (event) {
    var _this = $("#" + event.id);
    var targetId = _this.attr("data-targetId");
    var url = site_url + "categories/checktotalproduct";
    $.post(url,
            {
                targetId: targetId
            },
            function (resp) {
                console.log(resp);
                if (resp.flag == true) {
                    $.confirm(
                            {
                                closeIcon: true,
                                animationBounce: 2.5,
                                icon: 'fa fa-warning',
                                title: 'Delete Category',
                                content: "Are you sure want to delete this Category.",
                                type: "dark",
                                buttons: {
                                    Yes: {
                                        text: 'Yes',
                                        btnClass: 'btn-green',
                                        action: function () {
                                            var deleteUrl = site_url + "categories/delete_category";
                                            $.post(deleteUrl,
                                                    {
                                                        targetId: targetId
                                                    },
                                                    function (resp) {
                                                        if (resp.flag == true) {
                                                            _this.closest("tr").remove();
                                                        }
                                                    }, "json");
                                        }
                                    },
                                    No: function () { }
                                }
                            });

                } else {
                    $.alert({
                        closeIcon: true,
                        animationBounce: 2.5,
                        icon: 'fa fa-warning',
                        type: "dark",
                        title: 'Warning',
                        content: 'Sorry! On your selected category there are so many products are available. Please move this products to another category then you can delete this category.',
                    });
                }
            }, "json");
};