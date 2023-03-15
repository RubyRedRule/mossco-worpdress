<section <?php if(empty($_GET['context']) || $_GET['context'] !== 'edit') echo get_block_wrapper_attributes( array('class' => "container max-w-screen-xl menus-bg mx-auto py-20 scroll-smooth md:py-16", 'id' => "home-menus", 'data-pg-ia-scene' => '{"l":[{"name":"MENUS Header","t":"h3","a":"fadeInUp","p":"time","s":"30%","rev":"true"}]}', ) ); else echo 'data-wp-block-props="true"'; ?>>
    <div>
        <h3 class="pb-4 text-3xl text-center text-primary-NORMAL uppercase md:pb-4" data-pg-ia-hide><?php _e( 'Menus', 'mossco_hc' ); ?></h3>
    </div>
    <div class="items-center justify-evenly md:flex lg:w-full xl:h-72">
        <a href="cafe-menu.html"><div class="flex h-56 items-center justify-center m-5 menu-box overflow-hidden relative rounded-sm shadow-xl w-auto md:h-40 md:m-3 md:w-56 lg:h-48 lg:w-72 xl:h-52 xl:w-96">
                <div class="absolute bg-center bg-cover bg-no-repeat cafe-menu-img duration-500 ease-in-out h-full hover:scale-150 rounded-sm transform transition-all w-full"></div>
                <h2 class="absolute duration-500 ease-in-out font-bold font-serif menu-zoom-text opacity-60 scale-150 text-lg text-white transform transition-all"><?php _e( 'Café Menu', 'mossco_hc' ); ?></h2>
            </div></a>
        <a href="day-menu.html"><div class="flex h-56 items-center justify-center m-5 menu-box menu-zoom overflow-hidden relative rounded-sm shadow-xl w-auto md:h-40 md:m-3 md:w-56 lg:h-48 lg:w-72 xl:h-52 xl:w-96">
                <div class="absolute bg-center bg-cover bg-no-repeat day-menu-img duration-500 ease-in-out h-full hover:scale-150 rounded-sm transform transition-all w-full"></div>
                <h2 class="absolute duration-500 ease-in-out font-bold font-serif menu-zoom-text opacity-60 scale-150 text-lg text-white transform transition-all"><?php _e( 'Day Menu', 'mossco_hc' ); ?></h2>
            </div></a>
        <a href="evening-menu.html"><div class="flex h-56 items-center justify-center m-5 menu-box menu-zoom overflow-hidden relative rounded-sm shadow-xl w-auto md:h-40 md:m-3 md:w-56 lg:h-48 lg:w-72 xl:h-52 xl:w-96">
                <div class="absolute bg-center bg-cover bg-no-repeat duration-500 ease-in-out evening-menu-img h-full hover:scale-150 rounded-sm transform transition-all w-full"></div>
                <h2 class="absolute duration-500 ease-in-out font-bold menu-zoom-text opacity-60 scale-150 text-lg text-white transform transition-all"><?php _e( 'Evening Menu', 'mossco_hc' ); ?></h2>
            </div></a>
    </div>
</section>