server = {};

server.request = function(action, data) {

	if (typeof data == 'undefined') {
		data = {};
	} else {
		if (typeof data != 'object') {
			throw 'Can\'t send scalar value as data';
		}
	}

	server.indicator.show();

	// init request
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '/ace/?action=' + encodeURIComponent(action), false);
	xhr.setRequestHeader('Ajax-type', 'sync');
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

	// send request
	var request = {};
	request.data = data;
	xhr.send('request=' + encodeURIComponent(JSON.stringify(request)));

	server.indicator.hide();

	// fetch response
	var response = server.validateResponse(xhr, action);

	return response.data;
}

server.requestXml = function(action, data) {
	var response = server.request(action, data);
	if (response.xml) {
		// parse using DOMParser coz error handling is better
		var parser = new DOMParser();
		return parser.parseFromString(response.xml, "text/xml");
	} else {
		throw 'Error: XML not found in response of "' + action + '"';
	}
}

server.validateResponse = function(request, action) {
	var msg = 'Error: server.request("' + action + '") failed. ';

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

	if (response['user-error']) {
		alert(response['user-error']);
		// just interrupt
		throw msg + 'This exception thrown out only to stop further execution of the script in case of user error: '
				+ response['user-error'];
	}

	return response;
}

server.indicator = {

	'show' : function() {
		if (!el('.server-indicator')) {
			var indicatorDiv = newel('div');
			indicatorDiv.className = 'server-indicator';
			indicatorDiv.innerHTML = 'Processing..';
			el('body').appendChild(indicatorDiv);
		}
		el('.server-indicator').style.display = 'block';
	},

	'hide' : function() {
		el('.server-indicator').style.display = 'none';
	}

}