<?php
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
function enqueue_parent_styles() {
wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}
  

include get_template_directory() . '/template_parts/layouts/profile/profile-modern.php';


// GOOGLE MAPS INTEGRATION
function mossco_script() {
  if(is_page( array('home', 'contact'))){
      wp_register_script( 'google-map-script', get_stylesheet_directory_uri() . '/assets/js/maps.js','','',true);
      wp_enqueue_script( 'google-map-script' );
  }
}

add_action( 'wp_enqueue_scripts', 'mossco_script' );

///////////////////////
//CUSTOMISE LOGIN PAGE

//direct logo link to Mossco website
function mossco_login_logo_url() {
  return home_url();
}
add_filter( 'login_headerurl', 'mossco_login_logo_url' );

function mossco_login_logo_url_title() {
  return 'Your Site Name and Info';
}
add_filter( 'login_headertext', 'mossco_login_logo_url_title' );


//Load Login Style Sheet
function mossco_login_stylesheet() {
  wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/style-login.css' );
}

add_action( 'login_enqueue_scripts', 'mossco_login_stylesheet' );


///DISABLE WORDPRESS LANGUAGE SWITCHER
add_filter( 'login_display_language_dropdown', '__return_false' );

?>