<?php

        PG_Blocks::register_block_type( array(
            'name' => 'mossco-fse/mo-home-gallery',
            'title' => __( 'Home Gallery Block', 'mossco_fse' ),
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M22 9.999V20a1 1 0 0 1-1 1h-8V9.999h9zm-11 6V21H3a1 1 0 0 1-1-1v-4.001h9zM11 3v10.999H2V4a1 1 0 0 1 1-1h8zm10 0a1 1 0 0 1 1 1v3.999h-9V3h8z"/></svg>',
            'category' => 'mo_home_blocks',
            'enqueue_editor_style' => get_template_directory_uri() . '/assets/css/custom.css',
            'enqueue_editor_script' => get_template_directory_uri() . '/assets/@fancyapps/ui/src/Fancybox/Fancybox.js',
            'supports' => array('color' => array('background' => false,'text' => false,'gradients' => false,'link' => false,),'typography' => array('fontSize' => false,),'anchor' => false,'align' => false,),
            'base_url' => get_template_directory_uri(),
            'base_path' => get_template_directory(),
            'js_file' => 'blocks/mo-home-gallery/mo-home-gallery.js',
            'attributes' => array(
                'mo_gallery_heading' => array(
                    'type' => 'text',
                    'default' => 'Gallery'
                )
            ),
            'example' => array(
'mo_gallery_heading' => 'Gallery'
            ),
            'dynamic' => false,
            'version' => '1.0.363'
        ) );
