function grid_edit_action(code) {
	var item = false;
	for ( var i = 0; i < data.item.length; i++) {
		if (data.item[i]['code'] == code) {
			item = data.item[i];
		}
	}
	var xml = ({
		'config' : config.forms.edit,
		'item' : item
	}).toXmlDocument('data');
	var form = template('grid/form', xml);
	popup.show(form);
	grid_init_form(grid_save_action, code);
}

function grid_save_action(data) {
	server.request('model/update', data);
	grid_show();
}

function grid_delete_action(code) {
	if (confirm('Are you sure you need to delete "' + code + '" website?')) {
		server.request('model/delete', [ code ]);
		grid_show();
	}
}

function grid_add_action() {
	var xml = ({
		'config' : config.forms.add
	}).toXmlDocument('data');
	var form = template('grid/form', xml);
	popup.show(form);
	grid_init_form(grid_addsave_action);
}

function grid_addsave_action(data) {
	server.request('model/insert', data);
	grid_show();
}

function grid_show() {

	config = server.requestXml('model/config').toObject();
	data = server.requestXml('model/data').toObject();

	var xml = {
		'grid' : config.grid,
		'items' : data
	}.toXmlDocument('data');

	var html = template('grid', xml);
	document.body.innerHTML = html;

	grid_init();

}

grid_init = function() {

	var initLinks = function(selector, func) {
		var links = $$(selector);
		for ( var i = 0; i < links.length; i++) {
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

	if ($('.add-link'))
		with ($('.add-link')) {
			onclick = function() {
				grid_add_action();
				return false;
			};
			href = '#';
		}

}

function grid_init_form(submitFunc, code) {

	if (first = $('.popup *[name]')) {
		first.focus();
	}

	var submit = function() {
		var data = {};
		var fields = $$('.form *[name]');
		for ( var i = 0; i < fields.length; i++) {
			data[fields[i].name] = fields[i].value;
		}

		// if edit
		if (typeof code !== 'undefined') {
			data = {
				'code' : code,
				'data' : data
			};
		}
		submitFunc(data);
	};

	var textFields = $$('.popup input[type="text"]');
	for ( var i = 0; i < textFields.length; i++) {
		textFields[i].onkeypress = function(e) {
			if (e.keyCode == 13) {
				submit();
			}
		}
	}

	$('.form-save-button').onclick = function() {
		submit();
	};
}