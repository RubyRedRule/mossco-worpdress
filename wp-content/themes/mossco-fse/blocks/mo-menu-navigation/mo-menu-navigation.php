<header <?php if(empty($_GET['context']) || $_GET['context'] !== 'edit') echo get_block_wrapper_attributes( array('class' => "h-24 sm:h-28 sticky top-0 z-50", 'data-pg-ia-scene' => '{"l":[{"name":"burger menu","t":"button","a":{"l":[{"t":"","l":[{"t":"set","p":0.5,"d":0,"l":{"autoAlpha":0},"e":"Power1.easeOut"},{"t":"tween","p":0.5,"d":0.5,"l":{"autoAlpha":1},"e":"Power1.easeOut"}]}]},"p":"time","s":"0%"},{"name":"book table button tablet","t":"nav #gt# a:nth-of-type(2)","a":{"l":[{"t":"","l":[{"t":"set","p":0.5,"d":0,"l":{"autoAlpha":0},"e":"Power1.easeOut"},{"t":"tween","p":0.5,"d":0.5,"l":{"autoAlpha":1},"e":"Power1.easeOut"}]}]}}]}', ) ); else echo 'data-wp-block-props="true"'; ?>>
    <div class="bg-Mossco-grey-background bg-opacity-0 duration-500 false-header h-24 origin-top sticky top-0 transform transition z-50 sm:h-28">
        <div data-empty-placeholder></div>
    </div>
    <div class="-mt-28 container duration-500 h-24 max-w-screen-xl mossco-header mx-auto px-0 sticky top-1 transform transition z-50 md:top-0 lg:top-2"> 
        <nav class="flex flex-wrap items-center justify-between p-4 sm:py-5 md:px-4 lg:py-0"> <a href="/"><?php if ( !PG_Blocks::getImageSVG( $args, 'mo_mossco_logo', false) && PG_Blocks::getImageUrl( $args, 'mo_mossco_logo', 'full' ) ) : ?><img src="<?php echo PG_Blocks::getImageUrl( $args, 'mo_mossco_logo', 'full' ) ?>" class="<?php echo (PG_Blocks::getImageField( $args, 'mo_mossco_logo', 'id', true) ? ('wp-image-' . PG_Blocks::getImageField( $args, 'mo_mossco_logo', 'id', true)) : '') ?> drop-shadow-xl duration-500 h-9 lg:h-9 ml-4 mossco-logo mr-auto scale-125 transform transition" alt="<?php echo PG_Blocks::getImageField( $args, 'mo_mossco_logo', 'alt', true); ?>"><?php endif; ?><?php if ( PG_Blocks::getImageSVG( $args, 'mo_mossco_logo', false) ) : ?><?php echo PG_Blocks::mergeInlineSVGAttributes( PG_Blocks::getImageSVG( $args, 'mo_mossco_logo' ), array( 'class'=> 'drop-shadow-xl duration-500 h-9 ml-4 mossco-logo mr-auto scale-125 transform transition lg:h-9' ) ) ?><?php endif; ?></a>
            <button class="hamburger-menu hover:text-white ml-auto py-2 rounded text-current md:mr-5 lg:hidden" data-name="nav-toggler" data-pg-ia='{"l":[{"name":"NabMenuToggler","trg":"click","a":{"l":[{"t":"^nav|[data-name=nav-menu]","l":[{"t":"set","p":0,"d":0,"l":{"class.remove":"hidden"}}]},{"t":"#gt# span:nth-of-type(1)","l":[{"t":"tween","p":0,"d":0.2,"l":{"rotationZ":45,"yPercent":300}}]},{"t":"#gt# span:nth-of-type(2)","l":[{"t":"tween","p":0,"d":0.2,"l":{"autoAlpha":0}}]},{"t":"#gt# span:nth-of-type(3)","l":[{"t":"tween","p":0,"d":0.2,"l":{"rotationZ":-45,"yPercent":-400}}]}]},"pdef":"true","trev":"true"}]}' data-pg-ia-apply="$nav [data-name=nav-toggler]">
                <span class="bg-primary-NORMAL block h-1 hover:bg-primary-LIGHT my-2 rounded ml-auto w-10 sm:w-12"></span>
                <span class="bg-white block h-1 ml-auto my-2.5 rounded w-6 sm:w-8"></span>
                <span class="bg-primary-NORMAL block h-1 hover: my-2.5 rounded ml-auto w-10 sm:w-12"></span>
            </button>
            <a href="#" class="bg-primary-NORMAL font-light hidden hover:bg-primary-700 inline-block nav-btn-tablet-mobile px-5 py-2 rounded text-current text-primary-500 uppercase md:inline-block lg:hidden"><?php _e( 'Book a Table', 'mossco_fse' ); ?></a> 
            <div class="bg-Mossco-grey-dark bg-opacity-95 hidden mx-auto pl-4 py-8 rounded space-y-2 text-center w-full md:max-w-md md:mr-0 lg:bg-opacity-0 lg:flex lg:max-w-full lg:space-x-4 lg:space-y-0 lg:text-left lg:w-auto" data-name="nav-menu"> 
                <div class="flex flex-col font-normal h-full text-gray-50 lg:flex-row lg:text-sm 2xl:text-base"> 
                    <div class="flex flex-row items-center">
                        <?php if ( has_nav_menu( 'primary' ) ) : ?>
                            <?php
                                PG_Smart_Walker_Nav_Menu::init();
                                PG_Smart_Walker_Nav_Menu::$options['template'] = '<li class="flex items-center lg:border-primary-NORMAL lg:h-9 lg:hover:border-b-2 lg:hover:border-primary-NORMAL lg:hover:border-solid {CLASSES}" id="{ID}">
                                                                        <a class="font-sans hover:text-primary-LIGHT px-0 py-2 scroll-smooth smooth-scrolling uppercase lg:px-4" {ATTRS}>{TITLE}</a>
                                                                    </li>';
                                wp_nav_menu( array(
                                    'container' => '',
                                    'theme_location' => 'primary',
                                    'items_wrap' => '<ul class="%2$s flex h-11 lg:flex-row lg:h-auto md:text-center" id="%1$s">%3$s</ul>',
                                    'walker' => new PG_Smart_Walker_Nav_Menu()
                            ) ); ?>
                        <?php endif; ?><a href="<?php echo (!empty($_GET['context']) && $_GET['context'] === 'edit') ? 'javascript:void()' : PG_Blocks::getLinkUrl( $args, 'mo_nav_button_link' ) ?>" class="active:bg-primary-DARK bg-primary-NORMAL duration-300 ease-out flex font-sans hover:bg-primary-LIGHT hover:ring hover:ring-primary-DARK inline-block px-6 py-3 rounded text-base text-white transition uppercase lg:ml-3"><?php echo PG_Blocks::getAttribute( $args, 'mo_nav_button_text' ) ?></a>
                    </div>                     
                </div>                 
            </div>
        </nav>         
    </div>
</header>