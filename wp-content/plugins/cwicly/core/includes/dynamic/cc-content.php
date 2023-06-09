<?php

/**
 * Cwicly Content
 *
 * Functions for creating and managing the Content
 *
 * @package Cwicly\Functions
 * @version 1.1
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Cwicly Content Maker
 *
 * Create correct Content so that it processes like normal post_content
 *
 * @package Cwicly\Functions
 * @version 1.1
 */
function cc_content_maker($block)
{
    static $seen_ids = array();

    if (!isset($block->context['postId'])) {
        return '';
    }

    $post_id = $block->context['postId'];

    if (isset($seen_ids[$post_id])) {
        if (!is_admin()) {
            trigger_error(
                sprintf(
                    // translators: %s is a post ID (integer).
                    __('Could not render Post Content block with post ID: <code>%s</code>. Block cannot be rendered inside itself.'),
                    $post_id
                ),
                E_USER_WARNING
            );
        }

        $is_debug = defined('WP_DEBUG') && WP_DEBUG &&
        defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY;
        return $is_debug ?
        // translators: Visible only in the front end, this warning takes the place of a faulty block.
        __('[block rendering halted]') :
        '';
    }

    $seen_ids[$post_id] = true;

    if (!in_the_loop()) {
        the_post();
    }

    // When inside the main loop, we want to use queried object
    // so that `the_preview` for the current post can apply.
    // We force this behavior by omitting the third argument (post ID) from the `get_the_content`.
    $content = get_the_content();

    /** This filter is documented in wp-includes/post-template.php */
    $content = apply_filters('the_content', str_replace(']]>', ']]&gt;', $content));
    unset($seen_ids[$post_id]);

    if (empty($content)) {
        return '';
    } else {
        return $content;
    }
}
