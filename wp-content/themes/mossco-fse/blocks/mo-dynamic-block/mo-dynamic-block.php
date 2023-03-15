<section <?php if(empty($_GET['context']) || $_GET['context'] !== 'edit') echo get_block_wrapper_attributes( array('class' => "container max-w-screen-xl menus-bg mx-auto py-20 scroll-smooth md:py-16", 'id' => "home-menus", 'data-pg-ia-scene' => '{"l":[{"name":"MENUS Header","t":"h3","a":"fadeInUp","p":"time","s":"30%","rev":"true"}]}', ) ); else echo 'data-wp-block-props="true"'; ?>>
    <section>
        <div>
            <h3 class="pb-4 text-3xl text-center text-primary-NORMAL uppercase md:pb-4" data-pg-ia-hide><?php _e( 'Menus', 'mossco_fse' ); ?></h3>
        </div>
        <?php
            $menu_query_args = array(
                'post_type' => 'menu',
                'nopaging' => true,
                'order' => 'ASC',
                'orderby' => 'menu_order'
            )
        ?>
        <?php $menu_query = new WP_Query( $menu_query_args ); ?>
        <?php if ( $menu_query->have_posts() ) : ?>
            <div class="items-center justify-evenly md:flex lg:w-full xl:h-72">
                <?php while ( $menu_query->have_posts() ) : $menu_query->the_post(); ?>
                    <?php PG_Helper_v2::rememberShownPost(); ?>
                    <a href="<?php echo esc_url( get_permalink() ); ?>" id="post-<?php the_ID(); ?>" <?php post_class(); ?>><div class="flex h-56 items-center justify-center m-5 menu-box overflow-hidden relative rounded-sm shadow-xl w-auto md:h-40 md:m-3 md:w-56 lg:h-48 lg:w-72 xl:h-52 xl:w-96">
                            <?php $image_attributes = !empty( get_the_ID() ) ? wp_get_attachment_image_src( PG_Image::isPostImage() ? get_the_ID() : get_post_thumbnail_id( get_the_ID() ), 'full' ) : null; ?>
                            <div class="absolute bg-center bg-cover bg-no-repeat cafe-menu-img duration-500 ease-in-out h-full hover:scale-150 rounded-sm transform transition-all w-full" style="<?php if($image_attributes) echo 'background-image:url(\''.$image_attributes[0].'\')' ?>"></div>
                            <?php $image_attributes = !empty( get_the_ID() ) ? wp_get_attachment_image_src( PG_Image::isPostImage() ? get_the_ID() : get_post_thumbnail_id( get_the_ID() ), 'full' ) : null; ?>
                            <div class="absolute bg-center bg-cover bg-no-repeat cafe-menu-img duration-500 ease-in-out h-full hover:scale-150 rounded-sm transform transition-all w-full" style="<?php if($image_attributes) echo 'background-image:url(\''.$image_attributes[0].'\')' ?>"></div>
                            <h2 class="absolute duration-500 ease-in-out font-bold font-serif menu-zoom-text opacity-60 scale-150 text-lg text-white transform transition-all"><?php the_title(); ?></h2>
                        </div></a>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        <?php else : ?>
            <p><?php _e( 'Sorry, no posts matched your criteria.', 'mossco_fse' ); ?></p>
        <?php endif; ?>
    </section>
</section>