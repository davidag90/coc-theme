jQuery(function($) {
   $(document).ready(function(){
      const capacitaciones = $('.capacitacion');

      $('.filtro-espec').click( function() {
         let especialidad = $(this).attr('coc-especialidad');
         let capacitacionesFilt = $(`.capacitacion[coc-especialidad="${especialidad}"]`);
         
         $('.filtro-espec').each(function() {
            $(this).removeClass(`btn-${$(this).attr('coc-especialidad')}`);
            $(this).addClass(`btn-outline-dark`);
         });
         
         $(this).addClass(`btn-${especialidad}`);
         
         (especialidad === 'todos') ?
         capacitaciones.fadeIn() :
         capacitaciones.fadeOut(),
         capacitacionesFilt.fadeIn();
      });
   });
});