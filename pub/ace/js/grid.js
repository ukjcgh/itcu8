function grid_edit_action(code) {
	var form = server.request('grid/updateForm', [ code ]).form;
	popup.show(form);
	grid_init_form(grid_save_action);
}

function grid_save_action(data) {
	server.request('grid/update', data);
	document.location.reload();
}

function grid_delete_action(code) {
	if (confirm('Are you sure you need to delete "' + code + '" website?')) {
		server.request('grid/delete', [ code ]);
		document.location.reload();
	}
}

function grid_add_action() {
	var form = server.request('grid/insertForm').form;
	popup.show(form);
	grid_init_form(grid_addsave_action);
}

function grid_addsave_action(data) {
	server.request('grid/insert', data);
	document.location.reload();
}

function grid_init_form(submitFunc) {

	if (first = el('.popup *[name]')) {
		first.focus();
	}

	var submit = function() {
		var data = {};
		var fields = els('.form *[name]');
		for ( var i in fields) {
			data[fields[i].name] = fields[i].value;
		}
		submitFunc(data);
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
