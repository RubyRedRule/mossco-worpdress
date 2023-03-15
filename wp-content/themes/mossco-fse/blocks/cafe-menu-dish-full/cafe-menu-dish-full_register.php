<?php

        PG_Blocks::register_block_type( array(
            'name' => 'mossco-fse/cafe-menu-dish-full',
            'title' => __( 'Menu Dish', 'mossco_fse' ),
            'category' => 'mo_menu_blocks',
            'supports' => array('color' => array('background' => false,'text' => false,'gradients' => false,'link' => false,),'typography' => array('fontSize' => false,),'anchor' => false,'align' => false,),
            'base_url' => get_template_directory_uri(),
            'base_path' => get_template_directory(),
            'js_file' => 'blocks/cafe-menu-dish-full/cafe-menu-dish-full.js',
            'attributes' => array(
                'cafe_menu_dish_dt' => array(
                    'type' => 'text',
                    'default' => 'Buffalo mozzarella'
                ),
                'cafe_menu_dish_dd' => array(
                    'type' => 'text',
                    'default' => 'Beef tomato, red onion, with basil pesto olive oil &amp; black pepper on ciabatta'
                ),
                'cafe_menu_dish_allerg' => array(
                    'type' => 'text',
                    'default' => '(1,2,10,4)'
                ),
                'cafe_menu_dish_price' => array(
                    'type' => 'text',
                    'default' => '€5.50'
                )
            ),
            'example' => array(
'cafe_menu_dish_dt' => 'Buffalo mozzarella', 'cafe_menu_dish_dd' => 'Beef tomato, red onion, with basil pesto olive oil &amp; black pepper on ciabatta', 'cafe_menu_dish_allerg' => '(1,2,10,4)', 'cafe_menu_dish_price' => '€5.50'
            ),
            'dynamic' => false,
            'version' => '1.0.239'
        ) );
