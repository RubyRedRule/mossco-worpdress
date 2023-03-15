<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function cwicly_querypagination_register()
{
    register_block_type(__DIR__, array(
        'render_callback' => 'cc_query_pagination_render_callback',
    ));
}
add_action('init', 'cwicly_querypagination_register');

function cc_query_pagination_render_callback($attributes, $content, $block)
{
    if (isset($attributes['queryPaginationAjax']) && $attributes['queryPaginationAjax'] && !is_admin()) {
        wp_enqueue_script('pjax', CWICLY_DIR_URL . 'assets/js/pjax.js', null, CWICLY_VERSION, true);
        wp_enqueue_script('cc-pagination', CWICLY_DIR_URL . 'assets/js/cc-pagination.min.js', array('pjax'), CWICLY_VERSION, true);
    }
    if (isset($attributes['effectsTiltControl']) && $attributes['effectsTiltControl']) {
        wp_enqueue_script('cc-tilter', CWICLY_DIR_URL . 'assets/js/tilter.js', null, CWICLY_VERSION, true);
    }

    $hideLoggedin = cc_hide_logged_in($attributes);
    $hideGuest = cc_hide_guest($attributes);

    if ($hideGuest && $hideLoggedin && cc_conditions_maker($attributes, $block)) {
        if (isset($block->context['frontendRendering']) && $block->context['frontendRendering']) {
            $innerBlocks = (new CCQueryTemplater)->template($block, true);
            $skeleton_html_no_anim = (new CCSkeletoner)->cc_skeleton_block($block);
            $skeleton_html = (new CCSkeletoner)->cc_skeleton_block($block, true);
            $skeleton = array('html' => $skeleton_html);

            // FILTER
            $repeated = false;
            if (isset($block->context['rendered'])) {
                $repeated = true;
            }
            if (!$repeated) {
                add_action('wp_head', function () use ($innerBlocks, $attributes) {
                    echo '<script id="' . $attributes['id'] . '-qpt-json" type="application/json">' . json_encode($innerBlocks, JSON_UNESCAPED_SLASHES) . '</script>';
                });
                add_action('wp_head', function () use ($skeleton, $attributes) {
                    echo '<script id="' . $attributes['id'] . '-qpt-skeleton" type="application/json">' . json_encode($skeleton, JSON_UNESCAPED_SLASHES) . '</script>';
                });
            }
            // FILTER
        }

        return cc_render($content, $attributes, $block);
    }
}
