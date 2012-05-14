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

	w('<div id="invalid-browser" style="position: fixed; left: 0; top: 0; width: 100%; height: 100%; background-color: #fff; padding: 10px;">');

	proposition = 'Use <a href="https://www.google.com/chrome"><b>Chrome</b></a> or <a href="http://firefox.com"><b>Firefox</b></a> instead.';
	if (knownInvalid) {
		w(knownInvalid + '? In order to keep code cleaner we don\'t support this browser. ' + proposition);
	} else {
		w('Don\'t know this browser and how to work with it. ' + proposition);
	}

	w(' Functionality is not adapted for your browser and have never been tested.')

	w('</div>');

}