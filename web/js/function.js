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

/*HEIGHT MAP*/
var heightsuperInfoBar = $('.superInfoBar').height();

heightsuperInfoBar = heightsuperInfoBar - 40;

$('.mapView iframe').css('height', heightsuperInfoBar + 'px');

/************/


$(document).ready(function(){
  $(".vignetteBar").mouseenter(function(){
    $(this).find('.shadowHover h3').stop(true,true).animate({marginBottom:"25px"});
    $(this).find('.shadowHover p').stop(true,true).fadeIn(400);
    $(this).find('.shadowHover p').stop(true,true).animate({marginBottom:"23px"});
    $(this).find('.shadowHover').css("background", 'rgba(0,0,0,0.5)');
  });
  $(".vignetteBar").mouseleave(function(){
    $(this).find('.shadowHover h3').stop(true,true).animate({marginBottom:"10px"});
    $(this).find('.shadowHover p').stop(true,true).fadeOut(400);
    $(this).find('.shadowHover p').stop(true,true).animate({marginBottom:"8px"});
    $(this).find('.shadowHover').css("background", '-webkit-linear-gradient(bottom,rgba(000000,0,0,0.6),rgba(000000,0,0,0))');
    $(this).find('.shadowHover').css("background", '-o-linear-gradient(bottom,rgba(000000,0,0,0.6),rgba(000000,0,0,0))');
    $(this).find('.shadowHover').css("background", '-moz-linear-gradient(bottom,rgba(000000,0,0,0.6),rgba(000000,0,0,0))');
    $(this).find('.shadowHover').css("background", 'linear-gradient(bottom,rgba(000000,0,0,0.6),rgba(000000,0,0,0))');
  });
});

setInterval(function(){
	var widthShadow = $('.shadowHover').width();
	widthShadow = widthShadow / 2
	$('.shadowHover').css('margin-left', -widthShadow + 'px');
});


