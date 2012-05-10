server = {};

server.get = function(action, params) {
	var result = $.ajax({
		'async' : false,
		'type' : "POST",
		'dataType' : 'json', // force json, write separate function to change this option
		'url' : '/ace/?action=' + encodeURIComponent(action),
		'data' : params
	});
	result = JSON.parse(result.responseText);
	return result.data;
}
