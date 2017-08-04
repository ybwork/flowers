$(document).ready(function() {

	var _token = $('input[name="_token"]').val();

	// var count = localStorage.getItem('count');
	// if (count) {	
	// 	$('#count-product').text(localStorage.getItem('count'));
	// 	console.log(count);
	// }
	
	// 	var form = $(this);

	// form.attr('action', localStorage.getItem('action'));
	// form.find('input[type="_method"]').val(localStorage.getItem('method'));
	// form.find('#ajax-button')
	// 	.css('background', localStorage.getItem('color'))
	// 	.text(localStorage.getItem('text'));

	// localStorage.removeItem('count');
	// localStorage.removeItem('action');
	// localStorage.removeItem('method');
	// localStorage.removeItem('color');
	// localStorage.removeItem('text');

	function customizeForm(form, action, method, color, text) {
		form.attr('action', action);
		form.find('input[name="_method"]').val(method);
		form.find('#ajax-button').css('background', color).text(text);

		// localStorage.setItem('action', action);
		// localStorage.setItem('method', method);
		// localStorage.setItem('color', color);
		// localStorage.setItem('text', text);
		
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
				// console.log(response['status']);
				if (response['status'] == 'added') {
					customizeForm(
						form, 
						'/product/delete-from-cart', 
						'DELETE', 
						'red', 
						'Отказаться'
					);
					// localStorage.setItem('count', response['count']);
					// $('#count-product').text(localStorage.getItem('count'));
					$('#count-product').text(response['count']);
				} else if (response['status'] == 'deleted') {
					customizeForm(
						form, 
						'/product/add-to-cart', 
						'POST', 
						'green', 
						'Заказать'
					);
					// localStorage.removeItem('count');
					// $('#count-product').text(localStorage.getItem('count'));
					$('#count-product').text(response['count']);
				}

			},

			error: function(e) {

			},
		});
	});

	$(document).on('submit', '#deleteItem', function(e) {
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
					// form.remove('#delete-item');
					$('#cartItem').remove();
					// localStorage.removeItem('count');
					// localStorage.removeItem('action');
					// localStorage.removeItem('method');
					// localStorage.removeItem('color');
					// localStorage.removeItem('text');
				}

				$('#count-product').text(response['count']);
			},

			error: function(e) {

			},
		});
	});

	$(document).on('submit', '#order', function(e) {
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
});