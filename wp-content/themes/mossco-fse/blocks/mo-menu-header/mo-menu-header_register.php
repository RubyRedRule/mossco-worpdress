<?php

        PG_Blocks::register_block_type( array(
            'name' => 'mossco-fse/mo-menu-header',
            'title' => __( 'Mossco Menu Header', 'mossco_fse' ),
            'category' => 'mo_blocks',
            'supports' => array('color' => array('background' => false,'text' => false,'gradients' => false,'link' => false,),'typography' => array('fontSize' => false,),'anchor' => false,'align' => false,),
            'base_url' => get_template_directory_uri(),
            'base_path' => get_template_directory(),
            'js_file' => 'blocks/mo-menu-header/mo-menu-header.js',
            'attributes' => array(
                'mo_nav_button_link' => array(
                    'type' => 'object',
                    'default' => array('post_id' => 0, 'url' => '#', 'post_type' => '', 'title' => '')
                ),
                'mo_nav_button_text' => array(
                    'type' => 'text',
                    'default' => 'Book a Table'
                )
            ),
            'example' => array(
'mo_nav_button_link' => array('post_id' => 0, 'url' => '#', 'post_type' => '', 'title' => ''), 'mo_nav_button_text' => 'Book a Table'
            ),
            'dynamic' => false,
            'has_inner_blocks' => true,
            'version' => '1.0.256'
        ) );
