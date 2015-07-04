var days = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];

var hidden = $('#cac_barbundle_bar_schedule').val();
hidden = JSON.parse(hidden);
var nbBarClose = 0;

for(var i=0; i<days.length; i++){
    if(hidden[days[i]].status === "Fermé"){
        // $( '.servicesNewBar input[type=checkbox]' ).prop( "checked" );
        // break;
        nbBarClose++;
    }
}

if(nbBarClose != 7){
    console.log('chica');
    $('.closeAllBar').prop( "checked", false );
}

$("[name='my-checkbox']").bootstrapSwitch();

 $('input[name="my-checkbox"]').on('switchChange.bootstrapSwitch', function(event, state) {
    // console.log(this); // DOM element
    // console.log(event); // jQuery event
    

    if(state){
        //console.log('fermeture bar')
        $('.close-day').prop( "checked", true );

        

        

        for(var i=0; i<days.length; i++){
            hidden[days[i]].status = "Fermé"
        }
        
        $('#cac_barbundle_bar_schedule').val(JSON.stringify(hidden));
    }else{
         $('.close-day').prop( "checked", false );

         for(var i=0; i<days.length; i++){
            hidden[days[i]].status = "Ouvert"
        }
        
        $('#cac_barbundle_bar_schedule').val(JSON.stringify(hidden));
    }
    //console.log(state); // true | false
});