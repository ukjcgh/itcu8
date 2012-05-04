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

function grid_delete_action(code) {
	if (confirm('Are you sure you want to delete "' + code + '" website?')) {
		ace.request('delete', {
			'code' : code
		});
	}
}

function grid_add_action() {
	ace.request('add');
}

function grid_addsave_action(data) {
	ace.request('addsave', data);
}

$(document).ready(function() {
	$('.edit-link').each(function(i, el) {
		$(el).bind('click', function() {
			grid_edit_action($(el).attr('code'));
			return false;
		});
		$(el).attr('href', '#');
	});
	$('.delete-link').each(function(i, el) {
		$(el).bind('click', function() {
			grid_delete_action($(el).attr('code'));
			return false;
		});
		$(el).attr('href', '#');
	});
	$('.add-link').each(function(i, el) {
		$(el).bind('click', function() {
			grid_add_action($(el).attr('code'));
			return false;
		});
		$(el).attr('href', '#');
	});
});
