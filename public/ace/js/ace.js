ace = {
	action : function(action, data) {
		$.ajax({
			type : "POST",
			url : '/ace/?action=' + action,
			'data' : data
		}).done(function(msg) {
			popup.show(msg);
		}).fail(function(e) {
			msg = "Error during request";
			if (e.status)
				msg += ': ' + e.status + ' ' + e.statusText;
			alert(msg);
		});
	}
}