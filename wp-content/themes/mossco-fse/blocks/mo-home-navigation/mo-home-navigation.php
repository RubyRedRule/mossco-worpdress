<header <?php if(empty($_GET['context']) || $_GET['context'] !== 'edit') echo get_block_wrapper_attributes( array('class' => "h-28 scroll-smooth smooth-scrolling sticky top-0 z-50 sm:h-28", 'data-pg-ia-scene' => '{"l":[{"name":"logo","t":"img","a":{"l":[{"t":"","l":[{"t":"set","p":0,"d":0,"l":{"autoAlpha":0},"e":"Power1.easeOut"},{"t":"tween","p":0,"d":0.5,"l":{"autoAlpha":1},"e":"Power1.easeOut"}]}]},"p":"time","s":"0"},{"t":"nav #gt# div","a":{"l":[{"t":"","l":[{"t":"set","p":0.5,"d":0,"l":{"autoAlpha":0},"e":"Power1.easeOut"},{"t":"tween","p":0.5,"d":0.5,"l":{"autoAlpha":1},"e":"Power1.easeOut"}]}]},"p":"time","s":"0"},{"name":"burger menu","t":"button","a":{"l":[{"t":"","l":[{"t":"set","p":0,"d":0,"l":{"autoAlpha":0},"e":"Power1.easeOut"},{"t":"tween","p":0.5,"d":0.5,"l":{"autoAlpha":1},"e":"Power1.easeOut"}]}]},"p":"time","s":"0%"},{"name":"book table button tablet","t":"nav #gt# a:nth-of-type(2)","a":{"l":[{"t":"","l":[{"t":"set","p":0,"d":0,"l":{"autoAlpha":0},"e":"Power1.easeOut"},{"t":"tween","p":0.5,"d":0.5,"l":{"autoAlpha":1},"e":"Power1.easeOut"}]}]},"p":"time"}]}', ) ); else echo 'data-wp-block-props="true"'; ?>>
    <section class="duration-500 mx-auto nav-hover transform transition lg:hover:bg-opacity-80">
        <div class="bg-Mossco-grey-background bg-opacity-0 duration-500 false-header h-24 origin-top sticky top-0 transform transition z-50 sm:h-28">
            <div data-empty-placeholder></div>
        </div>
        <div class="-mt-24 container duration-500 h-24 mossco-header mx-auto px-0 sticky top-2 transform transition z-50 md:-mt-28 md:top-0 lg:hover:bg-opacity-80 lg:top-2 2xl:max-w-screen-xl"> 
            <nav class="flex flex-wrap h-full items-center justify-between p-4 sm:py-5 md:px-4 lg:p-0"> <a href="/"><?php if ( !PG_Blocks::getImageSVG( $args, 'mo_logo', false) && PG_Blocks::getImageUrl( $args, 'mo_logo', 'full' ) ) : ?><img src="<?php echo PG_Blocks::getImageUrl( $args, 'mo_logo', 'full' ) ?>" class="<?php echo (PG_Blocks::getImageField( $args, 'mo_logo', 'id', true) ? ('wp-image-' . PG_Blocks::getImageField( $args, 'mo_logo', 'id', true)) : '') ?> drop-shadow-xl duration-500 h-9 lg:h-9 ml-4 mossco-logo mr-auto scale-125 transform transition" data-pg-ia-hide alt="<?php echo PG_Blocks::getImageField( $args, 'mo_logo', 'alt', true); ?>"><?php endif; ?><?php if ( PG_Blocks::getImageSVG( $args, 'mo_logo', false) ) : ?><?php echo PG_Blocks::mergeInlineSVGAttributes( PG_Blocks::getImageSVG( $args, 'mo_logo' ), array( 'class'=> 'drop-shadow-xl duration-500 h-9 ml-4 mossco-logo mr-auto scale-125 transform transition lg:h-9', 'data-pg-ia-hide'=> null ) ) ?><?php endif; ?></a>
                <button class="hamburger-menu hover:text-white ml-auto py-2 rounded text-current md:mr-5 lg:hidden" data-name="nav-toggler" data-pg-ia='{"l":[{"name":"NavMenuToggler","trg":"click","a":{"l":[{"t":"^nav|[data-name=nav-menu]","l":[{"t":"set","p":0,"d":0,"l":{"class.remove":"hidden","autoAlpha":0,"x":"-100%"}},{"t":"tween","p":0,"d":0.5,"l":{"autoAlpha":1,"x":"0%"},"e":"Power1.easeOut"}]},{"t":"#gt# span:nth-of-type(1)","l":[{"t":"tween","p":0,"d":0.2,"l":{"rotationZ":45,"yPercent":300}}]},{"t":"#gt# span:nth-of-type(2)","l":[{"t":"tween","p":0,"d":0.2,"l":{"autoAlpha":0}}]},{"t":"#gt# span:nth-of-type(3)","l":[{"t":"tween","p":0,"d":0.2,"l":{"rotationZ":-45,"yPercent":-400}}]},{"t":"$body","l":[{"t":"tween","p":0,"d":0.5,"l":{"class.add":"body-overlay"}}]}]},"pdef":"true","trev":"true"}]}' data-pg-ia-apply="$nav [data-name=nav-toggler]" data-pg-ia-hide>
                    <span class="bg-primary-NORMAL block h-1 hover:bg-primary-LIGHT my-2 rounded ml-auto w-10 sm:w-12"></span>
                    <span class="bg-white block h-1 ml-auto my-2.5 rounded w-6 sm:w-8"></span>
                    <span class="bg-primary-NORMAL block h-1 hover: my-2.5 rounded ml-auto w-10 sm:w-12"></span>
                </button><a href="#" class="bg-primary-NORMAL font-light hidden nav-btn-tablet-mobile px-5 py-2 rounded text-current uppercase md:inline-block lg:hidden lg:hover:bg-Mossco-grey-dark lg:hover:bg-opacity-80"><?php _e( 'Book a Table', 'mossco_fse' ); ?></a>
                <script src="pgia/lib/pgia.js"></script>
                <div class="flex hidden ml-0 p-8 rounded text-left w-full md:flex-col md:mr-0 md:pl-8 md:w-full lg:bg-opacity-0 lg:flex lg:flex-row lg:max-w-full lg:px-0 lg:py-8 lg:space-x-4 lg:space-y-0 lg:text-left lg:w-auto" data-name="nav-menu" data-pg-ia-hide> 
                    <div class="absolute bg-Mossco-grey-dark bg-opacity-95 flex flex-col font-normal h-screen left-0 mobile-nav px-6 py-12 rounded-r-lg text-gray-50 text-left w-72 z-50 md:-left-4 md:h-screen md:ml-0 md:top-10 lg:align-middle lg:bg-opacity-0 lg:flex-row lg:h-auto lg:p-0 lg:static lg:text-sm lg:top-0 lg:w-full 2xl:text-base"> 
                        <div class="flex flex-col lg:flex-row">
                            <?php if ( has_nav_menu( 'home_navigation' ) ) : ?>
                                <?php
                                    PG_Smart_Walker_Nav_Menu::init();
                                    PG_Smart_Walker_Nav_Menu::$options['template'] = '<li class="flex lg:border-primary-NORMAL lg:h-full lg:hover:border-b-2 lg:hover:border-primary-NORMAL lg:hover:border-solid {CLASSES}" id="{ID}"><a class="font-sans hover:text-primary-LIGHT px-0 py-2 scroll-smooth smooth-scrolling uppercase lg:px-4" {ATTRS}>{TITLE}</a>
                                                                            </li>';
                                    wp_nav_menu( array(
                                        'container' => '',
                                        'theme_location' => 'home_navigation',
                                        'items_wrap' => '<ul class="%2$s flex flex-col lg:flex-row lg:place-self-auto md:text-center text-left" id="%1$s">%3$s</ul>',
                                        'walker' => new PG_Smart_Walker_Nav_Menu()
                                ) ); ?>
                            <?php endif; ?>
                            <button href="<?php echo (!empty($_GET['context']) && $_GET['context'] === 'edit') ? 'javascript:void()' : PG_Blocks::getLinkUrl( $args, 'mo_nav_button_link' ) ?>" class="active:bg-primary-DARK bg-primary-NORMAL duration-300 ease-out flex flex-col font-sans hover:bg-primary-LIGHT hover:ring hover:ring-primary-DARK ml-0 mt-8 px-5 py-2 rounded text-base text-center text-white transition uppercase w-full lg:flex-row lg:ml-2 lg:mt-0 lg:w-auto">
                                <?php echo PG_Blocks::getAttribute( $args, 'mo_nav_button_text' ) ?>
                            </button>
                        </div>                         
                    </div>                     
                </div>
            </nav>
        </div>
    </section>
</header>