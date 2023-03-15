<?php

/**
 * Cwicly Filter Args Maker
 *
 * Functions for creating and managing Taxonomy Args
 *
 * @package Cwicly\Functions
 * @version 1.1
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
function cc_filter_args_maker(
    $taxonomies,
    $includes,
    $excludes,
    $parents,
    $orderbys,
    $orders,
    $childlesss,
    $hide_emptys
) {
    function cc_filter_array($array)
    {
        $final = array();
        if ($array) {
            foreach ($array as $select) {
                $final[] = $select['value'];
            }
        }
        return $final;
    }
    function cc_filter_single($select)
    {
        $final = '';
        if ($select) {
            $final = $select;
        }
        return $final;
    }
    $args = array();

    // $taxonomies = $data->get_param('filterData');
    // $includes = $data->get_param('filterInclude');
    // $excludes = $data->get_param('filterExclude');

    $taxonomy = cc_filter_array($taxonomies);
    $include = cc_filter_array($includes);
    $exclude = cc_filter_array($excludes);
    $parent = cc_filter_single($parents);
    $orderby = cc_filter_single($orderbys);
    $order = cc_filter_single($orders);
    $childless = $childlesss;
    $hide_empty = $hide_emptys;

    if ($taxonomy) {
        $args['taxonomy'] = $taxonomy;
    } else {
        $args['taxonomy'] = '';
    }
    if ($include) {
        $args['include'] = $include;
    }
    if ($exclude) {
        $args['exclude'] = $exclude;
    }
    if ($parent) {
        $args['parent'] = $parent;
    }
    if ($orderby) {
        $args['orderby'] = $orderby;
    }
    if ($order) {
        $args['order'] = $order;
    }
    if ($childless === true) {
        $args['childless'] = true;
    } else if ($childless === false) {
        $args['childless'] = false;
    }
    if ($hide_empty === true) {
        $args['hide_empty'] = true;
    } else if ($hide_empty === false) {
        $args['hide_empty'] = false;
    }

    return $args;
}
