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



function mostrar_capacitaciones_iniciadas() {
   ob_start();

   // Get the current date
   $fechaHoy = date('Ymd');

   // Query arguments for the "capacitacion" custom post type
   $args = array(
      'post_type' => 'capacitacion',
      'posts_per_page' => -1, // Retrieve all posts
      'meta_query' => array(
         array(
               'key' => 'fecha_inicio_dateformat',
               'value' => $fechaHoy,
               'compare' => '<=',
               'type' => 'DATE',
         ),
      ),
      'tax_query' => array(
         array(
               'taxonomy' => 'especialidades',
               'field' => 'slug',
               'operator' => 'EXISTS',
         ),
      ),
   );

   
   // Execute the query
   $query = new WP_Query($args);
   
   $idsEspecialidades = [];

   if($query->have_posts()) {
      while($query->have_posts()) {
         $query->the_post();
         $especialidad = get_the_terms();
         
         $idsEspecialidades[] = $especialidad->term_id;
      }
   }

   // Remove duplicates from the term IDs array
   $idsEspecialidades = array_unique($idsEspecialidades);

   echo '<div id="capacitaciones-iniciadas">';
      echo '<div class="row">';
         echo '<div class="col-12 col-md-4">';
            echo '<div class="d-block d-md-none mb-4" id="filtros-espec-mobile">';
               echo '<select class="form-select">';
                  echo '<option value="todos" selected>Todos</option>';
                  foreach ($idsEspecialidades as $idEspecialidad) {
                     $especialidad = get_term_by('id', $idEspecialidad, 'especialidades');
                     echo '<option value="' . esc_attr($especialidad->slug) . '">' . esc_html($especialidad->name) . '</option>';
                  }
               echo '</select>'; // .form-select
            echo '</div>';// #filtros-espec-mobile

            echo '<div class="list-group d-none d-md-block">';
               echo '<button class="list-group-item list-group-item-action filtro-espec active" coc-especialidad="todos">Todas</button>';
               foreach ($idsEspecialidades as $idEspecialidad) {
                  $especialidad = get_term_by('id', $idEspecialidad, 'especialidades');
                  echo '<button class="list-group-item list-group-item-action filtro-espec" coc-especialidad="' . esc_html($especialidad->slug) . '">' . esc_html($especialidad->name) . '</button>';
               }
            echo '</div>';
         echo '</div>'; // .col
         echo '<div class="col-12 col-md-8">';
            echo '<div id="app-root"></div>';
         echo '</div>'; // .col
      echo '</div>'; // .row
   echo '</div>'; // #capacitaciones-inside
   
   // Reset the query
   wp_reset_postdata();
   
   return ob_get_clean();
}

add_shortcode('mostrar-capacitaciones-iniciadas', 'mostrar_capacitaciones_iniciadas');





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
   
   echo '<div id="modals"></div>';
   
   return ob_get_clean();
}

add_shortcode('mostrar-beneficios', 'mostrar_beneficios');
