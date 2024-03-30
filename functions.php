<?php

// style and scripts
add_action('wp_enqueue_scripts', 'bootscore_child_enqueue_styles');
function bootscore_child_enqueue_styles()
{

  // style.css
  wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

  // Compiled main.css
  $modified_bootscoreChildCss = date('YmdHi', filemtime(get_stylesheet_directory() . '/css/main.css'));
  wp_enqueue_style('main', get_stylesheet_directory_uri() . '/css/main.css', array('parent-style'), $modified_bootscoreChildCss);
}


add_action('wp_enqueue_scripts', 'custom_scripts_libs');
function custom_scripts_libs() {
  wp_enqueue_script('custom-js', get_stylesheet_directory_uri() . '/js/custom.js', false, '', true);
  if(is_front_page()):
    wp_enqueue_script('splide-js', get_stylesheet_directory_uri() . '/js/splide.min.js', array(), null, true);
    wp_enqueue_style('splide-css', get_stylesheet_directory_uri() . '/css/splide-default.min.css', array(), null);
    wp_enqueue_script('capacitaciones-front', get_stylesheet_directory_uri() . '/js/capacitaciones-front.js', false, array('splide-js'), true);
  endif;

  if(is_page('test')):
    wp_enqueue_script('test-js', get_stylesheet_directory_uri() . '/js/test.js', false, '', true);
  endif;

  function add_module_attribute($tag, $handle, $src) {
    // if not your script, do nothing and return original $tag
    if ( 'capacitaciones-front' !== $handle ) {
        return $tag;
    }
    
    // change the script tag by adding type="module" and return it.
    $tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
    
    return $tag;
  }
  
  add_filter('script_loader_tag', 'add_module_attribute', 10, 3);
}


add_action('after_setup_theme', 'include_custom_shortcodes');
function include_custom_shortcodes() {
  require_once(__DIR__ . '/inc/shortcodes.php');
}


add_action( 'widgets_init', 'manage_custom_sidebars', 11 );
// Desactiva Footer Widget 4 que viene por defecto para evitar confusiones
function manage_custom_sidebars() {
  unregister_sidebar( 'footer-2' );
  unregister_sidebar( 'footer-3' );
  unregister_sidebar( 'footer-4' );
  unregister_sidebar( 'top-footer' );
  register_sidebar(array(
    'name'          => 'Páginas internas',
    'id'            => 'sidebar-page-basic',
    'description'   => 'Sidebar para mostrar en páginas internas',
    'before_widget' => '<div class="widget bg-light border shadow-sm rounded overflow-hidden mb-4 p-3" id="widget-%1s">',
    'after_widget'  => '</div>'
  ));
}


function register_footer_menus () {
  register_nav_menus(array(
    'footer-menu-01' => 'Footer Menu 01',
    'footer-menu-02' => 'Footer Menu 02')
  );
}

add_action('after_setup_theme', 'register_footer_menus', 0);