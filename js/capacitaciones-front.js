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

      const splideCapacitaciones = new Splide( '.splide', {
         type: 'slide',
         mediaQuery: 'min',
         gap: '1rem',
         padding: '1rem',
         pagination: false,
         breakpoints: {
            0: {
               perPage: 1,
               perMove: 1
            },
            576: {
               perPage: 2,
               perMove: 1
            },
            768: {
               perPage: 3,
               perMove: 1
            },
            1200: {
               perPage: 4,
               perMove: 1
            }
         }
      });

      splideCapacitaciones.mount();
   });
});

