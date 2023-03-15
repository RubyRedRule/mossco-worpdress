<?php

        PG_Blocks::register_block_type( array(
            'name' => 'mossco-hc/mo-smartblock',
            'title' => __( 'Mossco Smart Block', 'mossco_hc' ),
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M14 10v4h-4v-4h4zm2 0h5v4h-5v-4zm-2 11h-4v-5h4v5zm2 0v-5h5v4a1 1 0 0 1-1 1h-4zM14 3v5h-4V3h4zm2 0h4a1 1 0 0 1 1 1v4h-5V3zm-8 7v4H3v-4h5zm0 11H4a1 1 0 0 1-1-1v-4h5v5zM8 3v5H3V4a1 1 0 0 1 1-1h4z"/></svg>',
            'category' => 'mo_blocks',
            'enqueue_editor_style' => get_template_directory_uri() . '/assets/css/wp_editor_menus.css',
            'render_template' => 'blocks/mo-smartblock/mo-smartblock.php',
            'supports' => array('color' => array('background' => false,'text' => false,'gradients' => false,'link' => false,),'typography' => array('fontSize' => false,),'anchor' => false,'align' => false,),
            'base_url' => get_template_directory_uri(),
            'base_path' => get_template_directory(),
            'js_file' => 'blocks/mo-smartblock/mo-smartblock.js',
            'attributes' => array(

            ),
            'example' => array(

            ),
            'dynamic' => true,
            'has_inner_blocks' => true,
            'version' => '1.0.273'
        ) );
