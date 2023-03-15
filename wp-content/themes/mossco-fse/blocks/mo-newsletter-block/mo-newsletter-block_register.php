<?php

        PG_Blocks::register_block_type( array(
            'name' => 'mossco-fse/mo-newsletter-block',
            'title' => __( 'Newsletter Block', 'mossco_fse' ),
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M22 13.341A6 6 0 0 0 14.341 21H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h18a1 1 0 0 1 1 1v9.341zm-9.94-1.658L5.648 6.238 4.353 7.762l7.72 6.555 7.581-6.56-1.308-1.513-6.285 5.439zM21 18h3v2h-3v3h-2v-3h-3v-2h3v-3h2v3z"/></svg>',
            'category' => 'mo_home_blocks',
            'supports' => array('color' => array('background' => false,'text' => false,'gradients' => false,'link' => false,),'typography' => array('fontSize' => false,),'anchor' => false,'align' => false,),
            'base_url' => get_template_directory_uri(),
            'base_path' => get_template_directory(),
            'js_file' => 'blocks/mo-newsletter-block/mo-newsletter-block.js',
            'attributes' => array(
                'newsletter_header' => array(
                    'type' => 'text',
                    'default' => 'Newsletter'
                )
            ),
            'example' => array(
'newsletter_header' => 'Newsletter'
            ),
            'dynamic' => false,
            'version' => '1.0.363'
        ) );
