<?php

        PG_Blocks::register_block_type( array(
            'name' => 'mossco-fse/mo-our-brand',
            'title' => __( 'Our Brand Section', 'mossco_fse' ),
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M16 2l5 5v14.008a.993.993 0 0 1-.993.992H3.993A1 1 0 0 1 3 21.008V2.992C3 2.444 3.445 2 3.993 2H16zm-5 5v2h2V7h-2zm0 4v6h2v-6h-2z"/></svg>',
            'category' => 'mo_home_blocks',
            'supports' => array('color' => array('background' => false,'text' => false,'gradients' => false,'link' => false,),'typography' => array('fontSize' => false,),'anchor' => false,'align' => false,),
            'base_url' => get_template_directory_uri(),
            'base_path' => get_template_directory(),
            'js_file' => 'blocks/mo-our-brand/mo-our-brand.js',
            'attributes' => array(
                'mo_our_brand_heading' => array(
                    'type' => 'text',
                    'default' => '&nbsp;our Brand'
                ),
                'mo_our_brand_para' => array(
                    'type' => 'text',
                    'default' => 'The Mossco brand was inspired by its local connection to Moss Street in Dublin 2. &lsquo;Co&rsquo; encompasses the full offering available here &ndash; a full-service Bar, Kitchen &amp; outdoor terrace. Our aim to provide a casual and stylish offering.'
                ),
                'mo_our_brand_img_1' => array(
                    'type' => 'object',
                    'default' => array('id' => 0, 'url' => esc_url( get_template_directory_uri() . '/assets/images/home/our-brand/MossCo%20Cafe-min.jpg' ), 'size' => '', 'svg' => '', 'alt' => 'image')
                ),
                'mo_our_brand_img_2' => array(
                    'type' => 'object',
                    'default' => array('id' => 0, 'url' => esc_url( get_template_directory_uri() . '/assets/images/home/our-brand/TL%20Townsend%20St_Bar-min.jpg' ), 'size' => '', 'svg' => '', 'alt' => 'image')
                ),
                'mo_our_brand_img_3' => array(
                    'type' => 'object',
                    'default' => array('id' => 0, 'url' => esc_url( get_template_directory_uri() . '/assets/images/home/our-brand/Travelodge-Pus-Lobby-min.jpg' ), 'size' => '', 'svg' => '', 'alt' => 'image')
                )
            ),
            'example' => array(
'mo_our_brand_heading' => '&nbsp;our Brand', 'mo_our_brand_para' => 'The Mossco brand was inspired by its local connection to Moss Street in Dublin 2. &lsquo;Co&rsquo; encompasses the full offering available here &ndash; a full-service Bar, Kitchen &amp; outdoor terrace. Our aim to provide a casual and stylish offering.', 'mo_our_brand_img_1' => array('id' => 0, 'url' => esc_url( get_template_directory_uri() . '/assets/images/home/our-brand/MossCo%20Cafe-min.jpg' ), 'size' => '', 'svg' => '', 'alt' => 'image'), 'mo_our_brand_img_2' => array('id' => 0, 'url' => esc_url( get_template_directory_uri() . '/assets/images/home/our-brand/TL%20Townsend%20St_Bar-min.jpg' ), 'size' => '', 'svg' => '', 'alt' => 'image'), 'mo_our_brand_img_3' => array('id' => 0, 'url' => esc_url( get_template_directory_uri() . '/assets/images/home/our-brand/Travelodge-Pus-Lobby-min.jpg' ), 'size' => '', 'svg' => '', 'alt' => 'image')
            ),
            'dynamic' => false,
            'version' => '1.0.363'
        ) );
