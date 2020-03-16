$(function() {

	$('#vvsoffert-se-search').click(function(e) {

		e.preventDefault();

		var currentUrl = window.location.href;

		var key = $('#search-key').val();

		var seachUrl = '';
		
		if(window.location.host == 'vvsoffert.se'){

			seachUrl = window.location.protocol + '//' + window.location.host + '/' + 'Products?search=' + key;

		} else {

			seachUrl = window.location.protocol + '//' + window.location.host + '/vvsoffert.se/' + 'Products?search=' + key;

		}

		window.location.href = seachUrl;

	});

	$('#m-vvsoffert-se-search').click(function(e) {

		e.preventDefault();

		var currentUrl = window.location.href;

		var key = $('#m-search-key').val();

		var seachUrl = '';
		
		if(window.location.host == 'vvsoffert.se'){

			seachUrl = window.location.protocol + '//' + window.location.host + '/' + 'Products?search=' + key;

		} else {

			seachUrl = window.location.protocol + '//' + window.location.host + '/vvsoffert.se/' + 'Products?search=' + key;
			
		}

		window.location.href = seachUrl;

	});

	$('.cl2pl').click(function(e) {

		e.preventDefault();

		var c1 = $(this);

		var c2ls = c1.next().next();

		var c1l = c2ls.parent('li');

		if(c2ls.is(":visible")) {

			c1.html('<i class="icon expand-icon fa fa-plus">');

			c1l.removeClass('active');
			

		} else {

			c1.html('<i class="icon expand-icon fa fa-minus">');

			c1l.addClass('active');

		}


	});


	$('.cl3pl').click(function(e) {

			e.preventDefault();

			var c2 = $(this);

			var c3ls = c2.next().next();

			var c2l = c3ls.parent('li');

			if(c3ls.is(":visible")) {

				//c3ls.css('display', 'none');
				c2l.removeClass('active');

				c2.html('<i class="icon expand-icon fa fa-plus">');

			} else {

				//c3ls.css('display', 'block');
				c2l.addClass('active');

				c2.html('<i class="icon expand-icon fa fa-minus">');
			}

			

	});




	$('#cc-place').change(function(e) {

		var place = $(this).val();

		var placeCoefficient = parseFloat(place);

		if(placeCoefficient != 0) {

			$('#cc-psId').val(0);

			$('#cc-pspId').html('<option value="0">Välj Produkt</option>');

        	$('#cc-psId').prop('disabled', false);
        	$('#cc-pspId').prop('disabled', false);
        	//$('#add_service').prop('disabled', true);

        	$('#cc-service-time').html('0');
        	$('#cc-total-cost').html('0');

        	$('#cc-job-description').html('');

		} else {

			$('#cc-psId').val('0');
        	$('#cc-psId').prop('disabled', true);
        	
        	$('#cc-pspId').html('<option value="0">Välj Produkt</option>');
        	$('#cc-pspId').prop('disabled', true);
        	//$('#add_service').prop('disabled', true);

        	$('#cc-job-description').html('');

        	$('#cc-service-time').html('---');
        	$('#cc-total-cost').html('---');

		}

		$('#add_service').prop('disabled', true);

	});

	$('#cc-psId').change(function(e) {

		var psId = $(this).val();

		var id = psId.split('/')[1];

    	var pricesUrl = $("#spUrl").val() + id;

		//alert(pricesUrl);

	    $.get(pricesUrl, function(data, status) {
	    	//alert(data);

	        var response = JSON.parse(data);

	        if(response.status = 200) {

	        	var prices = response.servicePrices;
            	var pCount = response.count;

            	if(pCount > 0) {

            		$('#cc-pspId').html('<option value="0">Välj Produkt</option>');

            		$.each(prices, function (i, item) {
					    $('#cc-pspId').append($('<option>', { 
					        value: item.price + '/' + item.time + '/' + item.jobDescription + '/' + item.jobTitle,
					        text : '[RSK-NO: ' + item.rskNumber + '] : ' + item.jobTitle 
					    }));
					});

            	} else {

            		$('#cc-pspId').html('<option value="0">Välj Produkt</option>');
            		$('#cc-job-description').html('');

            	}


	        }
	        

	    });


        $('#add_service').prop('disabled', true);

	});

	$('#cc-pspId').change(function(e) {

		var pspId = $(this).val();

		if(pspId != 0) {

			var pInfo = pspId.split('/');

			$('#cc-job-description').html(pInfo[2]);

			var price = parseFloat(pInfo[0]);

			$('#finalJob').val(pInfo[3]);

			var psId = $('#cc-psId').val();

			var service = psId.split('/')[0];

			$('#finalService').val(service);

			var placeValue = $('#cc-place').val();

			var place = placeValue.split('/')[0];

			$('#finalPlace').val(placeValue.split('/')[1]);

			var placeCoefficient = parseFloat(place);

			var totalPrice = price * placeCoefficient;

	        $('#cc-total-cost').html(totalPrice.toFixed(2));

			$('#cc-service-time').html(pInfo[1]);

        	$('#cc-quantity').prop('disabled', false);

        	$('#add_service').prop('disabled', false);

		} else {

			$('#cc-job-description').html('');

			$('#cc-service-time').html('0');
        	$('#cc-total-cost').html('0');

        	$('#cc-quantity').prop('disabled', true);

        	$('#add_service').prop('disabled', true);

		}

	});

	$('#cc-quantity').change(function(e) {

		var quantity = $(this).val();

	});

	$('#add_service').click(function(e) {

		e.preventDefault();



		$('#cost_rows').append('<tr><td>' + $('#finalPlace').val() + '</td><td>' + $('#finalService').val() + '</td><td>' + $('#finalJob').val() + '</td><td>' + $('#cc-quantity').val() + '</td><td>' + ($('#cc-service-time').html() * $('#cc-quantity').val()).toFixed(1) + '</td><td>' + ($('#cc-total-cost').html() * $('#cc-quantity').val()).toFixed(2) + '</td></tr>');



		$('#ccTotalTime').val(parseFloat($('#ccTotalTime').val()) + parseFloat($('#cc-service-time').html() * $('#cc-quantity').val()));
		$('#ccTotalCost').val(parseFloat($('#ccTotalCost').val()) + parseFloat($('#cc-total-cost').html() * $('#cc-quantity').val()));

        $('#cc_time').html(parseFloat($('#ccTotalTime').val()).toFixed(1));

		$('#cc_cost').html(parseFloat($('#ccTotalCost').val()).toFixed(2));

		$('#cc-place').val('0');

		$('#cc-psId').val('0');
    	$('#cc-psId').prop('disabled', true);
    	
    	$('#cc-pspId').html('<option value="0">Välj Produkt</option>');
    	$('#cc-pspId').prop('disabled', true);
    	
    	$('#cc-quantity').val('1');
    	$('#cc-quantity').prop('disabled', true);

    	$('#cc-job-description').html('');

    	$('#cc-service-time').html('---');
    	$('#cc-total-cost').html('---');
    	
    	$('#add_service').prop('disabled', true);


	});

	$("#send_quote_form").submit(function(e) {


		$('#name').css('border', '1px solid #d1d3d5');
		$('#email').css('border', '1px solid #d1d3d5');
		$('#message').css('border', '1px solid #d1d3d5');


		var name = $('#name').val();
		var email = $('#email').val();
		var message = $('#message').val();

		if(name == '') {
			$('#name').css('border', '1px solid #ed2939');

		}

		if(email == '') {

			$('#email').css('border', '1px solid #ed2939');

		}

		if(message == '') {

			$('#message').css('border', '1px solid #ed2939');

		}

		if(name == '' || email == '' || quantity == '' || quantity == 0 || message == '') {

			e.preventDefault();

		}

	});


});


function sendQuote(event){

	var _this=$("#"+event.id);

	var product_id=_this.attr("data-productId");var product_rsk=_this.attr("data-rskNo");$("#product_id").val(product_id);$("#product_rsk").val(product_rsk);

	var product_name=_this.attr("data-productName");$("#product_name").val(product_name);$("#productName").val(product_name);

	var manufacturer=_this.attr("data-manufacturer");$("#product_manufacturer").val(manufacturer);

	$('#quoteModal').modal('show');

}