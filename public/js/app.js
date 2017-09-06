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
		console.log(action);
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
		console.log(product_id);
		// var test = $('meta[name="csrf-token"]').attr('content');
		// console.log(test);
		// $('.order').find('.panel-body').eq(0).remove();
		// var panel = $('.order').find('.panel-body');
		// if (panel.length == 0) {
		// 	$('.order').remove();
		// }

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
	
});