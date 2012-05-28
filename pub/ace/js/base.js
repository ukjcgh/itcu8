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

	// fetch html
	var tmpdiv = newel('div');
	tmpdiv.appendChild(docFrag);
	var html = tmpdiv.innerHTML;

	return html;
}

initFuncs = [];
setTimeout(wait = function() {
	if (document.readyState === "complete") {
		if (!checkua()) {
			return;
		}
		if (window.initFuncs) {
			for ( var i in initFuncs) {
				initFuncs[i]();
			}
		}
	} else {
		setTimeout(wait, 0);
	}
}, 0);