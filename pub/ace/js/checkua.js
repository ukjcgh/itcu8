browser = false;

if (window.chrome) {
	browser = 'chrome';
} else {
	if (!window.opera && navigator.userAgent.indexOf('Firefox') >= 0) {
		browser = 'firefox';
	}
}

if (!browser) {
	w = function(html) {
		document.write(html);
	}

	knownInvalid = window.opera ? 'Opera' : (navigator.userAgent.indexOf('MSIE') >= 0 ? 'Internet Explorer' : false);

	w('<div style="position: fixed; left: 0; top: 0; width: 100%; height: 100%; background-color: #fff; padding: 5px;">');

	proposition = 'Use Chrome or Firefox instead.';
	if (knownInvalid) {
		w(knownInvalid + '? It is thankless job to make me working with this browser so I don\'t support it. ' + proposition);
	} else {
		w('Don\'t know this browser and how to work with it. ' + proposition);
	}

	w('</div>');
}