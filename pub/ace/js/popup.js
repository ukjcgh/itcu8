popup = {

	show : function(html) {
		if (!$('.popup-back')) {
			var body = $('body');

			var popupBackDiv = newElement('div');
			popupBackDiv.className = 'popup-back';
			body.appendChild(popupBackDiv);

			var popupDiv = newElement('div');
			popupDiv.className = 'popup';
			body.appendChild(popupDiv);

			popupDiv.innerHTML = '<div class="head"><a href="#">close</a></div>';
			popupDiv.innerHTML += '<div class="content"></div>';

			$('.popup .head a').onclick = function() {
				popup.hide();
				return false;
			};
		}
		$('.popup .content').innerHTML = html;
		$('.popup-back').style.display = 'block';
		$('.popup').style.display = 'block';
	},

	hide : function() {
		if ($('.popup-back')) {
			$('.popup').style.display = 'none';
			$('.popup-back').style.display = 'none';
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