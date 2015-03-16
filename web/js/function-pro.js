$(document).ready(function(){
  $( ".validate-promo" ).on( "click", function() {
      var promoId = $(this).data('promo-id');
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


/*******PAGE RETOUR OFFRE********/

var click = 0;

$('body').on("click", ".validerOffre",function(){
  $(this).parentsUntil('.allOffre').addClass('selectedOffre');
  selectedOffre('valider');
});

$('body').on("click", ".noValiderOffre",function(){
  if (click == 0){
    alert('En annulant ce verre on est au courant');
    click = 1;
  }
  $(this).parentsUntil('.allOffre').addClass('selectedOffre');
  selectedOffre('noValider');
});

function selectedOffre(option){
  if(option == 'valider'){
    if($('.retourOffre').hasClass('selectedOffre')){
      $('.selectedOffre .retourVerrePromotion').addClass('offreValide');
      $('.selectedOffre .retourVerrePromotion').removeClass('offreNonValide');
    }
  }

  if(option == 'noValider'){
    if($('.retourOffre').hasClass('selectedOffre')){
      $('.selectedOffre .retourVerrePromotion').addClass('offreNonValide');
      $('.selectedOffre .retourVerrePromotion').removeClass('offreValide');
    }
  }

  $('.selectedOffre').removeClass('selectedOffre');
}
