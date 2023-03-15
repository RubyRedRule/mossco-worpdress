<?php

/**
 * Cwicly Swatch
 *
 * Functions for creating and managing Swatches
 *
 * @package Cwicly\Functions
 * @version 1.1
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Cwicly Swatch Maker
 *
 * Functions for creating dynamic swatches based on Repeater or Variable Slug
 *
 * @package Cwicly\Functions
 * @version 1.1
 */
function cc_swatch_maker($attributes, $block, $classes, $divAdditions, $htmlAttributes)
{
    $content = '';
    global $post;
    if (isset($block->context['postId']) && $block->context['postId']) {
        $post = get_post($block->context['postId']);
    }
    if (CC_WOOCOMMERCE) {
        global $product;
        if (!is_object($product)) {
            $product = wc_get_product(get_the_ID());
        }

        $old_product = $product;
        if (isset($block->context['product']) && $block->context['product']) {
            $product = $block->context['product'];
        }

        $defaults = array();
        if ($product) {
            $defaults = $product->get_default_attributes();
        }
        $tag = 'div';
        if (isset($attributes['containerLayoutTag']) && $attributes['containerLayoutTag']) {
            $tag = $attributes['containerLayoutTag'];
        }

        // if (isset($block->context['wooVariable']) && $block->context['wooVariable'] && $block->context['isRepeater']) {
        if (isset($block->context['wooVariable']) && $block->context['wooVariable'] && isset($attributes['swatchSlug']) && strpos($attributes['swatchSlug'], 'g_') === false && isset($block->context['wooVariable']['terms']) && $attributes['swatchType'] && $block->context['wooVariable']['type'] === $attributes['swatchType']) {
            $context = $block->context['wooVariable'];
            if (isset($context['terms'])) {

                if ($attributes['swatchSlug']) {
                    if ($attributes['swatchType'] === 'select') {
                        $content .= '<option value="">' . __('Choose an option', 'woocommerce') . '</option>';
                    }
                    foreach ($context['terms'] as $swatcher) {
                        $content .= cc_swatch_helper($attributes, $block, $swatcher['type'], $swatcher['name'], $swatcher['slug'], $defaults, $classes, $tag, $divAdditions, $htmlAttributes, true, $block->context['wooVariable']['slug']);
                    }
                }
            }
        } else if (isset($attributes['swatchType']) && ((isset($block->context['wooVariable']['type']) && $block->context['wooVariable']['type'] === $attributes['swatchType']) || ($attributes['swatchType'] === 'select')) && isset($attributes['swatchSlug']) && $attributes['swatchSlug'] && strpos($attributes['swatchSlug'], 'g_') !== false) {

            if ($product && $product->get_type() === 'variable') {
                if ($attributes['swatchSlug']) {
                    if ($attributes['swatchType'] === 'select') {
                        $content .= '<option value="">' . __('Choose an option', 'woocommerce') . '</option>';
                    }

                    foreach ($product->get_variation_attributes() as $taxonomy => $terms_slug) {

                        // Setting some data in an array
                        $type = wc_get_attribute(wc_attribute_taxonomy_id_by_name($taxonomy)) ? wc_get_attribute(wc_attribute_taxonomy_id_by_name($taxonomy))->type : 'select';
                        $slug = $taxonomy;

                        if ($type === $attributes['swatchType']) {
                            if (taxonomy_exists($taxonomy)) {
                                $terms = wc_get_product_terms(
                                    $product->get_id(),
                                    $taxonomy,
                                    array(
                                        'fields' => 'all',
                                    )
                                );
                                foreach ($terms as $term) {
                                    $terms = wc_get_product_terms(
                                        $product->get_id(),
                                        $taxonomy,
                                        array(
                                            'fields' => 'all',
                                        )
                                    );

                                    $term_id = $term->term_id; // The ID  <==  <==  <==  <==  <==  <==  HERE
                                    $term_name = $term->name; // The Name
                                    $term_slug = $term->slug; // The Slug

                                    $content .= cc_swatch_helper($attributes, $block, $term_id, $term_name, $term_slug, $defaults, $classes, $tag, $divAdditions, $htmlAttributes, true, isset($block->context['wooVariable']['slug']) ? $block->context['wooVariable']['slug'] : '');
                                }
                            } else {
                                foreach ($terms_slug as $term) {
                                    $content .= cc_swatch_helper($attributes, $block, 'select', $term, $term, $defaults, $classes, $tag, $divAdditions, $htmlAttributes, true, isset($block->context['wooVariable']['slug']) ? $block->context['wooVariable']['slug'] : '');
                                }
                            }
                        }
                    }
                }
            }
        }

        $product = $old_product;
        return $content;
    }
}

