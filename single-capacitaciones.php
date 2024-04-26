<?php

/**
 * Template Post Type: post
 *
 * @version 5.3.1
 */

get_header();
?>
<?php the_post();

// Info de la Capacitación
$terms = get_the_terms(get_the_ID(), 'especialidad');
$especialidad_name = $terms[0]->name;
$especialidad_slug = $terms[0]->slug;
$producto_relacionado = get_field('producto_relacionado');
$tipo_capacitacion = get_field('tipo_capacitacion');
$img_destacada = get_the_post_thumbnail_url();
$dictantes = get_field('dictantes');
$curriculum_dictante = get_field('curriculum_dictante');
$dictantes_img = get_field('dictantes_img');
$codictantes = get_field('co_dictantes');
$dictantes_invitados = get_field('dictantes_invitados');
$tipo_inscripcion = get_field('tipo_inscripcion');
$aranceles = get_field('aranceles');
$fecha_inicio = get_field('fecha_inicio');
$horarios = get_field('horarios');
$sesiones = get_field('sesiones');
$horas = get_field('horas');
$certificaciones = get_field('certificaciones');
$detalles_adicionales = get_field('detalles_adicionales');
$objetivos = get_field('objetivos');
$temario = get_field('temario');
$esquema_actividad = get_field('esquema_actividad');
$listado_materiales = get_field('listado_materiales');
$beneficios = get_field('beneficios');
$sponsors = get_field('sponsors');
$extra = get_field('extra');
$espec_rel = get_field('especialidades_relativas');
$espec_rel_arr = [$especialidad_slug];

foreach ($espec_rel as $especialidad_relativa) {
   $espec_rel_arr[] = $especialidad_relativa->slug;
}

?>

<header id="header-capacitacion" class="bg-<?php echo $especialidad_slug ?> bg-header-<?php echo $especialidad_slug ?> border-<?php echo $especialidad_slug ?>">
   <div class="container">
      <div class="row">
         <div class="col-md-8">
            <div class="detalles-header d-flex flex-column justify-content-end pb-4 text-light">
               <h1 class="mb-0"><?php the_title(); ?></h1>
               <p class="subtitulo-capacitacion mb-0 fs-5">
                  <?php echo $tipo_capacitacion; ?> en <strong><?php echo $especialidad_name; ?></strong>
               </p>
            </div><!-- .detalles-header -->
         </div><!-- .col -->
      </div><!-- .row -->
   </div><!-- .container -->
</header>         

