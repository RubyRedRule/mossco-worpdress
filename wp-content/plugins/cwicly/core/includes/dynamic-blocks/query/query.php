<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
function cwicly_query_register()
{
    register_block_type(__DIR__, array(
        'render_callback' => 'cc_query_render_callback',
    ));
}
add_action('init', 'cwicly_query_register');

function cc_query_render_callback($attributes, $content, $block)
{
    $hideLoggedin = cc_hide_logged_in($attributes);
    $hideGuest = cc_hide_guest($attributes);

    if (isset($attributes['infiniteLoad']) && $attributes['infiniteLoad'] && !is_admin()) {
        wp_enqueue_script('cc-infinite', CWICLY_DIR_URL . 'assets/js/infinite-scroll.js', null, false, true);
        wp_enqueue_script('cc-query-infinite', CWICLY_DIR_URL . 'assets/js/cc-query-infinite.min.js', null, false, true);
        wp_enqueue_style('cc-loaders', CWICLY_DIR_URL . 'assets/css/loaders.min.css');
    }

    if (isset($attributes['effectsTiltControl']) && $attributes['effectsTiltControl']) {
        wp_enqueue_script('cc-tilter', CWICLY_DIR_URL . 'assets/js/tilter.js', null, CWICLY_VERSION, true);
    }

    if (isset($attributes['queryType']) && $attributes['queryType'] === 'comments') {
        wp_enqueue_script('comment-reply');
    } else if (isset($attributes['queryType']) && $attributes['queryType'] === 'products') {
        wp_enqueue_script('CCWoo', CWICLY_DIR_URL . 'assets/js/cc-woocommerce.min.js', null, CWICLY_VERSION, true);
    }

    if ($hideGuest && $hideLoggedin && cc_conditions_maker($attributes, $block)) {

        if (isset($attributes['frontendRendering']) && $attributes['frontendRendering'] && !is_admin()) {
            $queryParams = cc_query_fr_args($attributes, $block);
            // FRONTEND RENDERING

            if (!is_admin()) {
                wp_enqueue_script('CCdyn', CWICLY_DIR_URL . 'assets/js/ccdyn/main.js', null, CWICLY_VERSION, true);
                wp_enqueue_style('CCdyn', CWICLY_DIR_URL . 'assets/js/ccdyn/bundle.css');
            }

            if (isset($queryParams['postsPerPage']) && $queryParams['postsPerPage']) {
                $attributes['postsPerPage'] = $queryParams['postsPerPage'];
            }

            $queryType = '';
            if (isset($attributes['queryInherit']) && $attributes['queryInherit']) {
                $queryType = get_post_type();
                if ($queryType === 'product') {
                    $queryType = 'products';
                } else if ($queryType === 'user') {
                    $queryType = 'users';
                } else if ($queryType === 'term') {
                    $queryType = 'terms';
                } else {
                    $queryType = 'posts';
                }
            } else {
                $queryType = $attributes['queryType'];
            }

            add_action('wp_head', function () use ($attributes, $queryParams, $queryType) {
                echo '<script id="' . $attributes['id'] . '-args" type="application/json">' . json_encode(array('queryargs' => $queryParams['query_args'], 'queryargsnoget' => $queryParams['all_query_args_no_get'], 'querytype' => $queryType, 'params' => $queryParams['params'], 'postsperpage' => $queryParams['postsPerPage']), JSON_UNESCAPED_SLASHES) . '</script>' . PHP_EOL;
            });
            // FRONTEND RENDERING
        }
        $args = array();

        if (isset($attributes['hideConditionsType']) && $attributes['hideConditionsType'] && $attributes['hideConditionsType'] === '&&') {
            $is_checking = false;
            if (isset($attributes['hideConditions']) && $attributes['hideConditions']) {
                foreach ($attributes['hideConditions'] as $condition) {
                    if ($condition['condition'] === 'queryhasitems' && !$is_checking) {
                        if ($condition['operator'] === 'true') {
                            $args['hasToHaveItems'] = true;
                        } else {
                            $args['hasToHaveItems'] = false;
                        }
                        $is_checking = true;
                    }
                }
            }
        }
        return cc_render($content, $attributes, $block, $args);
    }
}
