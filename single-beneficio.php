<?php
/**
 * Template Post Type: beneficio
 *
 */

get_header();
?>

  <div id="content" class="site-content <?= bootscore_container_class(); ?> py-5 mt-4">
    <div id="primary" class="content-area">

      <!-- Hook to add something nice -->
      <?php bs_after_primary(); ?>

      <?php the_breadcrumb(); ?>

      <div class="row">
        <div class="<?= bootscore_main_col_class(); ?>">

          <main id="main" class="site-main">

            <header class="entry-header">
              <?php the_post(); ?>
              <h1><?php the_title(); ?></h1>
            </header>

            <div class="entry-content">
              <?php bootscore_post_thumbnail(); ?>
              <?= get_field('detalles'); ?>
            </div>

            <footer class="entry-footer clear-both">
              <!-- Related posts using bS Swiper plugin -->
              <?php if (function_exists('bootscore_related_posts')) bootscore_related_posts(); ?>
              
              <nav aria-label="bS page navigation">
                <ul class="pagination justify-content-center">
                  <li class="page-item">
                    <?php previous_post_link('%link'); ?>
                  </li>
                  <li class="page-item">
                    <?php next_post_link('%link'); ?>
                  </li>
                </ul>
              </nav>
            </footer>
          </main>
        </div>
        <?php get_sidebar(); ?>
      </div>
    </div>
  </div>

<?php
get_footer();
