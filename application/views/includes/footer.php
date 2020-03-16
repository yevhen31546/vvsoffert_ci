<div class="footer-wrapper footer-line">
  <div class="footer">
    <div class="footer-inner clearfix">
      <div class="container">
        <div class="footer-line-left"> &copy; 2017 Vvsoffert.se. All rights reserved. </div>
        <!-- /.footer-line-left -->
        <div class="footer-line-right">
          <ul class="nav nav-line">
            <li class="nav-item"><a href="<?php echo site_url(); ?>" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="<?php echo site_url('Products'); ?>" class="nav-link">Products</a></li>            
          </ul>
        </div>
        <!-- /.footer-line-right --> 
      </div>
      <!-- /.container --> 
    </div>
    <!-- /.footer-inner --> 
  </div>
  <!-- /.footer --> 
</div>
<!-- /.footer-wrapper -->
<!-- Return to Top -->
<a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>
</div>
<!-- /.page-wrapper --> 

<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.js'); ?>"></script> 
<script type="text/javascript" src="<?php echo base_url('assets/js/tether.min.js'); ?>"></script> 
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script> 
<script type="text/javascript" src="<?php echo base_url('assets/js/chartist.min.js'); ?>"></script> 
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.trackpad-scroll-emulator.min.js'); ?>"></script> 
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.inlinesvg.min.js'); ?>"></script> 
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.affix.js'); ?>"></script> 
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.scrollTo.js'); ?>"></script> 
<script type="text/javascript" src="<?php echo base_url('assets/libraries/slick/slick.min.js'); ?>"></script> 
<script type="text/javascript" src="<?php echo base_url('assets/js/nouislider.min.js'); ?>"></script> 
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.raty.js'); ?>"></script> 
<script type="text/javascript" src="<?php echo base_url('assets/js/wNumb.js'); ?>"></script> 
<script type="text/javascript" src="<?php echo base_url('assets/js/particles.min.js'); ?>"></script> 
<script type="text/javascript" src="<?php echo base_url('assets/js/explorer.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap-treeview.js'); ?>"></script>

<script>
// ===== Scroll to Top ==== 
$(window).scroll(function() {
    if ($(this).scrollTop() >= 50) {
        $('#return-to-top').fadeIn(200); 
    } else {
        $('#return-to-top').fadeOut(200);  
    }
});
$('#return-to-top').click(function() {  
    $('body,html').animate({
        scrollTop : 0                     
    }, 500);
});

// ===== Add To Compare ==== 
var compare = new Array();
var slno = 0; 
$( ".add-to-compare" ).click(function() {
	var name= $(this).closest('.listing-box').find('h2 a').html();
	var pid = $(this).val();
	if($(this).is(':checked'))
	{	
		if(slno==3)
		{
			alert('You can compare upto 3 products.');
			return false;
		}
		else
		{
			compare.push(pid);
			slno++;
			
			$("#pdt-compare-wrap").removeClass('hide'); 
			$("#pdt-compare-wrap ul").append($('<li id="li'+pid+'">').html(name+'<span><i class="fa fa-times remove-compare" id="'+pid+'"></i></span>'));
		}
	}
	else
	{
		var index = compare.indexOf(pid);		
		compare.splice(index, 1);
		console.log(compare);
		slno--;
		
		var delId = pid;
		$("#c"+delId).prop('checked', false);
		$("#li"+delId).remove();
	}
	
	console.log(slno);
});

// ===== Remove Compare ==== 
$('body').on('click', '.checkbox-wrapper', function() {
	$(this).find('span').addClass('checked');	
	$(this).find('span').css('display','block');	
});
$('body').on('click', '.remove-compare', function() {	
	var delId = parseInt($(this).attr('id'));
	var index = compare.indexOf(delId);		
	compare.splice(index, 1);
	$(this).closest('li').remove();
	$("#c"+delId).prop('checked', false);
	slno--;
});

$('body').on('click', '#goToCompare', function() {	
	if(slno>1)
	{	
		var blkstr = [];
		$.each(compare, function(idx2,val2) {
			var str = 'p'+(parseInt(idx2)+1)+'='+val2;
		  blkstr.push(str);
		});
		var param = blkstr.join("&");
		location.href= '<?php echo site_url('Products/compare'); ?>?'+param;
	}
	else
	{
		alert("Select minimum 2 products");
		
	}
});

// ===== Products Tree ==== 
var defaultData = [
{
  text: 'Parent 1',
  href: '<?php echo site_url(); ?>',  
  nodes: [
	{
	  text: 'Child 1',
	  href: '#child1',  
	  nodes: [
		{
		  text: 'Grandchild 1',
		  href: '#grandchild1',	  
		},
		{
		  text: 'Grandchild 2',
		  href: '#grandchild2',	 
		}
	  ]
	},
	{
	  text: 'Child 2',
	  href: '#child2'  
	}
  ]
},
{
  text: 'Parent 2',
  href: '#parent2',
},
{
  text: 'Parent 3',
  href: '#parent3'
},
{
  text: 'Parent 4',
  href: '#parent4'
},
{
  text: 'Parent 5',
  href: '#parent5'
}
];

var categoryData = [{"text":"Automatik\/Styrventiler","href":"http:\/\/wsfreelanzer.com\/projects\/vvsoffert.se\/index.php\/Products?cno=1","nodes":[{"text":"Givare","href":"http:\/\/wsfreelanzer.com\/projects\/vvsoffert.se\/index.php\/Products?c2no=27"},{"text":"Regulatorer","href":"http:\/\/wsfreelanzer.com\/projects\/vvsoffert.se\/index.php\/Products?c2no=29"},{"text":"Sj\u00e4lvverkande ventiler","href":"http:\/\/wsfreelanzer.com\/projects\/vvsoffert.se\/index.php\/Products?c2no=30"},{"text":"Spj\u00e4llst\u00e4lldon","href":"http:\/\/wsfreelanzer.com\/projects\/vvsoffert.se\/index.php\/Products?c2no=31"},{"text":"Statiska givare & vakter","href":"http:\/\/wsfreelanzer.com\/projects\/vvsoffert.se\/index.php\/Products?c2no=32"},{"text":"Styrventiler","href":"http:\/\/wsfreelanzer.com\/projects\/vvsoffert.se\/index.php\/Products?c2no=33"},{"text":"Ventilst\u00e4lldon","href":"http:\/\/wsfreelanzer.com\/projects\/vvsoffert.se\/index.php\/Products?c2no=34"},{"text":"\u00d6vrigt","href":"http:\/\/wsfreelanzer.com\/projects\/vvsoffert.se\/index.php\/Products?c2no=28"}]}];
var categoryData = <?php echo $categoryData; ?>;
$('#treeview1').treeview({
	expandIcon: 'fa fa-plus',
  	collapseIcon: 'fa fa-minus',
	emptyIcon: 'empty',
  	nodeIcon: 'custom-node-icon',
    selectedIcon: '',
    checkedIcon: 'fa fa-check-square-o',
 	uncheckedIcon: 'fa fa-square-o',
	
	// colors
	color: '#000000', // '#000000',
	backColor: undefined, // '#FFFFFF',
	borderColor: undefined, // '#dddddd',
	onhoverColor: '#F5F5F5',
	selectedColor: '#000000',
	selectedBackColor: '#fff',
	searchResultColor: '#D9534F',
	searchResultBackColor: undefined, //'#FFFFFF',

		levels: 1,
		showBorder: false,
		enableLinks: true,
        data: categoryData
 });

</script>
</body></html>