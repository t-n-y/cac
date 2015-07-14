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



var $dayOngletNewBar = $('.dayOngletNewBar');
var $promoParrainnage = $('.promoParrainnage');
var jsonBrut = $('#form_sponsorship_json').val();
var parseJson = JSON.parse(jsonBrut);

$($promoParrainnage[0]).addClass('selectedPromoParrainnage');

//récupération nombre de parrainage du premier jour
var nbParrainnageToday = parseJson["Lundi"];

$('.nbParrainnageToday').val(nbParrainnageToday.number);

$dayOngletNewBar.on('click', function(){

  //récupération nombre de parrainage du jour selectionné
  var daySelected = $(this).html();
  var nbParrainnageToday = parseJson[daySelected];
  $('.nbParrainnageToday').val(nbParrainnageToday.number);

  $dayOngletNewBar.removeClass('selectedOngletDay');
  $(this).addClass('selectedOngletDay');
  var daySelected = $(this).data("dayselected");

  $promoParrainnage.removeClass('selectedPromoParrainnage');
  $($promoParrainnage[(daySelected-1)]).addClass('selectedPromoParrainnage');
});


var myPromoOfTheDay = $('.JS-myPromoOfTheDay');
var nbMyPromoOfTheDay = myPromoOfTheDay.length;

var myHHOfTheDay = $('.JS-myHHOfTheDay');
var nbMyHHOfTheDay = myHHOfTheDay.length;

// var myHHOfTheDayBeginning = $('.JS-myHHOfTheDayBeginning');
// var nbMyHHOfTheDayBeginning = myHHOfTheDayBeginning.length;

// var myHHOfTheDayEnding = $('.JS-myHHOfTheDayEnding');
// var nbMyHHOfTheDayEnding = myHHOfTheDayEnding.length;



var goToTheRightPlace = function(nbData, data, classe){
  for(var i = 0; i < nbData; i++){

    $this = $($('.'+classe)[i]);

    $this.find('option').each(function()
    {
        if($(this).val() === $(data[i]).text()){
          $(this).prop('selected', true);
        }
    });
  }
}

goToTheRightPlace(nbMyPromoOfTheDay, myPromoOfTheDay, 'promotion-value-picker');

goToTheRightPlace(nbMyHHOfTheDay, myHHOfTheDay, 'hh-value-picker');

// goToTheRightPlace(nbMyHHOfTheDayEnding, myHHOfTheDayBeginning, 'hh-picker');

// goToTheRightPlace(nbMyHHOfTheDayEnding, myHHOfTheDayEnding, 'hh-picker');