function cc_swatch_helper($attributes, $block, $swatcher_id, $swatcher_name, $swatcher_slug, $defaults, $classes, $tag, $divAdditions, $htmlAttributes, $repeater = false, $repeaterID = '')
{
    $content = '';
    // TOOLTIP
    $tooltip = false;
    $tooltiper = array();
    // TOOLTIP
    $selected = '';
    if (in_array($swatcher_slug, $defaults, true)) {
        $selected = ' selected';
    }
    $style = '';
    $term_type = '';
    if ($attributes['swatchType'] === 'image' && $swatcher_id) {
        if (!$repeater || is_int($swatcher_id)) {
            $term_type = wp_get_attachment_url(get_term_meta($swatcher_id, '_cwicly_image_id', true));
        } else {
            $term_type = $swatcher_id;
        }
        $style = 'style="background-image:url(\'' . $term_type . '\')" ';
    }
    if ($attributes['swatchType'] === 'color' && $swatcher_id) {
        $term_type = '';
        if (!$repeater || is_int($swatcher_id)) {
            $term_type = get_term_meta($swatcher_id, '_cwicly_color', true);
        } else {
            $term_type = $swatcher_id;
        }
        $style = 'style="background-color:' . $term_type . '" ';
    }
    if (isset($attributes['tooltipSource']) && $attributes['tooltipSource']) {
        if ($attributes['tooltipSource'] === 'swatchname' && $swatcher_name) {
            $tooltip = true;
            $tooltiper[] = 'data-tooltip="' . wp_filter_post_kses(htmlspecialchars($swatcher_name)) . '"';
        }
        if ($attributes['tooltipSource'] === 'swatchvalue' && $term_type) {
            $tooltip = true;
            $tooltiper[] = 'data-tooltip="' . wp_filter_post_kses(htmlspecialchars($term_type)) . '"';
        }
    }
    // TOOLTIP
    $tooltip_extras = cc_tooltip_extras($tooltip, $attributes);
    if ($tooltip_extras) {
        $tooltiper = array_merge($tooltiper, $tooltip_extras);
    }
    $tooltiper = implode(' ', array_filter($tooltiper));
    // TOOLTIP
    // QUERY ID ADD
    $queryID = '';
    // QUERY ID ADD

    $variationID = '';
    if ($repeaterID) {
        $variationID = strtolower($repeaterID);
    } else {
        $variationID = $attributes['swatchSlug'];
    }
    if ($attributes['swatchType'] !== 'select' && $attributes['swatchType'] !== 'button') {
        $content .= '<' . $tag . ' class="' . $classes . $selected . '"' . $queryID . ' data-variation="' . $variationID . '" data-value="' . $swatcher_slug . '" ' . $style . $divAdditions . $htmlAttributes . '' . $tooltiper . '>';
        if (isset($attributes['swatchText']) && $attributes['swatchText']) {
            $content .= $swatcher_name;
        }
        $content .= '</' . $tag . '>';
    } else if ($attributes['swatchType'] === 'button') {
        $content .= '<' . $tag . ' class="' . $classes . $selected . '"' . $queryID . ' data-variation="' . $variationID . '" data-value="' . $swatcher_slug . '" ' . $style . $divAdditions . $htmlAttributes . '>';
        $content .= $swatcher_name;
        // }
        $content .= '</' . $tag . '>';
    } else {
        $content .= '<option data-variation="' . $variationID . '" value="' . $swatcher_slug . '"' . $selected . '>' . $swatcher_name . '</option>';
    }
    return $content;
}
