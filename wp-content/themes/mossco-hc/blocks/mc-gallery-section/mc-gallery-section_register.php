<?php

        PG_Blocks::register_block_type( array(
            'name' => 'mossco-hc/mc-gallery-section',
            'title' => __( 'Mossco Gallery Block', 'mossco_hc' ),
            'supports' => array('color' => array('background' => false,'text' => false,'gradients' => false,'link' => false,),'typography' => array('fontSize' => false,),'anchor' => false,'align' => false,),
            'base_url' => get_template_directory_uri(),
            'base_path' => get_template_directory(),
            'js_file' => 'blocks/mc-gallery-section/mc-gallery-section.js',
            'attributes' => array(
                'mc_gallery_heading' => array(
                    'type' => 'text',
                    'default' => 'Gallery'
                )
            ),
            'example' => array(
'mc_gallery_heading' => 'Gallery'
            ),
            'dynamic' => false,
            'version' => '1.0.277'
        ) );
