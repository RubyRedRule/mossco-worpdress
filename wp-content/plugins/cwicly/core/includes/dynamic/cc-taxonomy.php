<?php

/**
 * Cwicly Taxonomy
 *
 * Functions for creating and managing Taxonomy block functions
 *
 * @package Cwicly\Functions
 * @version 1.1
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function cc_taxonomyterms_maker_v2($attributes, $block)
{
    global $post;
    $content = '';
    $masonClass = '';
    if (isset($attributes['repeaterMasonry']) && $attributes['repeaterMasonry']) {
        $masonClass = ' class="cc-masonry-item"';
    }
    if (isset($attributes['taxtermsSource']) && $attributes['taxtermsSource'] && $attributes['taxtermsSource'] === 'current') {
        if ((isset($block->context['query_index']) && $block->context['query_index']) || is_singular()) {
            $excluded = [];
            $taxExcluded = [];
            $included = [];
            $taxIncluded = [];

            if (isset($attributes['taxtermsInclude']) && $attributes['taxtermsInclude']) {
                foreach ($attributes['taxtermsInclude'] as $includer) {
                    if (isset($includer['taxonomy']) && $includer['taxonomy']) {
                        $taxIncluded[] = $includer['value'];
                    } else {
                        $included[] = $includer['value'];
                    }
                }
            }
            if (isset($attributes['taxtermsExclude']) && $attributes['taxtermsExclude']) {
                foreach ($attributes['taxtermsExclude'] as $excluder) {
                    if (isset($excluder['taxonomy']) && $excluder['taxonomy']) {
                        if (!in_array($excluder['value'], $taxIncluded)) {
                            $taxExcluded[] = $excluder['value'];
                        }
                        // $taxExcluded[] = $excluder['value'];
                    } else {
                        if (!in_array($excluder['value'], $included)) {
                            $excluded[] = $excluder['value'];
                        }
                        // $excluded[] = $excluder['value'];
                    }
                }
            }

            $taxonomies = get_post_taxonomies();
            if ($taxExcluded) {
                foreach ($taxonomies as $key => $value) {
                    if (in_array($value, $taxExcluded)) {
                        unset($taxonomies[$key]);
                    }
                }
            }
            if ($taxIncluded) {
                foreach ($taxonomies as $key => $value) {
                    if (!in_array($value, $taxIncluded)) {
                        unset($taxonomies[$key]);
                    }
                }
            }

            $arrays = array();
            foreach ($taxonomies as $tax) {
                $result = get_the_terms($post->ID, $tax);
                if (is_array($result)) {
                    $arrays = array_merge($arrays, $result);
                }
            }

            if ($included) {
                $arrays = array_filter($arrays, function ($array) use ($included) {
                    return in_array($array->term_id, $included);
                });
            }

            $count = 1;
            $limit = null;

            if (isset($attributes['taxtermsNumber']) && $attributes['taxtermsNumber']) {
                $limit = $attributes['taxtermsNumber'];
            }

            foreach ($arrays as $index => $tax) {
                if (isset($tax) && $tax) {
                    if (!in_array($tax->term_id, $excluded)) {
                        if (!$limit || $count <= intval($limit)) {
                            $count = $count + 1;
                            $block_content = '';
                            foreach ($block->parsed_block['innerBlocks'] as $innerBlock) {
                                $block_content .= (new WP_Block(
                                    $innerBlock,
                                    array(
                                        'postType' => get_post_type(),
                                        'postId' => get_the_ID(),
                                        'taxterms' => $tax,
                                        'taxterms_index' => $index + 1,
                                        'rendered' => true,
                                    )
                                ))->render(array('dynamic' => true));
                            }
                            // $content .= "<div $masonClass>$block_content</div>";

                            if (isset($attributes['repeaterSlider']) && $attributes['repeaterSlider']) {
                                $content .= '<li class="splide__slide">' . $block_content . '</li>';
                            } else {
                                $content .= '<div ' . $masonClass . '>' . $block_content . '</div>';
                            }
                            // $bloginfo =  get_the_terms($post_id, $data->get_param('taxonomy'));
                        }
                    }
                }
            }
        } else {
            $excluded = [];
            if (isset($attributes['taxtermsExclude']) && $attributes['taxtermsExclude']) {
                foreach ($attributes['taxtermsExclude'] as $excluder) {
                    $excluded[] = $excluder['value'];
                }
            }

            $count = 1;
            $limit = null;

            if (isset($attributes['taxtermsNumber']) && $attributes['taxtermsNumber']) {
                $limit = $attributes['taxtermsNumber'];
            }

            $object = get_queried_object();
            if (isset($object) && $object) {
                if ((isset($object->term_id) && !in_array($object->term_id, $excluded)) || !isset($object->term_id)) {
                    if (!$limit || $count <= intval($limit)) {
                        $count = $count + 1;
                        $block_content = '';
                        foreach ($block->parsed_block['innerBlocks'] as $innerBlock) {
                            $block_content .= (new WP_Block(
                                $innerBlock,
                                array(
                                    'postType' => get_post_type(),
                                    'postId' => get_the_ID(),
                                    'taxterms' => $object,
                                    'rendered' => true,
                                )
                            ))->render(array('dynamic' => true));
                        }
                        // $content .= "<div $masonClass>$block_content</div>";
                        if (isset($attributes['repeaterSlider']) && $attributes['repeaterSlider']) {
                            $content .= '<li class="splide__slide">' . $block_content . '</li>';
                        } else {
                            $content .= '<div ' . $masonClass . '>' . $block_content . '</div>';
                        }
                    }
                }
            }
        }
        // get_post_taxonomies($post_id);
    } else if (isset($attributes['taxtermsSource']) && $attributes['taxtermsSource'] && $attributes['taxtermsSource'] === 'custom' && isset($attributes['taxtermsPostType']) && $attributes['taxtermsPostType']) {
        $postTypes = [];
        $postTaxonomies = [];
        $excluded = [];
        $included = [];
        if (isset($attributes['taxtermsExclude']) && $attributes['taxtermsExclude']) {
            foreach ($attributes['taxtermsExclude'] as $excluder) {
                $excluded[] = $excluder['value'];
            }
        }
        if (isset($attributes['taxtermsInclude']) && $attributes['taxtermsInclude']) {
            $included = [];
            foreach ($attributes['taxtermsInclude'] as $includer) {
                $included[] = $includer['value'];
            }
        }

        foreach ($attributes['taxtermsPostType'] as $type) {
            $postTypes[] = $type['value'];
            $currentPostTaxonomies = get_object_taxonomies($type['value']);
            foreach ($currentPostTaxonomies as $each) {
                if (!in_array($each, $postTaxonomies)) {
                    $postTaxonomies[] = $each;
                }
            }
        }

        $excludeCurrent = false;
        if (isset($attributes['taxtermsExcludeCurrent']) && $attributes['taxtermsExcludeCurrent']) {
            $excludeCurrent = true;
        }

        if (isset($attributes['taxtermsTaxonomies']) && $attributes['taxtermsTaxonomies']) {
            $selectedTax = [];
            foreach ($attributes['taxtermsTaxonomies'] as $type) {
                $selectedTax[] = $type['value'];
            }
            $terms = get_terms(array(
                'taxonomy' => $selectedTax,
                'orderby' => (isset($attributes['taxtermsOrderBy']) && $attributes['taxtermsOrderBy']) ? $attributes['taxtermsOrderBy'] : 'name',
                'order' => (isset($attributes['taxtermsOrderDirection']) && $attributes['taxtermsOrderDirection']) ? $attributes['taxtermsOrderDirection'] : 'ASC',
                'hide_empty' => isset($attributes['taxtermsHideEmpty']) && $attributes['taxtermsHideEmpty'] ? filter_var($attributes['taxtermsHideEmpty'], FILTER_VALIDATE_BOOLEAN) : false,
                'exclude' => $excluded,
                'include' => $included,
                // 'offset' => $data->get_param('offset') ? $data->get_param('orderby') : '',
                // 'parent'   => 0
            ));

            $count = 1;
            $limit = null;

            if (isset($attributes['taxtermsNumber']) && $attributes['taxtermsNumber']) {
                $limit = $attributes['taxtermsNumber'];
            }

            foreach ($terms as $index => $term) {
                if (($excludeCurrent && (!is_archive() || (isset($block->context['query_index']) && $block->context['query_index'])) && !has_term($term->term_id, $term->taxonomy)) || ($excludeCurrent && is_archive() && !isset($block->context['query_index']) && get_queried_object()->term_id != $term->term_id) || !$excludeCurrent) {
                    if (!$limit || $count <= intval($limit)) {
                        $count = $count + 1;
                        $block_content = '';
                        foreach ($block->parsed_block['innerBlocks'] as $innerBlock) {
                            $block_content .= (new WP_Block(
                                $innerBlock,
                                array(
                                    'postType' => get_post_type(),
                                    'postId' => get_the_ID(),
                                    'taxterms' => $term,
                                    'taxterms_index' => $index + 1,
                                    'rendered' => true,
                                )
                            ))->render(array('dynamic' => true));
                        }
                        // $content .= "<div $masonClass>$block_content</div>";
                        if (isset($attributes['repeaterSlider']) && $attributes['repeaterSlider']) {
                            $content .= '<li class="splide__slide">' . $block_content . '</li>';
                        } else {
                            $content .= '<div ' . $masonClass . '>' . $block_content . '</div>';
                        }
                    }
                }
            }
        } else {
            $terms = get_terms(array(
                'taxonomy' => array(),
                'orderby' => (isset($attributes['taxtermsOrderBy']) && $attributes['taxtermsOrderBy']) ? $attributes['taxtermsOrderBy'] : 'name',
                'order' => (isset($attributes['taxtermsOrderDirection']) && $attributes['taxtermsOrderDirection']) ? $attributes['taxtermsOrderDirection'] : 'ASC',
                'hide_empty' => isset($attributes['taxtermsHideEmpty']) && $attributes['taxtermsHideEmpty'] ? filter_var($attributes['taxtermsHideEmpty'], FILTER_VALIDATE_BOOLEAN) : false,
                'exclude' => $excluded,
                'include' => $included,
                // 'offset' => $data->get_param('offset') ? $data->get_param('orderby') : '',
                // 'parent'   => 0
            ));

            $count = 1;
            $limit = null;

            if (isset($attributes['taxtermsNumber']) && $attributes['taxtermsNumber']) {
                $limit = $attributes['taxtermsNumber'];
            }

            foreach ($terms as $index => $term) {
                if (($excludeCurrent && (!is_archive() || (isset($block->context['query_index']) && $block->context['query_index'])) && !has_term($term->term_id, $term->taxonomy)) || ($excludeCurrent && is_archive() && !isset($block->context['query_index']) && get_queried_object()->term_id != $term->term_id) || !$excludeCurrent) {
                    if (in_array($term->taxonomy, $postTaxonomies) && (!$limit || $count <= intval($limit))) {
                        $count = $count + 1;
                        $block_content = '';
                        foreach ($block->parsed_block['innerBlocks'] as $innerBlock) {
                            $block_content .= (new WP_Block(
                                $innerBlock,
                                array(
                                    'postType' => get_post_type(),
                                    'postId' => get_the_ID(),
                                    'taxterms' => $term,
                                    'taxterms_index' => $index + 1,
                                    'rendered' => true,
                                )
                            ))->render(array('dynamic' => true));
                        }
                        // $content .= "<div $masonClass>$block_content</div>";
                        if (isset($attributes['repeaterSlider']) && $attributes['repeaterSlider']) {
                            $content .= '<li class="splide__slide">' . $block_content . '</li>';
                        } else {
                            $content .= '<div ' . $masonClass . '>' . $block_content . '</div>';
                        }
                        // $bloginfo =  get_the_terms($post_id, $data->get_param('taxonomy'));
                    }
                }
            }
        }
        // print_r($postTypes);
    }

    // return $content;
    return addcslashes($content, '$');
}
