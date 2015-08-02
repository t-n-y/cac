$(document).ready(function(){
  $( ".validate-promo" ).on( "click", function() {
      var promoId = $(this).data('promo-id');
      var nbPersonne = $(this).data('promo-nbpersonne');
      $.ajax( {
          url: Routing.generate('validate_promo', {id: promoId, nbPersonne: nbPersonne}),
          data: 'json',
          success: function (data) {
            $('.zone-etat-'+promoId).html(data);
          }
      } );
    });
  $( ".invalidate-promo" ).on( "click", function() {
      var promoId = $(this).data('promo-id');
      var nbPersonne = $(this).data('promo-nbpersonne');
      $.ajax( {
          url: Routing.generate('invalidate_promo', {id: promoId, nbPersonne: nbPersonne}),
          data: 'json',
          success: function (data) {
            $('.zone-etat-'+promoId).html(data);
          }
      } );
    });

  $( ".mettreBarEnAvant p" ).on( "click", function() {
      var barId = $(this).data('bar-id');
      $.ajax( {
          url: Routing.generate('highlight_bar', {id: barId}),
          data: 'json',
          success: function (data) {
            if (data === "Bar non ajouté") {
              alert('La limite des bar mis en avant est atteinte');
            }
            else if(data === "Bar deja mis en avant"){
              alert('Ce bar est déja mis en avant');
            }
            else{
              alert('Bar mis en avant');
            }
          }
      } );
    });

});


/*******PAGE RETOUR OFFRE********/

var click = 0;

$('body').on("click", ".validerOffre",function(){
  $(this).parentsUntil('.allOffre').addClass('selectedOffre');
  selectedOffre('valider');
  $('p',this).addClass('offreValider');
  //$(this).parents($('.validationOffre')).children().find('.noValiderOffre').removeClass('offrePasValider');
  //$(this).parents($('.validationOffre')).children($('.noValiderOffre')).find('noValiderOffre p').addClass('prout');
  $(this).parents('.validationsOffre').children('.noValidationOffre').children().children().removeClass('offrePasValider');
  //$(this).parents('.retourVerrePromotion').children().addClass('offrePasValider');

});

$('body').on("click", ".noValiderOffre",function(){
  if (click == 0){
    alert('Un email sera envoyé au client pour savoir pourquoi il n\'est pas venu');
    click = 1;
  }
  $(this).parentsUntil('.allOffre').addClass('selectedOffre');
  selectedOffre('noValider');
  $('p',this).addClass('offrePasValider');
  $(this).parents('.validationsOffre').children('.validationOffre').children().children().removeClass('offreValider');
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
