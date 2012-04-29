ace = {
	'request' : function(action, data) {

		var reqData = {};

		// check for action on client
		if (window[action] == null) {
			reqData.actionIsNotLoaded = 1;
		} else {
			if (typeof (window[action]) != 'function') {
				console.error('No place to load action, window.' + action
						+ ' must be null. Use other name for this action');
				return;
			}
		}

		reqData.data = data;

		$.ajax({
			type : "POST",
			url : '/ace/?action=' + encodeURIComponent(action),
			'data' : reqData
		}).done(function(resp) {
			//TODO: eval attached action, run
			console.log(resp);
		}).fail(
				function(xhr, jError, jsError) {
					msg = "Error during request";
					msg += '\n      Status: ' + xhr.status + ' '
							+ xhr.statusText + '\n      jQuery: ' + jError
							+ '\n      JS: ' + jsError;
					console.error(msg);
				});
	}
};