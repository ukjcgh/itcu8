popup = {

	show : function(html) {
		if (!el('.popup-back')) {
			var body = el('body');

			var popupBackDiv = newel('div');
			popupBackDiv.className = 'popup-back';
			body.appendChild(popupBackDiv);

			var popupDiv = newel('div');
			popupDiv.className = 'popup';
			body.appendChild(popupDiv);

			popupDiv.innerHTML = '<div class="head"><a href="#">close</a></div>';
			popupDiv.innerHTML += '<div class="content"></div>';

			el('.popup .head a').onclick = function() {
				popup.hide();
				return false;
			};
		}
		el('.popup .content').innerHTML = html;
		el('.popup-back').style.display = 'block';
		el('.popup').style.display = 'block';
	},

	hide : function() {
		if (el('.popup-back')) {
			el('.popup').style.display = 'none';
			el('.popup-back').style.display = 'none';
		}
	}
}

initFuncs.push(function() {
	document.addEventListener('keyup', function(e) {
		if (e.keyCode == 27) {
			popup.hide();
		}
	});
});