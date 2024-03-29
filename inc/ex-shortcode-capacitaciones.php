<?php
$especialidades = get_terms(array(
   'taxonomy' => 'especialidad'
));

if ($especialidades) {
   $output .= '<div id="capacitaciones-front" class="py-5">';
      $output .= '<h2 class="mb-4 text-center display-4 fw-bold">Capacitaciones por Especialidad</h2>';

      $output .= '<div class="d-flex flex-row flex-wrap justify-content-center mb-4" id="filtros-espec">';
         $output .= '<button type="button" class="btn btn-sm btn-todos text-nowrap filtro-espec" coc-especialidad="todos">Todos</button>';

         foreach ($especialidades as $especialidad) {
            $output .= '<button type="button" class="btn btn-sm btn-outline-dark text-nowrap filtro-espec" coc-especialidad="' . esc_attr($especialidad->slug) . '">' . esc_html($especialidad->name) . '</button>';
         }
      $output .= '</div>'; // #filtros-espec

      $args = array(
         'post_type' => 'capacitacion'
      );

      $query = new WP_Query($args);

      if ($query->have_posts()) {
         $output .= '<div id="capacitaciones" class="splide mb-4">';
            $output .= '<div class="splide__track">';
               $output .= '<ul class="splide__list">';
                  while ($query->have_posts()) {
                     $query->the_post();

                     $img_top = get_the_post_thumbnail_url();
                     $titulo = get_the_title();
                     $inicio = get_field('fecha_inicio');
                     $link = get_the_permalink();
                     
                     $terms = get_the_terms(get_the_ID(), 'especialidad');
                     $especialidad_slug = '';
                     $especialidad_nombre = '';
                     if ($terms && !is_wp_error($terms)) {
                        $especialidad_slug = $terms[0]->slug;
                        $especialidad_nombre = $terms[0]->name;
                     }

                     $tipo_capacitacion = get_field('tipo_capacitacion');

                     $output .= '<li class="splide__slide">';
                        $output .= '<div class="card border-' . esc_attr($especialidad_slug) . ' h-100 capacitacion" coc-especialidad="' . esc_attr($especialidad_slug) . '">';
                           $output .= '<img class="card-img-top" src="' . esc_url($img_top) . '" alt="' . esc_attr($titulo) . '" />';
                           $output .= '<div class="card-body d-flex flex-column">';
                              $output .= '<p class="mb-2"><small>' . $tipo_capacitacion . ' en ' . $especialidad_nombre . '</small></p>';
                              $output .= '<h4 class="card-title h6">' . esc_html($titulo) . '</h4>';
                              $output .= '<p class="card-text">' . esc_html($inicio) . '</p>';
                              $output .= '<a href="' . esc_url($link) . '" class="btn btn-sm btn-' . esc_attr($especialidad_slug) . ' mt-auto ms-auto me-0 text-nowrap">Más información</a>';
                           $output .= '</div>'; // .card-body
                        $output .= '</div>'; // .card
                     $output .= '</li>'; // .splide__slide
                  }
               $output .= '</ul>'; // .splide__list
            $output .= '</div>'; // .splide__track
         $output .= '</div>'; // #capacitaciones
      } else {
         $output .= '<p>No hay capacitaciones disponibles.</p>';
      }
   
      $output .= '<div id="acceso-capacitaciones-full" class="d-flex justify-content-center"><a class="btn btn-secondary btn-lg" href="' . home_url() . '/capacitacion/">Ver nuestra agenda completa</a></div>';
   $output .= '</div>'; // #capacitaciones-front

   wp_reset_postdata();
} else {
   $output .= '<p>No hay especialidades disponibles.</p>';
}