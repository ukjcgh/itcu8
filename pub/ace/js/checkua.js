function checkua() {

	var browser = false;

	if (window.chrome) {
		browser = 'chrome';
	} else {
		if (!window.opera && navigator.userAgent.indexOf('Firefox') >= 0) {
			browser = 'firefox';
		}
	}

	if (!browser) {

		var knownInvalid = window.opera ? 'Opera' : (navigator.userAgent.indexOf('MSIE') >= 0 ? 'Internet Explorer' : false);

		var message = '<div id="invalid-browser" style="position: fixed; left: 0; top: 0; width: 100%; height: 100%; background-color: #fff; padding: 10px;">';
		var proposition = 'Use <a href="https://www.google.com/chrome"><b>Chrome</b></a> or <a href="http://firefox.com"><b>Firefox</b></a> instead.';

		if (knownInvalid) {
			message += knownInvalid + '? In order to keep code cleaner we don\'t support this browser. ' + proposition;
		} else {
			message += 'Don\'t know this browser and how to work with it. ' + proposition;
		}

		message += ' Functionality is not adapted for your browser and have never been tested.';
		message += '</div>';
		
		document.body.innerHTML = message;

		return false;

	}

	return true;

}