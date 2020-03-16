</div>
<div style="height: 5px;"></div>
<!-- Global Site Tag (gtag.js) - Google Analytics -->
<!--<script async src="<?php //echo base_url('assets/js/analytics.js'); ?>"></script>-->
<script type="text/javascript" src="<?php echo base_url('assets/js/vendors.js'); ?>"></script>

<!--<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>-->
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script defer src="<?php echo base_url('assets/js/jquery-confirm.min.js'); ?>"></script>
<script defer src="<?php echo base_url('assets/js/gtag.js'); ?>"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

<script type="text/javascript" src="<?php echo base_url('assets/js/select2.js'); ?>"></script>

<script defer type="text/javascript" src="<?php echo base_url('assets/custom/js/frontend_custom.js'); ?>"></script>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.min.js"></script> -->



<script defer type="text/javascript">
var total_price_of_project;
var edit_flag = true;


function showCustomerInfo (e){
    if($('#customer_sel').val()){
        
    var id = $('#customer_sel').val();
    var data=[];
    data = JSON.parse($('#customer_info').val());
    $.each(data, function(key, val){
       if(val.id == id) {
        //    $('#customer_id').val(val.id);
           $('#your_ref').val(val.ref_name);
        //    $('#our_ref').val(val.ref_name);
        //    $('#custom_ref').val(val.ref_name);
       }
    });
    }
}

function subtotalFunc(e){
    for(var i=0; i < e; i++){
        var tmp = 0;
        tmp = parseInt($('#quantity_' +i).text()) * $('#unit_'+i).text().replace(/[\$,]/g, '')*1;
        // console.log($('#unit_'+i).text().replace(/[\$,]/g, '')*1);
        $('#subtotal_'+i).text(tmp.toFixed(2));
    }
}
function AddProduct(e) {
    InsertInSelectedIDs(e) && ($(".searchContainer").empty(), $("#search_products").val(), $(".customSearchContainer").hide())
}

function removeProduct(e) {
    var o = new Array,
        r = $(".selected_products").val();
    o = (o = r.split(",")).map(Number), $.confirm({
        closeIcon: !0,
        closeIconClass: "fa fa-close",
        title: "vvsoffert.se säger:",
        escapeKey: !0,
        content: "Are you sure you want to <strong>remove</strong> it?",
        backgroundDismiss: !0,
        buttons: {
            avbryt: {
                keys: ["ctrl", "shift"],
                action: function() {
                    
                }
            },
            okay: {
                keys: ["enter"],
                action: function() {
                    console.log(e);
                    $('#template').empty();
                    $('#quantity_'+e).parent().remove();
                    $('#template').append($('#template1').html());
                    var datatabledata = $('#template #invoice_datatable_removebyme').dataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                text: 'Add Product',
                                action: function ( e, dt, node, config ) {
                                  $('#addProdut').modal('show');
                                  
                                }
                            }
                        ],
                        "footerCallback": function ( row, data, start, end, display ) {
                            var api = this.api(), data;
                 
                            // Remove the formatting to get integer data for summation
                            var intVal = function ( i ) {
                                return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '')*1 :
                                    typeof i === 'number' ?
                                        i : 0;
                            };
                  
                            // Total over all pages
                            total = api
                                .column( 4 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );
                 
                            // Total over this page
                            pageTotal = api
                                .column( 4, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );
                 
                            // Update footer
                            $( api.column(4).footer() ).html(
                                '$'+pageTotal.toFixed(2) +' ( $'+ total.toFixed(2) +' total)'
                            );
                            total_price_of_project = total.toFixed(2);
                        }
                    });
                    // console.log(JSON.stringify(datatabledata.fnGetData()));
                    
                    
                    
                }
            }
        }
    })
}


function editProduct(e) {
    // console.log($('#action_' + e + ' #save'));
    if(!edit_flag) {
        return;
    }
    $('#action_' + e + ' #save').css('display', 'initial');
    $('#action_' + e + ' #edit').css('display', 'none');
    $('#action_' + e).parent().addClass('edit_state');
    $('#pro_name_'+e).attr('contenteditable', 'true');
    $('#rsk_no_'+e).attr('contenteditable', 'true');
    $('#quantity_'+e).attr('contenteditable', 'true');
    $('#unit_'+e).attr('contenteditable', 'true');
    edit_flag = false;
    
    
}



function saveProduct(e) {
    // console.log('#action_' + e + ' #save');
    $('#action_' + e + ' #save').css('display', 'none');
    $('#action_' + e + ' #edit').css('display', 'initial');
    $('#action_' + e).parent().removeClass('edit_state');
    $('#pro_name_'+e).attr('contenteditable', 'false');
    $('#rsk_no_'+e).attr('contenteditable', 'false');
    $('#quantity_'+e).attr('contenteditable', 'false');
    $('#unit_'+e).attr('contenteditable', 'false');
    $('#template1 #pro_name_'+e).html($('#pro_name_'+e).html());
    $('#template1 #rsk_no_'+e).html($('#rsk_no_'+e).html());
    $('#template1 #quantity_'+e).html($('#quantity_'+e).html());
    $('#template1 #unit_'+e).html($('#unit_'+e).html());
    edit_flag = true;
    $('#template').empty();
    var length = $('#template1 #invoice_table tr').length;
    // console.log(length);
    subtotalFunc(length);
    $('#template').append($('#template1').html());
    $('#template #invoice_datatable_removebyme').dataTable({
        dom: 'Bfrtip',
            buttons: [
                {
                    text: 'Add Product',
                    action: function ( e, dt, node, config ) {
                      
                      $('#addProdut').modal('show');
                    }
                }
            ],
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
  
            // Total over all pages
            total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(4).footer() ).html(
                '$'+pageTotal.toFixed(2) +' ( $'+ total.toFixed(2) +' total)'
            );
            total_price_of_project = total.toFixed(2);
        }
    });
    
    
    
}



function InsertInSelectedIDs(e) {
    var o = addValue($(".selected_products").val(), e);
    if (o) {
        $(".selected_products").val(o);
        var r = $(".product_" + e).attr("data-name");
        $("#selected_pros").append('<li id="pro_' + e + '"> ' + r + '     <p class="fa fa-trash" onClick="removeProduct(' + e + ')"></p></li>'), $(".lblProducts").removeClass("hide")
    }
    return !0
}

