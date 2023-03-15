<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function cwicly_div_register()
{
    register_block_type(__DIR__, array(
        'render_callback' => 'cc_div_render_callback',
    ));
}
add_action('init', 'cwicly_div_register');

function cc_div_render_callback($attributes, $content, $block)
{

    if (isset($attributes['effectsTiltControl']) && $attributes['effectsTiltControl']) {
        wp_enqueue_script('cc-tilter', CWICLY_DIR_URL . 'assets/js/tilter.js', null, CWICLY_VERSION, true);
    }

    $hideLoggedin = cc_hide_logged_in($attributes);
    $hideGuest = cc_hide_guest($attributes);

    if ($hideGuest && $hideLoggedin && cc_conditions_maker($attributes, $block)) {
        if (!is_admin() && isset($attributes['dynamicContext']) && $attributes['dynamicContext'] === 'woocart') {
            // FRONTEND RENDERING
            $decoded = (new CCQueryTemplater)->singleBlock($block, false)[0];
            wp_enqueue_script('CCdyn', CWICLY_DIR_URL . 'assets/js/ccdyn/main.js', null, CWICLY_VERSION, true);
            wp_enqueue_style('CCdyn', CWICLY_DIR_URL . 'assets/js/ccdyn/bundle.css');

            add_action('wp_head', function () use ($decoded, $attributes) {
                echo '<script id="' . $attributes['id'] . '-ft-json" type="application/json">' . json_encode($decoded, JSON_UNESCAPED_SLASHES) . '</script>';
            });
            // FRONTEND RENDERING
        }
        return cc_render($content, $attributes, $block);
    }
}
