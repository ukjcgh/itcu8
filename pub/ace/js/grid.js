function grid_edit_action(code) {
	alert(code);
	// ace.request('edit', code);
}

function grid_save_action(data) {
	ace.request('save', data);
}

function grid_delete_action(code) {
	if (confirm('Are you sure you need to delete "' + code + '" website?')) {
		server.request('delete', code);
	}
}

function grid_add_action() {
	var data = server.request('add');

	popup.show(data.form);

	if (first = el('.popup *[name]')) {
		first.focus();
	}

	var submit = function() {
		var data = {};
		var fields = els('.form *[name]');
		for ( var i in fields) {
			data[fields[i].name] = fields[i].value;
		}
		grid_addsave_action(data);
	};

	var textFields = els('.popup input[type="text"]');
	for ( var i in textFields) {
		textFields[i].onkeypress = function(e) {
			if (e.keyCode == 13) {
				submit();
			}
		}
	}

	el('.form-save-button').onclick = function() {
		submit();
	};
}

function grid_addsave_action(data) {
	server.request('addsave', data);
	document.location.reload();
}

initFuncs.push(function() {

	var initLinks = function(selector, func) {
		var links = els(selector);
		for ( var i in links) {
			links[i].onclick = (function(links, i) {
				return function() {
					func(links[i].getAttribute('code'));
					return false;
				}
			})(links, i);
			links[i].href = '#';
		}
	}

	initLinks('.edit-link', grid_edit_action);
	initLinks('.delete-link', grid_delete_action);
	initLinks('.add-link', grid_add_action);

});