<div id="content" class="site-content <?= bootscore_container_class(); ?>">
   <div id="primary" class="content-area">
      <div class="row">
         <div class="col-12 col-md-8">
            <main id="main" class="site-main">
               <div class="entry-content pt-5">
                  <div class="row mb-5">
                     <div class="col-md-5 col-lg-4 col-xl-3">
                        <img src="<?php echo $dictantes_img ?>" class="w-100 mb-4" />
                     </div><!-- .col-lg-4 -->
                     <div class="col-md-7 col-lg-8 col-xl-9">
                        <div class="d-flex flex-column">
                           <div class="dictantes mb-4">
                              <?php echo $dictantes ?>
                              <?php if (!empty($curriculum_dictante)) : ?>
                                 <a class="btn btn-primary" href="<?php echo $curriculum_dictante ?>" target="_blank" rel="noopener noreferrer">Ver curriculum</a>
                              <?php endif; ?>
                           </div><!-- .dictantes -->

                           <?php if (!empty($co_dictantes)) : ?>
                              <div class="co-dictantes">
                                 <?php echo $co_dictantes; ?>
                              </div><!-- .co-dictantes -->
                           <?php endif; ?>

                           <?php if (!empty($dictantes_invitados)) : ?>
                              <div class="dictantes-invitados">
                                 <?php echo $dictantes_invitados; ?>
                              </div><!-- .dictantes-invitados -->
                           <?php endif; ?>
                        </div><!-- .d-flex -->
                     </div><!-- .col-lg-8 -->
                  </div><!-- .row -->

                  <hr class="m-0">

                  <div class="row">
                     <div class="col-12">
                        <div class="highlights pt-5">
                           <div class="highlight d-flex flex-column mb-5 px-3 justify-content-start align-items-center text-center">
                              <i class="fa-solid fa-calendar-days d-block fa-4x mb-3 text-secondary"></i>
                              <h4 class="mb-1 text-secondary">Fecha de Inicio</h4>
                              <p><?php echo $fecha_inicio; ?></p>
                           </div>

                           <div class="highlight d-flex flex-column mb-5 px-3 justify-content-start align-items-center text-center">
                              <i class="fa-solid fa-clock d-block fa-4x mb-3 text-secondary"></i>
                              <h4 class="mb-1 text-secondary">Horarios</h4>
                              <?php echo $horarios; ?>
                           </div>

                           <div class="highlight d-flex flex-column mb-5 px-3 justify-content-start align-items-center text-center">
                              <i class="fa-solid fa-users-between-lines d-block fa-4x mb-3 text-secondary"></i>
                              <h4 class="mb-1 text-secondary">Sesiones</h4>
                              <p><?php echo $sesiones; ?> sesiones</p>
                              <p><?php echo $horas; ?> horas</p>
                           </div>
                        </div>
                     </div>
                  </div>

                  <hr class="m-0">

                  <div class="row mt-5">
                     <div class="col-12">
                        <div class="detalles-adicionales">
                           <?php echo $detalles_adicionales; ?>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-12">
                        <div class="detalles-pedagogicos py-5">
                           <div class="accordion" id="acordeon-detalles">
                              <?php if (!empty($objetivos)) : ?>
                                 <div class="accordion-item">
                                    <h2 class="accordion-header" id="objetivos-enc">
                                       <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#objetivos-collapse" aria-expanded="false" aria-controls="objetivos-collapse">Objetivos</button>
                                    </h2><!-- .accordion-header -->
                                    <div id="objetivos-collapse" class="accordion-collapse collapse" aria-labelledby="objetivos-enc" data-bs-parent="#acordeon-detalles">
                                       <div class="accordion-body"><?php echo $objetivos; ?></div>
                                    </div><!-- .accordion-collapse -->
                                 </div><!-- .accordion-item -->
                              <?php endif; ?>

                              <?php if (!empty($temario)) : ?>
                                 <div class="accordion-item">
                                    <h2 class="accordion-header" id="temario-enc">
                                       <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#temario-collapse" aria-expanded="false" aria-controls="temario-collapse">Temario</button>
                                    </h2><!-- .accordion-header -->
                                    <div id="temario-collapse" class="accordion-collapse collapse" aria-labelledby="temario-enc" data-bs-parent="#acordeon-detalles">
                                       <div class="accordion-body"><?php echo $temario; ?></div>
                                    </div><!-- .accordion-collapse -->
                                 </div><!-- .accordion-item -->
                              <?php endif; ?>

                              <?php if (!empty($esquema_actividad)) : ?>
                                 <div class="accordion-item">
                                    <h2 class="accordion-header" id="esquema-actividad-enc">
                                       <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#esquema-actividad-collapse" aria-expanded="false" aria-controls="esquema-actividad-collapse">Esquema de Actividad</button>
                                    </h2><!-- .accordion-header -->
                                    <div id="esquema-actividad-collapse" class="accordion-collapse collapse" aria-labelledby="esquema-actividad-enc" data-bs-parent="#acordeon-detalles">
                                       <div class="accordion-body"><?php echo $esquema_actividad; ?></div>
                                    </div><!-- .accordion-collapse -->
                                 </div><!-- .accordion-item -->
                              <?php endif; ?>

                              <?php if (!empty($listado_materiales)) : ?>
                                 <div class="accordion-item">
                                    <h2 class="accordion-header" id="listado-materiales-enc">
                                       <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#listado-materiales-collapse" aria-expanded="false" aria-controls="listado-materiales-collapse">Listado de Materiales</button>
                                    </h2><!-- .accordion-header -->
                                    <div id="listado-materiales-collapse" class="accordion-collapse collapse" aria-labelledby="listado-materiales-enc" data-bs-parent="#acordeon-detalles">
                                       <div class="accordion-body"><?php echo $listado_materiales; ?></div>
                                    </div><!-- .accordion-collapse -->
                                 </div><!-- .accordion-item -->
                              <?php endif; ?>
                           </div><!-- #acordeon-detalles -->
                        </div><!-- .detalles-pedagogicos -->
                     </div><!-- .col-12 -->
                  </div><!-- .row -->

                  <?php if (!empty($beneficios)) : ?>
                     <div class="row">
                        <div class="col-12">
                           <div id="beneficios">
                              <?php echo $beneficios; ?>
                           </div><!-- #beneficios -->
                        </div><!-- .col-12 -->
                     </div><!-- .row -->
                  <?php endif; ?>

                  <?php if (!empty($sponsors)) : ?>
                     <div class="row">
                        <div class="col-12">
                           <div id="apoyos">
                              <h3 class="mb-3">Apoyan esta capacitación:</h3>
                              <?php echo $sponsors; ?>
                           </div><!-- #apoyos -->
                        </div><!-- .col-12 -->
                     </div><!-- .row -->
                  <?php endif; ?>

                  <?php if (!empty($extra)) : ?>
                     <div class="row">
                        <div class="col-12">
                           <div id="extra">
                              <?php echo $extra; ?>
                           </div><!-- #extra -->
                        </div><!-- .col-12 -->
                     </div><!-- .row -->
                  <?php endif; ?>
               </div><!-- .entry-content -->
            </main><!-- #main -->
         </div><!-- .col-md-8 -->

         <div class="col-12 col-md-4">
            <aside id="detalles-inscripcion" class="bg-light border shadow-sm rounded overflow-hidden mb-4">
               <img src="<?php echo $img_destacada; ?>" class="mb-4">
               <div class="botonera mb-4 px-4">
                  <a href="<?php print(!empty($producto_relacionado) ? home_url() . '/checkout/?add-to-cart=' . strval($producto_relacionado->ID) : 'https://wa.me/3512373661'); ?>" class="btn btn-warning w-100 py-2 link-light mb-2"><?php echo $tipo_inscripcion ?> &rarr;</a>
                  <a href="#" class="btn btn-success w-100 py-2"><i class="fa-brands fa-whatsapp"></i> <span class="d-none d-lg-inline">Contactar por </span>WhatsApp</a>
               </div>
               <div id="detalles-aranceles" class="px-4">
                  <h2>Aranceles</h2>
                  <div><?php echo $aranceles; ?></div>
               </div>
            </aside>
            <aside id="certificacion" class="bg-light border shadow-sm rounded overflow-hidden p-4">
               <h4 class="mb-3">Certifican esta propuesta:</h4>
               <div id="certificantes" class="d-flex flex-row justify-content-around">
                  <?php foreach ($certificaciones as $certificante) {
                     echo '<img src="' . get_stylesheet_directory_uri() . '/img/instituciones/' . $certificante . '.png" alt="' . $certificante . '">';
                  } ?>
               </div>
               <?php if(in_array('ucc', $certificaciones)): ?>
               <div id="aclaracion-ucc" class="text-center">
                  <p class="h5 bg-primary text-light p-2 mt-4 mb-2">Curso con Aval Universitario</p>
                  <p><strong>Certificación UCC opcional</strong><em> (solicitar trámite y presupuesto en Secretaría de la EPO)</em></p>
               </div>
               <?php endif;?>
            </aside>
         </div><!-- .col-md-4 -->
      </div><!-- .row -->
      
      <div class="row">
         <div class="col-12">
            <div class="width-100 bg-light bg-gradient py-5 mt-5">
               <div class="container">
                  <div class="row">
                     <div class="col">
                        <h2 class="text-center mb-4">Otras capacitaciones que podrían interesarte</h2>
                        
                        <div id="capacitaciones-sugeridas" class="mb-5">
                        <?php
                           $limite_capac = 4;

                           $capac_rel_args = array(
                              'post_type' => 'capacitaciones',
                              'posts_per_page' => $limite_capac,
                              'post__not_in' => array(get_the_ID()),
                              'tax_query' => array(
                                 'relation' => 'OR',
                                 array(
                                    'taxonomy' => 'especialidad',
                                    'field' => 'slug',
                                    'terms' => $espec_rel_arr,
                                    'operator' => 'IN'
                                 )
                              ),
                              'orderby' => 'meta_value',
                              'meta_key' => 'fecha_inicio_dateformat',
                              'meta_type' => 'DATE',
                              'order' => 'ASC'
                           );

                           $capac_rel_query = new WP_Query($capac_rel_args);

                           $capac_restantes = $limite_capac - $capac_rel_query->post_count;

                           $excluir_ids = array(get_the_ID());

                           // Mostrar los posts relacionados
                           if ($capac_rel_query->have_posts() || $capac_restantes > 0) {
                              while ($capac_rel_query->have_posts()) {
                                 $capac_rel_query->the_post();

                                 $excluir_ids[] = get_the_ID(); // Almacenar el ID del post mostrado

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

                                 echo '<div class="card border-' . esc_attr($especialidad_slug) . ' h-100 capacitacion" coc-especialidad="' . esc_attr($especialidad_slug) . '">';
                                    echo '<img class="card-img-top" src="' . esc_url($img_top) . '" alt="' . esc_attr($titulo) . '" />';
                                    echo '<div class="card-body d-flex flex-column">';
                                       echo '<p class="mb-2"><small>' . $tipo_capacitacion . ' en ' . $especialidad_nombre . '</small></p>';
                                       echo '<h4 class="card-title h6">' . esc_html($titulo) . '</h4>';
                                       echo '<p class="card-text">' . esc_html($inicio) . '</p>';
                                       echo '<a href="' . esc_url($link) . '" class="btn btn-sm btn-' . esc_attr($especialidad_slug) . ' mt-auto ms-auto me-0 text-nowrap">Más información</a>';
                                    echo '</div>'; // .card-body
                                 echo '</div>'; // .card
                              }
                              
                              if ($capac_restantes > 0) {
                                 $capac_restantes_args = array(
                                    'post_type' => 'capacitaciones',
                                    'posts_per_page' => $capac_restantes,
                                    'post__not_in' => $excluir_ids,
                                    'orderby' => 'date',
                                    'order' => 'ASC',
                                 );

                                 $capac_restantes_query = new WP_Query($capac_restantes_args);

                                 if($capac_restantes_query->have_posts()) {
                                    while ($capac_restantes_query->have_posts()) {
                                       $capac_restantes_query->the_post();

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

                                       echo '<div class="card border-' . esc_attr($especialidad_slug) . ' h-100 capacitacion" coc-especialidad="' . esc_attr($especialidad_slug) . '">';
                                          echo '<img class="card-img-top" src="' . esc_url($img_top) . '" alt="' . esc_attr($titulo) . '" />';
                                          echo '<div class="card-body d-flex flex-column">';
                                             echo '<p class="mb-2"><small>' . $tipo_capacitacion . ' en ' . $especialidad_nombre . '</small></p>';
                                             echo '<h4 class="card-title h6">' . esc_html($titulo) . '</h4>';
                                             echo '<p class="card-text">' . esc_html($inicio) . '</p>';
                                             echo '<a href="' . esc_url($link) . '" class="btn btn-sm btn-' . esc_attr($especialidad_slug) . ' mt-auto ms-auto me-0 text-nowrap">Más información</a>';
                                          echo '</div>'; // .card-body
                                       echo '</div>'; // .card
                                    }
                                 }
                              }
                              wp_reset_postdata();
                           } else {
                              // Si no se encuentran posts relacionados
                              echo 'No se encontraron posts relacionados.';
                           } ?>
                        </div><!-- #capacitaciones-sugeridas -->
                        
                        <div id="acceso-capacitaciones-full" class="d-flex justify-content-center">
                           <a class="btn btn-secondary btn-lg" href="<?= home_url() ?>/capacitacion/especialidades">Ver nuestra agenda completa</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div><!-- #primary -->
</div><!-- #content -->

<?php
get_footer();
