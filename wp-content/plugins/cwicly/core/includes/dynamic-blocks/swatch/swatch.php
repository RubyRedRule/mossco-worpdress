<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

register_block_type(__DIR__, array(
    'render_callback' => 'cc_swatch_render_callback',
));

function cc_swatch_render_callback($attributes, $content, $block)
{
    $hideLoggedin = cc_hide_logged_in($attributes);
    $hideGuest = cc_hide_guest($attributes);

    if (isset($block->context['wooVariable']) && $block->context['wooVariable'] && isset($attributes['swatchSlug']) && $attributes['swatchSlug'] && strpos($attributes['swatchSlug'], 'g_') === false && isset($block->context['wooVariable']['terms']) && $attributes['swatchType'] && $block->context['wooVariable']['type'] === $attributes['swatchType']) {
        if ($hideGuest && $hideLoggedin && cc_conditions_maker($attributes, $block)) {
            $final = cc_render($content, $attributes, $block);
            return $final;
        }
    } else if (!isset($block->context['isRepeater']) || (isset($block->context['isRepeater']) && $block->context['isRepeater'] && isset($attributes['swatchType']) && ((isset($block->context['wooVariable']['type']) && $block->context['wooVariable']['type'] === $attributes['swatchType']) || ((!isset($block->context['wooVariable']['type']) || (isset($block->context['wooVariable']['type']) && !$block->context['wooVariable']['type'])) && $attributes['swatchType'] === 'select')) && isset($attributes['swatchSlug']) && $attributes['swatchSlug'] && strpos($attributes['swatchSlug'], 'g_') !== false)) {
        if ($hideGuest && $hideLoggedin && cc_conditions_maker($attributes, $block)) {
            $final = cc_render($content, $attributes, $block);
            return $final;
        }
    }
}
