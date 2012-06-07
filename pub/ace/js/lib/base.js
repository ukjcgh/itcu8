// standard $ selector returns element by id, first element from css selector is more convenient
function $(selectors, context) {
	return $$(selectors, context)[0];
}

function $$(selectors, context) {
	context = context == null ? document : context;
	return context.querySelectorAll(selectors);
}

Element.prototype.$ = function(selectors) {
	return window.$(selectors, this);
}

Element.prototype.$$ = function(selectors) {
	return window.$$(selectors, this);
}

Element.prototype.findParent = function(nodeName) {
	if (this.parentNode.nodeName.toLowerCase() == nodeName.toLowerCase()) {
		return this.parentNode;
	} else {
		if (this.parentNode.findParent) {
			return this.parentNode.findParent(nodeName);
		} else {
			return null;
		}
	}
}

function newElement(name) {
	return document.createElement(name);
}

// always return string
function getClass(object) {

	if (object === null) {
		return 'null';
	}
	if (typeof (object) == 'undefined') {
		return 'undefined';
	}

	var info = object.constructor.toString();
	var rx = new RegExp(' (.*?)\\(');
	var ms = rx.exec(info);
	if (ms !== null) {
		return ms[1];
	}

	// firefox
	switch (info) {
	case '[object XMLDocument]':
		return 'Document';
	case '[object Element]':
		return 'Element';
	}

	return 'unknown';

}

function template(xslFile, xml) {

	var xhr = new XMLHttpRequest();
	xhr.open('GET', '/ace/xsl/' + xslFile + '.xsl', false);
	xhr.send();
	xsl = xhr.responseXML;

	var proc = new XSLTProcessor();
	proc.importStylesheet(xsl);

	if (xml == null) {
		xml = (new DOMParser()).parseFromString('<data/>', "text/xml");
	}

	var docFrag = proc.transformToFragment(xml, document);

	if (typeof docFrag != 'undefined') {
		// use div.innerHTML to avoid xmlns attributes in firefox
		var div = newElement('div');
		div.appendChild(docFrag);
		return div.innerHTML;
	} else {
		throwError('transformToFragment failed, check your template "' + xslFile + '" and passed XML');
	}

}

Object.prototype.isEmpty = function() {
	for ( var key in this) {
		// own properties always on top in Chrome and Firefox so it is enough to check first one
		return !this.hasOwnProperty(key);
	}
	return true;
};

function terminate(isUserError) {
	throw 'script termination' + (isUserError ? ' due to user error' : '');
}

function throwError(message) {
	// console.error adds trace in Chrome even in console
	console.error('Error: ' + message);
	terminate();
}

initFuncs = [];
setTimeout(wait = function() {
	if (document.readyState === "complete") {
		if (!checkua()) {
			return;
		}
		if (window.initFuncs) {
			for ( var i = 0; i < initFuncs.length; i++) {
				initFuncs[i]();
			}
		}
	} else {
		setTimeout(wait, 0);
	}
}, 0);