popup = {

	show : function(html) {
		if (!$('.popup-back').length) {
			$('body').append('<div class="popup-back"></div>');
			$('body').append('<div class="popup"></div>');
			$('.popup').append('<div class="head"><a href="#">close</a></div>');
			$('.popup .head a').click(function(e) {
				popup.hide();
				return false;
			});
			$('.popup').append('<div class="content"></div>');
		}
		// $('.popup').append();
		$('.popup .content').html(html);
		$('.popup-back').show();
		$('.popup').show();
	},

	hide : function() {
		if ($('.popup-back').length) {
			$('.popup').hide();
			$('.popup-back').hide();
		}
	}
}

$(document).bind('keyup', function(e) {
	if (e.keyCode == 27) {
		popup.hide();
	}
});