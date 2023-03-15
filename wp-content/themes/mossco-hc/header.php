<!DOCTYPE html> 
<html class="scroll-smooth" <?php language_attributes(); ?>> 
    <head> 
        <meta charset="<?php bloginfo( 'charset' ); ?>"> 
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">          
        <link rel="icon" type="image/svg+xml" href="<?php echo get_template_directory_uri(); ?>/favicon.svg">
        <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
        <?php wp_head(); ?>
    </head>     
    <body class="body-overlay scroll-smooth <?php echo implode(' ', get_body_class()); ?>" data-pg-ia-scene='{"l":[{"t":"this","a":"fadeIn","p":"time","s":"0%"}]}' data-pg-ia-hide>
        <?php if( function_exists( 'wp_body_open' ) ) wp_body_open(); ?>
        <?php get_template_part( 'parts/home', 'header' ); ?>
        <main style="position: relative;">