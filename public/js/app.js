$(document).ready(function() {
	var _token = $('input[name="_token"]').val();

	function customizeForm(form, action, method, color, text) {
		form.attr('action', action);
		form.find('input[name="_method"]').val(method);
		form.find('.ajax-button').css('background-color', color).text(text);
		
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
						'#34313a', 
						'Delete from cart'
					);

					$('#count-product').text(response['count']);
				} else if (response['status'] == 'deleted') {
					customizeForm(
						form, 
						'/product/add-to-cart', 
						'POST', 
						'#0f7ae5',
						'Add to cart'
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
					$('.uk-container').find('.uk-alert-success').css('display', 'block');

					setTimeout(function() { 
						var	url = 'http://' + window.location.host;
						window.location.href = url;
					}, 3000);
				} else {
					$('.uk-container').find('.uk-alert-danger').css('display', 'block');
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
		var productId = $(this).closest('.uk-card-body').find('.product-id').val();
		var element = ".item-" + productId;

		$.ajax({
			url: action,
			type: method,
			data: {
				product_id: productId
			},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},

			success: function(data) {
				var response = $.parseJSON(data);
				
				if (response['status'] == 'deleted') {
					$('.order').find(element).remove();
					// $('.order').find('.item').eq(0).remove();

					var panel = $('.order').find('.uk-card-body');
					if (panel.length == 0) {
						$('.uk-container').remove();
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
		var lastQuantity = $(this).closest('.uk-card-body').find('.quantity-product').val();
		var newQuantity = parseInt(lastQuantity) + parseInt(stepQuantity);
		$(this).closest('.uk-card-body').find('.quantity-product').val(newQuantity);

		var lastCommonPrice = $('.common-price').text();
		var productPrice = $(this).closest('.uk-card-body').find('.product-price').text();
		var newCommonPrice = parseFloat(lastCommonPrice) + parseFloat(productPrice);
		$(this).closest('.uk-container').find('.common-price').text(newCommonPrice);
	});

	$(document).on('click', '.minus', function() {
		var lastQuantity = $(this).closest('.uk-card-body').find('.quantity-product').val();
		var lastCommonPrice = $('.common-price').text();

		if (lastQuantity > 1 && lastCommonPrice > 0) {		
			var newQuantity = parseInt(lastQuantity) - parseInt(stepQuantity);;
			$(this).closest('.uk-card-body').find('.quantity-product').val(newQuantity);

			var productPrice = $(this).closest('.uk-card-body').find('.product-price').text();
			var newCommonPrice = parseFloat(lastCommonPrice) - parseFloat(productPrice);
			$(this).closest('.uk-container').find('.common-price').text(newCommonPrice);
		}
	});
});