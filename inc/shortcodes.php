<?php
function capacitaciones_front() {
   ob_start();

   $fechaHoy = date('Ymd');

   $args = array(
      'post_type' => 'capacitaciones',
      'posts_per_page' => -1, // Retrieve all posts
      'meta_query' => array(
         array(
               'key' => 'fecha_inicio_dateformat',
               'value' => $fechaHoy,
               'compare' => '>',
               'type' => 'DATE',
         ),
      ),
      'tax_query' => array(
         array(
               'taxonomy' => 'especialidad',
               'field' => 'slug',
               'operator' => 'EXISTS',
         ),
      ),
   );

   $query = new WP_Query($args);
   
   $slugEspecialidades = [];

   if($query->have_posts()) {
      while($query->have_posts()) {
         $query->the_post();

         $terms = get_the_terms($query->post, 'especialidad');

         foreach ($terms as $term) {
            $slugEspecialidades[] = $term->slug;
         }
      }
   }

   wp_reset_postdata();

   $slugEspecialidadesFilt = array_unique($slugEspecialidades, SORT_REGULAR);

   sort($slugEspecialidadesFilt);

   if($slugEspecialidadesFilt):
      echo '<div id="capacitaciones-front" class="py-5 px-4">';
         echo '<h2 class="mb-4 text-center display-4 fw-bold">Capacitaciones por Especialidad</h2>';

         echo '<div class="d-block d-md-none mb-4" id="filtros-espec-mobile">';
            echo '<select class="form-select">';
               echo '<option value="todos" selected>Todos</option>';
               foreach ($slugEspecialidadesFilt as $slugEspecialidad) {
                  $especialidad = get_term_by('slug', $slugEspecialidad, 'especialidad');
                  echo '<option value="' . esc_attr($especialidad->slug) . '">' . esc_html($especialidad->name) . '</option>';
               }
            echo '</select>'; // .form-select
         echo '</div>'; // #filtros-espec-mobile
         echo '<div class="d-none d-md-flex flex-row flex-wrap justify-content-center mb-4" id="filtros-espec-desk">';
            echo '<button type="button" class="btn btn-sm btn-todos text-nowrap filtro-espec" coc-especialidad="todos">Todos</button>';

            foreach ($slugEspecialidadesFilt as $slugEspecialidad) {
               $especialidad = get_term_by('slug', $slugEspecialidad, 'especialidad');
               echo '<button type="button" class="btn btn-sm btn-outline-dark text-nowrap filtro-espec" coc-especialidad="' . esc_attr($especialidad->slug) . '">' . esc_html($especialidad->name) . '</button>';
            }
         echo '</div>'; // #filtros-espec-desk

         echo '<div id="app-root" class="splide mb-5">';
            echo '<div class="splide__track">';
               echo '<ul class="splide__list">';
               echo '</ul>'; // .splide__list
            echo '</div>'; // .splide__track
         echo '</div>'; // .splide

         echo '<div id="acceso-capacitaciones-full" class="d-flex justify-content-center">';
            echo '<a class="btn btn-secondary btn-lg" href="' . home_url() . '/capacitacion/especialidades">Ver nuestra agenda completa</a>';
         echo '</div>';
      echo '</div>'; // #capacitaciones-front
   endif;

   return ob_get_clean();
}

add_shortcode('capacitaciones-front', 'capacitaciones_front');

