<?php

        PG_Blocks::register_block_type( array(
            'name' => 'mossco-fse/mo-menu-navigation',
            'title' => __( 'Menu Pages Navigation', 'mossco_fse' ),
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm4.5-14.5L10 10l-2.5 6.5L14 14l2.5-6.5zM12 13a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/></svg>',
            'category' => 'mo_menu_blocks',
            'render_template' => 'blocks/mo-menu-navigation/mo-menu-navigation.php',
            'supports' => array('color' => array('background' => false,'text' => false,'gradients' => false,'link' => false,),'typography' => array('fontSize' => false,),'anchor' => false,'align' => false,),
            'base_url' => get_template_directory_uri(),
            'base_path' => get_template_directory(),
            'js_file' => 'blocks/mo-menu-navigation/mo-menu-navigation.js',
            'attributes' => array(
                'mo_mossco_logo' => array(
                    'type' => 'object',
                    'default' => array('id' => 0, 'url' => esc_url( get_template_directory_uri() . '/assets/images/logo/logo-white-teal.svg' ), 'size' => '', 'svg' => '', 'alt' => null)
                ),
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
'mo_mossco_logo' => array('id' => 0, 'url' => esc_url( get_template_directory_uri() . '/assets/images/logo/logo-white-teal.svg' ), 'size' => '', 'svg' => '', 'alt' => null), 'mo_nav_button_link' => array('post_id' => 0, 'url' => '#', 'post_type' => '', 'title' => ''), 'mo_nav_button_text' => 'Book a Table'
            ),
            'dynamic' => true,
            'version' => '1.0.363'
        ) );
