<!DOCTYPE html> 
<html class="scroll-smooth" <?php language_attributes(); ?>> 
    <head> 
        <meta charset="<?php bloginfo( 'charset' ); ?>"> 
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">          
        <link rel="icon" type="image/svg+xml" href="<?php echo get_template_directory_uri(); ?>/favicon.svg">
        <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
        <?php wp_head(); ?>
    </head>     
    <body class="scroll-smooth smooth-scrolling <?php echo implode(' ', get_body_class()); ?>" data-pg-ia-scene='{"l":[{"t":"this","a":"fadeIn","p":"time","s":"0%"}]}' data-pg-ia-hide>
        <?php if( function_exists( 'wp_body_open' ) ) wp_body_open(); ?>
        <header class="h-24 sticky top-0 z-50 sm:h-28" data-pg-ia-scene='{"l":[{"t":"nav #gt# div","a":{"l":[{"t":"","l":[{"t":"set","p":0.5,"d":0,"l":{"autoAlpha":0},"e":"Power1.easeOut"},{"t":"tween","p":0.5,"d":0.5,"l":{"autoAlpha":1},"e":"Power1.easeOut"}]}]},"p":"time","s":"0","rep":"true"},{"name":"burger menu","t":"button","a":{"l":[{"t":"","l":[{"t":"set","p":0,"d":0,"l":{"autoAlpha":0},"e":"Power1.easeOut"},{"t":"tween","p":0.5,"d":0.5,"l":{"autoAlpha":1},"e":"Power1.easeOut"}]}]},"p":"time","s":"0%"},{"name":"book table button tablet","t":"nav #gt# a:nth-of-type(2)","a":{"l":[{"t":"","l":[{"t":"set","p":0,"d":0,"l":{"autoAlpha":0},"e":"Power1.easeOut"},{"t":"tween","p":0.5,"d":0.5,"l":{"autoAlpha":1},"e":"Power1.easeOut"}]}]}}]}'>
            <div>
                <section>
                    <div class="bg-Mossco-grey-background bg-opacity-0 duration-500 false-header h-24 origin-top sticky top-0 transform transition z-50 sm:h-28">
                        <div data-empty-placeholder></div>
                    </div>
                    <div class="-mt-28 container duration-500 h-24 mossco-header mx-auto px-0 sticky top-1 transform transition z-50 md:top-0 lg:top-2 2xl:max-w-screen-xl"> 
                        <nav class="flex flex-wrap items-center justify-between p-4 sm:py-5 md:px-4 lg:py-0"> <a href="index.html"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo/logo-white-teal.svg" class="drop-shadow-xl duration-500 h-9 ml-4 mossco-logo mr-auto scale-125 transform transition lg:h-9"></a>
                            <button class="hamburger-menu hover:text-white ml-auto py-2 rounded text-current md:mr-5 lg:hidden" data-name="nav-toggler" data-pg-ia='{"l":[{"name":"NabMenuToggler","trg":"click","a":{"l":[{"t":"^nav|[data-name=nav-menu]","l":[{"t":"set","p":0,"d":0,"l":{"class.remove":"hidden","autoAlpha":0}},{"t":"tween","p":0,"d":0.5,"l":{"autoAlpha":1}}]},{"t":"#gt# span:nth-of-type(1)","l":[{"t":"tween","p":0,"d":0.2,"l":{"rotationZ":45,"yPercent":300}}]},{"t":"#gt# span:nth-of-type(2)","l":[{"t":"tween","p":0,"d":0.2,"l":{"autoAlpha":0}}]},{"t":"#gt# span:nth-of-type(3)","l":[{"t":"tween","p":0,"d":0.2,"l":{"rotationZ":-45,"yPercent":-400}}]},{"t":"$body","l":[{"t":"set","p":0,"d":0,"l":{"class.add":"body-overlay"}}]}]},"pdef":"true","trev":"true"}]}' data-pg-ia-apply="$nav [data-name=nav-toggler]" data-pg-ia-hide><span class="bg-primary-NORMAL block h-1 hover:bg-primary-LIGHT my-2 rounded ml-auto w-10 sm:w-12"></span><span class="bg-white block h-1 ml-auto my-2.5 rounded w-6 sm:w-8"></span><span class="bg-primary-NORMAL block h-1 hover: my-2.5 rounded ml-auto w-10 sm:w-12"></span>
                            </button><a href="#" class="bg-primary-NORMAL font-light hidden hover:bg-primary-700 inline-block nav-btn-tablet-mobile px-5 py-2 rounded text-current text-primary-500 uppercase md:inline-block lg:hidden" data-pg-ia-hide><?php _e( 'Book a Table', 'mossco_fse' ); ?></a>
                            <div class="bg-Mossco-grey-dark bg-opacity-95 h-screen hidden p-8 rounded space-y-4 text-left w-72 md:max-w-md lg:bg-opacity-0 lg:flex lg:max-w-full lg:space-x-4 lg:space-y-0 lg:text-left lg:w-auto" data-name="nav-menu" data-pg-ia-hide> 
                                <ul class="flex flex-col font-normal text-gray-50 lg:flex-row lg:text-sm"> <a href="#home-our-brand" class="hover:text-primary-LIGHT px-0 py-2 uppercase lg:px-4"><?php _e( 'Our Story', 'mossco_fse' ); ?></a> <a href="#home-menus" class="hover:text-primary-LIGHT px-0 py-2 uppercase lg:px-4"><?php _e( 'Menus', 'mossco_fse' ); ?></a> <a href="#home-bar" class="hover:text-primary-LIGHT px-0 py-2 uppercase lg:px-4"><?php _e( 'Bar &#38; Restaurant', 'mossco_fse' ); ?></a><a href="#home-gallery" class="hover:text-primary-LIGHT px-0 py-2 uppercase lg:px-4"><?php _e( 'Gallery', 'mossco_fse' ); ?></a> <a href="#details-map" class="hover:text-primary-LIGHT px-0 py-2 uppercase lg:px-4"><?php _e( 'Location', 'mossco_fse' ); ?></a> <a href="#home-newsletter" class="hover:text-primary-LIGHT px-0 py-2 uppercase lg:px-4"><?php _e( 'Newsletter', 'mossco_fse' ); ?></a>
                                </ul>                                 <a href="#" class="active:bg-primary-DARK bg-primary-NORMAL duration-300 ease-out hover:bg-primary-LIGHT hover:ring hover:ring-primary-DARK inline-block px-5 py-2 rounded text-center text-white transition uppercase lg:h-10"><?php _e( 'Book a Table', 'mossco_fse' ); ?></a> 
                            </div>                             
                        </nav>
                    </div>
                </section>
            </div>
        </header>
        <main style="position: relative;">