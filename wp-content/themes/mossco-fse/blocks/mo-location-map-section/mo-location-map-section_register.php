<?php

        PG_Blocks::register_block_type( array(
            'name' => 'mossco-fse/mo-location-map-section',
            'title' => __( 'Location & Map Section', 'mossco_fse' ),
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M18.364 17.364L12 23.728l-6.364-6.364a9 9 0 1 1 12.728 0zM12 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm0-2a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg>',
            'category' => 'mo_home_blocks',
            'supports' => array('color' => array('background' => false,'text' => false,'gradients' => false,'link' => false,),'typography' => array('fontSize' => false,),'anchor' => false,'align' => false,),
            'base_url' => get_template_directory_uri(),
            'base_path' => get_template_directory(),
            'js_file' => 'blocks/mo-location-map-section/mo-location-map-section.js',
            'attributes' => array(
                'mo_location_address_h4' => array(
                    'type' => 'text',
                    'default' => 'Travelodge Plus <p class="font-serif text-base">44 Townsend Street</p> <p class="font-serif text-base">Dublin Docklands</p> <p class="font-serif text-base">Dublin</p> <p class="font-serif text-base">D02 DY01</p>'
                ),
                'mo_location_address_1' => array(
                    'type' => 'text',
                    'default' => '44 Townsend Street'
                ),
                'mo_location_address_2' => array(
                    'type' => 'text',
                    'default' => 'Dublin Docklands'
                ),
                'mo_location_address_3' => array(
                    'type' => 'text',
                    'default' => 'Dublin'
                ),
                'mo_location_address_4' => array(
                    'type' => 'text',
                    'default' => 'D02 DY01'
                ),
                'mo_phone' => array(
                    'type' => 'text',
                    'default' => '<a href="tel:+35315259500" class="lg:text-gray-200">(01) 525 9500</a>'
                ),
                'mo_contact_email_text' => array(
                    'type' => 'text',
                    'default' => '<a href="mailto:info@travelodgeplus.ie" class="lg:text-gray-200">info@travelodgeplus.ie</a>'
                ),
                'mo_contact_email_link' => array(
                    'type' => 'object',
                    'default' => array('post_id' => 0, 'url' => 'mailto:info@travelodgeplus.ie', 'post_type' => '', 'title' => '')
                )
            ),
            'example' => array(
'mo_location_address_h4' => 'Travelodge Plus <p class="font-serif text-base">44 Townsend Street</p> <p class="font-serif text-base">Dublin Docklands</p> <p class="font-serif text-base">Dublin</p> <p class="font-serif text-base">D02 DY01</p>', 'mo_location_address_1' => '44 Townsend Street', 'mo_location_address_2' => 'Dublin Docklands', 'mo_location_address_3' => 'Dublin', 'mo_location_address_4' => 'D02 DY01', 'mo_phone' => '<a href="tel:+35315259500" class="lg:text-gray-200">(01) 525 9500</a>', 'mo_contact_email_text' => '<a href="mailto:info@travelodgeplus.ie" class="lg:text-gray-200">info@travelodgeplus.ie</a>', 'mo_contact_email_link' => array('post_id' => 0, 'url' => 'mailto:info@travelodgeplus.ie', 'post_type' => '', 'title' => '')
            ),
            'dynamic' => false,
            'version' => '1.0.363'
        ) );
