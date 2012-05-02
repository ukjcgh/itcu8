ace = {};

ace.request = function(action, data) {

	var errorMsg = 'Error during ace.request().';

	this.actionIsLoaded = function(action) {
		ace.handlers = (ace.handlers == null) ? {} : ace.handlers;
		return ace.handlers[action] != null;
	};

	this.done = function(resp) {
		if (resp == null) {
			console.error(errorMsg + ' Empty response.');
			return;
		}
		if (resp.data == null) {
			console.error(errorMsg + ' Server returned no data.');
			return;
		}
		if (resp.handler) {
			try {
				ace.handlers[action] = eval(resp.handler);
			} catch (e) {
				console.error(errorMsg + ' Can\'t parse action "' + action + '":\n' + e);
				return;
			}
		}
		if (typeof ace.handlers[action] == 'function') {
			try {
				// TODO: eval so that lineNumber is defined in exception if error
				ace.handlers[action](resp.data);
			} catch (e) {
				console.error(errorMsg + ' Error in action "' + action + '.js":' + '\n' + e);
			}
		} else {
			console.error(errorMsg + ' Function ace.handlers["' + action + '"] not found.');
		}
	};

	this.fail = function(xhr, jError, jsError) {
		var msg = errorMsg;
		if (jError == 'parsererror') {
			msg += ' The server has sent invalid JSON. See response below:\n' + xhr.responseText;
			console.error(msg);
		} else {
			msg += '\n      HTTP: ' + xhr.status + ' ' + xhr.statusText + '\n      jQuery: ' + jError + '\n      JS: ' + jsError;
			console.error(msg);
		}
	};

	var params = {
		'type' : "POST",
		'dataType' : 'json', // force json, write separate request function to change this option
		'url' : '/ace/?action=' + encodeURIComponent(action),
		'data' : {
			// send json as string to keep types so you will have bool instead of string 'false'
			'requestData' : JSON.stringify({
				'actionIsLoaded' : this.actionIsLoaded(action),
				'data' : data
			})
		}
	};

	// REQUEST

	$.ajax(params).done(this.done).fail(this.fail);

};