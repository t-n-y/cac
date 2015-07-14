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

$('.blockWelcome').on('mouseenter', function(){
  $(this).find('.hoverBlockWelcome').addClass('opacityHover');
});

$('.blockWelcome').on('mouseleave', function(){
  $(this).find('.hoverBlockWelcome').removeClass('opacityHover');
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
var $contentCompteUser = $('.contentCompteUser');

setInterval(function(){
  var widthImg = $('.vignetteBar img').width();
  var heightImg = $('.vignetteBar img').height();
  var heightWindow = $(window).height();


  $shadowHover.css('width', widthImg + 'px');
  $shadowHover.css('height', heightImg + 'px');
  $mainContainer.css('min-height', heightWindow + 'px');
  $contentCompteUser.css('min-height', heightWindow + 'px');
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
  var $forParrainage = $('.forParrainage');
  var $animConnexion = $('.animConnexion');
  var $inscrivezVous = $('.inscrivezVous');
  var $closeForConnexion = $('.closeForConnexion');
  var $JSinscriptionProNav = $('.JSinscriptionProNav');
  var $mesParrainage = $('.parrainage');
  var $popupsponsorship = $('.popupsponsorship');
  var $emailsponsorship = $('.emailsponsorship');
  
  $animConnexion.on('click',function(){
    $isConnexion.css("display","block");
    $forConnexion.css("display","block");
    $forParrainage.css("display","none");
  });

  $isConnexion.on('click',function(){
    $isConnexion.css("display","none");
    $forConnexion.css("display","none");
    $forParrainage.css("display","none");
    $popupsponsorship.css("display","none");
    $emailsponsorship.css("display","none");
    $('.ui-state-active').removeClass('ui-state-active');
  });

  $closeForConnexion.on('click',function(){
    $isConnexion.css("display","none");
    $forConnexion.css("display","none");
    $forParrainage.css("display","none");
  });

  $JSinscriptionProNav.on('click',function(){
    $isConnexion.css("display","none");
    $forConnexion.css("display","none");
    $forRegister.css("display","none");

    $('html, body').animate({
        scrollTop: $('.contentFormRegisterPro').offset().top
    }, 700);

  });

  $mesParrainage.on('click',function(){
    $isConnexion.css("display","block");
    $forParrainage.show();
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
  loadTemplate('sponsorship');

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

$('.ongletRetourOffre').on('click', function(){
    $('.selectedOngletsRetourOffre').removeClass('selectedOngletsRetourOffre');
    $('.selectedRetourOffre').removeClass('selectedRetourOffre');
    $(this).addClass('selectedOngletsRetourOffre');

    if($(this).hasClass('ongletToday')){
      $('.JS-offreToday').addClass('selectedRetourOffre');
    }else if($(this).hasClass('ongletYesterday')){
      $('.JS-offreYesterday').addClass('selectedRetourOffre');
    }
});

$('.ongletUser').on('click', function(){
    $('.selectedOngletUser').removeClass('selectedOngletUser');
    $(this).addClass('selectedOngletUser');
});

$('.ongletReservation').on('click', function(){
  $('.contentUser').hide();
  $('.contentReservation').show();
});

$('.ongletParrainage').on('click', function(){
  $('.contentUser').hide();
  $('.contentParrainage').show();
});

$('.ongletFidelite').on('click', function(){
  $('.contentUser').hide();
  $('.contentFidelite').show();
});

$('.ongletInformation').on('click', function(){
  $('.contentUser').hide();
  $('.contentInformation').show();
});

$('.mesReservation').on('click', function(){
    document.cookie = "onglet=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
    setCookie("onglet", "ongletReservation", 1);
});

$('.mesParrainage').on('click', function(){
    document.cookie = "onglet=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
    setCookie("onglet", "ongletParrainage", 1);
});

$('.monCompte').on('click', function(){
    document.cookie = "onglet=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
    setCookie("onglet", "ongletInformation", 1);
});

var cookie = getCookie("onglet");

switch(cookie){
    case "ongletReservation":
        $('.ongletReservation').addClass('selectedOngletUser');
        $('.contentReservation').addClass('selectedContentUser');
        //console.log('lala ' + cookie);
        break;
    case "ongletParrainage":
        $('.ongletParrainage').addClass('selectedOngletUser');
        $('.contentParrainage').addClass('selectedContentUser');
        //console.log('lala ' + cookie);
        break;
    case "ongletInformation":
        $('.ongletInformation').addClass('selectedOngletUser');
        $('.contentInformation').addClass('selectedContentUser');
        //console.log('lala ' + cookie);
        break;
    default : 
        $('.ongletInformation').addClass('selectedOngletUser');
        $('.contentInformation').addClass('selectedContentUser');
        break;

}


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

$body.on('click', '.ongletVerresOffert', function(){
  $('.contentBackOffre').show();
  $('.contentBackparrainage').hide();
});

$body.on('click', '.ongletVerresParrainage', function(){
  $('.contentBackparrainage').show();
    $('.contentBackOffre').hide();
});

/******** Mon compte BB********/

$('body').on('click','.generalBO',function(){
  $('.contentFactureBO').hide();
  $('.contentBarmanBO').hide();
  $('.contentModifBO').hide();
  $('.contentGeneralBO').show();
  heightSuperInfoBar();
});

$('body').on('click','.factureBO',function(){
  $('.contentGeneralBO').hide();
  $('.contentBarmanBO').hide();
  $('.contentModifBO').hide();
  $('.contentFactureBO').show();
  heightSuperInfoBar();
});

$('body').on('click','.showFactureBO',function(){
  $('.contentGeneralBO').hide();
  $('.contentBarmanBO').hide();
  $('.contentModifBO').hide();
  $('.contentFactureBO').show();
  $('.ongletOptionPro').removeClass('ongletselect');
  $('.factureBO').addClass('ongletselect');
  heightSuperInfoBar();
});

$('body').on('click','.barmanBO',function(){
  $('.contentGeneralBO').hide();
  $('.contentFactureBO').hide();
  $('.contentModifBO').hide();
  $('.contentBarmanBO').show();
  heightSuperInfoBar();
});

$('body').on('click','.ModifBO',function(){
  $('.contentGeneralBO').hide();
  $('.contentFactureBO').hide();
  $('.contentBarmanBO').hide();
  $('.contentModifBO').show();
  heightSuperInfoBar();
});

$body.on('click','.closeMesOptionEnCours',function(){
  var dataGenre = $(this).parentsUntil($('.JS-contentMesOptions')).find('.dataMiseEnAvant').data("genre")
  var dataDate = $(this).parentsUntil($('.JS-contentMesOptions')).find('.dataDate').data("date");
  var dataPrix = $(this).parentsUntil($('.JS-contentMesOptions')).find(".dataPrix").data("prix");
  var dataTotal = $(this).parentsUntil($('.JS-contentMesOptions')).find(".dataTotal").data("total");

  if (dataGenre == "carte") {
    $.ajax( {
        type: 'GET',
        url: Routing.generate('remove_carte_abo'),
    } );
  };
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
        // '<div class="col-xs-4 col-sm-4 col-md-4 noPadding">'+
        //   '<p>'+ dataPrix +'€/Jour</p>'+
        // '</div>'+
        // '<div class="col-xs-4 col-sm-4 col-md-4 noPadding">'+
        //   '<p>' + dataTotal +'€</p>'+
        // '</div>'+
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

$(document).on({
    mouseenter: function(){
      openTicketPromotion();
    },
    mouseleave: function(){
      closeTicketPromotion();
    }
}, '.JS-ticket');

function openTicketPromotion(){
  $(".ticket .ticketBarTop").stop(true,false).animate({
        marginTop: "-10px"
    }, 300);
  $(".ticket .ticketPromotion").stop(true,false).animate({
            marginTop: "0px"
        }, 300);
  $('.ticket .ticketPromotion').css("display" , "block");
}

function closeTicketPromotion(){
  $(".ticket .ticketBarTop").stop(true,false).animate({
            marginTop: "0px"
        }, 300);
  $(".ticket .ticketPromotion").stop(true,false).animate({
            marginTop: "-42px"
        }, 300);
  setTimeout(function() {  
    $('.ticket .ticketPromotion').css("display" , "none");
  },300);
}





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
  closeConfirmationReservation();
});


$('body').on('click','.voirMaConfirmationDone',function(){
  confirmationReservation();
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
  $("body").on('mouseenter', '.barInList', function(){
     $(this).find('.hoverShadow').stop(true,true).fadeIn(400);
     $(this).find('.shadowbarInList p.shadowNote').css('margin-top', '6px');
     $(this).find('.barInListHighlight .shadowbarInList p.shadowNote').css('margin-top', '2px');
   });
 $("body").on('mouseleave', '.barInList', function(){
     $(this).find('.hoverShadow').stop(true,true).fadeOut(10);
     $(this).find('.shadowbarInList p.shadowNote').css('margin-top', '10px');
   });

   $("body").on('mouseenter', '.barInListHighlight', function(){
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
$(document).on( 'click', '.JS-obtenirPromo', function() {
  var promoId = $(this).data('bar-id');
  var valuePromo = $(this).data('valuepromo');
  $.ajax( {
      url: Routing.generate('get_promo', {id: promoId, value: valuePromo}),
      data: 'json',
      success: function (data) {
        $('.testSuccess').html(data);
        $('.ticket .ticketBarTop').css('background-color', '#ea9026');
        $('.ticket .ticketBarTop h2').hide();
        $('.ticket .ticketBarTop h3').hide();
        $('.ticket .ticketBarTop p').html('');
        $('.ticket .ticketBarTop p').append('VOIR MA RESERVATION');
        $('.ticket p.obtenirPromo').html('');
        $('.ticket p.obtenirPromo').append('POUR AUJOUR\'HUI');
        $('.ticket').find('[data-bar-id]').attr( 'data-bar-id', null );
        $('.JS-ticket').removeClass('JS-ticket');
        $('.JS-promoBox').addClass('voirMaConfirmationDone');
        $('.JS-obtenirPromo').removeClass('JS-obtenirPromo');
        closeTicketPromotion();
        confirmationReservation();

      },
      error: function(data){
        $('.testSuccess').html(data);
        alert("Vous n'avez pas votre promotion");
      }
  } );
});

function confirmationReservation(){
    $('.confirmationReservation').show();
    $('.checkConfirmation').addClass('open-checkConfirmation');
    setTimeout(function(){
        $('.contentConfirmation').addClass('open-contentConfirmation');
    },300);

    setTimeout(function(){
        $('.textContentConfirmation').addClass('open-textContentConfirmation');
    },600);  

    setTimeout(function(){
        closeConfirmationReservation()
    },8000); 

}

function closeConfirmationReservation(){
    
  
    $('.textContentConfirmation').removeClass('open-textContentConfirmation');

    setTimeout(function(){
        $('.contentConfirmation').removeClass('open-contentConfirmation');
    },200); 

    setTimeout(function(){
        $('.checkConfirmation').removeClass('open-checkConfirmation');
    },600); 

    setTimeout(function(){
        $('.confirmationReservation').hide();
    },1000);  
}


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

$('.contactUsBO').on('click', function() {
  $(this).parentsUntil($('.contentOptionBar')).find('.changeMyAbonnement').addClass('open-changerMyAbonnement');
});

$('body').on('click','.closetypeFormule',function(){
  $('.changeMyAbonnement').removeClass('open-changerMyAbonnement');
});

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
      annee = annee - 1;
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

var conceptName = $('.promotion').find(":selected").text();

// $('.addBarman').on('click', function() {
//   $(this).parent().find('.formBarman').addClass('open-formBarman');
// });

$('.deleteBarman').on('click', function(){
  var $this = $(this);
  var id = $this.data('id');

  var confirmation = confirm("Êtes-vous sûre de supprimer ce barman ?");

  if(confirmation){
      $.ajax( {
            type: 'POST',
            url: Routing.generate('barman_delete', { 'id': id}),
            success: function (data) {
              $this.parentsUntil($('.listBarman')).hide();
              alert(data);
            }
        });
  }
});

$('.ticketVerreValidate').on('click', function(){
  var code = $(this).parent().find('.codeValue').val();
  $.ajax( {
        type: 'POST',
        url: Routing.generate('validate_code', { 'code': code }),
        success: function (data) {
          if (data.msg == 'code ok') {

          var disableddates = data.weekdays;
            $( "#codeInput" ).val(code);
            $( "#datepicker" ).datepicker({ 
                minDate: 0, 
                maxDate: "+12D",
                firstDay: 1 ,
                closeText: 'Fermer',
                prevText: 'Précédent',
                nextText: 'Suivant',
                currentText: 'Aujourd\'hui',
                monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
                dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
                dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
                dayNamesMin: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
                weekHeader: 'Sem.',
                beforeShowDay: function(date){
                    var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
                    return [ disableddates.indexOf(string) == -1 ]
                },
                onSelect: function(date) {
                    $('#datepickerInput').val(date);
                    $('.popupsponsorship').hide();
                    $('.emailsponsorship').show();
                },
                dateFormat: "dd-mm-yy"
              });
            $('.forParrainage').hide();
            $('.popupsponsorship').show();
            $('.isConnexion').show();

          }
          else
            alert(data.msg);
        }
    });
});

$('#senddrink').on('click', function(){
  var mail = $('#mailToSend').val();
  var code = $('#codeInput').val();
  var date = $('#datepickerInput').val();
  $.ajax( {
        type: 'POST',
        url: Routing.generate('invite_friend', { 'mail': mail, 'date' : date, 'code': code}),
        success: function (data) {
          $('.popupsponsorship').hide();
          $('.isConnexion').hide();
          $('.emailsponsorship').hide()
          alert(data.msg);
        }
    });
});

/****GET PARRAINNAGE ****/

var images = ['1.jpg', '2.jpg', '3.jpg'];
$('.welcome').css('background-image', "url(../img/imgHome/" + images[Math.floor(Math.random() * images.length)] + ")");



/***** pro Vos offres *****/

var changeHourAutomatique = true;

$('.heure select').on('change', function(){
    // console.log($(this).data('when'));
    // console.log($(this).val());

    // var string = JSON.stringify($(this).parentsUntil('.CreationBar').find($('#cac_barbundle_bar_schedule')).attr('value'));

    // console.log(string);

    if(changeHourAutomatique){
        var days = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];

        if($(this).data('when') == 'open'){

            if($(this).parentsUntil('.servicesNewBar').find($("select[data-when='close']")).val() != ""){
                // console.log('open : ' + $(this).val() +' close : ' + $(this).parentsUntil('.servicesNewBar').find($("select[data-when='close']")).val());
                // console.log('ok les deux sont plein : last click open');

                if(confirm('Voulez vous appliquer ces horaires pour tout les jours ?')){
                    $('.servicesNewBar').find($("select[data-when='open'] option[value=" + $(this).val() + "]")).prop('selected', true);
                    $('.servicesNewBar').find($("select[data-when='close'] option[value=" + $(this).parentsUntil('.servicesNewBar').find($("select[data-when='close']")).val() + "]")).prop('selected', true);
                    
                    var hidden = $('#cac_barbundle_bar_schedule').val();
                    hidden = JSON.parse(hidden);

                    

                    for(var i=0; i<days.length; i++){
                        hidden[days[i]].close = $(this).parentsUntil('.servicesNewBar').find($("select[data-when='close']")).val();
                        hidden[days[i]].open = $(this).val();
                    }
                    
                    $('#cac_barbundle_bar_schedule').val(JSON.stringify(hidden));
                }else{
                    console.log('nope');
                }
                changeHourAutomatique = false;
            }
           
        }else{
            if($(this).parentsUntil('.servicesNewBar').find($("select[data-when='open']")).val() != ""){
                // console.log('open : ' + $(this).parentsUntil('.servicesNewBar').find($("select[data-when='open']")).val() +' close : ' + $(this).val());
                // console.log('ok les deux sont plein : last click close');
                if(confirm('Voulez vous appliquer ces horaires pour tout les jours ?')){
                    //console.log('okay');
                    $('.servicesNewBar').find($("select[data-when='close'] option[value=" + $(this).val() + "]")).prop('selected', true);
                    $('.servicesNewBar').find($("select[data-when='open'] option[value=" + $(this).parentsUntil('.servicesNewBar').find($("select[data-when='open']")).val() + "]")).prop('selected', true);
                    
                    var hidden = $('#cac_barbundle_bar_schedule').val();
                    hidden = JSON.parse(hidden);

                    

                    for(var i=0; i<days.length; i++){
                        hidden[days[i]].open = $(this).parentsUntil('.servicesNewBar').find($("select[data-when='open']")).val();
                        hidden[days[i]].close = $(this).val();
                    }
                    
                    $('#cac_barbundle_bar_schedule').val(JSON.stringify(hidden));


                }else{
                    console.log('nope');
                }
                changeHourAutomatique = false;
            }
        }
    }
    


    //console
});

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}












