<?php

        PG_Blocks::register_block_type( array(
            'name' => 'mossco-fse/cafe-menu-heading',
            'title' => __( 'Top Heading Section', 'mossco_fse' ),
            'category' => 'mo_menu_blocks',
            'supports' => array('color' => array('background' => false,'text' => false,'gradients' => false,'link' => false,),'typography' => array('fontSize' => false,),'anchor' => false,'align' => false,),
            'base_url' => get_template_directory_uri(),
            'base_path' => get_template_directory(),
            'js_file' => 'blocks/cafe-menu-heading/cafe-menu-heading.js',
            'attributes' => array(
                'cafe_menu_h4' => array(
                    'type' => 'text',
                    'default' => 'Sweet pastries and cakes'
                ),
                'cafe_menu_exerpt' => array(
                    'type' => 'text',
                    'default' => 'Selection of the items noted below available daily from 10am serviced from the bar. <br>Take out or eat in.'
                )
            ),
            'example' => array(
'cafe_menu_h4' => 'Sweet pastries and cakes', 'cafe_menu_exerpt' => 'Selection of the items noted below available daily from 10am serviced from the bar. <br>Take out or eat in.'
            ),
            'dynamic' => false,
            'version' => '1.0.237'
        ) );