function capacitaciones_inside() {
   ob_start();

   $fechaHoy = date('Ymd');

   $args = array(
      'post_type' => 'capacitaciones',
      'posts_per_page' => -1, // Retrieve all posts
      'meta_query' => array(
         array(
               'key' => 'fecha_inicio_dateformat',
               'value' => $fechaHoy,
               'compare' => '>',
               'type' => 'DATE',
         ),
      ),
      'tax_query' => array(
         array(
               'taxonomy' => 'especialidad',
               'field' => 'slug',
               'operator' => 'EXISTS',
         ),
      ),
   );

   $query = new WP_Query($args);
   
   $slugEspecialidades = [];

   if($query->have_posts()) {
      while($query->have_posts()) {
         $query->the_post();

         $terms = get_the_terms($query->post, 'especialidad');

         foreach ($terms as $term) {
            $slugEspecialidades[] = $term->slug;
         }
      }
   }

   wp_reset_postdata();

   $slugEspecialidadesFilt = array_unique($slugEspecialidades, SORT_REGULAR);

   sort($slugEspecialidadesFilt);

   echo '<div id="capacitaciones-inside">';
      echo '<div class="row">';
         echo '<div class="col-12 col-md-4">';
            if($slugEspecialidadesFilt) {
               echo '<div class="d-block d-md-none mb-4" id="filtros-espec-mobile">';
                  echo '<select class="form-select">';
                     echo '<option value="todos" selected>Todos</option>';
                     foreach ($slugEspecialidadesFilt as $slugEspecialidad) {
                        $especialidad = get_term_by('slug', $slugEspecialidad, 'especialidad');
                        echo '<option value="' . esc_attr($especialidad->slug) . '">' . esc_html($especialidad->name) . '</option>';
                     }
                  echo '</select>'; // .form-select
               echo '</div>';// #filtros-espec-mobile

               echo '<div class="list-group d-none d-md-block">';
                  echo '<button class="list-group-item list-group-item-action filtro-espec active" coc-especialidad="todos">Todas</button>';
                  foreach ($slugEspecialidadesFilt as $slugEspecialidad) {
                     $especialidad = get_term_by('slug', $slugEspecialidad, 'especialidad');
                     echo '<button class="list-group-item list-group-item-action filtro-espec" coc-especialidad="' . esc_html($especialidad->slug) . '">' . esc_html($especialidad->name) . '</button>';
                  }
               echo '</div>';
            }

            echo '<a href="' . home_url() . '/capacitacion/capacitaciones-iniciadas" class="btn btn-success btn-lg d-block my-4" target="_blank"><i class="fa-solid fa-flag-checkered me-1"></i> Ver Capacitaciones Iniciadas</a>';
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

   $fechaHoy = date('Ymd');

   $args = array(
      'post_type' => 'capacitaciones',
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
               'taxonomy' => 'especialidad',
               'field' => 'slug',
               'operator' => 'EXISTS',
         ),
      ),
   );

   $query = new WP_Query($args);
   
   $slugEspecialidades = [];

   if($query->have_posts()) {
      while($query->have_posts()) {
         $query->the_post();

         $terms = get_the_terms($query->post, 'especialidad');

         foreach ($terms as $term) {
            $slugEspecialidades[] = $term->slug;
         }
      }
   }

   wp_reset_postdata();

   $slugEspecialidadesFilt = array_unique($slugEspecialidades, SORT_REGULAR);

   sort($slugEspecialidadesFilt);

   echo '<div id="capacitaciones-iniciadas">';
      echo '<div class="row">';
         echo '<div class="col-12 col-md-4">';
            echo '<div class="d-block d-md-none mb-4" id="filtros-espec-mobile">';
               echo '<select class="form-select">';
                  echo '<option value="todos" selected>Todos</option>';
                  foreach ($slugEspecialidadesFilt as $slugEspecialidad) {
                     $especialidad = get_term_by('slug', $slugEspecialidad, 'especialidad');
                     echo '<option value="' . esc_attr($especialidad->slug) . '">' . esc_html($especialidad->name) . '</option>';
                  }
               echo '</select>'; // .form-select
            echo '</div>';// #filtros-espec-mobile

            echo '<div class="list-group d-none d-md-block">';
               echo '<button class="list-group-item list-group-item-action filtro-espec active" coc-especialidad="todos">Todas</button>';
               foreach ($slugEspecialidadesFilt as $slugEspecialidad) {
                  $especialidad = get_term_by('slug', $slugEspecialidad, 'especialidad');
                  echo '<button class="list-group-item list-group-item-action filtro-espec" coc-especialidad="' . esc_html($especialidad->slug) . '">' . esc_html($especialidad->name) . '</button>';
               }
            echo '</div>';
         echo '</div>'; // .col
         echo '<div class="col-12 col-md-8">';
            echo '<div id="app-root"></div>';
         echo '</div>'; // .col
      echo '</div>'; // .row
   echo '</div>'; // #capacitaciones-inside
   
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


function mostrar_sociedades_filiales() {
   ob_start();

   echo '<div id="sociedades-filiales">';
      echo '<div class="row">';
         echo '<div class="col-12">';
            echo '<div id="app-root"></div>';
         echo '</div>'; // .col
      echo '</div>'; // .row
   echo '</div>'; // #sociedades-filiales
   
   echo '<div id="modals"></div>';
   
   return ob_get_clean();
}

add_shortcode('mostrar-sociedades-filiales', 'mostrar_sociedades_filiales');
