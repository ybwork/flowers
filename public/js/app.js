$(document).ready(function() {

	var _token = $('input[name="_token"]').val();

	function customizeForm(form, action, method, color, text) {
		form.attr('action', action);
		form.find('input[name="_method"]').val(method);
		form.find('.ajax-button').css('background', color).text(text);
		
		return true;
	}

	$(document).on('submit', '.ajax-form', function(e) {
		e.preventDefault();

		var form = $(this);
		var	action = form.attr('action');
		var	method = form.attr('method');
		var data = new FormData(form[0]);

		$.ajax({
			url: action,
			data: data,
			type: method,
			contentType: false,
			cache: false,
			processData:false,
			headers: {
				'X-CSRF-TOKEN': _token
			},

			success: function(data) {
				var response = $.parseJSON(data);

				if (response['status'] == 'added') {
					customizeForm(
						form, 
						'/product/delete-from-cart', 
						'DELETE', 
						'red', 
						'Отказаться'
					);

					$('#count-product').text(response['count']);
				} else if (response['status'] == 'deleted') {
					customizeForm(
						form, 
						'/product/add-to-cart', 
						'POST', 
						'green', 
						'Заказать'
					);

					$('#count-product').text(response['count']);
				}
			},

			error: function(e) {
				var error = $.parseJSON(e.responseText);

				switch (error.error) {
					case 'Unauthenticated.':
						var loginPage = window.location.origin + '/login';
						$(location).attr('href', loginPage);
						break;
				}
			},
		});
	});

	$(document).on('submit', '.order', function(e) {
		e.preventDefault();

		var form = $(this);
		var action = form.attr('action');
		var method = form.attr('method');
		var data = new FormData(form[0]);

		$.ajax({
			url: action,
			type: method,
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			headers: {
				'X-CSRF-TOKEN': _token
			},

			success: function(data) {
				var response = $.parseJSON(data);

				if (response['status'] == 'success') {
					console.log(1);
				} else {
					console.log(0);
				}
			},

			error: function(e) {

			}
		})
	});

	$(document).on('click', '.delete-item', function(e) {
		e.preventDefault();

		var	action = 'http://' + window.location.host + '/product/delete-from-cart';
		var	method = 'DELETE';
		var product_id = $(this).closest('.panel-body').find('.product-id').val();

		$.ajax({
			url: action,
			type: method,
			data: {
				product_id: product_id
			},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},

			success: function(data) {
				var response = $.parseJSON(data);
				
				if (response['status'] == 'deleted') {
					$('.order').find('.panel-body').eq(0).remove();
					
					var panel = $('.order').find('.panel-body');
					if (panel.length == 0) {
						$('.order').remove();
					}
				}

				$('#count-product').text(response['count']);
			},

			error: function(e) {

			},
		});
	});


	var stepQuantity = 1;

	$(document).on('click', '.plus', function() {
		var lastQuantity = $(this).closest('.panel-body').find('.quantity-product').val();
		var newQuantity = parseInt(lastQuantity) + parseInt(stepQuantity);
		$(this).closest('.panel-body').find('.quantity-product').val(newQuantity);

		var lastCommonPrice = $('.common-price').text();
		var productPrice = $(this).closest('.panel-body').find('.product-price').text();
		var newCommonPrice = parseInt(lastCommonPrice) + parseInt(productPrice);
		$(this).closest('.panel-info').find('.common-price').text(newCommonPrice);
	});

	$(document).on('click', '.minus', function() {
		var lastQuantity = $(this).closest('.panel-body').find('.quantity-product').val();
		var lastCommonPrice = $('.common-price').text();

		if (lastQuantity > 1 && lastCommonPrice > 0) {		
			var newQuantity = parseInt(lastQuantity) - parseInt(stepQuantity);;
			$(this).closest('.panel-body').find('.quantity-product').val(newQuantity);

			var productPrice = $(this).closest('.panel-body').find('.product-price').text();
			var newCommonPrice = parseInt(lastCommonPrice) - parseInt(productPrice);
			$(this).closest('.panel-info').find('.common-price').text(newCommonPrice);
		}
	});
});