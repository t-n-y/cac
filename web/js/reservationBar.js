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
	        success: function (data) {

	        	//data.weekdays = ['Lundi'];
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

							madate = madate.split("-");
							var dateBack = madate[1] + "-" + madate[2] + "-" + madate[4];
							var dateFront = madate[0] + " " + madate[1] + " " + madate[3];

							$('.JS-obtenirPromo').attr('data-dateReservation', dateBack);
							$('.choiceReservationDate').html(dateFront);

		                },
		                beforeShowDay: /*function(date){
		                    var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
		                    console.log([ disableddates.indexOf(string)]) ;
		                    return [ disableddates.indexOf(string) == -1]
		                }*/
		               
		                
		                function(date) {
		                	 

					      var day = date.getDay();
					      //console.log(day);

					      
					 //      if (data.weekdays != 0){
						//       for(var i = 0; i < data.weekdays.length; i++){
						//       	switch (data.weekdays[i]) {
						// 		    case "Dimanche":
						// 		        data.weekdays[i] = 0;
						// 		        break;
						// 		    case "Lundi":
						// 		        data.weekdays[i] = 1;
						// 		        break;
						// 		    case "Mardi":
						// 		        data.weekdays[i] = 2;
						// 		        break;
						// 		    case "Mercredi":
						// 		        data.weekdays[i] = 3;
						// 		        break;
						// 		    case "Jeudi":
						// 		        data.weekdays[i] = 4;
						// 		        break;
						// 		    case "Vendredi":
						// 		        data.weekdays[i] = 5;
						// 		        break;
						// 		    case "Samedi":
						// 		        data.weekdays[i] = 6;
						// 		        break;
						// 		}
						// 	  }
						// }
						// console.log(data.weekdays);
						// console.log(data.weekdays.length);

						switch (data.weekdays.length) {
							    case 1:
							        return [(day != data.weekdays[0])];
							        break;
							    case 2:
							        return [(day != data.weekdays[0] && day != data.weekdays[1])];
							        break;
							    case 3:
							        return [(day != data.weekdays[0] && day != data.weekdays[1] && day != data.weekdays[2])];
							        break;
							    case 4:
							        return [(day != data.weekdays[0] && day != data.weekdays[1] && day != data.weekdays[2] && day != data.weekdays[3])];
							        break;
							    case 5:
							        return [(day != data.weekdays[0] && day != data.weekdays[1] && day != data.weekdays[2] && day != data.weekdays[3] && day != data.weekdays[4])];
							        break;
							    case 6:
							        return [(day != data.weekdays[0] && day != data.weekdays[1] && day != data.weekdays[2] && day != data.weekdays[3] && day != data.weekdays[4] && day != data.weekdays[5])];
							        break;
							    case 7:
							        return [(day != data.weekdays[0] && day != data.weekdays[1] && day != data.weekdays[2] && day != data.weekdays[3] && day != data.weekdays[4] && day != data.weekdays[5] && day != data.weekdays[6])];
							        break;
							    default : return [(day != 7)];
							}					      
					    },
		                dateFormat: "DD-dd-mm-MM-yy"});
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