function addValue(e, o) {
    var r = new Array;
    return -1 == (r = (r = e.split(",")).map(Number)).indexOf(o) && (r.push(o), (r = cleanArray(r)).join(","))
}

function cleanArray(e) {
    for (var o = new Array, r = 0; r < e.length; r++) e[r] && o.push(e[r]);
    return o
}

function showLoader() {
    $(".pre-loader").fadeIn()
}

function hideLoader() {
    $(".pre-loader").fadeOut()
}

$(document).ready(function() {
    $("#multiDropdown").select2();
   
    $("select").select2();
    responsiveNav("#sidebar-wrapper", {
        customToggle: "",
        enableFocus: !0,
        enableDropdown: !0,
        openDropdown: '<span class="screen-reader-text">Open sub menu</span>',
        closeDropdown: '<span class="screen-reader-text">Close sub menu</span>'
    });
    $(".search-button").on("click", function(e) {
        showLoader(), $.ajax({
            url: "<?php echo site_url() ?>",
            type: "POST",
            data: {
                term: $("#search_products").val(),
                store_id: $(".store_id option:selected").val()
            },
            dataType: "JSON",
            success: function(e) {
                "" != e && (console.log(e), $(".searchContainer").empty(), $(".searchContainer").append(e.html_product), $(".searchContainer").show()), hideLoader()
            }
        })
    });
    $("#resetCompany").on("click", function(e) {
        $('#address1').val("");
        $('#address2').val("");
        $('#post_code').val("");
        $('#city').val("");
        $('#domicile_place').val("");
        $('#phone_num').val("");
        $('#mobile_num').val("");
        $('#email_address').val("");
        $('#website').val("");
        $('#corporate_id').val("");
        $('#gln').val("");
        $('#local_currency').val("");
        $('#vat_num').val("");
        $('#bankiro').val("");
        $('#plus_giro').val("");
        $('#swish').val("");
        $('#usesQuotes').prop("checked", false);
        $('#usesOrder').prop("checked", false);
    });
    // $("#domestic_service").on("click", function(e) {
    //     if($("#domestic_service").prop('checked') == true){
    //         $("#domestic_area").attr("style", "display:block;");
    //     }else{
    //         $("#domestic_area").attr("style", "display:none;");
    //     }
    // });
});
var menuBarClose = !1;
$("#menu-toggle").on("click", function(e) {
    $("#myNavbar").show("slow"), menuBarClose = !0
}), $(".close-sidebar").on("click", function(e) {
    $("#myNavbar").hide("slow"), menuBarClose = !1
}), $(window).scroll(function() {
    50 <= $(this).scrollTop() ? $("#return-to-top").fadeIn(200) : $("#return-to-top").fadeOut(200)
}), $("#return-to-top").click(function() {
    $("body,html").animate({
        scrollTop: 0
    }, 500)
});




</script>


<script defer type="text/javascript" src="<?php echo base_url('assets/js/vvsoffert-se-scripts.min.js'); ?>"></script>


<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.magnific-popup.js'); ?>"></script>

 <script language="JavaScript" src="//cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js" type="text/javascript"></script> 
<!--<script language="JavaScript" src="assets/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>-->

<script language="JavaScript" src="//cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script language="JavaScript" src="//cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/3/dataTables.bootstrap.js" type="text/javascript"></script>
<!-- <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script> -->
<script type="text/javascript" src="assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/locales/bootstrap-datepicker.es.min.js"></script> -->



