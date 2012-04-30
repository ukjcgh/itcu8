ace = {
	'request' : function(action, data) {

		this.actionIsLoaded = function(action) {
			ace.actions = (ace.actions == null) ? {} : ace.actions;
			return ace.actions[action] == null;
		};

		this.done = function(resp) {
			if (resp == null) {
				console.error('Error during ace.request(). Empty response.');
			}
			console.log(resp);
		};

		this.fail = function(xhr, jError, jsError) {
			msg = "Error during ace.request().";
			if (jError == 'parsererror') {
				msg += ' The server has sent invalid JSON. See response below:\n'
						+ xhr.responseText;
				console.error(msg);
			} else {
				msg += '\n      HTTP: ' + xhr.status + ' ' + xhr.statusText
						+ '\n      jQuery: ' + jError + '\n      JS: '
						+ jsError;
				console.error(msg);
			}
		};

		var params = {
			'type' : "POST",
			'dataType' : 'json', ????// force json
			'url' : '/ace/?action=' + encodeURIComponent(action),
			'data' : {
				'actionIsLoaded' : this.actionIsLoaded(action),
				'data' : data
			}
		};

		// REQUEST

		$.ajax(params).done(this.done).fail(this.fail);

	}
};