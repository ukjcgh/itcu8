function grid_edit_action(code) {
	$.ajax({
		type : "POST",
		url : '/ace/?action=edit',
		'data' : {
			'code' : code
		}
	}).done(function(msg) {
		popup.show(msg);

		var data = {};
		$('.form-save-button').bind('click', function() {
			$('.form *[name]').each(function(i, el) {
				data[el.name] = el.value;
			});
			grid_save_action(data);
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