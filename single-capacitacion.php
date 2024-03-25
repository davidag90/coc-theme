<?php

/**
 * Template Post Type: post
 *
 * @version 5.3.1
 */

get_header();
?>
<?php
the_post();
$terms = get_the_terms(get_the_ID(), 'especialidad');
$especialidad_name = $terms[0]->name;
$especialidad_slug = $terms[0]->slug;
$tipo_capacitacion = get_field('tipo_capacitacion');
$img_destacada = get_the_post_thumbnail_url();
$dictantes = get_field('dictantes');
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
?>

<header id="header-capacitacion" class="bg-<?php echo $especialidad_slug ?>">
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

<div id="content" class="site-content <?= bootscore_container_class(); ?> pb-5">
   <div id="primary" class="content-area">
      <div class="row">
         <div class="col-12 col-md-8">
            <main id="main" class="site-main">
               <div class="entry-content pt-5">
                  <div class="row">
                     <div class="col-lg-4">
                        <img src="<?php echo $dictantes_img ?>" class="w-100" />
                     </div><!-- .col-lg-4 -->
                     <div class="col-lg-8">
                        <div class="d-flex flex-column">
                           <h2>Dictantes</h2>
                           <div class="dictantes">
                              <?php echo $dictantes ?>
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
                  <hr>
                  <div class="row">
                     <div class="col-12">
                        <div class="highlights pt-4">
                           <div class="highlight d-flex flex-column justify-content-start align-items-center">
                              <i class="fa-solid fa-calendar-days d-block fa-4x mb-3 text-secondary"></i>
                              <h4 class="mb-1 text-secondary">Fecha de Inicio</h4>
                              <p><?php echo $fecha_inicio; ?></p>
                           </div>

                           <div class="highlight d-flex flex-column justify-content-start align-items-center">
                              <i class="fa-solid fa-clock d-block fa-4x mb-3 text-secondary"></i>
                              <h4 class="mb-1 text-secondary">Horarios</h4>
                              <?php echo $horarios; ?>
                           </div>

                           <div class="highlight d-flex flex-column justify-content-start align-items-center">
                              <i class="fa-solid fa-users-between-lines d-block fa-4x mb-3 text-secondary"></i>
                              <h4 class="mb-1 text-secondary">Sesiones</h4>
                              <p><?php echo $sesiones; ?> sesiones</p>
                              <p><?php echo $horas; ?> horas</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <hr>
                  <div class="row">
                     <div class="col-12">
                        <div class="detalles-adicionales pt-4">
                           <?php echo $detalles_adicionales; ?>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-12">
                        <div class="detalles-pedagogicos pt-4">
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
                           </div><!-- #acordeon-detalles -->
                        </div><!-- .detalles-pedagogicos -->
                     </div><!-- .col-12 -->
                  </div><!-- .row -->
               </div><!-- .entry-content -->
            </main><!-- #main -->
         </div><!-- .col-md-8 -->

         <div class="col-12 col-md-4 mt-0 mt-md-n5">
            <aside id="detalles-inscripcion" class="bg-light border shadow-sm rounded-top overflow-hidden mb-4">
               <img src="<?php echo $img_destacada; ?>" class="mb-4">
               <div class="botonera mb-4 px-4">
                  <a href="#" class="btn btn-warning w-100 py-2 link-light mb-2"><?php echo $tipo_inscripcion ?> &rarr;</a>
                  <a href="#" class="btn btn-success w-100 py-2"><i class="fa-brands fa-whatsapp"></i> Contactar por WhatsApp</a>
               </div>
               <div id="detalles-aranceles" class="px-4">
                  <h2>Aranceles</h2>
                  <div>
                     <?php echo $aranceles; ?>
                  </div>
               </div>
            </aside>
            <aside id="certificacion" class="bg-light border shadow-sm rounded-top overflow-hidden p-4">
               <h4>Certifican esta propuesta:</h4>
               <?php
               foreach ($certificaciones as $certificacion) {
                  echo $certificacion;
               }
               ?>
            </aside>
         </div><!-- .col-md-4 -->
      </div><!-- .row -->
   </div><!-- #primary -->
</div><!-- #content -->

<?php
get_footer();
