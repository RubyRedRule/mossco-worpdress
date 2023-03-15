<?php

        PG_Blocks::register_block_type( array(
            'name' => 'mossco-fse/cafe-menu-left-heading',
            'title' => __( 'Top Heading Section', 'mossco_fse' ),
            'category' => 'mo_menu_blocks',
            'supports' => array('color' => array('background' => false,'text' => false,'gradients' => false,'link' => false,),'typography' => array('fontSize' => false,),'anchor' => false,'align' => false,),
            'base_url' => get_template_directory_uri(),
            'base_path' => get_template_directory(),
            'js_file' => 'blocks/cafe-menu-left-heading/cafe-menu-left-heading.js',
            'attributes' => array(
                'cafe_menu_h3' => array(
                    'type' => 'text',
                    'default' => 'Café'
                ),
                'cafe_menu_h4' => array(
                    'type' => 'text',
                    'default' => 'Sandwiches'
                ),
                'cafe_menu_exerpt' => array(
                    'type' => 'text',
                    'default' => 'Pre-made, cut and deli wrapped, available hot or cold. Served with daily soup, available from 12noon. <br>Take out or eat in.'
                )
            ),
            'example' => array(
'cafe_menu_h3' => 'Café', 'cafe_menu_h4' => 'Sandwiches', 'cafe_menu_exerpt' => 'Pre-made, cut and deli wrapped, available hot or cold. Served with daily soup, available from 12noon. <br>Take out or eat in.'
            ),
            'dynamic' => false,
            'version' => '1.0.236'
        ) );
