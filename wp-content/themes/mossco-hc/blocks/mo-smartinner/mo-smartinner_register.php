<?php

        PG_Blocks::register_block_type( array(
            'name' => 'mossco-hc/mo-smartinner',
            'title' => __( 'Mossco Smart Inner Block', 'mossco_hc' ),
            'category' => 'mo_blocks',
            'supports' => array('color' => array('background' => false,'text' => false,'gradients' => false,'link' => false,),'typography' => array('fontSize' => false,),'anchor' => false,'align' => false,),
            'base_url' => get_template_directory_uri(),
            'base_path' => get_template_directory(),
            'js_file' => 'blocks/mo-smartinner/mo-smartinner.js',
            'attributes' => array(
                'inner_menu_link' => array(
                    'type' => 'object',
                    'default' => array('post_id' => 0, 'url' => 'cafe-menu.html', 'post_type' => '', 'title' => '')
                ),
                'inner_menu_hover' => array(
                    'type' => 'text',
                    'default' => null
                ),
                'inner_menu_bg' => array(
                    'type' => 'object',
                    'default' => array('id' => 0, 'url' => '', 'size' => '', 'svg' => '', 'alt' => null)
                ),
                'inner_menu_name' => array(
                    'type' => 'text',
                    'default' => 'Café Menu'
                )
            ),
            'example' => array(
'inner_menu_link' => array('post_id' => 0, 'url' => 'cafe-menu.html', 'post_type' => '', 'title' => ''), 'inner_menu_hover' => null, 'inner_menu_bg' => array('id' => 0, 'url' => '', 'size' => '', 'svg' => '', 'alt' => null), 'inner_menu_name' => 'Café Menu'
            ),
            'dynamic' => false,
            'version' => '1.0.273'
        ) );
