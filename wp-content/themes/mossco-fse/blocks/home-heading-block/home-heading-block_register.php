<?php

        PG_Blocks::register_block_type( array(
            'name' => 'mossco-fse/home-heading-block',
            'title' => __( 'Home banner block', 'mossco_fse' ),
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M19 12H5v7h14v-7zM4 3h16a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/></svg>',
            'category' => 'mo_home_blocks',
            'supports' => array('color' => array('background' => false,'text' => false,'gradients' => false,'link' => false,),'typography' => array('fontSize' => false,),'anchor' => false,'align' => false,),
            'base_url' => get_template_directory_uri(),
            'base_path' => get_template_directory(),
            'js_file' => 'blocks/home-heading-block/home-heading-block.js',
            'attributes' => array(
                'mo_home_bg_img' => array(
                    'type' => 'object',
                    'default' => array('id' => 0, 'url' => '', 'size' => '', 'svg' => '', 'alt' => null)
                ),
                'mo_home_h1' => array(
                    'type' => 'text',
                    'default' => 'bar | kitchen | terrace'
                ),
                'mo_home_heading_h2' => array(
                    'type' => 'text',
                    'default' => 'FOOD &amp; DRINK WITH STYLE'
                ),
                'mo_banner_btn_text' => array(
                    'type' => 'text',
                    'default' => 'View Menus'
                ),
                'mo_banner_btn_bg' => array(
                    'type' => 'text',
                    'default' => ''
                ),
                'mo_banner_btn_br' => array(
                    'type' => 'text',
                    'default' => ''
                )
            ),
            'example' => array(
'mo_home_bg_img' => array('id' => 0, 'url' => '', 'size' => '', 'svg' => '', 'alt' => null), 'mo_home_h1' => 'bar | kitchen | terrace', 'mo_home_heading_h2' => 'FOOD &amp; DRINK WITH STYLE', 'mo_banner_btn_text' => 'View Menus', 'mo_banner_btn_bg' => '', 'mo_banner_btn_br' => ''
            ),
            'dynamic' => false,
            'version' => '1.0.363'
        ) );
