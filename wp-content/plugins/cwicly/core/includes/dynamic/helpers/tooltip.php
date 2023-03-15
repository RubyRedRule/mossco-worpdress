<?php

/**
 * Cwicly Tooltip Helper
 *
 * Functions for creating and managing Tooltip Attributes and Includes
 *
 * @package Cwicly\Functions
 * @version 1.1
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function cc_tooltip_extras($tooltip, $attributes)
{
    $divAdditions = array();
    if ($tooltip) {
        if (isset($attributes['tooltipArrow']) && $attributes['tooltipArrow']) {
            $divAdditions[] = 'data-tooltiparrow="true"';
        }
        if (isset($attributes['tooltipAnimation']) && $attributes['tooltipAnimation']) {
            if ($attributes['tooltipAnimation'] === 'material') {
                wp_enqueue_style('tooltip-shift-away', CWICLY_DIR_URL . 'assets/css/tooltip/shift-away.css');
                wp_enqueue_style('tooltip-backdrop', CWICLY_DIR_URL . 'assets/css/tooltip/backdrop.css');
                $divAdditions[] = 'data-tooltipanimationfill="true"';
            } else {
                $divAdditions[] = 'data-tooltipanimation="' . $attributes['tooltipAnimation'] . '"';
            }
            if ($attributes['tooltipAnimation'] === 'scale') {
                wp_enqueue_style('tooltip-scale', CWICLY_DIR_URL . 'assets/css/tooltip/scale.css');
            }
            if ($attributes['tooltipAnimation'] === 'scale-subtle') {
                wp_enqueue_style('tooltip-scale-subtle', CWICLY_DIR_URL . 'assets/css/tooltip/scale-subtle.css');
            }
            if ($attributes['tooltipAnimation'] === 'scale-extreme') {
                wp_enqueue_style('tooltip-scale-subtle', CWICLY_DIR_URL . 'assets/css/tooltip/scale-extreme.css');
            }
            if ($attributes['tooltipAnimation'] === 'shift-toward') {
                wp_enqueue_style('tooltip-shift-toward', CWICLY_DIR_URL . 'assets/css/tooltip/shift-toward.css');
            }
            if ($attributes['tooltipAnimation'] === 'shift-toward-subtle') {
                wp_enqueue_style('tooltip-shift-toward-subtle', CWICLY_DIR_URL . 'assets/css/tooltip/shift-toward-subtle.css');
            }
            if ($attributes['tooltipAnimation'] === 'shift-toward-extreme') {
                wp_enqueue_style('tooltip-shift-toward-subtle', CWICLY_DIR_URL . 'assets/css/tooltip/shift-toward-extreme.css');
            }
            if ($attributes['tooltipAnimation'] === 'shift-away') {
                wp_enqueue_style('tooltip-shift-away', CWICLY_DIR_URL . 'assets/css/tooltip/shift-away.css');
            }
            if ($attributes['tooltipAnimation'] === 'shift-away-subtle') {
                wp_enqueue_style('tooltip-shift-away-subtle', CWICLY_DIR_URL . 'assets/css/tooltip/shift-away-subtle.css');
            }
            if ($attributes['tooltipAnimation'] === 'shift-away-extreme') {
                wp_enqueue_style('tooltip-shift-away-subtle', CWICLY_DIR_URL . 'assets/css/tooltip/shift-away-extreme.css');
            }
            if ($attributes['tooltipAnimation'] === 'perspective') {
                wp_enqueue_style('tooltip-perspective', CWICLY_DIR_URL . 'assets/css/tooltip/perspective.css');
            }
            if ($attributes['tooltipAnimation'] === 'perspective-subtle') {
                wp_enqueue_style('tooltip-perspective-subtle', CWICLY_DIR_URL . 'assets/css/tooltip/perspective-subtle.css');
            }
            if ($attributes['tooltipAnimation'] === 'perspective-extreme') {
                wp_enqueue_style('tooltip-perspective-subtle', CWICLY_DIR_URL . 'assets/css/tooltip/perspective-extreme.css');
            }
        }
        if (isset($attributes['tooltipTheme']) && $attributes['tooltipTheme']) {
            if ($attributes['tooltipTheme'] === 'light') {
                wp_enqueue_style('tooltip-theme-light', CWICLY_DIR_URL . 'assets/css/tooltip/themes/light.css');
            }
            if ($attributes['tooltipTheme'] === 'light-border') {
                wp_enqueue_style('tooltip-theme-light-border', CWICLY_DIR_URL . 'assets/css/tooltip/themes/light-border.css');
            }
            if ($attributes['tooltipTheme'] === 'material') {
                wp_enqueue_style('tooltip-theme-material', CWICLY_DIR_URL . 'assets/css/tooltip/themes/material.css');
            }
            if ($attributes['tooltipTheme'] === 'translucent') {
                wp_enqueue_style('tooltip-theme-translucent', CWICLY_DIR_URL . 'assets/css/tooltip/themes/translucent.css');
            }
        }
        if (isset($attributes['tooltipHideClick']) && $attributes['tooltipHideClick']) {
            $divAdditions[] = 'data-tooltiphideclick="true"';
        }
        if (isset($attributes['tooltipPlacement']) && $attributes['tooltipPlacement']) {
            $divAdditions[] = 'data-tooltipplace="' . $attributes['tooltipPlacement'] . '"';
        }
        if (isset($attributes['tooltipDuration']) && $attributes['tooltipDuration']) {
            $divAdditions[] = 'data-tooltipduration="' . $attributes['tooltipDuration'] . '"';
        }
        if (isset($attributes['tooltipDuration']) && $attributes['tooltipDuration']) {
            $divAdditions[] = 'data-tooltipduration="' . $attributes['tooltipDuration'] . '"';
        }
        if (isset($attributes['tooltipFollowCursor']) && $attributes['tooltipFollowCursor']) {
            $divAdditions[] = 'data-tooltipfollow="' . $attributes['tooltipFollowCursor'] . '"';
        }
        if (isset($attributes['tooltipTheme']) && $attributes['tooltipTheme']) {
            $divAdditions[] = 'data-theme="' . $attributes['tooltipTheme'] . '"';
        }
    }
    if ($divAdditions) {
        return $divAdditions;
    }
}
