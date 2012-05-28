initFuncs.push(function() {

	// show websites grid

	configXml = server.requestXml('model/config');
	dataXml = server.requestXml('model/data');

	xml = createDocument('data');
	with (xml.firstChild) {
		appendChild(configXml.querySelector('grid'));
		appendChild(dataXml.firstChild);
	}

	html = template('grid', xml);
	document.body.innerHTML = html;

	grid_init();

});