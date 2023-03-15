<?php

        PG_Blocks::register_block_type( array(
            'name' => 'mossco-hc/pg-home-banner',
            'title' => __( 'Mossco Home Banner', 'mossco_hc' ),
            'category' => 'mo_blocks',
            'supports' => array('color' => array('background' => false,'text' => false,'gradients' => false,'link' => false,),'typography' => array('fontSize' => false,),'anchor' => false,'align' => false,),
            'base_url' => get_template_directory_uri(),
            'base_path' => get_template_directory(),
            'js_file' => 'blocks/pg-home-banner/pg-home-banner.js',
            'attributes' => array(
                'pg_bg_banner_img' => array(
                    'type' => 'object',
                    'default' => array('id' => 0, 'url' => '', 'size' => '', 'svg' => '', 'alt' => null)
                ),
                'pg_banner_h1' => array(
                    'type' => 'text',
                    'default' => 'bar | kitchen | terrace'
                ),
                'pg_banner_h2' => array(
                    'type' => 'text',
                    'default' => 'FOOD &amp; DRINK WITH STYLE'
                ),
                'pg_banner_btn_link' => array(
                    'type' => 'object',
                    'default' => array('post_id' => 0, 'url' => '#home-menus', 'post_type' => '', 'title' => '')
                ),
                'pg_banner_btn_text' => array(
                    'type' => 'text',
                    'default' => 'View Menus'
                )
            ),
            'example' => array(
'pg_bg_banner_img' => array('id' => 0, 'url' => '', 'size' => '', 'svg' => '', 'alt' => null), 'pg_banner_h1' => 'bar | kitchen | terrace', 'pg_banner_h2' => 'FOOD &amp; DRINK WITH STYLE', 'pg_banner_btn_link' => array('post_id' => 0, 'url' => '#home-menus', 'post_type' => '', 'title' => ''), 'pg_banner_btn_text' => 'View Menus'
            ),
            'dynamic' => false,
            'version' => '1.0.277'
        ) );
