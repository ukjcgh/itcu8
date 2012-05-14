initFuncs = [];
setTimeout(wait = function() {
	if (document.readyState === "complete") {
		if (window.initFuncs) {
			for ( var i in initFuncs) {
				initFuncs[i]();
			}
		}
	} else {
		setTimeout(wait, 0);
	}
}, 0);

function els(selectors) {
	var list = document.querySelectorAll(selectors);
	var els = [];
	for ( var i = 0; i < list.length; i++) {
		els.push(list.item(i));
	}
	return els;
}

function el(selector) {
	var list = els(selector);
	if (list.length) {
		return list[0];
	}
	return null;
}

function newel(tag){
	return document.createElement(tag);
}