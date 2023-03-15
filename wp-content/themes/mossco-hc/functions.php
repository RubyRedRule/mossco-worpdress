<?php
if ( ! function_exists( 'mossco_hc_setup' ) ) :

function mossco_hc_setup() {

    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    /* Pinegrow generated Load Text Domain Begin */
    load_theme_textdomain( 'mossco_hc', get_template_directory() . '/languages' );
    /* Pinegrow generated Load Text Domain End */

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
     * Let WordPress manage the document title.
     */
    add_theme_support( 'title-tag' );
    
    /*
     * Enable support for Post Thumbnails on posts and pages.
     */
    add_theme_support( 'post-thumbnails' );
    //Support custom logo
    add_theme_support( 'custom-logo' );

    // Add menus.
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'mossco_hc' ),
        'social'  => __( 'Social Links Menu', 'mossco_hc' ),
    ) );

/*
     * Register custom menu locations
     */
    /* Pinegrow generated Register Menus Begin */

    /* Pinegrow generated Register Menus End */
    
/*
    * Set image sizes
     */
    /* Pinegrow generated Image sizes Begin */

    /* Pinegrow generated Image sizes End */
    
    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    ) );

    /*
     * Enable support for Post Formats.
     */
    add_theme_support( 'post-formats', array(
        'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
    ) );

    /*
     * Enable support for Page excerpts.
     */
     add_post_type_support( 'page', 'excerpt' );
}
endif; // mossco_hc_setup

add_action( 'after_setup_theme', 'mossco_hc_setup' );


if ( ! function_exists( 'mossco_hc_init' ) ) :

function mossco_hc_init() {

    
    // Use categories and tags with attachments
    register_taxonomy_for_object_type( 'category', 'attachment' );
    register_taxonomy_for_object_type( 'post_tag', 'attachment' );

    /*
     * Register custom post types. You can also move this code to a plugin.
     */
    /* Pinegrow generated Custom Post Types Begin */

    register_post_type('pg_menu_post_type', array(
        'labels' => 
            array(
                'name' => __( 'Menus', 'mossco_hc' ),
                'singular_name' => __( 'Menu', 'mossco_hc' )
            ),
        'public' => true,
        'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'author', 'excerpt' ),
        'has_archive' => true,
        'show_in_rest' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-text-page',
        'menu_position' => 20
    ));

    /* Pinegrow generated Custom Post Types End */
    
    /*
     * Register custom taxonomies. You can also move this code to a plugin.
     */
    /* Pinegrow generated Taxonomies Begin */

    register_taxonomy('mo-menu-options', 'pg_menu_post_type', array(
        'labels' => 
            array(
                'name' => __( 'Menu Options', 'mossco_hc' ),
                'singular_name' => __( 'Menu Option', 'mossco_hc' )
            ),
        'show_in_rest' => true,
        'hierarchical' => true
    ));

    /* Pinegrow generated Taxonomies End */

}
endif; // mossco_hc_setup

add_action( 'init', 'mossco_hc_init' );


if ( ! function_exists( 'mossco_hc_custom_image_sizes_names' ) ) :

function mossco_hc_custom_image_sizes_names( $sizes ) {

    /*
     * Add names of custom image sizes.
     */
    /* Pinegrow generated Image Sizes Names Begin*/
    /* This code will be replaced by returning names of custom image sizes. */
    /* Pinegrow generated Image Sizes Names End */
    return $sizes;
}
add_action( 'image_size_names_choose', 'mossco_hc_custom_image_sizes_names' );
endif;// mossco_hc_custom_image_sizes_names



if ( ! function_exists( 'mossco_hc_widgets_init' ) ) :

function mossco_hc_widgets_init() {

    /*
     * Register widget areas.
     */
    /* Pinegrow generated Register Sidebars Begin */

    /* Pinegrow generated Register Sidebars End */
}
add_action( 'widgets_init', 'mossco_hc_widgets_init' );
endif;// mossco_hc_widgets_init



if ( ! function_exists( 'mossco_hc_customize_register' ) ) :

