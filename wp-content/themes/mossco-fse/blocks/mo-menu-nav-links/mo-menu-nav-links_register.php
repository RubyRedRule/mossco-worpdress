<?php

        PG_Blocks::register_block_type( array(
            'name' => 'mossco-fse/mo-menu-nav-links',
            'title' => __( 'Mossco Navigation Links', 'mossco_fse' ),
            'supports' => array('color' => array('background' => false,'text' => false,'gradients' => false,'link' => false,),'typography' => array('fontSize' => false,),'anchor' => false,'align' => false,),
            'base_url' => get_template_directory_uri(),
            'base_path' => get_template_directory(),
            'js_file' => 'blocks/mo-menu-nav-links/mo-menu-nav-links.js',
            'attributes' => array(
                'inner_menu_nav_link' => array(
                    'type' => 'object',
                    'default' => array('post_id' => 0, 'url' => '#home-menus', 'post_type' => '', 'title' => '')
                ),
                'inner_menu_nav_item_text' => array(
                    'type' => 'text',
                    'default' => 'Day menu'
                )
            ),
            'example' => array(
'inner_menu_nav_link' => array('post_id' => 0, 'url' => '#home-menus', 'post_type' => '', 'title' => ''), 'inner_menu_nav_item_text' => 'Day menu'
            ),
            'dynamic' => false,
            'version' => '1.0.258'
        ) );
