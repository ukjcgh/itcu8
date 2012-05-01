ace = {};

ace.request = function(action, data) {

	var errorMsg = 'Error during ace.request(). ';

	this.actionIsLoaded = function(action) {
		ace.handlers = (ace.handlers == null) ? {} : ace.handlers;
		// 0, 1 to keep bool sense even if string
		return ace.handlers[action] == null ? 0 : 1;
	};

	this.done = function(resp) {
		if (resp == null) {
			console.error(errorMsg + 'Empty response.');
			return;
		}
		if (resp.data == null) {
			console.error(errorMsg + 'Server returned no data.');
			return;
		}
		if (resp.handler) {
			try {
				ace.handlers[action] = eval(resp.handler);
			} catch (e) {
				console.error(errorMsg + 'Can\'t parse action "' + action
						+ '":\n' + e);
				return;
			}
		}
		if (typeof ace.handlers[action] == 'function') {
			try {
				ace.handlers[action](resp.data);
			} catch (e) {
				console.error(errorMsg + 'Error in action "' + action + '"\n'
						+ e);
			}
		} else {
			console.error(errorMsg + 'Function ace.handlers["' + action
					+ '"] not found.');
		}
	};

	this.fail = function(xhr, jError, jsError) {
		msg = errorMsg;
		if (jError == 'parsererror') {
			msg += 'The server has sent invalid JSON. See response below:\n'
					+ xhr.responseText;
			console.error(msg);
		} else {
			msg += '\n      HTTP: ' + xhr.status + ' ' + xhr.statusText
					+ '\n      jQuery: ' + jError + '\n      JS: ' + jsError;
			console.error(msg);
		}
	};

	var params = {
		'type' : "POST",
		'dataType' : 'json', // force json, write separate request function
								// to change this option
		'url' : '/ace/?action=' + encodeURIComponent(action),
		'data' : {
			'actionIsLoaded' : this.actionIsLoaded(action),
			'data' : data
		}
	};

	// REQUEST

	$.ajax(params).done(this.done).fail(this.fail);

};