<?php
function capacitaciones_front() {
   ob_start();

   $output = '';

   $especialidades = get_terms(array(
      'taxonomy' => 'especialidad'
   ));

   if($especialidades):
      echo '<div id="capacitaciones-front" class="py-5 px-4">';
         $output .= '<h2 class="mb-4 text-center display-4 fw-bold">Capacitaciones por Especialidad</h2>';

         $output .= '<div class="d-block d-md-none mb-4" id="filtros-espec-mobile">';
            $output .= '<select class="form-select">';
               $output .= '<option value="todos" selected>Todos</option>';
               foreach ($especialidades as $especialidad) {
                  $output .= '<option value="' . esc_attr($especialidad->slug) . '">' . esc_html($especialidad->name) . '</option>';
               }
            $output .='</select>'; // .form-select
         $output .= '</div>'; // #filtros-espec-mobile
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

         $output .= '<div id="acceso-capacitaciones-full" class="d-flex justify-content-center">';
            $output .= '<a class="btn btn-secondary btn-lg" href="' . home_url() . '/capacitacion/especialidades">Ver nuestra agenda completa</a>';
         $output .= '</div>';
      $output .= '</div>'; // #capacitaciones-front
   endif;

   echo $output;
   return ob_get_clean();
}

add_shortcode('capacitaciones-front', 'capacitaciones_front');


function capacitaciones_iniciadas_front() {
   ob_start();

   $output = '';
   
   $args = array(
      'post_type'    => 'capacitaciones',
      'meta_key'     => 'fecha_inicio_dateformat',
      'meta_value'   => date( "Ymd" ), // change to how "event date" is stored
      'meta_compare' => '<',
      'order_by'     => 'meta_value',
      'order'        => 'ASC',
      'meta_type'    => 'DATE'
   );
   
   $query = new WP_Query($args);

   if($query->have_posts()) {
      $output .= '<div class="list-group">';

      while($query->have_posts()) {
         $query->the_post();
         
         $fecha_inicio_dateformat = get_field('fecha_inicio_dateformat');

         $fecha_obj = DateTime::createFromFormat('Ymd', $fecha_inicio_dateformat);

         $output .= '<a class="list-group-item list-group-item-secondary list-group-item-action" href="'. get_the_permalink() . '">' . get_the_title() . ' <small class="opacity-50">' . $fecha_obj->format('d-m-Y') . '</small></a>';
      }

      $output .= '</div>'; // .list-group
   }

   echo $output;
   
   return ob_get_clean();
}

add_shortcode('capacitaciones-iniciadas-front', 'capacitaciones_iniciadas_front');

function capacitaciones_inside() {
   ob_start();

   $especialidades = get_terms(array(
      'taxonomy' => 'especialidad'
   ));

   echo '<div id="capacitaciones-inside">';
      echo '<div class="row">';
         echo '<div class="col-12 col-md-4">';
            if($especialidades) {
               echo '<div class="d-block d-md-none mb-4" id="filtros-espec-mobile">';
                  echo '<select class="form-select">';
                     echo '<option value="todos" selected>Todos</option>';
                     foreach ($especialidades as $especialidad) {
                        echo '<option value="' . esc_attr($especialidad->slug) . '">' . esc_html($especialidad->name) . '</option>';
                     }
                  echo '</select>'; // .form-select
               echo '</div>';// #filtros-espec-mobile

               echo '<div class="list-group d-none d-md-block">';
               echo '<button class="list-group-item list-group-item-action filtro-espec active" coc-especialidad="todos">Todas</button>';
               foreach($especialidades as $especialidad) {
                  echo '<button class="list-group-item list-group-item-action filtro-espec" coc-especialidad="' . esc_html($especialidad->slug) . '">' . esc_html($especialidad->name) . '</button>';
               }
               echo '</div>';
            }
         echo '</div>'; // .col
         echo '<div class="col-12 col-md-8">';
            echo '<div id="app-root"></div>';
         echo '</div>'; // .col
      echo '</div>'; // .row
   echo '</div>'; // #capacitaciones-inside

   return ob_get_clean();
}

add_shortcode('capacitaciones-inside', 'capacitaciones_inside');


function mostrar_beneficios() {
   ob_start();
   
   $rubros = get_terms(array(
      'taxonomy' => 'rubro'
   ));

   echo '<div id="beneficios">';
      echo '<div class="row">';
         echo '<div class="col-12 col-md-4">';
            if($rubros) {
               echo '<div class="d-block d-md-none mb-4" id="filtros-rubro-mobile">';
                  echo '<select class="form-select">';
                     echo '<option value="todos" selected>Todos</option>';
                     foreach ($rubros as $rubro) {
                        echo '<option value="' . esc_attr($rubro->slug) . '">' . esc_html($rubro->name) . '</option>';
                     }
                  echo '</select>'; // .form-select
               echo '</div>';// #filtros-rubro-mobile

               echo '<div class="list-group d-none d-md-block">';
               echo '<button class="list-group-item list-group-item-action filtro-rubro active" coc-rubro="todos">Todas</button>';
               foreach($rubros as $rubro) {
                  echo '<button class="list-group-item list-group-item-action filtro-rubro" coc-rubro="' . esc_html($rubro->slug) . '">' . esc_html($rubro->name) . '</button>';
               }
               echo '</div>';
            }
         echo '</div>'; // .col
         echo '<div class="col-12 col-md-8">';
            echo '<div id="app-root"></div>';
         echo '</div>'; // .col
      echo '</div>'; // .row
   echo '</div>'; // #beneficios

   return ob_get_clean();
}

add_shortcode('mostrar-beneficios', 'mostrar_beneficios');