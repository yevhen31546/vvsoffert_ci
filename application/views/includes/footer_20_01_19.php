<div class="site_footer">

        <ul class="links list-inline">

            <li><a href="<?=site_url()?>">Hem &nbsp;&nbsp;|</a></li>

            <li><a href="<?=site_url('Products')?>">Produkter &nbsp;&nbsp;|</a></li>

             <li><a href="<?=site_url('terms-condition')?>">Villkor &nbsp;&nbsp;|</a></li>
             <li><a href="<?=site_url('nyheter')?>">Nyheter &nbsp;&nbsp;|</a></li>
                   <a href="https://twitter.com/vvsoffert" target="_blank" align="left"><img src="<?php echo site_url('assets/custom/images/twitter.png'); ?>" alt="Twitter" width="125" height="125"></a>

        </ul>

        <div class="coppyright">© <?=date('Y')?> <h2 style="font-size: 21px !important;">Vvsoffert.se. Alla rättigheter förbehållna.</h2></div>

    </div>

<!-- Global Site Tag (gtag.js) - Google Analytics -->
<!--<script async src="<?php //echo base_url('assets/js/analytics.js'); ?>"></script>-->
<script defer src="<?php echo base_url('assets/js/gtag.js'); ?>"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

<script type="text/javascript" src="<?php echo base_url('assets/js/vendors.js'); ?>"></script>


<script defer type="text/javascript" src="<?php echo base_url('assets/custom/js/frontend_custom.js'); ?>"></script>

    

<script defer type="text/javascript">

        
function AddProduct(e){InsertInSelectedIDs(e)&&($(".searchContainer").empty(),$("#search_products").val(),$(".customSearchContainer").hide())}function removeProduct(e){var o=new Array,r=$(".selected_products").val();o=(o=r.split(",")).map(Number),$.confirm({closeIcon:!0,closeIconClass:"fa fa-close",title:"vvsoffert.se säger:",escapeKey:!0,content:"Are you sure you want to <strong>remove</strong> it?",backgroundDismiss:!0,buttons:{avbryt:{keys:["ctrl","shift"],action:function(){}},okay:{keys:["enter"],action:function(){o.splice($.inArray(e,o),1),$(".selected_products").val(o),$("#pro_"+e).hide()}}}})}function InsertInSelectedIDs(e){var o=addValue($(".selected_products").val(),e);if(o){$(".selected_products").val(o);var r=$(".product_"+e).attr("data-name");$("#selected_pros").append('<li id="pro_'+e+'"> '+r+'     <p class="fa fa-trash" onClick="removeProduct('+e+')"></p></li>'),$(".lblProducts").removeClass("hide")}return!0}function addValue(e,o){var r=new Array;return-1==(r=(r=e.split(",")).map(Number)).indexOf(o)&&(r.push(o),(r=cleanArray(r)).join(","))}function cleanArray(e){for(var o=new Array,r=0;r<e.length;r++)e[r]&&o.push(e[r]);return o}function showLoader(){$(".pre-loader").fadeIn()}function hideLoader(){$(".pre-loader").fadeOut()}$(document).ready(function(){$("#multiDropdown").select2();responsiveNav("#sidebar-wrapper",{customToggle:"",enableFocus:!0,enableDropdown:!0,openDropdown:'<span class="screen-reader-text">Open sub menu</span>',closeDropdown:'<span class="screen-reader-text">Close sub menu</span>'});$(".search-button").on("click",function(e){showLoader(),$.ajax({url:"<?php echo site_url() ?>user/searchProductAjax",type:"POST",data:{term:$("#search_products").val(),store_id:$(".store_id option:selected").val()},dataType:"JSON",success:function(e){""!=e&&(console.log(e),$(".searchContainer").empty(),$(".searchContainer").append(e.html_product),$(".searchContainer").show()),hideLoader()}})})});var menuBarClose=!1;$("#menu-toggle").on("click",function(e){$("#myNavbar").show("slow"),menuBarClose=!0}),$(".close-sidebar").on("click",function(e){$("#myNavbar").hide("slow"),menuBarClose=!1}),$(window).scroll(function(){50<=$(this).scrollTop()?$("#return-to-top").fadeIn(200):$("#return-to-top").fadeOut(200)}),$("#return-to-top").click(function(){$("body,html").animate({scrollTop:0},500)});




</script>


<script defer type="text/javascript" src="<?php echo base_url('assets/js/vvsoffert-se-scripts.min.js'); ?>"></script>
    

    

</body>