(function(box) {

	popup.show(box.html);

	$('.popup *[name]:first').focus();

	var submit_func = function() {
		var data = {};
		$('.form *[name]').each(function(i, el) {
			data[el.name] = el.value;
		});

		$('.form-save-button').html('saving..');

		grid_addsave_action(data);
	};

	$('.popup input[type="text"]').each(function(i, el) {
		$(el).bind('keypress', function(e) {
			if (e.keyCode == 13) {
				submit_func();
			}
		});
	});

	$('.form-save-button').bind('click', function() {
		submit_func();
	});

});