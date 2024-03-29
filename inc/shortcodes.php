<?php
function capacitaciones_front()
{
   ob_start();

   $output = '';

   $especialidades = get_terms(array(
      'taxonomy' => 'especialidad'
   ));

   if($especialidades):
      $output .= '<div id="capacitaciones-front" class="py-5 px-4">';
         $output .= '<h2 class="mb-4 text-center display-4 fw-bold">Capacitaciones por Especialidad</h2>';

         $output .= '<div class="d-block d-md-none mb-4" id="filtros-espec-mobile">';
            $output .= '<select class="form-select">';
               $output .= '<option value="todos" selected>Todos</option>';
               foreach ($especialidades as $especialidad) {
                  $output .= '<option value="' . esc_attr($especialidad->slug) . '">' . esc_html($especialidad->name) . '</option>';
               }
            $output .='</select>'; // .form-select
         $output .= '</div>';// #filtros-espec-mobile
         $output .= '<div class="d-none d-md-flex flex-row flex-wrap justify-content-center mb-4" id="filtros-espec-desk">';
            $output .= '<button type="button" class="btn btn-sm btn-todos text-nowrap filtro-espec" coc-especialidad="todos">Todos</button>';

            foreach ($especialidades as $especialidad) {
               $output .= '<button type="button" class="btn btn-sm btn-outline-dark text-nowrap filtro-espec" coc-especialidad="' . esc_attr($especialidad->slug) . '">' . esc_html($especialidad->name) . '</button>';
            }
         $output .= '</div>'; // #filtros-espec-desk

         $output .= '<div id="app-root" class="splide mb-5">';
            $output .= '<div class="splide__track">';
               $output .= '<ul class="splide__list">';
               $output .= '</ul>'; // .splide__list
            $output .= '</div>'; // .splide__track
         $output .= '</div>'; // .splide

         $output .= '<div id="acceso-capacitaciones-full" class="d-flex justify-content-center"><a class="btn btn-secondary btn-lg" href="' . home_url() . '/capacitacion/">Ver nuestra agenda completa</a></div>';
      $output .= '</div>'; // #capacitaciones-front
   endif;

   echo $output;
   return ob_get_clean();
}

add_shortcode('capacitaciones-front', 'capacitaciones_front');
