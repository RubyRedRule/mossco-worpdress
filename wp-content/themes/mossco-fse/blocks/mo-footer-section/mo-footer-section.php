<footer <?php if(empty($_GET['context']) || $_GET['context'] !== 'edit') echo get_block_wrapper_attributes( array('class' => "bg-primary-NORMAL font-light py-12 text-gray-500", 'data-pg-ia-scene' => '{"l":[{"name":"Mossco logo footer","t":".container #gt# div:nth-of-type(1) #gt# div:nth-of-type(1) #gt# img","a":"fadeInUp","p":"time","s":"20%"},{"t":".container #gt# div:nth-of-type(1) #gt# div:nth-of-type(2) #gt# img","p":"time","s":"30%","a":{"l":[{"t":"","l":[{"t":"set","p":0,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":0,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]}}]}', ) ); else echo 'data-wp-block-props="true"'; ?>> 
    <div class="container max-w-screen-xl mx-auto px-4"> 
        <div class="footer-bg gap-2 grid grid-cols-1 pb-6 md:grid-cols-2">
            <div class="col-span-1 grid place-items-center md:place-items-start">
                <?php if ( !PG_Blocks::getImageSVG( $args, 'mo_footer_logo_1', false) && PG_Blocks::getImageUrl( $args, 'mo_footer_logo_1', 'full' ) ) : ?>
                    <img src="<?php echo PG_Blocks::getImageUrl( $args, 'mo_footer_logo_1', 'full' ) ?>" class="<?php echo (PG_Blocks::getImageField( $args, 'mo_footer_logo_1', 'id', true) ? ('wp-image-' . PG_Blocks::getImageField( $args, 'mo_footer_logo_1', 'id', true)) : '') ?> md:pb-0 md:w-56 pb-8 w-60" data-pg-ia-hide alt="<?php echo PG_Blocks::getImageField( $args, 'mo_footer_logo_1', 'alt', true); ?>">
                <?php endif; ?>
                <?php if ( PG_Blocks::getImageSVG( $args, 'mo_footer_logo_1', false) ) : ?>
                    <?php echo PG_Blocks::mergeInlineSVGAttributes( PG_Blocks::getImageSVG( $args, 'mo_footer_logo_1' ), array( 'class'=> 'pb-8 w-60 md:pb-0 md:w-56', 'data-pg-ia-hide'=> null ) ) ?>
                <?php endif; ?>
                <?php if ( has_nav_menu( 'footer' ) ) : ?>
                    <?php
                        PG_Smart_Walker_Nav_Menu::init();
                        PG_Smart_Walker_Nav_Menu::$options['template'] = '<li class="border-primary_bg-NORMAL border-r-2 border-solid mr-4 pr-4 {CLASSES}" id="{ID}"> <a class="hover:text-primary-LIGHT" {ATTRS}>{TITLE}</a> 
                                                    </li>';
                        wp_nav_menu( array(
                            'container' => '',
                            'theme_location' => 'footer',
                            'items_wrap' => '<ul class="%2$s flex font-sans justify-between mt-auto text-Mossco-grey-background" id="%1$s">%3$s</ul>',
                            'walker' => new PG_Smart_Walker_Nav_Menu()
                    ) ); ?>
                <?php endif; ?>
            </div>
            <div class="col-span-1 grid place-items-center md:place-items-end">
                <?php if ( !PG_Blocks::getImageSVG( $args, 'mo_footer_logo_2', false) && PG_Blocks::getImageUrl( $args, 'mo_footer_logo_2', 'full' ) ) : ?>
                    <img src="<?php echo PG_Blocks::getImageUrl( $args, 'mo_footer_logo_2', 'full' ) ?>" class="<?php echo (PG_Blocks::getImageField( $args, 'mo_footer_logo_2', 'id', true) ? ('wp-image-' . PG_Blocks::getImageField( $args, 'mo_footer_logo_2', 'id', true)) : '') ?> md:pb-2 md:pt-0 md:w-56 pb-4 pt-8 w-64" data-pg-ia-hide alt="<?php echo PG_Blocks::getImageField( $args, 'mo_footer_logo_2', 'alt', true); ?>">
                <?php endif; ?>
                <?php if ( PG_Blocks::getImageSVG( $args, 'mo_footer_logo_2', false) ) : ?>
                    <?php echo PG_Blocks::mergeInlineSVGAttributes( PG_Blocks::getImageSVG( $args, 'mo_footer_logo_2' ), array( 'class'=> 'pb-4 pt-8 w-64 md:pb-2 md:pt-0 md:w-56', 'data-pg-ia-hide'=> null ) ) ?>
                <?php endif; ?>
                    <div class="flex-wrap inline-flex justify-center justify-end justify-self-auto pb-4 pt-6 space-x-12 text-Mossco-grey-background w-full md:justify-end md:pb-0 md:space-x-6" style="grid-area:2 / 1 / 3 / 2;" <?php if(!empty($_GET['context']) && $_GET['context'] === 'edit') echo 'data-wp-inner-blocks'; ?>>
                    <?php if(empty($_GET['context']) || $_GET['context'] !== 'edit') echo PG_Blocks::getInnerContent( $args ); ?>
                </div>
            </div>
        </div>         
        <div class="pb-4 text-center"> 
            <hr class="border-Mossco-grey-background mb-4"> 
            <p class="font-sans text-sm text-white"><?php echo PG_Blocks::getAttribute( $args, 'm_footer_copyright' ) ?></p> 
        </div>         
        <div data-empty-placeholder></div>
    </div>     
</footer>