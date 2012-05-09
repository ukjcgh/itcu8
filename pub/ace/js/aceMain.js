aceMain = {};

aceMain.request = {

	'run' : function(action, data) {
		var self = aceMain.request;
		var helper = aceHelper.request;

		$.ajax(self.getParams(action, data)).done(self.done(action)).fail(helper.fail);

	},

	'done' : function(action) {
		return function(response) {
			var helper = aceHelper.request;

			if (helper.runupResponse(response, action)) {
				if (response.handler) {
					helper.handlers[action] = eval(response.handler);
				} else {
					if (helper.handlers[action] == null) {
						console.error(helper.errorMsg + ' Handler for action "' + action + '" is not defined.');
						return;
					}
				}
				try {
					// TODO: eval function so that lineNumber is defined in exception if error
					helper.handlers[action](response.box);
				} catch (e) {
					console.error(helper.errorMsg + ' Error in action "' + action + '.js":' + '\n' + e);
				}
			}
		};
	},

	'getParams' : function(action, data) {
		var helper = aceHelper.request;

		var post = {
			// send json as string to keep types so you will have bool instead of string 'false'
			'request' : JSON.stringify({
				'isActionLoaded' : helper.isActionLoaded(action),
				'box' : data
			})
		};

		return {
			'type' : "POST",
			'dataType' : 'json', // force json, write separate request function to change this option
			'url' : '/ace/?action=' + encodeURIComponent(action),
			'data' : post
		};
	}
};