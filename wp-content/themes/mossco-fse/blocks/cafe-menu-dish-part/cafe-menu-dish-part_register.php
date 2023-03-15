<?php

        PG_Blocks::register_block_type( array(
            'name' => 'mossco-fse/cafe-menu-dish-part',
            'title' => __( 'Menu Dish', 'mossco_fse' ),
            'category' => 'mo_menu_blocks',
            'supports' => array('color' => array('background' => false,'text' => false,'gradients' => false,'link' => false,),'typography' => array('fontSize' => false,),'anchor' => false,'align' => false,),
            'base_url' => get_template_directory_uri(),
            'base_path' => get_template_directory(),
            'js_file' => 'blocks/cafe-menu-dish-part/cafe-menu-dish-part.js',
            'attributes' => array(
                'cafe_menu_dish_dd' => array(
                    'type' => 'text',
                    'default' => 'Selection of Danish pastries, Croissants and Pain Chocolate'
                ),
                'cafe_menu_dish_allerg' => array(
                    'type' => 'text',
                    'default' => '(1)'
                ),
                'cafe_menu_dish_price' => array(
                    'type' => 'text',
                    'default' => '€ 3.50'
                )
            ),
            'example' => array(
'cafe_menu_dish_dd' => 'Selection of Danish pastries, Croissants and Pain Chocolate', 'cafe_menu_dish_allerg' => '(1)', 'cafe_menu_dish_price' => '€ 3.50'
            ),
            'dynamic' => false,
            'version' => '1.0.239'
        ) );
