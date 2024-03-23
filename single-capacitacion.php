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
?>
<header id="header-capacitacion" class="bg-<?php echo $especialidad_slug ?>">
   <div class="container">
      <div class="row">
         <div class="col-md-8">
            <div class="detalles-header d-flex flex-column justify-content-end pb-4 text-light">
               <h1><?php the_title(); ?></h1>
               <p class="subtitulo-capacitacion mb-0">
                  <?php echo get_field('tipo_capacitacion'); ?> en <?php echo $especialidad_name; ?>
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
               <div class="entry-content">

               </div>
            </main>
         </div><!-- .col-md-8 -->
         <div class="col-12 col-md-4 mt-0 mt-md-n5">
            <aside id="detalles-inscripcion" class="bg-light border shadow-sm rounded-top overflow-hidden mb-4">
               <img src="<?php echo get_the_post_thumbnail_url(); ?>" class="mb-4">
               <div class="botonera mb-4 px-4">
                  <a href="#" class="btn btn-warning w-100 py-2 link-light mb-2"><?php echo get_field('tipo_inscripcion') ?> &rarr;</a>
                  <a href="#" class="btn btn-success w-100 py-2"><i class="fa-brands fa-whatsapp"></i> Contactar por WhatsApp</a>
               </div>
               <div id="detalles-aranceles" class="px-4">
                  <h2>Aranceles</h2>
                  <div>
                     <?php echo get_field('aranceles'); ?>
                  </div>
               </div>
            </aside>
            <aside id="certificacion" class="bg-light border shadow-sm rounded-top overflow-hidden p-4">
               <h4>Certifican esta propuesta:</h4>
               <?php 
                  $certificaciones = get_field('certificaciones');
                  
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
