$(document).ready(function(){
  $( ".validate-promo" ).on( "click", function() {
      var promoId = $(this).data('promo-id');
      // console.log($(this).parent().parent().parent().find('.zone-etat-'+1));
      $.ajax( {
          url: Routing.generate('validate_promo', {id: promoId}),
          data: 'json',
          success: function (data) {
            $('.zone-etat-'+promoId).html(data);
          }
      } );
    });
  $( ".invalidate-promo" ).on( "click", function() {
      var promoId = $(this).data('promo-id');
      $.ajax( {
          url: Routing.generate('invalidate_promo', {id: promoId}),
          data: 'json',
          success: function (data) {
            $('.zone-etat-'+promoId).html(data);
          }
      } );
    });
});
