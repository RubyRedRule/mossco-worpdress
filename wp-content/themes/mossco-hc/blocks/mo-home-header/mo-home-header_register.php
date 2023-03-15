<?php

        PG_Blocks::register_block_type( array(
            'name' => 'mossco-hc/mo-home-header',
            'title' => __( 'Mossco Home Header', 'mossco_hc' ),
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M19 12H5v7h14v-7zM4 3h16a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/></svg>',
            'category' => 'mo_blocks',
            'supports' => array('color' => array('background' => false,'text' => false,'gradients' => false,'link' => false,),'typography' => array('fontSize' => false,),'anchor' => false,'align' => false,),
            'base_url' => get_template_directory_uri(),
            'base_path' => get_template_directory(),
            'js_file' => 'blocks/mo-home-header/mo-home-header.js',
            'attributes' => array(
                'inner_nav_item_1_link' => array(
                    'type' => 'object',
                    'default' => array('post_id' => 0, 'url' => '#home-our-brand', 'post_type' => '', 'title' => '')
                ),
                'inner_nav_item_1_text' => array(
                    'type' => 'text',
                    'default' => 'Our Story'
                ),
                'inner_nav_item_2_link' => array(
                    'type' => 'object',
                    'default' => array('post_id' => 0, 'url' => '#home-menus', 'post_type' => '', 'title' => '')
                ),
                'inner_nav_item_2_text' => array(
                    'type' => 'text',
                    'default' => 'Menus'
                ),
                'inner_nav_item_3_link' => array(
                    'type' => 'object',
                    'default' => array('post_id' => 0, 'url' => '#home-bar', 'post_type' => '', 'title' => '')
                ),
                'inner_nav_item_3_text' => array(
                    'type' => 'text',
                    'default' => 'Bar &#38; Restaurant'
                ),
                'inner_book_button_colour' => array(
                    'type' => 'text',
                    'default' => ''
                ),
                'inner_book_button_text' => array(
                    'type' => 'text',
                    'default' => 'Book a Table'
                )
            ),
            'example' => array(
'inner_nav_item_1_link' => array('post_id' => 0, 'url' => '#home-our-brand', 'post_type' => '', 'title' => ''), 'inner_nav_item_1_text' => 'Our Story', 'inner_nav_item_2_link' => array('post_id' => 0, 'url' => '#home-menus', 'post_type' => '', 'title' => ''), 'inner_nav_item_2_text' => 'Menus', 'inner_nav_item_3_link' => array('post_id' => 0, 'url' => '#home-bar', 'post_type' => '', 'title' => ''), 'inner_nav_item_3_text' => 'Bar &#38; Restaurant', 'inner_book_button_colour' => '', 'inner_book_button_text' => 'Book a Table'
            ),
            'dynamic' => false,
            'version' => '1.0.277'
        ) );
