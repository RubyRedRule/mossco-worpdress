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
    <body class="scroll-smooth smooth-scrolling <?php echo implode(' ', get_body_class()); ?>" data-pg-ia-scene="{&quot;l&quot;:[{&quot;t&quot;:&quot;this&quot;,&quot;a&quot;:&quot;fadeIn&quot;,&quot;p&quot;:&quot;time&quot;,&quot;s&quot;:&quot;0%&quot;}]}">
        <?php if( function_exists( 'wp_body_open' ) ) wp_body_open(); ?>
        <?php get_template_part( 'parts/home', 'header' ); ?>
        <main style="position: relative;">