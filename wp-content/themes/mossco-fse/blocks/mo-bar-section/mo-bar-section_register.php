<?php

        PG_Blocks::register_block_type( array(
            'name' => 'mossco-fse/mo-bar-section',
            'title' => __( 'Mossco Bar Section', 'mossco_fse' ),
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M11 3v18H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h7zm10 10v7a1 1 0 0 1-1 1h-7v-8h8zM20 3a1 1 0 0 1 1 1v7h-8V3h7z"/></svg>',
            'category' => 'mo_home_blocks',
            'supports' => array('color' => array('background' => false,'text' => false,'gradients' => false,'link' => false,),'typography' => array('fontSize' => false,),'anchor' => false,'align' => false,),
            'base_url' => get_template_directory_uri(),
            'base_path' => get_template_directory(),
            'js_file' => 'blocks/mo-bar-section/mo-bar-section.js',
            'attributes' => array(
                'mo_bar_section_img_1' => array(
                    'type' => 'object',
                    'default' => array('id' => 0, 'url' => esc_url( get_template_directory_uri() . '/assets/images/home/bar/travelodge-lounge-2-min.jpg' ), 'size' => '', 'svg' => '', 'alt' => null)
                ),
                'mo_heading_bar' => array(
                    'type' => 'text',
                    'default' => '&nbsp;Bar'
                ),
                'mo_bar_section_text' => array(
                    'type' => 'text',
                    'default' => 'Casual but stylish dining can be found within Mossco Restaurant - a perfect combination for our food and drink offering. With ample cosy seating and chic interiors, Mossco Restaurant is the place to relax and dine in Dublin 2.'
                ),
                'mo_bar_section_img_2' => array(
                    'type' => 'object',
                    'default' => array('id' => 0, 'url' => esc_url( get_template_directory_uri() . '/assets/images/home/bar/travelodge-mossco-bar-min.jpg' ), 'size' => '', 'svg' => '', 'alt' => null)
                )
            ),
            'example' => array(
'mo_bar_section_img_1' => array('id' => 0, 'url' => esc_url( get_template_directory_uri() . '/assets/images/home/bar/travelodge-lounge-2-min.jpg' ), 'size' => '', 'svg' => '', 'alt' => null), 'mo_heading_bar' => '&nbsp;Bar', 'mo_bar_section_text' => 'Casual but stylish dining can be found within Mossco Restaurant - a perfect combination for our food and drink offering. With ample cosy seating and chic interiors, Mossco Restaurant is the place to relax and dine in Dublin 2.', 'mo_bar_section_img_2' => array('id' => 0, 'url' => esc_url( get_template_directory_uri() . '/assets/images/home/bar/travelodge-mossco-bar-min.jpg' ), 'size' => '', 'svg' => '', 'alt' => null)
            ),
            'dynamic' => false,
            'version' => '1.0.363'
        ) );
