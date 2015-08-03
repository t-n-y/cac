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
		$('.contentHourReservation').fadeIn();
		$('.avancementReservation').fadeIn();
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





