annimationShowBar();
firstWord();

 $('body').removeClass('load');

 $('.navToggle').slideToggle(150);
 $('.displayMore').on('click', function() {
  $('.navToggle').slideToggle(150);
  $('.navToggleBtn').slideToggle(150);
 });

var baseHeight = $(window).height();
var navHeight = $('.menuNav').height();
var baseHeightCenterWelcome = $('.centerWelcome').height();

var heighWelcome = baseHeight - navHeight;

$('.welcome').css('height', heighWelcome+'px');

function changePaddingWelcome(heighWelcome, baseHeightCenterWelcome){

  var marginCenterWelcome = (heighWelcome - baseHeightCenterWelcome) / 2;
  $('.centerWelcome').css('padding-top', marginCenterWelcome+'px');
  $('.welcome').css('height', heighWelcome+'px');

}

changePaddingWelcome(heighWelcome, (baseHeightCenterWelcome+20) );


$(window).on('resize',function() {
  baseHeight = $(window).height();
  navHeight = $('.menuNav').height();
  baseHeightCenterWelcome = $('.centerWelcome').height();
  heighWelcome = baseHeight - navHeight;

  changePaddingWelcome(heighWelcome, baseHeightCenterWelcome);
});

$( ".menuHeaderList .hottest" ).on( "click", function() {
  setTimeout(function() {  
    annimationShowBar();
    firstWord();            
  },350);
});
$( ".menuHeaderList .small-price" ).on( "click", function() {
  setTimeout(function() {  
      annimationShowBar();
      firstWord();            
    },350);
});
$( ".menuHeaderList .best" ).on( "click", function() {
  setTimeout(function() {  
      annimationShowBar();
      firstWord();            
    },350);
});

var $shadowHover = $('.shadowHover');
var $mainContainer = $('.mainContainer');
var $isConnexion = $('.isConnexion');

setInterval(function(){
  var widthImg = $('.vignetteBar img').width();
  var heightImg = $('.vignetteBar img').height();
  var heightWindow = $(window).height();


  $shadowHover.css('width', widthImg + 'px');
  $shadowHover.css('height', heightImg + 'px');
  $mainContainer.css('min-height', heightWindow + 'px');
  $isConnexion.css('min-height', heightWindow + 'px');

},100);

/*HEIGHT MAP*/
var heightsuperInfoBar = $('.superInfoBar').height();

heightsuperInfoBar = heightsuperInfoBar - 40;

$('.mapView iframe').css('height', heightsuperInfoBar + 'px');

/************/

/*******CONNEXION*******/
$(document).ready(function(){

  $('.active').each(function() {
    $( this ).click();
    $( this ).click();
  });

  $('#recherche input').keypress(function(e) {
    if(e.which == 13) {
      $('#recherche button').click();
    }});
  $('#recherche button').on('click', function() {
    var searchValue = $("#recherche input").val();
    if(searchValue.length > 0){
      window.location = Routing.generate('search', { value: searchValue });
    }
  });

  var $forConnexion = $('.forConnexion');
  var $forRegister = $('.forRegister');
  var $animConnexion = $('.animConnexion');
  var $inscrivezVous = $('.inscrivezVous');
  var $closeForConnexion = $('.closeForConnexion');
  var $JSinscriptionProNav = $('.JSinscriptionProNav');
  
  $animConnexion.on('click',function(){
    $isConnexion.css("display","block");
    $forConnexion.css("display","block");
    $forRegister.css("display","none");
  });

  $isConnexion.on('click',function(){
    $isConnexion.css("display","none");
    $forConnexion.css("display","none");
    $forRegister.css("display","none");
  });

  $closeForConnexion.on('click',function(){
    $isConnexion.css("display","none");
    $forConnexion.css("display","none");
    $forRegister.css("display","none");
  });

  $JSinscriptionProNav.on('click',function(){
    $isConnexion.css("display","none");
    $forConnexion.css("display","none");
    $forRegister.css("display","none");

    $('html, body').animate({
        scrollTop: $('.contentFormRegisterPro').offset().top
    }, 700);

  });
});

/***********************/

var $vignetteBar = $('.vignetteBar');
var shadowHover = '.shadowHover';
var shadowHoverP = '.shadowHover p';
var shadowHoverH3 = '.shadowHover h3';

