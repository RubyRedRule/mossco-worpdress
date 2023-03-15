<?php

        PG_Blocks::register_block_type( array(
            'name' => 'mossco-fse/mo-menu-banner',
            'title' => __( 'Menu Banner Block', 'mossco_fse' ),
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M5 11.1l2-2 5.5 5.5 3.5-3.5 3 3V5H5v6.1zM4 3h16a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm11.5 7a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/></svg>',
            'category' => 'mo_menu_blocks',
            'supports' => array('color' => array('background' => false,'text' => false,'gradients' => false,'link' => false,),'typography' => array('fontSize' => false,),'anchor' => false,'align' => false,),
            'base_url' => get_template_directory_uri(),
            'base_path' => get_template_directory(),
            'js_file' => 'blocks/mo-menu-banner/mo-menu-banner.js',
            'attributes' => array(
                'mo_menu_banner_img' => array(
                    'type' => 'object',
                    'default' => array('id' => 0, 'url' => '', 'size' => '', 'svg' => '', 'alt' => null)
                ),
                'mo_menu_banner_header' => array(
                    'type' => 'text',
                    'default' => 'Café menu'
                )
            ),
            'example' => array(
'mo_menu_banner_img' => array('id' => 0, 'url' => '', 'size' => '', 'svg' => '', 'alt' => null), 'mo_menu_banner_header' => 'Café menu'
            ),
            'dynamic' => false,
            'version' => '1.0.363'
        ) );
