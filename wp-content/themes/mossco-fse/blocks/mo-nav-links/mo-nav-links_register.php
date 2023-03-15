<?php

        PG_Blocks::register_block_type( array(
            'name' => 'mossco-fse/mo-nav-links',
            'title' => __( 'Mossco Navigation Links', 'mossco_fse' ),
            'supports' => array('color' => array('background' => false,'text' => false,'gradients' => false,'link' => false,),'typography' => array('fontSize' => false,),'anchor' => false,'align' => false,),
            'base_url' => get_template_directory_uri(),
            'base_path' => get_template_directory(),
            'js_file' => 'blocks/mo-nav-links/mo-nav-links.js',
            'attributes' => array(
                'inner_nav_item_link' => array(
                    'type' => 'object',
                    'default' => array('post_id' => 0, 'url' => '#home-our-brand', 'post_type' => '', 'title' => '')
                ),
                'inner_nav_item_text' => array(
                    'type' => 'text',
                    'default' => 'Our Story'
                )
            ),
            'example' => array(
'inner_nav_item_link' => array('post_id' => 0, 'url' => '#home-our-brand', 'post_type' => '', 'title' => ''), 'inner_nav_item_text' => 'Our Story'
            ),
            'dynamic' => false,
            'version' => '1.0.297'
        ) );
