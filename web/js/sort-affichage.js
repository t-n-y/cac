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
    $( ".menuHeaderList .hottest" ).on( "click", function() {
        $.ajax( {
            type: 'GET',
            url: Routing.generate('sortByDate'),
            data: 'json',
            success: function (data) {
              $('.barList').html(data);
            }
        } );
    });
    $( ".menuHeaderList .best" ).on( "click", function() {
        $.ajax( {
            type: 'GET',
            url: Routing.generate('sortByBest'),
            data: 'json',
            success: function (data) {
              $('.barList').html(data);
            }
        } );
    });
});



