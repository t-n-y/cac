var middlejaloux = $('.jaloux').height();
var heightbar = $('.bar').height();

var middlejaloux = heightbar - middlejaloux;

middlejaloux = middlejaloux / 2;

//$('.jaloux').css('margin-top', middlejaloux + 'px');

setInterval(function(){
var widthImg = $('.vignetteBar img').width();
var heightImg = $('.vignetteBar img').height();

$('.shadowHover').css('width', widthImg + 'px');
$('.shadowHover').css('height', heightImg + 'px');
},100);
$('.vignetteBar').on("hover",function(){
	

});

$(document).ready(function(){
  $(".vignetteBar").mouseenter(function(){
    $(this).find('.shadowHover').stop(true,true).fadeIn(300);
  });
  $(".vignetteBar").mouseleave(function(){
    //$(this).find('.shadowHover').stop(true,true).fadeOut(300);
  });
});

setInterval(function(){
	var widthShadow = $('.shadowHover').width();
	widthShadow = widthShadow / 2
	$('.shadowHover').css('margin-left', -widthShadow + 'px');
});


