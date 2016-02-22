var hourReservation;
var minuteReservation;
var myHourReservation;
var verifHour = false;
var verifMinute = false;
var verifPersonne = false;

var nbPersonneReservation;

$('.hourReservation').on('change', function(){
	hourReservation = $(this).val();
	myHourReservation = hourReservation + 'h' + minuteReservation;
	hourPromotion(myHourReservation);
	verifHour = true;
});

$('.minuteReservation').on('change', function(){
	minuteReservation = $(this).val();
	myHourReservation = hourReservation + 'h' + minuteReservation;
	hourPromotion(myHourReservation);
	verifMinute = true;
});

$('.nbPersonneReservation').on('change', function(){
	nbPersonneReservation = $(this).val();
	nbPersonne(nbPersonneReservation);
});

function hourPromotion(myHourReservation){
	$('.JS-obtenirPromo').attr('data-bar-hour', myHourReservation);
}

function nbPersonne(nbPersonneReservation){
	$('.JS-obtenirPromo').attr('data-nbpersone', nbPersonneReservation);
	console.log($('.JS-obtenirPromo').attr('data-nbpersone'));
}

$('.ReserveHour').on('click', function(){
	$('.ReserveHour').fadeOut(function(){
		$('.contentSelectDayReservation').fadeIn();
		$('.avancementReservation').fadeIn();
		var idBar = $('.JS-obtenirPromo').attr('data-bar-id');


		$.ajax( {
	        type: 'POST',
	        url: Routing.generate('closed_days', { 'id': idBar }),
	        error: function (data) {
	        	var disableddates = ["21-02-2016","23-02-2016","25-02-2016"];
	        	console.log(data.weekdays);
				$(function() {
				    $( "#datepickerResa" ).datepicker({ 
		                minDate: 0, 
		                maxDate: "+40D",
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
		                onSelect: function(date) {
		                    var madate = $('#datepickerReservation').val(date)[0].value;
		                    //console.log($('#datepickerReservation').val(date));
		                    $('.contentSelectDayReservation').fadeOut(function(){
								$('.contentHourReservation').fadeIn();
							});

							$('.JS-obtenirPromo').attr('data-dateReservation', madate);

							madate = madate.split("-").join(" ");
							$('.choiceReservationDate').html(madate);

		                },
		                beforeShowDay: /*function(date){
		                    var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
		                    console.log([ disableddates.indexOf(string)]) ;
		                    return [ disableddates.indexOf(string) == -1]
		                }*/
		                function(date) {
					      var day = date.getDay();
					      //console.log(day);
					      return [(day != 1 && day != 2)];
					    },
		                dateFormat: "dd-mm-yy"});
				});
				$('.datepickerForReservation input').show().focus().hide();
	        }
	    });




		
	});
});

$('.ReservePersonne').on('click', function(){
	if(verifHour && verifMinute){
		$('.contentHourReservation').fadeOut(function(){
			$('.contentNbPersonneReservation').fadeIn();
			$('.ReservationEtapeNext').removeClass('ReservationEtapeNext').addClass('ReservationEtapeOK');
			$('.ReservationEtapetoDo').removeClass('ReservationEtapetoDo').addClass('ReservationEtapeNext');
		});

	$('.JS-choiceHour').html(hourReservation+'h'+minuteReservation);
	}else{
		alert('Veuillez choisir une heure de réservation');
	}
});

$('.JS-obtenirPromo').on('click', function(){
	$('.contentHourReservation').fadeOut(function(){
			$('.contentNbPersonneReservation').fadeIn();
			$('.ReservationEtapeNext').removeClass('ReservationEtapeNext').addClass('ReservationEtapeOK');
		});
	$('.JS-choiceNbPersonne').html(nbPersonneReservation + ' personnes');
});