<script type="text/javascript">
    $(document).ready(function(){
        var addedRow = 0;
        
        $("#invoice_type").change(function(){
            alert("ok") ;
        });

        if($(".onload_show").length > 0){
            $("#addProject").modal("show");
        }
        if($("#id").length>0){
            $('#addProjectLabel').text('Edit Project');
            $('#edit_project_btn').css('display', 'initial');
            $("#add_project_form").attr("action", "https://vvsoffert.se/user/edit_project/?id=" + $('#id').val());
            
        }
        $('.video').magnificPopup({
            type: 'iframe',
            iframe: {
                markup: '<div class="mfp-iframe-scaler">'+
                '<div class="mfp-close"></div>'+
                '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
                '<div class="mfp-title">Some caption</div>'+
                '</div>'
            },
            callbacks: {
                markupParse: function(template, values, item) {
                    values.title = item.el.attr('title');
                }
            } 

        });
         
        alert = function() {};
        var length = $("#invoice_table tr").length;
        
        
        subtotalFunc(length);
        var html_table = $('#template').html();
        $('#template1').html(html_table);

        // $('.datetimepicker').datepicker({
        //     locale: 'se',
        // });
        $('.datetimepicker').datepicker({
            format: "yyyy-mm-dd",
            //  defaultDate: "11/1/2013",
            language: "se",
            autoclose: true,
            todayHighlight: true    	
        });
        $('#datetimepicker').datepicker({
            format: "yyyy-mm-dd",
            // defaultDate: "11/1/2013",
            language: "se",
            autoclose: true,
            todayHighlight: true
        });
        // $.datepicker.setDefaults($.datepicker.regional['fr']);
        //$(.datetimepicker).setLocale('ru');
        // function changeValue({
        //     var customer_id = $('#customer_sel').val()
        //     consol.log('=========id=========',customer_id)
        // });
        $('#datatable').dataTable(
        );
        
        $('#invoice_datatable_removebyme').dataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    text: 'Add Product',
                    action: function ( e, dt, node, config ) {
                        $('#addProdut').modal('show');
               
                    }
                }
            ],
            
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
     
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
     
                // Total over all pages
                total = api
                    .column( 4 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
     
                // Total over this page
                pageTotal = api
                    .column( 4, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
     
                // Update footer
                $( api.column(4).footer() ).html(
                    '$'+pageTotal.toFixed(2) +' ( $'+ total.toFixed(2) +' total)'
                );
                total_price_of_project = total.toFixed(2);
            }
        });
        
        // console.log(tmp_datatable);
        
        $('#store_name').change(function(){
            var key = this.value;
            $('#template').empty();
            for(var i=0; i<length; i++){
                var pricelist = JSON.parse($('#unit_' + i).attr('data').trim());
                pricelist.forEach(function(ele){
                //  console.log(Object.values(ele));
                 
                    if(Object.keys(ele) == key){
                        if(Object.values(ele) =="")
                        {
                            $('#unit_' + i).text("0.00");
                        }
                        else{
                            $('#unit_' + i).text(Object.values(ele));
                        }
                    }
                });
            }
            subtotalFunc(length);
            $('#template').append($('#template1').html());
            $('#template #invoice_datatable_removebyme').dataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        text: 'Add Product',
                        action: function ( e, dt, node, config ) {
                           $('#addProdut').modal('show');
                        }
                    }
                ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
         
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
          
                    // Total over all pages
                    total = api
                        .column( 4 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
         
                    // Total over this page
                    pageTotal = api
                        .column( 4, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
         
                    // Update footer
                    $( api.column(4).footer() ).html(
                        '$'+pageTotal.toFixed(2) +' ( $'+ total.toFixed(2) +' total)'
                    );
                    total_price_of_project = total.toFixed(2);
                }
            });
        });

        function timeline() {
            for(i=0;i<30000;i++){
                //
            }
        }

        $('#store_name_inv').change(function(){

            var key = this.value;
            var store = key.split('-');
            var store_id = store[1];
            var total_sum = 0;
            var rsk_no_array = new Array();

            $(".artclass").each(function(index, value){
                setTimeout(function(){
                    
                }, 2000);

                var item = $(this);
                rsk_no='';
                var selector = '#' + $(this).attr('attr-id');
                rsk_no = item.val();
                //rsk_no_array[index] = jQuery.makeArray( rsk_no );
                console.log("rsk number",rsk_no);
                // if(rsk_no){
                    //$.post(
                        // "/get-article-price",
                        // {rsk_no: rsk_no},
                        // function(data, status){
                        //     data = JSON.parse(data);
                            
                        //     if(data['status']=="success"){
                        //         price_list = JSON.parse(data["price_list"]);
                        //         console.log(price_list)
                        //         $.each(price_list, function() {
                        //             $.each(this, function(k, v) {
                        //                 store_info = k.split("-")
                        //                 if(store_info[1] == store_id){
                        //                     $(selector + " input[name='sale_price_excl[]']").val(v);
                        //                     $(selector + " input[name='sum_excl[]']").val(v);
                        //                     total_sum += v*1;
                        //                     console.log("--------tao",total_sum);
                        //                     $('#total_sum').val(total_sum);
                        //                 }
                        //             });
                        //         });
                        //     }else{
                                $.post(
                                    "/get-product-info",
                                    {rsk_no: rsk_no},
                                    function(data, status){
                                        data2_status = JSON.parse(data).status;
                                        console.log("-==-==-=-=-==--=-==-",data2_status);
                                        if(data2_status == "exist"){
                                        
                                            data = JSON.parse(data).productlist;
                                            price = JSON.parse(data['PRICE']);
                                            console.log("*********ssss*******",price)
                                                            
                                            //dafl_price="0.0";
                                            $.each(price, function() {
                                                $.each(this, function(k, v) {
                                                    store_name = k.split("-")
                                                    if(store_name[1] == store_id){
                                                        $(selector + " input[name='sale_price_excl[]']").val(v);
                                                        $(selector + " input[name='sum_excl[]']").val(v);
                                                        total_sum += v*1;
                                                        console.log("--------tao",total_sum);
                                                        $('#total_sum').val(total_sum);
                                                    }                                                       
                                                });
                                            });

                                        }else{
                                            console.log("there is no product");
                                        }
                                    }
                                );
                            // }
                    //});
                    
            });
            //console.log(rsk_no_array);
            //var temp=0;
            //#added-row-0
            // do{
            //     selector = "#added-row-"+temp;                
            //     console.log("sssssssssssssssssssssss",rsk_no_array[temp][0]);
            //     $.post(
            //         "/get-article-price",
            //         {rsk_no: rsk_no_array[temp][0]},
            //         function(data, status){
            //             data = JSON.parse(data);
                        
            //             if(data['status']=="success"){
            //                 price_list = JSON.parse(data["price_list"]);
            //                 console.log(price_list)
            //                 $.each(price_list, function() {
            //                     $.each(this, function(k, v) {
            //                         store_info = k.split("-")
            //                         if(store_info[1] == store_id){
            //                             $(selector + " input[name='sale_price_excl[]']").val(v);
            //                             $(selector + " input[name='sum_excl[]']").val(v);
            //                             total_sum += v*1;
            //                             console.log("--------tao",total_sum);
            //                             $('#total_sum').val(total_sum);
            //                         }
            //                     });
            //                 });
                            
            //             }else{
            //                 $.post(
            //                     "/get-product-info",
            //                     {rsk_no: rsk_no_array[temp]},
            //                     function(data, status){
            //                         data2_status = JSON.parse(data).status;
            //                         console.log("-==-==-=-=-==--=-==-",data2_status);
            //                         if(data2_status == "exist"){
                                    
            //                             data = JSON.parse(data).productlist;
            //                             price = JSON.parse(data['PRICE']);
            //                             console.log("*********ssss*******",price)
                                                        
            //                             //dafl_price="0.0";
            //                             $.each(price, function() {
            //                                 $.each(this, function(k, v) {
            //                                     store_name = k.split("-")
            //                                     if(store_name[1] == store_id){
            //                                         $(selector + " input[name='sale_price_excl[]']").val(v);
            //                                         $(selector + " input[name='sum_excl[]']").val(v);
            //                                         total_sum += v*1;
            //                                         console.log("--------tao",total_sum);
            //                                         $('#total_sum').val(total_sum);
            //                                     }                                                       
            //                                 });
            //                             });
                                        
            //                         }else{
            //                             console.log("there is no product");
            //                         }
            //                     }
            //                 );
            //             }
            //     });
            // temp++;
            // }
            // while(temp < rsk_no_array.length);

        });

        $('#invoice_history_table_all').dataTable({
            dom: 'Bfrtip',
            buttons: [
                // {
                //     text: 'Histories',
                //     action: function ( e, dt, node, config ) {
                //       //$('#addProdut').modal('show');
                //     }
                // }
            ],
            "language": {
                "paginate": {
                    "previous": "Tidigare",
                    "next": "Nästa",
                },
                "search": "Sök",
                "info": "Sida _START_ to _END_ och _TOTAL_ sidor ",
                "emptyTable": "Inga data tillgängliga i tabellen",
                "zeroRecords": "Inga matchande uppgifter hittades",
            },
            "footerCallback": function ( row, data, start, end, display ) {
            }
        });
        
        $(".invoice_notify_icon").click(function(){
            $(".invoice_history_list_2").fadeToggle("slow");
        });
        
        // $(".invoice_history_list_sub_table_view_more").click(function(){

        //     $(".invoice_history_list .row_hidden").removeClass("row_hidden");
        // });

        $('#sbmt_email').click(function(){
            $('form').attr('action', 'https://vvsoffert.se/pdf-export-invoice-edited?id=MTA0');
            // $('form').attr('action', '/pdf-export-invoice-edited?id=MTA0');
            var tmp_post = $('#template1 #invoice_datatable_removebyme').dataTable().fnGetData();
            tmp_post.forEach(function (ele){
                ele.pop();
            });
            tmp_post.push(total_price_of_project);
            $('#selected_products').val(JSON.stringify(tmp_post));
            $('form').submit();
        });
        
        $('#sbmt_pdf').click(function(){
            var tmp_post = $('#template1 #invoice_datatable_removebyme').dataTable().fnGetData();
            tmp_post.forEach(function (ele){
                if(ele.length >= 6)
                    ele.pop();
            });
            tmp_post.push(total_price_of_project);
            $('#selected_products').val(JSON.stringify(tmp_post));
            //  $('form').attr('action', 'https://vvsoffert.se/pdf-export-invoice-edited?id=MTA0');
            $('form').submit();
        });

        $('#sbmt_save').click(function(){
            var tmp_post = $('#template1 #invoice_datatable_removebyme').dataTable().fnGetData();
            tmp_post.forEach(function (ele){
                if(ele.length >= 6)
                    ele.pop();
            });
            tmp_post.push(total_price_of_project);
            $('#selected_products').val(JSON.stringify(tmp_post));

            event.preventDefault();
            var formData = new FormData($("form"));
            loader_start();
            $('.error-msg').html('');
            $.ajax({
                url: site_url + 'home/invoiceHistory',
                dataType: 'json',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(resp) {
                    console.log(resp);
                    loader_stop();
                    if (resp.type == "success") {
                        show_success(resp.message);
                    //     setTimeout(function() {
                    //         window.location.href = resp.url;
                    //     }, 2000)
                    } else if (resp.type == "warning") {
                    
                        
                    }
                },
                error: function(resp) {
                    console.log(resp);
                    loader_stop();
                    show_error(resp.message);                    
                }
            });
            /*
            var product_list = JSON.stringify(tmp_post);
            var name = $("#customer_sel").val();
            var email = $("#email").val();
            var address = $("#address").val();
            var postnumber = $("#city").val();
            var comment = $("#special_comments").val();
            var invoice_number = $("#invoice_number").val();
            var store_name = $("#store_name").val();
            var invoice_type = $("#invoice_type").val();
            var date = $("#date_value").val();
            var ajax_url = "";

            jQuery.ajax({
                type: 'post',
                dataType: 'json',
                url: "https://vvsoffert.se/home/invoiceHistory",
                data: {
                    'name'          : $("#customer_sel").val(),
                    'product_list'  : JSON.stringify(tmp_post),
                    'email'         : $("#email").val(),
                    'address'       : $("#address").val(),
                    'postcode'      : $("#city").val(),
                    'comment'       : $("#special_comments").val(),
                    'invoice_number': $("#invoice_number").val(),
                    'store_name'    : $("#store_name").val(),
                    'invoice_type'  : $("#invoice_type").val(),
                    'date'          : $("#date_value").val()
                },
                before: function(){
                    jQuery("#erp_updating_lbl").show();
                },
                success: function (resp) {
                    console.log(resp);
                    alert(" update data succeed! ");
                },
                error: function (resp) {
                    console.log(resp);
                    alert(" update data succeed! ");
                }
            });
            */
        });

        $("[data-toggle=tooltip]").tooltip();
        
        
        $('#add_project_modal_btn').click(function(){
            $('#addProjectLabel').text('Add Project');
            $('#first_name').val('');
            $('#add_project_btn').css('display', 'initial');
            $('#edit_project_btn').css('display', 'none');    
        });
        
        $('#add_customer_modal_btn').click(function(){
            // event.preventDefault();
            var url = "https://vvsoffert.se/user/add_new_customer";
            $('#add_customer_form').attr("action", url);
            $('#addCustomerLabel').text('New Customer');
            $('#first_name').val('');
            $('#last_name').val('');
            $('#email').val('');
            $('#company').val('');
            $('#webaddress').val('');
            $('#phonenumber').val('');
            $('#postcode').val('');
            
            $('#add_customer_btn').css('display', 'initial');
            $('#edit_customer_btn').css('display', 'none');
            // console.log("sdfsdfsdf");
        });
        
        
        
        $("#add_project_btn").click(function(e){
            if($('#name').val()){
                $("#add_project_form").submit();
            }
            else{
                $('#check_field').css('display', 'block');
            }
            
        });
        $('#customer_sel').change(function(){
           showCustomerInfo();
        });
        
        $('#invoice_type').change(function(){
            alert("ok"); 
        });
        
        $("#add_customer_btn").click(function(e){
            var flag =false;
            if($('#first_name').val()){
                $('#check_first_name').css('display', 'none');
            }
            else{
                $('#check_first_name').css('display', 'block');
                flag = true;
                
            }
            if($('#last_name').val()){
                $('#check_last_name').css('display', 'none');
            }
            else{
                $('#check_last_name').css('display', 'block');
                flag = true;
                // return;
            }
            if($('#email').val()){
                $('#check_email').css('display', 'none');
            }
            else{
                $('#check_email').css('display', 'block');
                flag = true;
            }
            if(!flag){
                $("#add_customer_form").submit();
            }
                
        });
        
        
        
        $("#edit_customer_btn").click(function(e){
            var flag =false;
            if($('#first_name').val()){
                $('#check_first_name').css('display', 'none');
            }
            else{
                $('#check_first_name').css('display', 'block');
                flag = true;
                
            }
            if($('#last_name').val()){
                $('#check_last_name').css('display', 'none');
            }
            else{
                $('#check_last_name').css('display', 'block');
                flag = true;
                // return;
            }
            if($('#email').val()){
                $('#check_email').css('display', 'none');
            }
            else{
                $('#check_email').css('display', 'block');
                flag = true;
            }
            if(!flag){
                $("#add_customer_form").submit();
            }
            
        });

        $('#find_rsknum').click(function(){
            // console.log($('#art_num').val());
            var rsk_no = $('#art_num').val();
            
            $.post(
                // "https://vvsoffert.se/get-product",
                "/get-product",
                {rsk_no: rsk_no},
                function(data, status){
                    data = JSON.parse(data).productlist;
                    //console.log("Data: " + data['PRICE'] + "\nStatus: " + status);
                    price = JSON.parse(data['PRICE']);
                    //console.log("=========price===========",price);
                    dafl_price=0;
                    $.each(price, function() {
                        $.each(this, function(k, v) {
                            store_name = k.split("-")
                            if(store_name[1] == 46)
                                dafl_price=v;
                        });
                    });
                    dafl_price = parseFloat(dafl_price.replace(',',''))
                    //console.log("-----daflprice------",dafl_price)
                    foms_price = dafl_price*1.25;
                    $('#art_name').val(data['PRO_NAME']);
                    $('#art_name_en').val(data['PRO_NAME']);
                    $('#sale_price_excl').val(dafl_price);
                    $('#sale_price_incl').val(foms_price);
                    $('#pur_price_excl').val(dafl_price);
                    $('#stock_bal').val(data['QUANTITY']);
                    $('#price_list').val(data['PRICE']);
                }
            );
        });

        $('#make_invoice_form').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                return false;
            }
        });

        $('#make_order_form').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                return false;
            }
        });

        $('#make_offerter_form').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                return false;
            }
        });
        
        
        $('#search-key').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                var currentUrl = window.location.href;
                var key = $('#search-key').val();
                var seachUrl = '';
                if (window.location.host == 'vvsoffert.se') {
                    seachUrl = window.location.protocol + '//' + window.location.host + '/' + 'Products_new?search=' + key;
                    } else {
                    seachUrl = window.location.protocol + '//' + window.location.host + '/vvsoffert.se/' + 'Products_new?search=' + key;
                }
                window.location.href = seachUrl;
            }
        });
        
        $('#m-search-key').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
            var currentUrl = window.location.href;
            var key = $('#m-search-key').val();
            var seachUrl = '';
            if (window.location.host == 'vvsoffert.se') {
                seachUrl = window.location.protocol + '//' + window.location.host + '/' + 'Products_new?search=' + key;
            } else {
                seachUrl = window.location.protocol + '//' + window.location.host + '/vvsoffert.se/' + 'Products_new?search=' + key;
            }
            window.location.href = seachUrl;
            }
        });
    
        


        $(document).on('click', '.add-article-row-btn', function(){
            
            addedRow++;
            var article_numstr = $('#article_nums').val();
            //console.log(article_numstr);
            article_num = article_numstr.split(",");
            var option_str = '<option value='+0+'>Select Article Num</option>';
            $.each(article_num, function(k, v) {
                //$.each(this, function(k, v) {
                    option_str +='<option class='+v+' value='+v+'>'+v+'</option>';                                
                //});
            });
            temp=0;
            $(".add-article-row").each(function(index, value){
                temp++;
            });
            console.log("------------========temp",temp);
            //`<div class='add-article-row row' style='margin-bottom:5px;' id='added-row-`+addedRow+`'>
            //<input style='width:100%;font-size:18px;' type='text' placeholder='' class='form-control artclass' attr-id='added-row-`+addedRow+`' name='art_id[]' value=''>
            //<i class='fa fa-search find-product-info'  style=' position: absolute; top: 9px;  right: 12%;'></i>
            // <select style='line-height:28px; padding-left:5px; height: 34px;font-size:18px;' class='form-control artclass' attr-id='added-row-`+addedRow+`' name='art_id[]'>
            //     `+option_str+`
            // </select>
            
            var attHtml = `<div class='add-article-row row' style='margin-bottom:5px;' id='added-row-`+temp+`'>
                                <div class='col-md-2 col-sm-12'>
                                    <input style='width:100%;font-size:18px;' type='text' placeholder='' class='form-control artclass' attr-id='added-row-`+temp+`' name='art_id[]' value=''>
                                    <i class='fa fa-search find-product-info'  style=' position: absolute; top: 9px;  right: 12%;'></i>
                                </div>
                                <div class='col-md-3 col-sm-12'>
                                    <input style='font-size:18px;' type='text' placeholder='' class='form-control ' name='art_name[]' value=''> 
                                </div>
                                <div class='col-md-1 col-sm-12'>
                                    <input style='font-size:16px;' type='text' placeholder='' class='form-control ' name='art_quantity[]' value=''> 
                                </div>
                                <div class='col-md-2 col-sm-12'>
                                    <input style='font-size:18px;' type='text' placeholder='' class='form-control ' name='unit[]' value=''> 
                                </div>
                                <div class='col-md-1 col-sm-12'>
                                    <input style='font-size:18px;' type='text' placeholder='' class='form-control ' name='sale_price_excl[]' value=''> 
                                </div>
                                <div class='col-md-1 col-sm-12'>
                                    <input style='font-size:18px;' type='text' placeholder='' class='form-control ' name='discount[]' value=''> 
                                </div>
                                <div class='col-md-1 col-sm-12'>
                                    <input style='font-size:18px;' type='text' placeholder='' class='form-control ' name='sum_excl[]' value=''>
                                </div>
                                <div class='col-md-1 col-sm-12' style="margin-top:0px">
                                    <i class='fa fa-plus-circle add-article-row-btn' style='font-size:30px;color:green;' ></i>
                                    <i class='fa fa-minus-circle remove-article-row-btn' attr-id='added-row-`+temp+`' style='font-size:30px;color:red;' ></i>
                                </div>
                            </div>`;
            $('#add-article-area').append(attHtml);
            $("select").select2();
            
        });

        $(document).on('click', '.remove-article-row-btn', function(){
            console.log("-----------remove----------");
            var selector = "#add-article-area #" + $(this).attr('attr-id');
            total_sum = ($('#total_sum').val())*1;
            sum_excl = $(selector + " input[name='sum_excl[]']").val();
            total_sum -= sum_excl;
            $('#total_sum').val(total_sum);
            $(selector).remove();
        });
        
        //---------------------using blur event 
        // $(document).bind('keypress', 'input[name="art_id[]"]', function(event){
        //     if ( event.which == 13 ) {
        //         var key = $(this).val();
        //         console.log("enter key press event",key)
        //         var selector = '#' + $(this).attr('attr-id');
        //         insertVal(key,selector);
        //     }
        // });
        $(document).on('blur', '#sale_price_excl', function(){
            price_excel = $('#sale_price_excl').val();
            price_incl = price_excel*1.25;
            $('#sale_price_incl').val(price_incl);

        });
        

        $(document).on('blur', 'input[name="art_quantity[]"]', function(){
            var key = $(this).val();
            //var selector = '#' + $(this).attr('attr-quantity');
            //console.log(selector)

            var store = $('#store_name_inv').val()
            var store_id = store[1];
            var total_sum = 0;

            $(".artclass").each(function(index, value){
                var item = $(this);
                var selector = '#' + $(this).attr('attr-id');
                var quan = $(selector + " input[name='art_quantity[]']").val()
                var pris = $(selector + " input[name='sale_price_excl[]']").val()
                var sum = (quan*1)*(pris*1);
                $(selector + " input[name='sum_excl[]']").val(sum.toFixed(2))
                total_sum += sum;
                $('#total_sum').val(total_sum.toFixed(2));
            });
         });
        
        // $(document).on('click', '.find-product-info', function(){
        //     var key = $(this).val();
        //     var selector = '#' + $(this).attr('attr-id');
        //     insertVal(key,selector);
        // });
        $(document).on('blur', 'input[name="art_id[]"]', function(){
            var key = $(this).val();
            var selector = '#' + $(this).attr('attr-id');
            insertVal(key,selector);
        });

        // $(document).on('change', 'select[name="art_id[]"]', function(){
        //     var articleId = $(this).val();
        //     var selector = '#' + $(this).attr('attr-id');
        //     insertVal(articleId,selector);
        // })

        function insertVal(key,selector){
            $.post(
                "/get-article-info",
                {rsk_no: key},
                function(data, status){
                    
                    art_data = JSON.parse(data).article_list;
                    data_status = JSON.parse(data).status;

                    if(data_status == "success"){
                        
                        sum_price = art_data['stock_bal'] * art_data['sale_price_excl'];
                        old_sum_excel = ($(selector + " input[name='sum_excl[]']").val())*1;
                        total_sum = ($('#total_sum').val())*1;
                        total_sum -= old_sum_excel;
                        total_sum += sum_price;
                        $(selector + " input[name='art_name[]']").val(art_data['art_name']);
                        $(selector + " input[name='art_quantity[]']").val(art_data['stock_bal']);
                        $(selector + " input[name='unit[]']").val(art_data['unit']);
                        $(selector + " input[name='sale_price_excl[]']").val(art_data['sale_price_excl']);
                        $(selector + " input[name='discount[]']").val('0.00%');
                        $(selector + " input[name='sum_excl[]']").val(sum_price.toFixed(2));
                        $('#total_sum').val(total_sum.toFixed(2));

                    }else{
                        $.post(
                            "/get-product-info",
                            {rsk_no: key},
                            function(data, status){
                                data2_status = JSON.parse(data).status;
                                console.log("-==-==-=-=-==--=-==-",data2_status);
                                if(data2_status == "exist"){
                                
                                    data = JSON.parse(data).productlist;
                                    price = JSON.parse(data['PRICE']);
                                                       
                                    dafl_price="0.0";
                                    $.each(price, function() {
                                        $.each(this, function(k, v) {
                                            store_name = k.split("-")
                                            if(store_name[1] == 46)
                                                if(v)
                                                    dafl_price=v;
                                        });
                                    });

                                    dafl_price = parseFloat(dafl_price.replace(',',''))

                                    sum_excel = ((data['QUANTITY'])*1)*(dafl_price*1);
                                    old_sum_excel = ($(selector + " input[name='sum_excl[]']").val())*1;
                                    total_sum = ($('#total_sum').val())*1;
                                    
                                    total_sum += sum_excel;
                                    total_sum -= old_sum_excel;
                                    console.log(total_sum);
                                    $(selector + " input[name='art_name[]']").val(data['PRO_NAME']);
                                    $(selector + " input[name='art_quantity[]']").val(data['QUANTITY']);
                                    $(selector + " input[name='unit[]']").val('ST');
                                    $(selector + " input[name='sale_price_excl[]']").val(dafl_price);
                                    $(selector + " input[name='discount[]']").val('0.00%');
                                    $(selector + " input[name='sum_excl[]']").val(sum_excel);
                                    $('#total_sum').val(total_sum);

                                }else{
                                    console.log("there is no product");
                                }
                            }
                        );
                    }
                   
                }
            );

        }

        //-------------old method : above line article change
        // $('#article_num').change(function(){
        //     var articleId = $(this).val();
        //     var selector = "#article_num ." + articleId;
        //     var quantity = $(selector).attr('attr-quantity');
        //     var art_name = $(selector).attr('attr-art_name');
        //     var sale_price_excl = $(selector).attr('attr-sale_price_excl');
        //     var price_list = $(selector).attr('attr-price_list');
        //     var unit = $(selector).attr('attr-unit');
        //     var sum = quantity*sale_price_excl;
        //     var total_sum = ($('#total_sum').val())*1;
        //     total_sum += sum*1;
        //     $('#total_sum').val(total_sum.toFixed(2));
        //     var html = `<div class='add-article-row row `+articleId+`' style='margin-bottom:5px;'>
        //                         <div class='col-sm-2'>
        //                             <input style='font-size:18px;' type='text' placeholder='' class='form-control artclass' name='art_id[]' value='`+articleId+`'> 
        //                         </div>
        //                         <div class='col-sm-3'>
        //                             <input style='font-size:18px;' type='text' placeholder='' class='form-control art_name_`+articleId+`' name='art_name[]' value='`+art_name+`'> 
        //                         </div>
        //                         <div class='col-sm-1'>
        //                             <input style='font-size:16px;' type='text' placeholder='' class='form-control art_quantity_`+articleId+`' name='art_quantity[]' value='`+quantity+`'> 
        //                         </div>
        //                         <div class='col-sm-2'>
        //                             <input style='font-size:18px;' type='text' placeholder='' class='form-control unit_`+articleId+`' name='unit[]' value='`+unit+`'> 
        //                         </div>
        //                         <div class='col-sm-1'>
        //                             <input style='font-size:18px;' type='text' placeholder='' class='form-control sale_price_excl_`+articleId+`' name='sale_price_excl[]' value='`+sale_price_excl+`'> 
        //                         </div>
        //                         <div class='col-sm-1'>
        //                             <input style='font-size:18px;' type='text' placeholder='' class='form-control discount_`+articleId+`' name='discount[]' value='0.00%'> 
        //                         </div>
        //                         <div class='col-sm-1'>
        //                             <input style='font-size:18px;' type='text' placeholder='' class='form-control sum_excl_`+articleId+`' name='sum_excl[]' value='`+sum+`'>
        //                         </div>
        //                         <div class='col-sm-0' style='display:none;'>
        //                             <input style='font-size:18px;' type='text' class='form-control price_list' name='price_list[]' value='`+price_list+`'>
        //                         </div>
        //                         <div class='col-sm-1'>
        //                             <i class='fa fa-trash remove-article-row' attr-remove-class='.`+articleId+`'></i>
        //                             <i class='fa fa-plus-circle add-article-row' id='add-article-row-btn' style='font-size:30px;color:red;' ></i>
        //                             <i class='fa fa-minus-circle remove-article-row' style='font-size:30px;color:green;' ></i>
        //                         </div>
        //                     </div>`;
        //     $('#add-article-area').append(html);
        // });

        //-------------old method: above line article find
        // $('#find_rsknum_invoice').click(function(){
        //     var rsk_no = $('#art_num').val();
            
        //     $.post(
        //         "/get-product",
        //         {rsk_no: rsk_no},
        //         function(data, status){
        //             data = JSON.parse(data).productlist;
        //             price = JSON.parse(data['PRICE']);
        //             $('#add-article-area').append(html);
        //             dafl_price=0;
        //             $.each(price, function() {
        //                 $.each(this, function(k, v) {
        //                     store_name = k.split("-")
        //                     if(store_name[1] == 46)
        //                         dafl_price=v;
        //                 });
        //             });


        //             var html = `<div class='add-article-row row `+rsk_no+`' style='margin-bottom:5px;'>
        //                         <div class='col-sm-2'>
        //                             <input style='font-size:18px;' type='text' placeholder='' class='form-control artclass' name='art_id[]' value='`+rsk_no+`'> 
        //                         </div>
        //                         <div class='col-sm-3'>
        //                             <input style='font-size:18px;' type='text' placeholder='' class='form-control art_name_`+rsk_no+`' name='art_name[]' value='`+data['PRO_NAME']+`'> 
        //                         </div>
        //                         <div class='col-sm-1'>
        //                             <input style='font-size:16px;' type='text' placeholder='' class='form-control art_quantity_`+rsk_no+`' name='art_quantity[]' value='`+data['QUANTITY']+`'> 
        //                         </div>
        //                         <div class='col-sm-2'>
        //                             <input style='font-size:18px;' type='text' placeholder='' class='form-control unit_`+rsk_no+`' name='unit[]' value='ST'> 
        //                         </div>
        //                         <div class='col-sm-1'>
        //                             <input style='font-size:18px;' type='text' placeholder='' class='form-control sale_price_excl_`+rsk_no+`' name='sale_price_excl[]' value='`+dafl_price+`'> 
        //                         </div>
        //                         <div class='col-sm-1'>
        //                             <input style='font-size:18px;' type='text' placeholder='' class='form-control discount_`+rsk_no+`' name='discount[]' value='0.00%'> 
        //                         </div>
        //                         <div class='col-sm-1'>
        //                             <input style='font-size:18px;' type='text' placeholder='' class='form-control sum_excl_`+rsk_no+`' name='sum_excl[]' value='`+dafl_price+`'>
        //                         </div>
        //                         <div class='col-sm-0' style='display:none;'>
        //                             <input style='font-size:18px;' type='text' class='form-control price_list' name='price_list[]' value='`+price+`'>
        //                         </div>
        //                         <div class='col-sm-1'>
        //                             <i class='fa fa-trash remove-article-row' attr-remove-class='.`+rsk_no+`'></i>
        //                             <i class='fa fa-plus-circle add-article-row' id='add-article-row-btn' style='font-size:30px;color:red;' ></i>
        //                             <i class='fa fa-minus-circle remove-article-row' style='font-size:30px;color:green;' ></i>
        //                         </div>
        //                     </div>`;
        //             $('#add-article-area').append(html);
        //             // dafl_price=0;
        //             // $.each(price, function() {
        //             //     $.each(this, function(k, v) {
        //             //         store_name = k.split("-")
        //             //         if(store_name[1] == 46)
        //             //             dafl_price=v;
        //             //     });
        //             // });
        //             // $('#art_name').val(data['PRO_NAME']);
        //             // $('#art_name_en').val(data['PRO_NAME']);
        //             // $('#sale_price_excl').val(dafl_price);
        //             // $('#sale_price_incl').val(dafl_price);
        //             // $('#pur_price_excl').val(dafl_price);
        //             // $('#stock_bal').val(data['QUANTITY']);
        //             // $('#price_list').val(data['PRICE']);
        //         }
        //     );
        // });

        // $(document).on('click', '#add-article-area .remove-article-row', function(){
        //     var selector = $(this).attr('attr-remove-class');
        //     total_sum = ($('#total_sum').val())*1;
        //     sum_excl = $(selector + " input[name='sum_excl[]']").val();
        //     total_sum -= sum_excl;
        //     $('#total_sum').val(total_sum);
        //     $(selector).remove();
        // })
        
        $('#add_product_btn').click(function(){
            // console.log($('#rsk_no').val());
            var rsk_no = $('#rsk_no').val();
            
            $.post(
                // "https://vvsoffert.se/get-product",
                "/get-product",
                {rsk_no: rsk_no},
                function(data, status){
                    data = JSON.parse(data).productlist;
                    console.log("Data: " + data + "\nStatus: " + status);                    
                    if(status!="success" || !data){
                        $('#add_product_alarm').css('display', 'initial');
                        return;
                    }
                    $('#add_product_alarm').css('display', 'none');
                    $('#template').empty();
                    var length = $('#template1 #invoice_table tr').length;
                    var tmp_tr="<tr><td id='pro_name_" + length + "' contenteditable='false'>" + data['PRO_NAME'] + "</td><td id='rsk_no_" + length + "' contenteditable='false'>" + data['RSK_NO'] + "</td><td id='quantity_" + length + "' contenteditable='false'>" + data['QUANTITY'] + "</td><td id='unit_" + length + "' data='" + data['PRICE'] + "' contenteditable='false'>" + data[$('#store_name').val()] + "</td><td id='subtotal_" + length + "'></td><td style = 'text-align: center;' id = 'action_" + length + "'><a href='#' onclick='editProduct(" + length + ")' style = 'color: white; width: 50px; height: 30px; background-color: #f0ad4e; padding:5px 10px; box-shadow: 5px 3px lightgrey; border-radius: 8px; margin-right: 15px;' class='fa fa-edit' id = 'edit'></a><a href='#'' onclick='saveProduct(" + length + ")' style = 'color: white; width: 50px; height: 30px; background-color: green; padding:5px 10px; box-shadow: 5px 3px lightgrey; border-radius: 8px; margin-right: 15px; display: none' class='fa fa-save' id = 'save'></a><a href='#' onclick='removeProduct(" + length + ")' style = 'color: white; width: 50px; height: 30px; background-color: #d9534f; padding: 5px 10px;; box-shadow: 5px 3px lightgrey; border-radius: 8px;' class='fa fa-trash'></a></td></tr>"
                    $('#template1 #invoice_table').append(tmp_tr);
                    subtotalFunc(length+1);
                    $('#template').append($('#template1').html());
                    $('#template #invoice_datatable_removebyme').dataTable({
                        dom: 'Bfrtip',
                            buttons: [
                                {
                                    text: 'Add Product',
                                    action: function ( e, dt, node, config ) {
                                      $('#addProdut').modal('show');
                                      
                                    }
                                }
                            ],
                        "footerCallback": function ( row, data, start, end, display ) {
                            var api = this.api(), data;
                 
                            // Remove the formatting to get integer data for summation
                            var intVal = function ( i ) {
                                return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '')*1 :
                                    typeof i === 'number' ?
                                        i : 0;
                            };
                  
                            // Total over all pages
                            total = api
                                .column( 4 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );
                 
                            // Total over this page
                            pageTotal = api
                                .column( 4, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );
                 
                            // Update footer
                            $( api.column(4).footer() ).html(
                                '$'+pageTotal.toFixed(2) +' ( $'+ total.toFixed(2) +' total)'
                            );
                            total_price_of_project = total.toFixed(2);
                        }
                    });
                    $('#template #invoice_datatable_removebyme1').dataTable({
                        dom: 'Bfrtip',
                            buttons: [
                                {
                                    text: 'Add Product',
                                    action: function ( e, dt, node, config ) {
                                      $('#addProdut').modal('show');
                                      
                                    }
                                }
                            ],
                        "footerCallback": function ( row, data, start, end, display ) {
                            var api = this.api(), data;
                 
                            // Remove the formatting to get integer data for summation
                            var intVal = function ( i ) {
                                return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '')*1 :
                                    typeof i === 'number' ?
                                        i : 0;
                            };
                  
                            // Total over all pages
                            total = api
                                .column( 4 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );
                 
                            // Total over this page
                            pageTotal = api
                                .column( 4, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );
                 
                            // Update footer
                            $( api.column(4).footer() ).html(
                                '$'+pageTotal.toFixed(2) +' ( $'+ total.toFixed(2) +' total)'
                            );
                            total_price_of_project = total.toFixed(2);
                        }
                    });
                    $('#addProdut').modal('toggle');
                }
            );
        });

        // $('#store_name_inv').change(function(){

        //     var key = this.value;
        //     var store = key.split('-');
        //     var store_id = store[1];
        //     var price_list = $('.price_list').val();
        //     price_list = JSON.parse(price_list);
        //     var total_sum = 0;

        //     $(".artclass").each(function(index, value){
        //         var item = $(this);
        //         article_num = item.val();
        //         var price_class ='".sale_price_excl_'+article_num+'"';

        //         var price_list = $('.price_list')[index].value;
        //         price_list = JSON.parse(price_list);
        //         $.each(price_list, function() {
        //             $.each(this, function(k, v) {
        //                 store_info = k.split("-")
        //                 if(store_info[1] == store_id){
        //                     $(".sale_price_excl_"+article_num).val(v);
        //                     $(".sum_excl_"+article_num).val(v);
        //                     total_sum += v*1;
        //                 }
        //             });
        //         });
        //     });
        //     $('#total_sum').val(total_sum);
        // });
    showCustomerInfo();


    });
</script>

    

        <div class="row clearfix"></div>
    </div>
</div>
<div class="site_footer">
    <br>
    <ul class="links list-inline">

        <li><a href="<?=site_url()?>">Hem &nbsp;&nbsp;|</a></li>

        <li><a href="<?=site_url('Products')?>">Produkter &nbsp;&nbsp;|</a></li>

         <li><a href="<?=site_url('licensvillkor')?>">Villkor &nbsp;&nbsp;|</a></li>
         <li><a href="<?=site_url('nyheter')?>">Nyheter &nbsp;&nbsp;|</a></li>
    <a href="https://www.vvsgroup.se/">Rörmokare Göteborg</a>
    <a href="https://www.skrotpriset.se//">Skrotpriser</a>

    </ul>

    <div class="coppyright">© <?=date('Y')?> <h2 style="font-size: 21px !important;">Vvsoffert.se. Alla rättigheter förbehållna.</h2></div>

</div>
</body>
