function grid_edit_action(code) {
	$.ajax({
		type : "POST",
		url : '/ace/?action=edit',
		'data' : {
			'code' : code
		}
	}).done(function(msg) {
		popup.show(msg);
		$('.popup *[name]:first').focus();

		var submit_func = function() {
			var data = {};
			$('.form *[name]').each(function(i, el) {
				data[el.name] = el.value;
			});

			$('.form-save-button').html('saving..');

			grid_save_action(data);
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

	}).fail(function(e) {
		msg = "Error during request";
		if (e.status)
			msg += ': ' + e.status + ' ' + e.statusText;
		alert(msg);
	});
	return false;
}

function grid_save_action(data) {
	$.ajax({
		type : "POST",
		url : '/ace/?action=save',
		'data' : data
	}).done(function(msg) {

		document.location.reload();

	}).fail(function(e) {
		msg = "Error during request";
		if (e.status)
			msg += ': ' + e.status + ' ' + e.statusText;
		alert(msg);
	});
}