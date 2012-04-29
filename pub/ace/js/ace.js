ace = {
	'request' : function(action, data) {
		$.ajax({
			type : "POST",
			url : '/ace/?action=' + encodeURIComponent(action),
			'data' : data
		}).done(function(resp) {
			console.log(resp);
		}).fail(
				function(xhr, jError, jsError) {
					msg = "Error during request";
					msg += '\n      Status: ' + xhr.status + ' '
							+ xhr.statusText + '\n      jQuery: ' + jError
							+ '\n      JS: ' + jsError;
					alert(msg + '\n');
				});
	}
};