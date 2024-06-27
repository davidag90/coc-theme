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
              <?php get_the_post_thumbnail(); ?>
              <?= get_field('detalles'); ?>
            </div>
          </main>
        </div>
        
        <?php get_sidebar(); ?>
      </div><!-- .row -->
    </div><!-- #primary -->
  </div><!-- #content -->

<?php get_footer();
