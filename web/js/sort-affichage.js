$(document).ready(function(){
  $( ".menuHeaderList .small-price" ).on( "click", function() {
        $.ajax( {
            type: 'GET',
            url: Routing.generate('sortByPrice'),
            data: 'json',
            success: function (data) {
              $('.barList').html(data);
            }
        } );
    });
});



