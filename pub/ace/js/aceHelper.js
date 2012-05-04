aceHelper = {};

aceHelper.request = {
	'errorMsg' : 'Error during ace.request().',
	'handlers' : {},

	'actionIsLoaded' : function(action) {
		return aceHelper.request.handlers[action] != null;
	},

	'runupResponse' : function(response, action) {
		var helper = aceHelper.request;

		if (response == null) {
			console.error(helper.errorMsg + ' Empty response.');
			return;
		}
		if (response.handler) {
			try {
				if (typeof eval(response.handler) != 'function') {
					console.error(helper.errorMsg + ' Function not found in ' + action + '.js');
					return;
				}
			} catch (e) {
				console.error(helper.errorMsg + ' Can\'t parse action "' + action + '.js":\n' + e);
				return;
			}
		}
		if (response.error) {
			console.error(helper.errorMsg + ' ' + response.error);
			return;
		}

		return true;
	},

	'fail' : fail = function(xhr, jError, jsError) {
		var helper = aceHelper.request;

		var msg = helper.errorMsg;
		if (jError == 'parsererror') {
			msg += ' The server has sent invalid JSON. See response below:\n' + xhr.responseText;
			console.error(msg);
		} else {
			msg += '\n      HTTP: ' + xhr.status + ' ' + xhr.statusText + '\n      jQuery: ' + jError + '\n      JS: ' + jsError;
			console.error(msg);
		}
	}
};