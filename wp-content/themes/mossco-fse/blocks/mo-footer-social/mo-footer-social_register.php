<?php

        PG_Blocks::register_block_type( array(
            'name' => 'mossco-fse/mo-footer-social',
            'title' => __( 'Footer Social icon block', 'mossco_fse' ),
            'supports' => array('color' => array('background' => false,'text' => false,'gradients' => false,'link' => false,),'typography' => array('fontSize' => false,),'anchor' => false,'align' => false,),
            'base_url' => get_template_directory_uri(),
            'base_path' => get_template_directory(),
            'js_file' => 'blocks/mo-footer-social/mo-footer-social.js',
            'attributes' => array(
                'mo_social_link' => array(
                    'type' => 'object',
                    'default' => array('post_id' => 0, 'url' => '#', 'post_type' => '', 'title' => '')
                ),
                'mo_social_icon' => array(
                    'type' => 'object',
                    'default' => array('id' => 0, 'url' => '', 'size' => '', 'svg' => '<svg viewBox="0 0 175.37 175.37" fill="currentColor" class="h-10 w-10 lg:hover:fill-primary-LIGHT"> 
    <path d="m156.58,0H18.79C8.41,0,0,8.41,0,18.79v137.79c0,10.38,8.41,18.79,18.79,18.79h53.73v-59.62h-24.66v-28.06h24.66v-21.39c0-24.33,14.48-37.77,36.67-37.77,10.62,0,21.73,1.89,21.73,1.89v23.88h-12.24c-12.06,0-15.82,7.48-15.82,15.16v18.22h26.92l-4.31,28.06h-22.62v59.62h53.73c10.38,0,18.79-8.41,18.79-18.79V18.79c0-10.38-8.41-18.79-18.79-18.79Z"/>
</svg>', 'alt' => null)
                )
            ),
            'example' => array(
'mo_social_link' => array('post_id' => 0, 'url' => '#', 'post_type' => '', 'title' => ''), 'mo_social_icon' => array('id' => 0, 'url' => '', 'size' => '', 'svg' => '<svg viewBox="0 0 175.37 175.37" fill="currentColor" class="h-10 w-10 lg:hover:fill-primary-LIGHT"> 
    <path d="m156.58,0H18.79C8.41,0,0,8.41,0,18.79v137.79c0,10.38,8.41,18.79,18.79,18.79h53.73v-59.62h-24.66v-28.06h24.66v-21.39c0-24.33,14.48-37.77,36.67-37.77,10.62,0,21.73,1.89,21.73,1.89v23.88h-12.24c-12.06,0-15.82,7.48-15.82,15.16v18.22h26.92l-4.31,28.06h-22.62v59.62h53.73c10.38,0,18.79-8.41,18.79-18.79V18.79c0-10.38-8.41-18.79-18.79-18.79Z"/>
</svg>', 'alt' => null)
            ),
            'dynamic' => false,
            'version' => '1.0.363'
        ) );
