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
    $(this).find('.shadowHover h3').stop(true,true).animate({marginBottom:"25px"});
  });
  $(".vignetteBar").mouseleave(function(){
    $(this).find('.shadowHover h3').stop(true,true).animate({marginBottom:"10px"});
  });
});

setInterval(function(){
	var widthShadow = $('.shadowHover').width();
	widthShadow = widthShadow / 2
	$('.shadowHover').css('margin-left', -widthShadow + 'px');
});


