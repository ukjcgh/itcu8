ace = {
	action : function(action, param) {
		$.ajax({
			type : "POST",
			url : '/ace/' + action,
			data : {
				name : "John",
				location : "Boston"
			}
		}).done(function(msg) {
			alert("Data Saved: " + msg);
		}).fail(function(e) {
			msg = "Error during ajax request";
			if(e.status) msg += ': ' + e.status + ' ' + e.statusText;
			alert(msg);
		});
	}
}