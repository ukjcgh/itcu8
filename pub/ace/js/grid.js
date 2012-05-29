function grid_edit_action(code) {
	var form = server.request('model/forms/update', [ code ]).form;
	popup.show(form);
	grid_init_form(grid_save_action);
}

function grid_save_action(data) {
	server.request('model/update', data);
	document.location.reload();
}

function grid_delete_action(code) {
	if (confirm('Are you sure you need to delete "' + code + '" website?')) {
		server.request('model/delete', [ code ]);
		document.location.reload();
	}
}

function grid_add_action() {
	// var form = server.request('model/forms/insert').form;
	// var xml = (new DOMParser()).parseFromString('<data/>', "text/xml");
	var xml = createDocument('data');
	var cfg = newel('config');
	xml.firstChild.appendChild(xml.importNode(cfg));
	// console.log(xml); return;
	var childs = configXml.querySelector('forms add').childNodes;
	// import node?
	for ( var i = 0; i < childs.length; i++) {
		cfg.appendChild(childs.item(i).cloneNode(true));
	}
	xml1 = xml;
	console.log(xml1);

	var xhr = new XMLHttpRequest();
	xhr.open('GET', '/ace/test.xml', false);
	xhr.send();
	xml = xhr.responseXML;
	xml2 = xml;
	console.log(xml2);

	xml3 = (new DOMParser()).parseFromString("<data>	<config>		<title>Add Website</title>		<fields>			<code></code>			<domain></domain>			<path></path>		</fields>	</config></data>", "text/xml");
	console.log(xml3);
	xml3.firstChild.appendChild(newel('asdf'));
	
	xml4 = createDocument('data');
	xml4.firstChild.appendChild(xml4.createElement('config'));
	title = xml4.createElement('title');
	title.textContent = 'asdfasdf';
	xml4.firstChild.firstChild.appendChild(title);
	console.log(xml4);
	var form = template('grid/form', xml4);
	popup.show(form);
	grid_init_form(grid_addsave_action);
}

function grid_addsave_action(data) {
	server.request('model/insert', data);
	document.location.reload();
}

function grid_show() {
	configXml = server.requestXml('model/config');
	dataXml = server.requestXml('model/data');

	xml = createDocument('data');
	with (xml.firstChild) {
		appendChild(configXml.querySelector('grid'));
		appendChild(dataXml.firstChild);
	}

	html = template('grid', xml);
	document.body.innerHTML = html;

	grid_init();
}

grid_init = function() {
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