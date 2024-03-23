jQuery(function($) {
   $(document).ready(function(){
      const capacitaciones = $('.capacitacion');

      $('.filtro-espec').click( function() {
         let especialidad = $(this).attr('coc-especialidad');
         
         $('.filtro-espec').each(function() {
            $(this).removeClass(`btn-${$(this).attr('coc-especialidad')}`);
            $(this).addClass(`btn-outline-dark`);
         });
         
         $(this).addClass(`btn-${especialidad}`);
         
         if(especialidad === 'todos') {
            setTimeout( () => {
               $('.capacitacion').show();
               $('.capacitacion').css('opacity', '1');
            }, 250);
         } else {
            $('.capacitacion').css('opacity', 0);
            setTimeout( () => {
               $('.capacitacion').hide();

            }, 250);
            
            setTimeout( () => {
               $(`.capacitacion[coc-especialidad="${especialidad}"]`).show();
               $(`.capacitacion[coc-especialidad="${especialidad}"]`).css('opacity', '1');
            }, 250);
         }
      });
   });
});