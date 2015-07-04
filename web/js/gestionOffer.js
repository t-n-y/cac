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

$('.nbParrainnageToday').html(nbParrainnageToday.number);

$dayOngletNewBar.on('click', function(){

  //récupération nombre de parrainage du jour selectionné
  var daySelected = $(this).html();
  var nbParrainnageToday = parseJson[daySelected];
  $('.nbParrainnageToday').html(nbParrainnageToday.number);

  $dayOngletNewBar.removeClass('selectedOngletDay');
  $(this).addClass('selectedOngletDay');
  var daySelected = $(this).data("dayselected");

  $promoParrainnage.removeClass('selectedPromoParrainnage');
  $($promoParrainnage[(daySelected-1)]).addClass('selectedPromoParrainnage');
});