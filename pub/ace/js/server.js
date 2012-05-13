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

server.request = function(action, data) {
	var xhr = new XMLHttpRequest();
	xhr.open("POST", '/ace/?action=' + encodeURIComponent(action), true);
	xhr.setRequestHeader('XMLHttpRequest', 'async');
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4) {
			if (xhr.status == 200) {
				// self.done(action)(xhr);
			} else {
				console.error('xhr fail');
			}
		}
	}
	var request = {
		'isActionLoaded' : helper.isActionLoaded(action),
		'data' : data
	};
	xhr.send('request=' + encodeURIComponent(JSON.stringify(request)));
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
