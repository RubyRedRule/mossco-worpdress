<section <?php if(empty($_GET['context']) || $_GET['context'] !== 'edit') echo get_block_wrapper_attributes( array('class' => "container max-w-screen-xl menus-bg mx-auto py-20 scroll-smooth md:py-16", 'id' => "home-menus", 'data-pg-ia-scene' => '{"l":[{"name":"MENUS Header","t":"h3","a":"fadeInUp","p":"time","s":"30%","rev":"true"}]}', ) ); else echo 'data-wp-block-props="true"'; ?>>
    <section>
        <div>
            <h3 class="pb-4 text-3xl text-center text-primary-NORMAL uppercase md:pb-4" data-pg-ia-hide><?php _e( 'Menus', 'mossco_hc' ); ?></h3>
        </div>
            <div class="flex-wrap items-center justify-evenly md:flex lg:w-full xl:h-72" <?php if(!empty($_GET['context']) && $_GET['context'] === 'edit') echo 'data-wp-inner-blocks'; ?>>
            <?php if(empty($_GET['context']) || $_GET['context'] !== 'edit') echo PG_Blocks::getInnerContent( $args ); ?>
        </div>
    </section>
</section>