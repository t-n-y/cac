var middlejaloux = $('.jaloux').height();
var heightbar = $('.bar').height();

var middlejaloux = heightbar - middlejaloux;

middlejaloux = middlejaloux / 2;

//$('.jaloux').css('margin-top', middlejaloux + 'px');

setInterval(function(){
var widthImg = $('.vignetteBar img').width();
var heightImg = $('.vignetteBar img').height();
var heightWindow = $(window).height();


$('.shadowHover').css('width', widthImg + 'px');
$('.shadowHover').css('height', heightImg + 'px');
$('.mainContainer').css('min-height', heightWindow + 'px');



},100);

/*HEIGHT MAP*/
var heightsuperInfoBar = $('.superInfoBar').height();

heightsuperInfoBar = heightsuperInfoBar - 40;

$('.mapView iframe').css('height', heightsuperInfoBar + 'px');

/************/


$(document).ready(function(){
  $(".vignetteBar").mouseenter(function(){
    $(this).find('.shadowHover h3').stop(true,true).animate({marginBottom:"25px"});
    $(this).find('.shadowHover p').stop(true,true).fadeIn(600);
    $(this).find('.shadowHover p').stop(true,true).animate({marginBottom:"8px",opacity:"1"});
    $(this).find('.shadowHover').css("background", 'rgba(0,0,0,0.5)');
  });
  $(".vignetteBar").mouseleave(function(){
    $(this).find('.shadowHover h3').stop(true,true).animate({marginBottom:"10px"});
    $(this).find('.shadowHover p').stop(true,true).fadeOut(600);
    $(this).find('.shadowHover p').stop(true,true).animate({marginBottom:"23px",opacity:"0"});
    $(this).find('.shadowHover').css("background", '-webkit-linear-gradient(bottom,rgba(000000,0,0,0.6),rgba(000000,0,0,0))');
    $(this).find('.shadowHover').css("background", '-o-linear-gradient(bottom,rgba(000000,0,0,0.6),rgba(000000,0,0,0))');
    $(this).find('.shadowHover').css("background", '-moz-linear-gradient(bottom,rgba(000000,0,0,0.6),rgba(000000,0,0,0))');
    $(this).find('.shadowHover').css("background", 'linear-gradient(bottom,rgba(000000,0,0,0.6),rgba(000000,0,0,0))');
  });


setInterval(function(){
  var widthShadow = $('.shadowHover').width();
  widthShadow = widthShadow / 2;
  $('.shadowHover').css('margin-left', -widthShadow + 'px');
});



  $('.schedule-picker').change(function(){
    var day = $(this).attr('data-day');
    var when = $(this).attr('data-when');
    var time = $(this).val();
    var hidden = $('#cac_barbundle_bar_schedule').val();
    hidden = JSON.parse(hidden);
    hidden[day][when] = time;
    $('#cac_barbundle_bar_schedule').val(JSON.stringify(hidden));
  });

  $('.close-day').change(function() {
    var day = $(this).attr('data-day');
    var hidden = $('#cac_barbundle_bar_schedule').val();
    hidden = JSON.parse(hidden);
    if(hidden[day].status == 'Ouvert') {
      hidden[day].status = 'Fermé';
    } else {
      hidden[day].status = 'Ouvert';
    }
    $('#cac_barbundle_bar_schedule').val(JSON.stringify(hidden));
  });




  $('.hh-picker').change(function(){
    var day = $(this).attr('data-day');
    var when = $(this).attr('data-when');
    var time = $(this).val();
    var hidden = $('#cac_barbundle_promotion_promotion').val();
    hidden = JSON.parse(hidden);
    hidden[day]['happy-hour'][when] = time;
    $('#cac_barbundle_promotion_promotion').val(JSON.stringify(hidden));
  });

  $('.hh-value-picker').change(function(){
    var day = $(this).attr('data-day');
    var reduction = $(this).val();
    var hidden = $('#cac_barbundle_promotion_promotion').val();
    hidden = JSON.parse(hidden);
    hidden[day]['happy-hour']['value'] = reduction;
    $('#cac_barbundle_promotion_promotion').val(JSON.stringify(hidden));
  });

  $('.hh-condition-picker').change(function(){
    var day = $(this).attr('data-day');
    var condition = $(this).val();
    var hidden = $('#cac_barbundle_promotion_promotion').val();
    hidden = JSON.parse(hidden);
    hidden[day]['happy-hour']['condition'] = condition;
    $('#cac_barbundle_promotion_promotion').val(JSON.stringify(hidden));
  });



  $('.promotion-qt-picker').keyup(function(){
    var day = $(this).attr('data-day');
    var qt = $(this).val();
    var hidden = $('#cac_barbundle_promotion_promotion').val();
    hidden = JSON.parse(hidden);
    hidden[day].promotion.quantity = qt;
    $('#cac_barbundle_promotion_promotion').val(JSON.stringify(hidden));
    $('.promotion-unlimited[data-day="' + day + '"]').attr('checked', false);
  });

  $('.promotion-qt-picker').mouseup(function(){
    var day = $(this).attr('data-day');
    var qt = $(this).val();
    var hidden = $('#cac_barbundle_promotion_promotion').val();
    hidden = JSON.parse(hidden);
    hidden[day].promotion.quantity = qt;
    $('#cac_barbundle_promotion_promotion').val(JSON.stringify(hidden));
  });

  $('.promotion-unlimited').change(function() {
    var day = $(this).attr('data-day');
    var hidden = $('#cac_barbundle_promotion_promotion').val();
    hidden = JSON.parse(hidden);
    if(hidden[day].promotion.quantity !== 'Illimité') {
      hidden[day].promotion.quantity = 'Illimité';
    } else {
      hidden[day].promotion.quantity = $('.promotion-qt-picker[data-day="' + day + '"]').val();
    }
    $('#cac_barbundle_promotion_promotion').val(JSON.stringify(hidden));
  });

  $('.promotion-value-picker').change(function(){
    var day = $(this).attr('data-day');
    var reduction = $(this).val();
    var hidden = $('#cac_barbundle_promotion_promotion').val();
    hidden = JSON.parse(hidden);
    hidden[day].promotion.value = reduction;
    $('#cac_barbundle_promotion_promotion').val(JSON.stringify(hidden));
  });

  $('.promotion-condition-picker').change(function(){
    var day = $(this).attr('data-day');
    var condition = $(this).val();
    var hidden = $('#cac_barbundle_promotion_promotion').val();
    hidden = JSON.parse(hidden);
    hidden[day].promotion.condition = condition;
    $('#cac_barbundle_promotion_promotion').val(JSON.stringify(hidden));
  });



  function loadTemplate(template) {
    $.getJSON( "http://localhost/cac/web/json/" + template + ".template.json", function( data ) {
      var bundle = {
        "schedule": "bar",
        "promotion": "promotion"
      };
      if($('#cac_barbundle_' + bundle[template] + '_' + template).val() == '') {
        $('#cac_barbundle_' + bundle[template] + '_' + template).val(JSON.stringify(data));
      }
    });
  }

  loadTemplate('schedule');
  loadTemplate('promotion');

  $(window).scroll(function() {
    var scrollTop = $(window).scrollTop();
    if(scrollTop > 150 && $('.navbar-afterscroll').hasClass('stuck')) {
      $('.navbar-afterscroll').stop().animate({
        top: '0px'},
        400
      );
      $('.navbar-afterscroll').removeClass('stuck');
    } 
    if(scrollTop < 150 && !$('.navbar-afterscroll').hasClass('stuck')) {
      $('.navbar-afterscroll').stop().animate({
        top: '-150px'},
        250
      );
      $('.navbar-afterscroll').addClass('stuck');
    }
  });

});





