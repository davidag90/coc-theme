<?php
/**
 * Template Post Type: clasificado
 *
 */

get_header();
?>

  <div id="content" class="site-content <?= bootscore_container_class(); ?> py-5 mt-4">
    <div id="primary" class="content-area">
      <div class="row">
        <div class="<?= bootscore_main_col_class(); ?>">
          <main id="main" class="site-main">
            <header class="entry-header">
              <?php the_post(); ?>
              <h1><?php the_title(); ?></h1>
            </header>

            <div class="entry-content">
              <div class="row">
                <div class="col-12 col-md-4">
                  <a href="<?= get_the_post_thumbnail_url('large'); ?>" target="_blank"><?php the_post_thumbnail(); ?></a>
                </div>
                <div class="col-12 col-md-8">
                  <p><strong>Contacto:</strong> <?= get_field('contacto'); ?> (<a href="mailto:<?= get_field('email') ?>" target="_blank"><?= get_field('correo_electronico') ?></a> - <?= get_field('telefono') ?>)</p>
                  <p><strong>Tipo de publicación:</strong> <?= get_field('modalidad'); ?></p>
                  <p><strong>Ubicación:</strong> <?= get_field('ubicacion'); ?></p>
                  <h2>Detalles</h2>
                  <?= get_field('detalles'); ?>
                </div>
              </div>
            </div>
          </main>
        </div>
        
        <?php get_sidebar(); ?>
      </div><!-- .row -->
    </div><!-- #primary -->
  </div><!-- #content -->

<?php get_footer();
