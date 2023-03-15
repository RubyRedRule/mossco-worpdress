<?php
function fancybox_enqueue_scripts() {
    wp_deregister_script('fancybox-script');
    wp_enqueue_script('fancybox-script', get_template_directory_uri() . '/assets/@fancyapps/ui/src/Fancybox/Fancybox.js', [], '1.0', true);
    
    add_filter("script_loader_tag", "add_module_to_fancybox_script", 10, 3);
    function add_module_to_fancybox_script($tag, $handle, $src)
    {
        if ("fancybox-script" === $handle) {
            $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
        }
    
        return $tag;
    }
}
    add_action( 'wp_enqueue_scripts', 'fancybox_enqueue_scripts' );
    
    ?>