$(document).ready(function(){
  $vignetteBar.mouseenter(function(){
    $(this).find(shadowHoverH3).stop(true,true).animate({marginBottom:"25px"});
    $(this).find(shadowHoverP).stop(true,true).fadeIn(600);
    $(this).find(shadowHoverP).stop(true,true).animate({marginBottom:"8px",opacity:"1"});
    $(this).find(shadowHover).css("background", 'rgba(0,0,0,0.5)');
  });

  $vignetteBar.mouseleave(function(){
    $(this).find(shadowHoverH3).stop(true,true).animate({marginBottom:"10px"});
    $(this).find(shadowHoverP).stop(true,true).fadeOut(600);
    $(this).find(shadowHoverP).stop(true,true).animate({marginBottom:"23px",opacity:"0"});
    $(this).find(shadowHover).css("background", '-webkit-linear-gradient(bottom,rgba(000000,0,0,0.6),rgba(000000,0,0,0))');
    $(this).find(shadowHover).css("background", '-o-linear-gradient(bottom,rgba(000000,0,0,0.6),rgba(000000,0,0,0))');
    $(this).find(shadowHover).css("background", '-moz-linear-gradient(bottom,rgba(000000,0,0,0.6),rgba(000000,0,0,0))');
    $(this).find(shadowHover).css("background", 'linear-gradient(bottom,rgba(000000,0,0,0.6),rgba(000000,0,0,0))');
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
    var hidden = $('#cac_barbundle_promotion_dummy_promotion').val();
    hidden = JSON.parse(hidden);
    hidden[day]['happy-hour'][when] = time;
    $('#cac_barbundle_promotion_dummy_promotion').val(JSON.stringify(hidden));
  });

  $('.hh-value-picker').change(function(){
    var day = $(this).attr('data-day');
    var reduction = $(this).val();
    var hidden = $('#cac_barbundle_promotion_dummy_promotion').val();
    hidden = JSON.parse(hidden);
    hidden[day]['happy-hour']['value'] = reduction;
    $('#cac_barbundle_promotion_dummy_promotion').val(JSON.stringify(hidden));
  });

  $('.hh-condition-picker').change(function(){
    var day = $(this).attr('data-day');
    var condition = $(this).val();
    var hidden = $('#cac_barbundle_promotion_dummy_promotion').val();
    hidden = JSON.parse(hidden);
    hidden[day]['happy-hour']['condition'] = condition;
    $('#cac_barbundle_promotion_dummy_promotion').val(JSON.stringify(hidden));
  });

  $('.promotion-qt-picker').keyup(function(){
    var day = $(this).attr('data-day');
    var qt = $(this).val();
    var hidden = $('#cac_barbundle_promotion_dummy_promotion').val();
    hidden = JSON.parse(hidden);
    hidden[day].promotion.quantity = qt;
    $('#cac_barbundle_promotion_dummy_promotion').val(JSON.stringify(hidden));
    $('.promotion-unlimited[data-day="' + day + '"]').attr('checked', false);
  });

  $('.promotion-qt-picker').mouseup(function(){
    var day = $(this).attr('data-day');
    var qt = $(this).val();
    var hidden = $('#cac_barbundle_promotion_dummy_promotion').val();
    hidden = JSON.parse(hidden);
    hidden[day].promotion.quantity = qt;
    $('#cac_barbundle_promotion_dummy_promotion').val(JSON.stringify(hidden));
  });

  $('.promotion-unlimited').change(function() {
    var day = $(this).attr('data-day');
    var hidden = $('#cac_barbundle_promotion_dummy_promotion').val();
    hidden = JSON.parse(hidden);
    if(hidden[day].promotion.quantity !== 'Illimité') {
      hidden[day].promotion.quantity = 'Illimité';
    } else {
      hidden[day].promotion.quantity = $('.promotion-qt-picker[data-day="' + day + '"]').val();
    }
    $('#cac_barbundle_promotion_dummy_promotion').val(JSON.stringify(hidden));
  });

  $('.promotion-value-picker').change(function(){
    var day = $(this).attr('data-day');
    var reduction = $(this).val();
    var hidden = $('#cac_barbundle_promotion_dummy_promotion').val();
    hidden = JSON.parse(hidden);
    hidden[day].promotion.value = reduction;
    $('#cac_barbundle_promotion_dummy_promotion').val(JSON.stringify(hidden));
  });

  $('.promotion-condition-picker').change(function(){
    var day = $(this).attr('data-day');
    var condition = $(this).val();
    var hidden = $('#cac_barbundle_promotion_dummy_promotion').val();
    hidden = JSON.parse(hidden);
    hidden[day].promotion.condition = condition;
    $('#cac_barbundle_promotion_dummy_promotion').val(JSON.stringify(hidden));
  });

  function loadTemplate(template) {
    $.getJSON( "http://localhost/cac/web/json/" + template + ".template.json", function( data ) {
      var bundle = {
        "schedule": "bar",
        "promotion": "promotion_dummy"
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

$(document).on('click','.menu__handle' ,function() {
    $(this).addClass('menu_open');
    $(this).parent().addClass('menu_open');
});

$(document).on('click','.menu_open' ,function() {
    $(this).removeClass('menu_open');
    $(this).children().removeClass('menu_open');
});

$(document).on('click','.inscriptionNewProNav', function() {
    $('html, body').animate({
        scrollTop: $('.contentFormRegisterPro').offset().top
    }, 700);
});

$('.administration').mouseenter(function() {
    $(this).find('ul').addClass('openSousNav');
});
$('.administration').mouseleave(function() {
    $(this).find('ul').removeClass('openSousNav');
});


$('.interrogation p').mouseenter(function() {
    $(this).parent().find($('.informationInterrogation')).css('display','block');
});

$('.interrogation p').mouseleave(function() {
    $(this).parent().find($('.informationInterrogation')).css('display','none');
});

/********PAGE SHOW BAR*****/

var $body = $('body');


$body.on("click", ".information",function(){
  $('.informationBar').css("display" , "block");
  $('.avisBar').css("display" , "none");
  $('.avis').removeClass('selectedOngletBar');
  $(this).addClass('selectedOngletBar');
});

$body.on("click", ".avis",function(){
  $('.informationBar').css("display" , "none");
  $('.avisBar').css("display" , "block");
  $('.information').removeClass('selectedOngletBar');
  $(this).addClass('selectedOngletBar');
});


$('.informationJour').first().addClass('selectedDay');

$body.on("click", ".informationJour",function(){
  $('.selectedDay').removeClass('selectedDay');
  $(this).addClass('selectedDay');
});


$('.ongletOptionPro').first().addClass('ongletselect');

$body.on("click", ".ongletOptionPro",function(){
  $('.ongletOptionPro').removeClass('ongletselect');
  $(this).addClass('ongletselect');
});

$('.onglet').first().addClass('ongletselect');

$body.on("click", ".onglet",function(){
  $('.onglet').removeClass('ongletselect');
  $(this).addClass('ongletselect');
});

$('.gestion').first().css('display','block');

$body.on('click','.ongletVerresOffert',function(){
  $('.gestion').hide();
  $('.gestionVerreOffert').show();
});

$body.on('click','.ongletVerresPromotion',function(){
  $('.gestion').hide();
  $('.gestionPromotion').show();
});



$('body').on('click','.sms',function(){
  $('.contentEmail').hide();
  $('.contentCarte').hide();
  $('.contentMiseAvant').hide();
  $('.contentMesOptions').hide();
  $('.contentSms').show();
  heightSuperInfoBar();
});

$body.on('click','.email',function(){
  $('.contentSms').hide();
  $('.contentCarte').hide();
  $('.contentMiseAvant').hide();
  $('.contentMesOptions').hide();
  $('.contentEmail').show();
  heightSuperInfoBar();
});

$body.on('click','.carte',function(){
  $('.contentSms').hide();
  $('.contentEmail').hide();
  $('.contentMiseAvant').hide();
  $('.contentMesOptions').hide();
  $('.contentCarte').show();
  heightSuperInfoBar();
});

$body.on('click','.miseAvant',function(){
  $('.contentEmail').hide();
  $('.contentCarte').hide();
  $('.contentSms').hide();
  $('.contentMesOptions').hide();
  $('.contentMiseAvant').show();
  heightSuperInfoBar();
});

$body.on('click','.mesOptions',function(){
  $('.contentEmail').hide();
  $('.contentCarte').hide();
  $('.contentSms').hide();
  $('.contentMiseAvant').hide();
  $('.contentMesOptions').show();
  heightSuperInfoBar();
});

/******** Mon compte BB********/

$('body').on('click','.generalBO',function(){
  $('.contentFactureBO').hide();
  $('.contentBarmanBO').hide();
  $('.contentGeneralBO').show();
  heightSuperInfoBar();
});

$('body').on('click','.factureBO',function(){
  $('.contentGeneralBO').hide();
  $('.contentBarmanBO').hide();
  $('.contentFactureBO').show();
  heightSuperInfoBar();
});

$('body').on('click','.barmanBO',function(){
  $('.contentGeneralBO').hide();
  $('.contentFactureBO').hide();
  $('.contentBarmanBO').show();
  heightSuperInfoBar();
});

// $body.on('click','.mesOptions',function(){
//   $('.contentMesOptions').show();
// });

// $body.on('click','p.closeMesOptions',function(){
//   $('.contentMesOptions').hide();
// });

$body.on('click','.closeMesOptionEnCours',function(){
  var dataGenre = $(this).parentsUntil($('.JS-contentMesOptions')).find('.dataMiseEnAvant').data("genre")
  var dataDate = $(this).parentsUntil($('.JS-contentMesOptions')).find('.dataDate').data("date");
  var dataPrix = $(this).parentsUntil($('.JS-contentMesOptions')).find(".dataPrix").data("prix");
  var dataTotal = $(this).parentsUntil($('.JS-contentMesOptions')).find(".dataTotal").data("total");

  console.log(dataGenre + ' ' + dataDate);

  var date = new Date();

  var jour = date.getDate();
  var mois = date.getMonth();
  var annee = date.getFullYear();

  mois = mois + 1;

  if(jour <= 9){
    jour = '0'+jour;
  }

  if(mois <= 9){
    mois = '0'+mois;
  }

  var dataStop = jour + '/' + mois + '/' + annee; 


  $(this).parentsUntil($('.JS-contentMesOptions')).hide(300);

  var new_element = jQuery(
    '<div class="mesOptionsEnCours col-xs-12 col-sm-12 col-md-12 noPadding">'+
      '<div class="ligneMesOption1">'+
        '<div class="col-xs-4 col-sm-4 col-md-4 noPadding">'+
          '<p class="dataMiseEnAvant">'+ dataGenre +'</p>'+
        '</div>'+
        '<div class="col-xs-4 col-sm-4 col-md-4 noPadding">'+
          '<p>Historique</p>'+
        '</div>'+
        '<div class="col-xs-4 col-sm-4 col-md-4 noPadding">'+
          '<div class="closeMesOptionEnCours">'+
            '<span>Arrêté le <p class="dataDate"> '+dataStop+'</p>'+
          '</div>'+
        '</div>'+
      '</div>'+
      '<div class="ligneMesOption2">'+
        '<div class="col-xs-4 col-sm-4 col-md-4 noPadding">'+
          '<span>Souscrit le <p class="dataDate">'+ dataDate +'</p>'+
        '</div>'+
        '<div class="col-xs-4 col-sm-4 col-md-4 noPadding">'+
          '<p>'+ dataPrix +'€/Jour</p>'+
        '</div>'+
        '<div class="col-xs-4 col-sm-4 col-md-4 noPadding">'+
          '<p>' + dataTotal +'€</p>'+
        '</div>'+
      '</div>'+
    '</div>'
  );

  $('.optionFinies').append(new_element.css("display","none"));

  setTimeout(function() {  
      $('.mesOptionsEnCours').last().show(300);
    },300);
});




function heightSuperInfoBar(){
  var heightSuperInfoBar = $('.superInfoBar').height();
  $('.contentMesOptions').css('height', heightSuperInfoBar+'px');
}


$(document).ready(function(){
  $(".ticket").mouseenter(function(){
    //$(".ticket .ticketBarTop").css("margin-top","-10px");
    $(".ticket .ticketBarTop").stop(true,false).animate({
              marginTop: "-10px"
          }, 300);
    $(".ticket .ticketPromotion").stop(true,false).animate({
              marginTop: "0px"
          }, 300);
    $('.ticket .ticketPromotion').css("display" , "block");
  });
  $(".ticket").mouseleave(function(){
    $(".ticket .ticketBarTop").stop(true,false).animate({
              marginTop: "0px"
          }, 300);
    $(".ticket .ticketPromotion").stop(true,false).animate({
              marginTop: "-42px"
          }, 300);
    setTimeout(function() {  
      $('.ticket .ticketPromotion').css("display" , "none");
    },300);
  });
});


$(document).ready(function(){
  $(".ticketVerre").mouseenter(function(){
    $(".ticketVerre .ticketBarTop").stop(true,false).animate({
              marginTop: "-10px"
          }, 300);
    $(".ticketVerre .ticketCode").stop(true,false).animate({
              marginTop: "0px"
          }, 300);
    $('.ticketVerre .ticketCode').css("display" , "block");
  });
  $(".ticketVerre").mouseleave(function(){
    $(".ticketVerre .ticketBarTop").stop(true,false).animate({
              marginTop: "0px"
          }, 300);
    $(".ticketVerre .ticketCode").stop(true,false).animate({
              marginTop: "-46px"
          }, 300);
    setTimeout(function() {  
      $('.ticketVerre .ticketCode').css("display" , "none");
    },300);
  });
});

$('body').on('click','.closeRappel',function(){
  $('.confirmationReservation').css('display', 'none');
});

/**********SLIDER HOME*************************/

var nbImage = $( ".topPage img" ).length;
    var compteur = 0;
    var annimationTime = 5000;   /******REGLER VITESSE DU SLIDER******/

    $(".borderTopImage").animate({
    width: "100%"
  }, annimationTime-100);

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


/*****************************************SLIDER Page Bar*************************/

    var nbImageBar = $( ".topBar img" ).length;
    var compteurBar = 0;
    var annimationTimeBar = 5000;   /******REGLER VITESSE DU SLIDER******/

 if(nbImageBar !=1){

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
   }


$(document).ready(function() {
$(".topBar").animate({
      height: "360px"
    }, 300);

    var timer;
    $(".topBar").hover(function() {
        timer = setTimeout(function() {
            $(".topBar").animate({
              height: "550px"
          }, 300);
        },1000);
    },function() {
        clearTimeout(timer);
    });

    $( ".topBar" ).mouseleave(function() {
  
    $(".topBar").animate({
      height: "360px"
    }, 300);

  });
});

/*********************************************************************************/




/**********************************Page Show Bar*********************************/
function firstWord(){
    $.fn.firstWord = function() {
    var text = this.text().trim().split(" ");
    var first = text.shift();
    this.html((text.length > -1 ? "<span class='firstWords'>"+ first + "</span> " : first) + text.join(" "));
  };

  for(var i = 0; i<1000; i++){
    $("#firstWord"+[i]).firstWord();
  }
}

function annimationShowBar(){
  $(".barInList").mouseenter(function(){
     $(this).find('.hoverShadow').stop(true,true).fadeIn(400);
     $(this).find('.shadowbarInList p.shadowNote').css('margin-top', '6px');
     $(this).find('.barInListHighlight .shadowbarInList p.shadowNote').css('margin-top', '2px');
   });
  $(".barInList").mouseleave(function(){
     $(this).find('.hoverShadow').stop(true,true).fadeOut(10);
     $(this).find('.shadowbarInList p.shadowNote').css('margin-top', '10px');
   });
  $(".barInListHighlight").mouseenter(function(){
     $(this).find('.shadowbarInList p.shadowNote').css('margin-top', '2px');
   });
  
}





/********************************************************************************/


function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

$("#form_file").change(function(){
    readURL(this);
    $(".showImg").stop(true,true).show(300);
    $(".file_button_container img").stop(true,true).show(300);
});

$("#cac_barbundle_bar_file").change(function(){
    readURL(this);
    $(".showImg").stop(true,true).show(300);
    $(".file_button_container img").stop(true,true).show(300);
    $("#lastPicture").stop(true,true).hide(300);
});

// render modal login
$( ".animConnexion" ).on( "click", function() {
    $.ajax( {
        type: 'GET',
        url: Routing.generate('fos_user_security_login'),
        data: 'json',
        success: function (data) {
          $('.forConnexion .container-modal').html(data);
        }
    });
});

// Obtenir une promotion
$( '.obtenirPromo' ).on( 'click', function() {
  var promoId = $(this).data('bar-id');
  $.ajax( {
      url: Routing.generate('get_promo', {id: promoId}),
      data: 'json',
      success: function (data) {
        $('.testSuccess').html(data);
        $('.confirmationReservation').css('display', 'block');
        $('.ticket .ticketBarTop').css('background-color', '#ea9026');
        $('.obtenirPromo h2').html('');
        $('.obtenirPromo h3').html('');
        $('.obtenirPromo p').append('VOIR MA RESERVATION');
        $('.ticket p.obtenirPromo').html('');
        $('.ticket p.obtenirPromo').append('POUR AUJOUR\'HUI');
      },
      error: function(data){
        $('.testSuccess').html(data);
        alert("Vous n'avez pas votre promotion !!!");
      }
  } );
});



var $dayOngletNewBar = $('.dayOngletNewBar');
var numberOfDayOnglet;
var $promoHappyHour = $('.promoHappyHour');

numberOfDayOnglet = $dayOngletNewBar.length;

$($dayOngletNewBar[0]).addClass('selectedOngletDay');
$($promoHappyHour[0]).addClass('selectedPromoHappyHour');


$dayOngletNewBar.on('click', function(){
    $dayOngletNewBar.removeClass('selectedOngletDay');
    $(this).addClass('selectedOngletDay');
    var daySelected = $(this).data("dayselected");

    $promoHappyHour.removeClass('selectedPromoHappyHour');
    $($promoHappyHour[(daySelected-1)]).addClass('selectedPromoHappyHour');
});


$('.programmeFidelite span').on('click', function(){
    $('.programmeFidelitePlus').removeClass('closeProgrammeFidelitePlus');
});

$('.programmeFidelitePlus').on('click', function(){
    $(this).addClass('closeProgrammeFidelitePlus');
});

$('.btn-submitNewBar input').on('click', function(){
  if(document.getElementById('cac_barbundle_bar_valet').checked == true){
    if($('#cac_barbundle_bar_valetCost').val() == ''){
      alert('Veuillez inscrire un montant pour le voiturier');
      return false;
   }
  }
});


$('#cac_barbundle_bar_valet').on('click', function(){
  if($('.valetSecurity').hasClass('noInputValet')){
    $('.valetSecurity').removeClass('noInputValet');
  }else{
    $('.valetSecurity').addClass('noInputValet');
  }
});

/********BO BAR******/

function dateYesterday(){
  var date = new Date();

  var jour = date.getDate();
  var mois = date.getMonth();
  var annee = date.getFullYear();

  mois = mois + 1;

  if(jour <= 9){
    jour = '0'+jour;
  }

  if(mois <= 9){
    mois = '0'+mois;
  }

  if(mois === 5 || mois === 7 || mois === 8 || mois === 10 || mois === 12){
    if( jour === 1){
      jour = 30;
      mois = mois - 1; 
    }
  }
  else if(mois === 2 || mois === 4 || mois === 6 || mois === 9 || mois === 11){
    if( jour === 1){
      jour = 31;
      mois = mois - 1; 
    }
  }
  else if(mois === 1){
    if( jour === 1){
      jour = 31;
      mois = 12; 
      annee = annee - 1
    }
  }
  else if(mois === 3){
    if( jour === 3){
      jour = 28;
    }
  }else{
    jour = jour - 1;
  }

  var dateYesterday = jour + '/' + mois + '/' + annee; 

  $('.dateYesterday').append(dateYesterday);
}

dateYesterday();

/********************************/

//$('#cac_barbundle_bar_valetCost').val($('#cac_barbundle_bar_valetCost').val() + '€');






  // $dayOngletNewBar.on('click', function(){
  //   $dayOngletNewBar.removeClass('selectedOngletDay');
  //   $(this).addClass('selectedOngletDay');
  // });






