server = {};

server.get = function(action, params) {
	server.indicator.show();
	var request = $.ajax({
		'async' : false,
		'type' : "POST",
		'dataType' : 'json', // force json, write separate function to change this option
		'url' : '/ace/?action=' + encodeURIComponent(action),
		'data' : params
	});
	server.indicator.hide();
	response = server.validateResponse(request, action);
	return response.data;
}

server.validateResponse = function(request, action) {
	var msg = 'Error: server.get("' + action + '") failded. ';
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
			$('body').append('<div class="server-indicator">waiting for a response from the server</div>');
		}
		$('.server-indicator').show();
	},
	'hide' : function() {
		$('.server-indicator').hide();
	}
}
