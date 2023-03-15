<?php

/**
 * Cwicly Repeater
 *
 * Functions for creating and managing the repeaters
 *
 * @package Cwicly\Functions
 * @version 1.1
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Cwicly Dynamic Repeater
 *
 * Function for creating the repeater depending on the source
 *
 * @package Cwicly\Functions
 * @version 1.1
 */
function cc_repeater_maker($attributes, $block)
{
    $content = '';
    $masonClass = '';
    if (isset($attributes['repeaterMasonry']) && $attributes['repeaterMasonry']) {
        $masonClass = ' class="cc-masonry-item"';
    }

    // WOOCOMMERCE=
    if (isset($attributes['dynamic']) && $attributes['dynamic'] === 'woovariable') {
        if (CC_WOOCOMMERCE) {
            global $product;
            if (isset($block->context['product']) && $block->context['product']) {
                $product = $block->context['product'];
            }
            if (!is_object($product)) {
                $product = wc_get_product(get_the_ID());
            }

            if ($product && $product->get_type() === 'variable') {
                $variations = $product->get_variation_attributes();
                $counter = 0;
                foreach ($variations as $taxonomy => $terms_slug) {
                    $counter = $counter + 1;
                    // To get the attribute label (in WooCommerce 3+)
                    $taxonomy_label = wc_attribute_label($taxonomy, $product);
                    // Setting some data in an array
                    $variations_attributes_and_values[$taxonomy] = array('label' => $taxonomy_label);
                    if (isset(wc_get_attribute(wc_attribute_taxonomy_id_by_name($taxonomy))->type)) {
                        $variations_attributes_and_values[$taxonomy]['type'] = wc_get_attribute(wc_attribute_taxonomy_id_by_name($taxonomy))->type;
                    }
                    $variations_attributes_and_values[$taxonomy]['slug'] = $taxonomy;

                    if ($product && taxonomy_exists($taxonomy)) {
                        // Get terms if this is a taxonomy - ordered. We need the names too.
                        $terms = wc_get_product_terms(
                            $product->get_id(),
                            $taxonomy,
                            array(
                                'fields' => 'all',
                            )
                        );

                        foreach ($terms as $term) {
                            if (in_array($term->slug, $terms_slug, true)) {
                                $term_id = $term->term_id; // The ID
                                $term_name = $term->name; // The Name
                                $term_slug = $term->slug; // The Slug
                                $term_type = '';
                                if ($variations_attributes_and_values[$taxonomy]['type'] && $variations_attributes_and_values[$taxonomy]['type'] === 'color') {
                                    $term_type = get_term_meta($term_id, '_cwicly_color', true);
                                }
                                if ($variations_attributes_and_values[$taxonomy]['type'] && $variations_attributes_and_values[$taxonomy]['type'] === 'image') {
                                    $term_type = wp_get_attachment_url(get_term_meta($term_id, '_cwicly_image_id', true));
                                }

                                // Setting the terms ID and values in the array
                                $variations_attributes_and_values[$taxonomy]['terms'][$term_id] = array(
                                    'name' => $term_name,
                                    'slug' => $term_slug,
                                    'type' => $term_type,
                                );
                            }
                        }
                    }
                    if ($block->parsed_block) {
                        $block_content = '';
                        foreach ($block->parsed_block['innerBlocks'] as $innerBlock) {
                            $block_content .= (new WP_Block(
                                $innerBlock,
                                array(
                                    'postType' => get_post_type(),
                                    'postId' => get_the_ID(),
                                    'wooVariable' => $variations_attributes_and_values[$taxonomy],
                                    'repeater_row' => $counter,
                                    'isRepeater' => true,
                                    'query_index' => isset($block->context['query_index']) ? $block->context['query_index'] : null,
                                    'queryId' => isset($block->context['queryId']) ? $block->context['queryId'] : null,
                                    'product' => isset($block->context['product']) ? $block->context['product'] : null,
                                    'rendered' => true,
                                )
                            ))->render(array('dynamic' => true));
                        }
                        $content .= "<div $masonClass>$block_content</div>";
                    }
                }
            }
        }
    } else if (isset($attributes['dynamic']) && $attributes['dynamic'] === 'woogrouped') {
        global $post;
        global $product;
        $parentPro = $product;
        if (isset($block->context['product']) && $block->context['product']) {
            $product = $block->context['product'];
        }
        if ($product && $product->get_type() === 'grouped') {

            $products = array_filter(array_map('wc_get_product', $product->get_children()), 'wc_products_array_filter_visible_grouped');

            $quantites_required = false;
            $previous_post = $post;
            // $show_add_to_cart_button = false;

            foreach ($products as $index => $grouped_product_child) {
                $post_object = get_post($grouped_product_child->get_id());

                $product_id = ' data-cc-id="' . $grouped_product_child->get_id() . '"';
                $type = ' data-cc-woo-type="' . $grouped_product_child->get_type() . '"';

                $quantites_required = $quantites_required || ($grouped_product_child->is_purchasable() && !$grouped_product_child->has_options());
                $post = $post_object; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
                setup_postdata($post);
                $product = wc_get_product($grouped_product_child);
                if ($block->parsed_block) {
                    $block_content = '';
                    foreach ($block->parsed_block['innerBlocks'] as $innerBlock) {
                        $block_content .= (new WP_Block(
                            $innerBlock,
                            array(
                                'postType' => get_post_type(),
                                'postId' => get_the_ID(),
                                'product' => $product,
                                'parent_product' => $parentPro,
                                'isWooGrouped' => true,
                                'repeater_row' => $index + 1,
                                'queryId' => '',
                                'rendered' => true,
                            )
                        ))->render(array('dynamic' => true));
                    }
                    $content .= "<div$masonClass$product_id$type>$block_content</div>";
                }
            }
            $post = $previous_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
            setup_postdata($post);
            $product = $parentPro;
        }
    } else if (isset($attributes['dynamic']) && $attributes['dynamic'] === 'woocartitems') {
        if (CC_WOOCOMMERCE && WC()->cart) {
            global $post;
            $index = 0;
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                $post_object = get_post($cart_item['product_id']);
                $previous_post = $post;
                $post = $post_object;
                setup_postdata($post);
                if ($block->parsed_block['innerBlocks']) {
                    $block_content = '';
                    foreach ($block->parsed_block['innerBlocks'] as $innerBlock) {
                        $block_content .= (new WP_Block(
                            $innerBlock,
                            array(
                                'postType' => get_post_type(),
                                'postId' => get_the_ID(),
                                'product_index' => $index + 1,
                                'cart_key' => $cart_item_key,
                                'cart_item' => $cart_item,
                                'rendered' => true,
                            )
                        ))->render(array('dynamic' => true));
                    }
                    $content .= "<div $masonClass>$block_content</div>";
                }
                $index++;
                $post = $previous_post;
                setup_postdata($post);
            }
        }
    } else if (isset($attributes['dynamic']) && $attributes['dynamic'] === 'woogallery') {

        global $product;
        $parentPro = $product;
        if (isset($block->context['product']) && $block->context['product']) {
            $product = $block->context['product'];
        }
        if ($product) {
            $attachment_ids = [get_post_thumbnail_id($product->get_id())];
            $attachment_ids = array_merge($attachment_ids, $product->get_gallery_image_ids());

            $counter = 0;

            foreach ($attachment_ids as $attachment_id) {
                $counter = $counter + 1;
                $attribute = ' data-cc-image-id="' . $attachment_id . '"';
                if ($block->parsed_block) {
                    $block_content = '';
                    foreach ($block->parsed_block['innerBlocks'] as $innerBlock) {
                        $block_content .= (new WP_Block(
                            $innerBlock,
                            array(
                                'postType' => get_post_type(),
                                'postId' => get_the_ID(),
                                'isRepeater' => true,
                                'repeater_row' => $counter,
                                'query_index' => isset($block->context['query_index']) ? $block->context['query_index'] : null,
                                'queryId' => isset($block->context['queryId']) ? $block->context['queryId'] : null,
                                'product' => isset($block->context['product']) ? $block->context['product'] : null,
                                'gallery_image_id' => $attachment_id,
                                'rendered' => true,
                            )
                        ))->render(array('dynamic' => true));
                    }
                    if (isset($attributes['repeaterSlider']) && $attributes['repeaterSlider']) {
                        $content .= '<li class="splide__slide"' . $attribute . '>' . $block_content . '</li>';
                    } else {
                        $content .= "<div $masonClass>$block_content</div>";
                    }
                }
            }
        }
    } else if (isset($attributes['dynamic']) && $attributes['dynamic'] === 'woorelatedproducts') {

        global $post;
        global $product;
        $parentPro = $product;
        $previous_post = $post;

        if (isset($block->context['product']) && $block->context['product']) {
            $product = $block->context['product'];
        }
        if ($product) {
            $pre = wc_get_related_products($product->get_id());

            $counter = 0;

            foreach ($pre as $id) {
                $counter = $counter + 1;

                $the_product = wc_get_product($id);
                $post_object = get_post($id);
                $post = $post_object;
                setup_postdata($post);

                if ($block->parsed_block) {
                    $block_content = '';
                    foreach ($block->parsed_block['innerBlocks'] as $innerBlock) {
                        $block_content .= (new WP_Block(
                            $innerBlock,
                            array(
                                'postType' => 'product',
                                'postId' => $the_product->get_id(),
                                'isRepeater' => true,
                                'repeater_row' => $counter,
                                'query_index' => isset($block->context['query_index']) ? $block->context['query_index'] : null,
                                'queryId' => isset($block->context['queryId']) ? $block->context['queryId'] : null,
                                'product' => $the_product,
                                'rendered' => true,
                            )
                        ))->render(array('dynamic' => true));
                    }
                    if (isset($attributes['repeaterSlider']) && $attributes['repeaterSlider']) {
                        $content .= '<li class="splide__slide">' . $block_content . '</li>';
                    } else {
                        $content .= "<div $masonClass>$block_content</div>";
                    }
                }
            }
            $post = $previous_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
            setup_postdata($post);
            $product = $parentPro;
        }
    }
    // WOOCOMMERCE

    if (isset($attributes['dynamic']) && $attributes['dynamic'] === 'acf' && isset($attributes['dynamicACFField']) && $attributes['dynamicACFField']) {
        $postID = get_the_ID();
        if (isset($attributes['dynamicACFFieldLocation']) && $attributes['dynamicACFFieldLocation']) {
            if ($attributes['dynamicACFFieldLocation'] === 'postid' && isset($attributes['dynamicACFFieldLocationID']) && $attributes['dynamicACFFieldLocationID']) {
                $postID = $attributes['dynamicACFFieldLocationID'];
            } else if ($attributes['dynamicACFFieldLocation'] === 'option') {
                $postID = 'option';
            }
        }

        if (have_rows($attributes['dynamicACFField'], $postID)) {
            // Loop through rows.
            while (have_rows($attributes['dynamicACFField'], $postID)): the_row();
                $row = get_row_index() - 1;

                if ($block->parsed_block) {
                    $block_content = '';
                    foreach ($block->parsed_block['innerBlocks'] as $innerBlock) {
                        $block_content .= (new WP_Block(
                            $innerBlock,
                            array(
                                'postType' => get_post_type(),
                                'postId' => get_the_ID(),
                                'repeaters' => get_field($attributes['dynamicACFField'], $postID),
                                'repeater_row' => $row,
                                'rendered' => true,
                            )
                        ))->render(array('dynamic' => true));
                    }

                    if (isset($attributes['repeaterSlider']) && $attributes['repeaterSlider']) {
                        $content .= '<li class="splide__slide">' . $block_content . '</li>';
                    } else {
                        $content .= '<div ' . $masonClass . '>' . $block_content . '</div>';
                    }
                    // $content .= "<div $masonClass>$block_content</div>";
                }
                // Do something...

                // End loop.
            endwhile;

            // No value.
        }
        // Do something...
    } else if (isset($attributes['dynamic']) && $attributes['dynamic'] === 'repeater' && isset($attributes['dynamicRepeaterField']) && $attributes['dynamicRepeaterField']) {
        $postID = get_the_ID();

        $sub_repeater = get_sub_field($attributes['dynamicRepeaterField']);

        if (have_rows($attributes['dynamicRepeaterField'])) {
            // Loop through rows.
            while (have_rows($attributes['dynamicRepeaterField'])): the_row();

                $row = get_row_index() - 1;

                if ($block->parsed_block) {
                    $block_content = '';
                    foreach ($block->parsed_block['innerBlocks'] as $innerBlock) {
                        $block_content .= (new WP_Block(
                            $innerBlock,
                            array(
                                'postType' => get_post_type(),
                                'postId' => get_the_ID(),
                                'repeaters' => $sub_repeater,
                                'repeater_row' => $row,
                                'rendered' => true,
                            )
                        ))->render(array('dynamic' => true));
                    }
                    $content .= "<div $masonClass>$block_content</div>";
                }
                // Do something...

                // End loop.
            endwhile;

            // No value.
        }
        // Do something...
    }

    // return $content;
    return addcslashes($content, '$');
}
