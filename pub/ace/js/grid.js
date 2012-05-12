function grid_edit_action(code) {
	ace.request('edit', code);
}

function grid_save_action(data) {
	ace.request('save', data);
}

function grid_delete_action(code) {
	if (confirm('Are you sure you need to delete "' + code + '" website?')) {
		ace.request('delete', code);
	}
}

function grid_add_action() {
	var data = server.get('add');
	
	popup.show(data.form);

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
