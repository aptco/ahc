$(function()
{
	var params =
	{
		auto:true,
		pause:6500,
		speed:800,
		slideMargin:20,
		slideWidth:1200,
		minSlides: 1,
		maxSlides: 1,
		moveSlides: 1,
		adaptiveHeight: true,
		controls:false
	};

	var slider = $('.bxslider').bxSlider(params).fadeIn(500);
}
);