<?php

        PG_Blocks::register_block_type( array(
            'name' => 'mossco-fse/mo-footer-section',
            'title' => __( 'Mossco Footer Section', 'mossco_fse' ),
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M21 3a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h18zm-2 13H5v2h14v-2z"/></svg>',
            'category' => 'mo_global_blocks',
            'render_template' => 'blocks/mo-footer-section/mo-footer-section.php',
            'supports' => array('color' => array('background' => false,'text' => false,'gradients' => false,'link' => false,),'typography' => array('fontSize' => false,),'anchor' => false,'align' => false,),
            'base_url' => get_template_directory_uri(),
            'base_path' => get_template_directory(),
            'js_file' => 'blocks/mo-footer-section/mo-footer-section.js',
            'attributes' => array(
                'mo_footer_logo_1' => array(
                    'type' => 'object',
                    'default' => array('id' => 0, 'url' => esc_url( get_template_directory_uri() . '/assets/images/logo/Mosso%20black%20white.svg' ), 'size' => '', 'svg' => '', 'alt' => null)
                ),
                'mo_footer_logo_2' => array(
                    'type' => 'object',
                    'default' => array('id' => 0, 'url' => esc_url( get_template_directory_uri() . '/assets/images/logo/Travelodge%20black%20white.svg' ), 'size' => '', 'svg' => '', 'alt' => null)
                ),
                'm_footer_copyright' => array(
                    'type' => 'text',
                    'default' => 'Copyright &copy; 2023 Mossco'
                )
            ),
            'example' => array(
'mo_footer_logo_1' => array('id' => 0, 'url' => esc_url( get_template_directory_uri() . '/assets/images/logo/Mosso%20black%20white.svg' ), 'size' => '', 'svg' => '', 'alt' => null), 'mo_footer_logo_2' => array('id' => 0, 'url' => esc_url( get_template_directory_uri() . '/assets/images/logo/Travelodge%20black%20white.svg' ), 'size' => '', 'svg' => '', 'alt' => null), 'm_footer_copyright' => 'Copyright &copy; 2023 Mossco'
            ),
            'dynamic' => true,
            'has_inner_blocks' => true,
            'version' => '1.0.363'
        ) );