function mossco_hc_customize_register( $wp_customize ) {
    // Do stuff with $wp_customize, the WP_Customize_Manager object.

    /* Pinegrow generated Customizer Controls Begin */

    /* Pinegrow generated Customizer Controls End */

}
add_action( 'customize_register', 'mossco_hc_customize_register' );
endif;// mossco_hc_customize_register


if ( ! function_exists( 'mossco_hc_enqueue_scripts' ) ) :
    function mossco_hc_enqueue_scripts() {

        /* Pinegrow generated Enqueue Scripts Begin */

    wp_deregister_script( 'mossco_hc-script' );
    wp_enqueue_script( 'mossco_hc-script', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDCjQbOAcZR002cGDTl_hchKl_Oo9vI33U&callback=initMap', [], '1.0.277', true);

    wp_deregister_script( 'mossco_hc-pgia' );
    wp_enqueue_script( 'mossco_hc-pgia', get_template_directory_uri() . '/pgia/lib/pgia.js', [], '1.0.277', true);

    wp_register_script( 'inline-script-1', '', [], '1.0.277', false );
    wp_enqueue_script( 'inline-script-1' );
    wp_add_inline_script( 'inline-script-1', '/* Pinegrow Interactions, do not remove */ (function(){try{if(!document.documentElement.hasAttribute(\'data-pg-ia-disabled\')) { window.pgia_small_mq=typeof pgia_small_mq==\'string\'?pgia_small_mq:\'(max-width:767px)\';window.pgia_large_mq=typeof pgia_large_mq==\'string\'?pgia_large_mq:\'(min-width:768px)\';var style = document.createElement(\'style\');var pgcss=\'html:not(.pg-ia-no-preview) [data-pg-ia-hide=""] {opacity:0;visibility:hidden;}html:not(.pg-ia-no-preview) [data-pg-ia-show=""] {opacity:1;visibility:visible;display:block;}\';if(document.documentElement.hasAttribute(\'data-pg-id\') && document.documentElement.hasAttribute(\'data-pg-mobile\')) {pgia_small_mq=\'(min-width:0)\';pgia_large_mq=\'(min-width:99999px)\'} pgcss+=\'@media \' + pgia_small_mq + \'{ html:not(.pg-ia-no-preview) [data-pg-ia-hide="mobile"] {opacity:0;visibility:hidden;}html:not(.pg-ia-no-preview) [data-pg-ia-show="mobile"] {opacity:1;visibility:visible;display:block;}}\';pgcss+=\'@media \' + pgia_large_mq + \'{html:not(.pg-ia-no-preview) [data-pg-ia-hide="desktop"] {opacity:0;visibility:hidden;}html:not(.pg-ia-no-preview) [data-pg-ia-show="desktop"] {opacity:1;visibility:visible;display:block;}}\';style.innerHTML=pgcss;document.querySelector(\'head\').appendChild(style);}}catch(e){console&&console.log(e);}})()');

    wp_deregister_script( 'mossco_hc-maps' );
    wp_enqueue_script( 'mossco_hc-maps', get_template_directory_uri() . '/assets/js/maps.js', [], '1.0.277', false);

    wp_deregister_script( 'mossco_hc-header' );
    wp_enqueue_script( 'mossco_hc-header', get_template_directory_uri() . '/assets/js/header.js', [], '1.0.277', true);

    wp_deregister_script( 'mossco_hc-fancybox' );
    wp_enqueue_script( 'mossco_hc-fancybox', get_template_directory_uri() . '/assets/@fancyapps/ui/src/Fancybox/Fancybox.js', [], '1.0.277', true);

    /* Pinegrow generated Enqueue Scripts End */

        /* Pinegrow generated Enqueue Styles Begin */

    wp_deregister_style( 'mossco_hc-tailwind' );
    wp_enqueue_style( 'mossco_hc-tailwind', get_template_directory_uri() . '/tailwind_theme/tailwind.css', [], '1.0.277', 'all');

    wp_deregister_style( 'mossco_hc-custom' );
    wp_enqueue_style( 'mossco_hc-custom', get_template_directory_uri() . '/custom.css', [], '1.0.277', 'all');

    wp_deregister_style( 'mossco_hc-fancybox' );
    wp_enqueue_style( 'mossco_hc-fancybox', get_template_directory_uri() . '/assets/css/fancybox.css', [], '1.0.277', 'all');

    wp_deregister_style( 'mossco_hc-bgimages' );
    wp_enqueue_style( 'mossco_hc-bgimages', get_template_directory_uri() . '/assets/css/bg-images.css', [], '1.0.277', 'all');

    wp_deregister_style( 'mossco_hc-style' );
    wp_enqueue_style( 'mossco_hc-style', get_bloginfo('stylesheet_url'), [], '1.0.277', 'all');

    /* Pinegrow generated Enqueue Styles End */

    }
    add_action( 'wp_enqueue_scripts', 'mossco_hc_enqueue_scripts' );
endif;

function pgwp_sanitize_placeholder($input) { return $input; }
/*
 * Resource files included by Pinegrow.
 */
/* Pinegrow generated Include Resources Begin */
require_once "inc/custom.php";
if( !class_exists( 'PG_Helper_v2' ) ) { require_once "inc/wp_pg_helpers.php"; }
if( !class_exists( 'PG_Blocks' ) ) { require_once "inc/wp_pg_blocks_helpers.php"; }

    /* Pinegrow generated Include Resources End */

/* Creating Editor Blocks with Pinegrow */

if ( ! function_exists('mossco_hc_blocks_init') ) :
function mossco_hc_blocks_init() {
    // Register blocks. Don't edit anything between the following comments.
    /* Pinegrow generated Register Pinegrow Blocks Begin */
    require_once 'blocks/pg-home-banner/pg-home-banner_register.php';
    require_once 'blocks/mo-dynamic-block/mo-dynamic-block_register.php';
    require_once 'blocks/mc-gallery-section/mc-gallery-section_register.php';
    require_once 'blocks/mo-home-header/mo-home-header_register.php';

    /* Pinegrow generated Register Pinegrow Blocks End */
}
add_action('init', 'mossco_hc_blocks_init');
endif;

/* End of creating Editor Blocks with Pinegrow */


/* Register Blocks Categories */

function mossco_hc_register_blocks_categories( $categories ) {

    // Don't edit anything between the following comments.
    /* Pinegrow generated Register Blocks Category Begin */

$categories = array_merge( $categories, array( array(
        'slug' => 'mo_blocks',
        'title' => __( 'Mossco Blocks', 'mossco_hc' )
    ) ) );

    /* Pinegrow generated Register Blocks Category End */
    
    return $categories;
}
add_action( version_compare('5.8', get_bloginfo('version'), '<=' ) ? 'block_categories_all' : 'block_categories', 'mossco_hc_register_blocks_categories');

/* End of registering Blocks Categories */


/* Setting up theme supports options */

function mossco_hc_setup_theme_supports() {
    // Don't edit anything between the following comments.
    /* Pinegrow generated Theme Supports Begin */
    
//Tell WP to scope loaded editor styles to the block editor                    
add_theme_support( 'editor-styles' );
    /* Pinegrow generated Theme Supports End */
}
add_action('after_setup_theme', 'mossco_hc_setup_theme_supports');

/* End of setting up theme supports options */


/* Loading editor styles for blocks */

function mossco_hc_add_blocks_editor_styles() {
// Add blocks editor styles. Don't edit anything between the following comments.
/* Pinegrow generated Load Blocks Editor Styles Begin */
    add_editor_style( 'assets/css/custom.css' );
    add_editor_style( 'tailwind_theme/tailwind_for_wp_editor.css' );
    add_editor_style( 'assets/css/bauhaus.css' );
    add_editor_style( 'assets/css/montserrat.css' );

    /* Pinegrow generated Load Blocks Editor Styles End */
}
add_action('admin_init', 'mossco_hc_add_blocks_editor_styles');

/* End of loading editor styles for blocks */

?>