server = {};

server.request = function(action, data) {
	server.indicator.show();
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '/ace/?action=' + encodeURIComponent(action), false);
	xhr.setRequestHeader('Ajax-type', 'sync');
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	var request = {};
	request.data = data;
	xhr.send('request=' + encodeURIComponent(JSON.stringify(request)));
	var response = JSON.parse(xhr.responseText);
	response = server.validateResponse(response, action);
	server.indicator.hide();
	return response.data;
}

server.validateResponse = function(request, action) {
	var msg = 'Error: server.get("' + action + '") failed. ';
	if (request.status != 200) {
		throw msg + '\n      HTTP: ' + request.status + ' ' + request.statusText;
	}
	try {
		response = JSON.parse(request.responseText);
	} catch (e) {
		throw msg + 'The server has sent invalid JSON. See response below:\n' + request.responseText;
	}
	if (response.error) {
		throw msg + 'Server has sent error: ' + response.error;
	}
	return response;
}

server.indicator = {
	'show' : function() {
		if (!$('.server-indicator').length) {
			$('body').append('<div class="server-indicator">Loading..</div>');
		}
		$('.server-indicator').show();
	},
	'hide' : function() {
		$('.server-indicator').hide();
	}
}
