<?php

/**
 * Cwicly Queries
 *
 * Functions for creating and managing queries
 *
 * @package Cwicly\Functions
 * @version 1.1
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

require_once CWICLY_DIR_PATH . 'core/includes/dynamic/query/args.php';

function cc_query_fr_args($attributes, $block)
{
    $all_query_args = cc_query_front_args($attributes, true, $block);

    $old_get = $_GET;
    $_GET = null;
    $all_query_args_no_get = cc_query_front_args($attributes, false, $block);
    $_GET = $old_get;

    $query_args = $all_query_args['args'];

    $params = $all_query_args['params'];

    $starting_offset = '';
    if (isset($query_args['offset']) && $query_args['offset']) {
        $starting_offset = $query_args['offset'];
    }

    if (isset($attributes['queryPage']['field']) && $attributes['queryPage']['field']) {
        $page_key = $attributes['queryPage']['field'];
    } else {
        $page_key = isset($attributes['queryId']) ? 'query-' . $attributes['queryId'] . '-page' : 'query-page';
        if (empty($_GET[$page_key])) {
            $query_args['paged'] = 1;
            $query_args['page'] = 1;
        } else {
            $query_args['paged'] = (int) $_GET[$page_key];
            $query_args['page'] = (int) $_GET[$page_key];
        }
    }

    // FOR OFFSETING CORRECTLY
    if (isset($query_args['offset']) && $query_args['offset']) {
        if (isset($query_args['paged']) && $query_args['paged']) {
            if (isset($query_args['posts_per_page']) && $query_args['posts_per_page']) {
                $query_args['offset'] = (intval($query_args['posts_per_page']) * (intval($query_args['paged']) - 1)) + (intval($query_args['offset']));
            } else {
                $default_posts_per_page = get_option('posts_per_page');
                $query_args['offset'] = (intval($default_posts_per_page) * (intval($query_args['paged']) - 1)) + (intval($query_args['offset']));
            }
        }
    } else if ($attributes['queryType'] === 'terms' && isset($query_args['number']) && $query_args['number'] && isset($query_args['offset']) && $query_args['offset']) {
        if (isset($query_args['paged']) && $query_args['paged']) {
            $query_args['offset'] = (intval($query_args['number']) * (intval($query_args['paged']) - 1)) + (intval($query_args['offset']));
        }
    } else if ($attributes['queryType'] === 'terms' && isset($query_args['number']) && $query_args['number']) {
        if (isset($query_args['paged']) && $query_args['paged']) {
            $query_args['offset'] = (intval($query_args['number']) * (intval($query_args['paged']) - 1));
        }
    }
    // FOR OFFSETING CORRECTLY

    // Override the custom query with the global query if needed.
    $use_global_query = (isset($attributes['queryInherit']) && $attributes['queryInherit']);
    if ($use_global_query) {
        global $wp_query;
        if ($wp_query && isset($wp_query->query_vars) && is_array($wp_query->query_vars)) {
            unset($query_args['offset']);
            $query_args = wp_parse_args($wp_query->query_vars, $query_args);

            if (empty($query_args['post_type']) && is_singular()) {
                $query_args['post_type'] = get_post_type(get_the_ID());
            }
        }
    }
    ;

    $postsPerPage = get_option('posts_per_page');
    if ($attributes['queryType'] === 'products' && isset($query_args['limit']) && $query_args['limit']) {
        $postsPerPage = $query_args['limit'];
    } else if (isset($query_args['posts_per_page']) && $query_args['posts_per_page']) {
        $postsPerPage = $query_args['posts_per_page'];
    }

    return array(
        'query_args' => $query_args,
        'all_query_args_no_get' => $all_query_args_no_get,
        'params' => $params,
        'postsPerPage' => $postsPerPage,
    );
}
