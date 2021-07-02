$(function()
{
	var mobilemenu = (function()
	{
		var $btn = $("#menu-mobile .menu-hamburger");
		var $menu = $("#menu-mobile .mobile-navi");
		var $ul = $("#menu-mobile .mobile-navi ul");
		var $overlay = $("#menu-mobile .overlay");

		var prop = "left";
		var menuW = $menu.width();

		var _this = {};

		_this.isOpened = false;

		_this.reset = function()
		{
			_this.isOpened = false;

			menuW = window.innerWidth - 70;

			$menu.css("width", menuW);
			$menu.css(prop, -menuW);

			$overlay.hide();
			$ul.scrollTop(0);
		}

		_this.toggle = function(e)
		{
			if (!_this.isOpened) _this.open();
			else _this.close();
		}

		_this.open = function()
		{
			_this.reset();

			_this.isOpened = true;

			$menu.show();
			$overlay.fadeIn(200);

			$btn.addClass("open");

			$("#menu-mobile").addClass("active");
			$("html, body").css("overflow", "hidden");
			$("html, body").css("height", "100%");

			var tween = {};

			tween[prop] = 0;

			TweenLite.to($menu, 0.4, tween);
		}

		_this.close = function()
		{
			_this.isOpened = false;

			$overlay.fadeOut(200);

			$btn.removeClass("open");
			$("#menu-mobile").removeClass("active");
			$("html, body").css("overflow", "visible");
			$("html, body").css("height", "auto");

			var tween = {};

			tween[prop] = -menuW;
			tween.onComplete = function()
			{
				$menu.hide();
				$menu.scrollTop(0);
				$ul.scrollTop(0);
			}

			TweenLite.to($menu, 0.4, tween);
		}

		$btn.on("tap", _this.toggle);
		$btn.on("click", _this.toggle);

		_this.reset();

		return _this;
	}
	)();
}
);