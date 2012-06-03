function els(selectors) {
	var list = document.querySelectorAll(selectors);

	// convert list to regular array
	var els = [];
	for ( var i = 0; i < list.length; i++) {
		els.push(list.item(i));
	}

	return els;
}

function el(selector) {
	return document.querySelector(selector);
}

function newel(tag) {
	return document.createElement(tag);
}

function createDocument(rootNode) {
	return document.implementation.createDocument(null, rootNode, null);
}

function getClass(object) {
	return object === null ? null : (new RegExp(' (.*?)\\(')).exec(object.constructor.toString())[1];
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
		var tmpdiv = newel('div');
		tmpdiv.appendChild(docFrag);
		return tmpdiv.innerHTML;
	} else {
		return '';
	}

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