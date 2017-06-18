$(document).ready(function() {

	var _token = $('input[name="_token"]').val();

	function customizeForm(form, action, method, color, text) {
		form.attr('action', action);
		form.find('input[name="_method"]').val(method);
		form.find('#ajax-button').css('background', color).text(text);

		return true;
	}

	$(document).on('submit', '#ajax-form', function(e) {
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
						'Delete from cart'
					);
					$('#count-product').text(response['count']);
				} else if (response['status'] == 'deleted') {
					customizeForm(
						form, 
						'/product/add-to-cart', 
						'POST', 
						'green', 
						'Add to cart'
					);
					$('#count-product').text(response['count']);
				}

			},

			error: function(e) {

			},
		});
	});

	$(document).on('submit', '#delete-item', function(e) {
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
				
				if (response['status'] == 'deleted') {
					form.remove('#delete-item');
				}

				$('#count-product').text(response['count']);
			},

			error: function(e) {

			},
		});
	});
});