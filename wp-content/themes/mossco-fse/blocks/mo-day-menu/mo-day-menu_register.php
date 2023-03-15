<?php

        PG_Blocks::register_block_type( array(
            'name' => 'mossco-fse/mo-day-menu',
            'title' => __( 'Day Menu Block', 'mossco_fse' ),
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M11 5H5v14h6V5zm2 0v14h6V5h-6zM4 3h16a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/></svg>',
            'category' => 'mo_menu_blocks',
            'supports' => array('color' => array('background' => false,'text' => false,'gradients' => false,'link' => false,),'typography' => array('fontSize' => false,),'anchor' => false,'align' => false,),
            'base_url' => get_template_directory_uri(),
            'base_path' => get_template_directory(),
            'js_file' => 'blocks/mo-day-menu/mo-day-menu.js',
            'attributes' => array(
                'day_menu_left_col' => array(
                    'type' => 'text',
                    'default' => '<h3 class="border-b-2 border-primary-NORMAL border-solid mb-6 mt-2 pb-10 text-3xl text-primary-NORMAL md:mb-6">Terrance Bites</h3> <div class="menu_item"> <dt>Mossco Sharing Platter</dt> <dd>Crispy chicken wings, woodfired garlic & oregano flatbread, honey & soya pork ribs, & black tiger prawn skewers
</dd> <p class="allergen_info">(1,2,7,9,10,11)</p> <p class="italic mb-7 mt-2 text-primary-LIGHT">We recommend pairing this with Hope Beer Seasonal draft</p> </div> <div class="menu_item"> <dt>Award Winning Irish Cheeses & Charcuterie Platter</dt> <dd>Served with a selection of cracker, quince jelly & grapes Gubeen salami, Gubeen chorizo</dd> <p class="allergen_info">(1,7)</p> <p class="italic mb-7 mt-2 text-primary-LIGHT">We recommend pairing this with Hope Beer Hop-on Session IPA</p> </div> <div class="menu_item"> <dt>Crispy Chicken Wings</dt> <dd>Cashel blue cheese dip, Frank\'s hot sauce</dd> <p class="allergen_info">(1, 7, 9, 10)</p> <!-- <p class="price">€10.00</p> --> </div> <div class="menu_item"> <dt>Humus Starter</dt> <dd>Humus, carrots, cucumber, black olives, oregano flatbread</dd> <p class="allergen_info">(1)</p> <!-- <p class="price">€5.50</p> --> </div>'
                ),
                'day_menu_right_col' => array(
                    'type' => 'text',
                    'default' => '<h4 class="border-b-2 border-primary-NORMAL border-solid font-sans my-6 pb-3 text-Mossco-grey-semi text-xl uppercase">Mossco Pizza</h4> <div class="border-primary-NORMAL border-r-4 border-t-4 dark part2 pb-16 lg:pb-0 xl:pb-14 2xl:pb-12 rounded-xl md:my-0"> <div class="menu_item"> <dt class="mt-6">Margherita</dt> <dd>Toonsbridge buffalo mozzarella, basil, parmesan, tomato sauce & olive oil</dd> <p class="allergen_info pb-7">(1,7,9)</p> <!-- <p class="price">€3.00</p> --> </div> <div class="menu_item"> <dt>Crunchy peanut butter &amp; banoffee toffee</dt> <dd>Vanilla ice cream, peanut butter &amp; toffee sauce, banana &amp; crus</dd> <p class="allergen_info">(10,4)</p> <p class="price">€2.50</p> </div> </div> <div data-empty-placeholder class="2xl:pt-32 day-menu-bg h-0 hidden lg:pb-40 md:flex md:pb-52 pt-48 xl:pt-36"></div>'
                )
            ),
            'example' => array(
'day_menu_left_col' => '<h3 class="border-b-2 border-primary-NORMAL border-solid mb-6 mt-2 pb-10 text-3xl text-primary-NORMAL md:mb-6">Terrance Bites</h3> <div class="menu_item"> <dt>Mossco Sharing Platter</dt> <dd>Crispy chicken wings, woodfired garlic & oregano flatbread, honey & soya pork ribs, & black tiger prawn skewers
</dd> <p class="allergen_info">(1,2,7,9,10,11)</p> <p class="italic mb-7 mt-2 text-primary-LIGHT">We recommend pairing this with Hope Beer Seasonal draft</p> </div> <div class="menu_item"> <dt>Award Winning Irish Cheeses & Charcuterie Platter</dt> <dd>Served with a selection of cracker, quince jelly & grapes Gubeen salami, Gubeen chorizo</dd> <p class="allergen_info">(1,7)</p> <p class="italic mb-7 mt-2 text-primary-LIGHT">We recommend pairing this with Hope Beer Hop-on Session IPA</p> </div> <div class="menu_item"> <dt>Crispy Chicken Wings</dt> <dd>Cashel blue cheese dip, Frank\'s hot sauce</dd> <p class="allergen_info">(1, 7, 9, 10)</p> <!-- <p class="price">€10.00</p> --> </div> <div class="menu_item"> <dt>Humus Starter</dt> <dd>Humus, carrots, cucumber, black olives, oregano flatbread</dd> <p class="allergen_info">(1)</p> <!-- <p class="price">€5.50</p> --> </div>', 'day_menu_right_col' => '<h4 class="border-b-2 border-primary-NORMAL border-solid font-sans my-6 pb-3 text-Mossco-grey-semi text-xl uppercase">Mossco Pizza</h4> <div class="border-primary-NORMAL border-r-4 border-t-4 dark part2 pb-16 lg:pb-0 xl:pb-14 2xl:pb-12 rounded-xl md:my-0"> <div class="menu_item"> <dt class="mt-6">Margherita</dt> <dd>Toonsbridge buffalo mozzarella, basil, parmesan, tomato sauce & olive oil</dd> <p class="allergen_info pb-7">(1,7,9)</p> <!-- <p class="price">€3.00</p> --> </div> <div class="menu_item"> <dt>Crunchy peanut butter &amp; banoffee toffee</dt> <dd>Vanilla ice cream, peanut butter &amp; toffee sauce, banana &amp; crus</dd> <p class="allergen_info">(10,4)</p> <p class="price">€2.50</p> </div> </div> <div data-empty-placeholder class="2xl:pt-32 day-menu-bg h-0 hidden lg:pb-40 md:flex md:pb-52 pt-48 xl:pt-36"></div>'
            ),
            'dynamic' => false,
            'version' => '1.0.363'
        ) );
