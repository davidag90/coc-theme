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
  wp_localize_script('custom-js', 'envParams', array(
    'SITE_URL' => esc_url(home_url()) . '/'
  ));

  wp_enqueue_script('env', get_stylesheet_directory_uri() . '/js/env.js', array(), false, false);
  wp_localize_script('env', 'envParams', array(
    'SITE_URL' => esc_url(home_url()) . '/'
  ));

  if(is_front_page()):
    wp_enqueue_script('splide-js', get_stylesheet_directory_uri() . '/js/splide.min.js', array(), null, true);
    wp_enqueue_style('splide-css', get_stylesheet_directory_uri() . '/css/splide-default.min.css', array(), null);

    wp_enqueue_script('capacitaciones-front', get_stylesheet_directory_uri() . '/js/capacitaciones-front.js', false, array('env', 'splide-js'), true);
  endif;

  if(is_page('capacitaciones-iniciadas')):
    wp_enqueue_script('capacitaciones-iniciadas', get_stylesheet_directory_uri() . '/js/capacitaciones-iniciadas.js', array('env'), null, true);
  endif;

  if(is_page('especialidades')):
    wp_enqueue_script('capacitaciones-inside', get_stylesheet_directory_uri() . '/js/capacitaciones-inside.js', array('env'), null, true);
  endif;

  if(is_page('beneficios')):
    wp_enqueue_script('beneficios', get_stylesheet_directory_uri() . '/js/beneficios.js', array('env'), null, true);
  endif;

  if(is_page('sociedades-filiales')):
    wp_enqueue_script('sociedades', get_stylesheet_directory_uri() . '/js/sociedades.js', array('env'), null, true);
  endif;

  if(is_singular('capacitaciones')):
    wp_enqueue_script('handler-inscripcion', get_stylesheet_directory_uri() . '/js/handler-inscripcion.js', array('env'), null, true);
  endif;

  function add_module_attribute($tag, $handle, $src) {
    $handle_check = (
      $handle === 'capacitaciones-inside'||
      $handle === 'capacitaciones-front' ||
      $handle === 'capacitaciones-iniciadas' ||
      $handle === 'sociedades' ||
      $handle === 'beneficios'
    );
    
    if ($handle_check) {
      $tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
      
      return $tag;
    }
    
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

/* Vacía el Carrito antes de agregar cualquier producto nuevo para asegurar que no se hagan
inscripciones múltiples */
function single_item_cart( $new_item, $product_id, $quantity ) {
  if( ! WC()->cart->is_empty() ) {
    WC()->cart->empty_cart();
  }
  
  return $new_item;
}

add_filter( 'woocommerce_add_to_cart_validation', 'single_item_cart', 20, 3 );

function add_custom_checkout_field_to_emails_notifications( $order, $sent_to_admin, $plain_text, $email ) {
  $billing_dni = get_post_meta( $order->id, 'billing_wooccm12', true );
  
  if ( !empty($billing_dni) ) {
    echo '<div><strong>DNI</strong> <span class="text">' . $billing_dni . '</span></div>';
  } else {
    echo '<div><pre>' . print_r($order, true) . '</pre></div>';
  }
}

add_action('woocommerce_email_customer_details','add_custom_checkout_field_to_emails_notifications', 25, 4 );

// Disable AJAX Cart
function register_ajax_cart() {
}

add_action('after_setup_theme', 'register_ajax_cart');