/********PAGE SHOW BAR*****/

$('body').on("click", ".information",function(){
  $('.informationBar').css("display" , "block");
  $('.avisBar').css("display" , "none");
  $('.information').css("width" , "160px");
  $('.information').css("margin-left" , "-160px");
  $('.avis').css("width" , "150px");
  $('.avis').css("margin-left" , "-150px");
});

$('body').on("click", ".avis",function(){
  $('.informationBar').css("display" , "none");
  $('.avisBar').css("display" , "block");
  $('.avis').css("width" , "160px");
  $('.avis').css("margin-left" , "-160px");
  $('.information').css("width" , "150px");
  $('.information').css("margin-left" , "-150px");
});

$('.ticket').hover(function(){
    $('.ticketPromotion').stop(true,true).show(500);
  },function(){
    $('.ticketPromotion').stop(true,true).hide(500);
});

$('.ticketVerre').hover(function(){
    $('.ticketCode').stop(true,true).show(500);
  },function(){
    $('.ticketCode').stop(true,true).hide(500);
});


/***************************/




/*$(document).ready(function(){
  $("button").click(function(){
    var x=$(".navbar-nav li:nth-child(2)").offset();
    alert("Top: " + x.top + " Left: " + x.left);
  });
});*/


/**********SLIDER HOME*************************/

var nbImage = $( ".topPage img" ).length;
    var compteur = 0;
    var annimationTime = 5000;   /******REGLER VITESSE DU SLIDER******/

    $(".borderTopImage").animate({
    width: "100%"
  }, annimationTime);

    setInterval(function(){
        $(".borderTopImage").css("width","0%");

          $(".borderTopImage").animate({
              width: "100%"
          }, annimationTime-100);

          

       },annimationTime);

   setInterval(function(){

        
        
        $($(".topPage img")[compteur]).fadeOut(300);
        $($(".topPage img")[compteur]).removeClass("current");
        $($(".topPage img")[compteur +1]).addClass("current");
        $($(".topPage img")[compteur +1]).fadeIn(300);
        

        compteur ++;

        if($( ".topPage img" ).last().hasClass( "current" )){ 

                setTimeout(function() {  

                    compteur = 0;
                   $(".topPage img").fadeIn(300);
                  

                },annimationTime);

            }
            

    },annimationTime);



/*****************************************************************************/


/*****************************************SLIDER HOME*************************/

    var nbImageBar = $( ".topBar img" ).length;
    var compteurBar = 0;
    var annimationTimeBar = 5000;   /******REGLER VITESSE DU SLIDER******/


   setInterval(function(){

        
        
        $($(".topBar img")[compteurBar]).fadeOut(300);
        $($(".topBar img")[compteurBar]).removeClass("current");
        $($(".topBar img")[compteurBar +1]).addClass("current");
        $($(".topBar img")[compteurBar +1]).fadeIn(300);
        

        compteurBar ++;

        if($( ".topBar img" ).last().hasClass( "current" )){ 

                setTimeout(function() {  

                    compteurBar = 0;
                   $(".topBar img").fadeIn(300);
                  

                },annimationTimeBar);

            }
            

    },annimationTimeBar);


$( ".topBar" ).mouseenter(function() {
    setTimeout(function() {  

       $(".topBar").animate({
              height: "600px"
          }, 300);
                  

    },1000);
  });
  $( ".topBar" ).mouseleave(function() {
    setTimeout(function() {  

       $(".topBar").animate({
              height: "508px"
          }, 300);
                  

    },1000);
  });

/*****************************************************************************/

  

