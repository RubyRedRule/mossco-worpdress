<?php

/**
 * Cwicly Menu
 *
 * Functions for creating and managing Menus
 *
 * @package Cwicly\Functions
 * @version 1.1
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Cwicly Menu Maker
 *
 * Create Menu for Menu block
 *
 * @package Cwicly\Functions
 * @version 1.1
 */
function cc_menu_maker($attributes)
{
    $flatMainNav = '';
    $menu = '';
    if (isset($attributes['menuSelected']) && $attributes['menuSelected']) {
        $flatMainNav = wp_get_nav_menu_items($attributes['menuSelected']);
        $menu = wp_get_nav_menu_object($attributes['menuSelected']);
    }
    if (isset($attributes['menuAriaLabel']) && $attributes['menuAriaLabel']) {
        $menu = ' aria-label="' . $attributes['menuAriaLabel'] . '"';
    } else if ($menu) {
        $menu = ' aria-label="' . $menu->name . '"';
    }

    $menu_layout = '';
    $main_role = '';

    if (isset($attributes['menuLayout']) && $attributes['menuLayout']['lg'] === 'horizontal') {
        $menu_layout = 'hor';
    } else {
        $menu_layout = 'ver';
        $main_role = ' role="tree"';
    }

    $menu_list = '<ul class="cc-menu ' . $menu_layout . '"' . $main_role . $menu . '>';

    if (!function_exists('cc_buildTree')) {
        function cc_buildTree(array&$elements, $parentId = 0)
        {
            $branch = array();
            foreach ($elements as &$element) {
                if ($element->menu_item_parent == $parentId) {
                    $children = cc_buildTree($elements, $element->ID);
                    if ($children) {
                        $element->child = $children;
                    }

                    $element->has_children = 1;

                    $branch[$element->ID] = $element;
                    unset($element);
                }
            }
            return $branch;
        }
    }

    $menu_items = '';
    if ($flatMainNav) {
        $menu_items = cc_buildTree($flatMainNav);
    }

    if (!function_exists('create_sub_menu')) {
        function create_sub_menu($item, $attributes)
        {
            $link = $item->url;
            $title = $item->title;
            $id = $item->ID;

            $blank = '';
            if ($item->target === '_blank') {
                $blank = ' target="_blank"';
            }

            $xfn = '';
            if ($item->xfn) {
                $xfn = ' rel="' . $item->xfn . '"';
            }

            $attribute = '';
            if ($item->post_excerpt) {
                $attribute = ' title="' . $item->post_excerpt . '"';
            }

            $current_item = '';
            $aria_current = '';
            $role_type = '';
            $role_ul = '';
            $role_li = '';

            $realID = '';
            $owns = '';

            if (isset($attributes['menuLayout']) && $attributes['menuLayout']['lg'] === 'horizontal') {
                $role_type = 'role="menuitem"';
                $role_ul = 'role="menu"';
            } else {
                $role_type = 'role="treeitem"';
                $role_ul = 'role="group"';
                $realID = ' id="cc-menu-' . $item->ID . '"';
                $owns = ' aria-owns="cc-menu-' . $item->ID . '"';
                $role_li = 'role="none"';
            }

            if (in_array("current-menu-item", $item->classes)) {
                $current_item = 'current';
            }
            if (in_array("current-menu-item", $item->classes)) {
                $aria_current = 'aria-current="page"';
            }

            $final = '';

            if (property_exists($item, 'child')) {
                $children = $item->child;
                $iconBefore = '';
                if ($attributes['menuSubMenuIconActive'] && $attributes['menuSubMenuIconPosition'] === 'before' && isset($attributes['menuSubMenuIconUnicode']) && $attributes['menuSubMenuIconUnicode']) {
                    $iconBefore = $attributes['menuSubMenuIconUnicode'];
                }
                $iconAfter = '';
                if ($attributes['menuSubMenuIconActive'] && $attributes['menuSubMenuIconPosition'] === 'after' && isset($attributes['menuSubMenuIconUnicode']) && $attributes['menuSubMenuIconUnicode']) {
                    $iconAfter = $attributes['menuSubMenuIconUnicode'];
                }

                $final .= '<li ' . $role_li . '>';
                $final .= '<a' . $owns . ' href="' . $link . '" class="cc-menu-sub menu-id-' . $id . '" aria-haspopup="true" ' . $role_type . ' aria-expanded="false" ' . $attribute . $blank . $xfn . '>' . $iconBefore . '' . $title . '' . $iconAfter . '</a>';
                $final .= '<ul' . $realID . ' data-ccdropmenu class="cc-menu-dropdown" ' . $role_ul . ' aria-label="' . $title . '">';
                foreach ($children as $child) {
                    $final .= create_sub_menu($child, $attributes);
                }
                $final .= '</ul>';
                $final .= '</li>';
            } else {
                $final .= '<li ' . $role_li . '>';
                $final .= '<a href="' . $link . '" class="cc-menu-sub menu-id-' . $id . ' ' . $current_item . '" ' . $role_type . '' . $aria_current . $attribute . $blank . $xfn . '>' . $title . '</a>';
                $final .= '</li>';
            }
            return $final;
        }
    }

    if (!function_exists('create_menu')) {
        function create_menu($item, $attributes)
        {
            $link = $item->url;
            $title = $item->title;
            $id = $item->ID;

            $xfn = '';
            if ($item->xfn) {
                $xfn = ' rel="' . $item->xfn . '"';
            }

            $blank = '';
            if ($item->target === '_blank') {
                $blank = ' target="_blank"';
            }

            $attribute = '';
            if ($item->post_excerpt) {
                $attribute = ' title="' . $item->post_excerpt . '"';
            }

            $current_item = '';
            $aria_current = '';
            $role_type = '';
            $role_ul = '';
            $role_li = '';

            $realID = '';
            $owns = '';

            if (isset($attributes['menuLayout']) && $attributes['menuLayout']['lg'] === 'horizontal') {
                // $role_type = 'role="menuitem"';
                // $role_ul = 'role="menu"';
            } else {
                $role_type = 'role="treeitem"';
                $role_ul = 'role="group"';
                $realID = ' id="cc-menu-' . $item->ID . '"';
                $owns = ' aria-owns="cc-menu-' . $item->ID . '"';
                $role_li = 'role="none"';
            }

            if (in_array("current-menu-item", $item->classes)) {
                $current_item = 'current';
            }

            if (in_array("current-page-ancestor", $item->classes)) {
                $current_item = 'current';
            }

            if (in_array("current-menu-item", $item->classes)) {
                $aria_current = ' aria-current="page"';
            }
            if (in_array("current-page-ancestor", $item->classes)) {
                $aria_current = ' aria-current="page"';
            }

            $final = '';

            if (property_exists($item, 'child')) {
                $children = $item->child;
                $iconBefore = '';
                if (isset($attributes['menuMainMenuIconActive']) && $attributes['menuMainMenuIconActive'] && isset($attributes['menuMainMenuIconUnicode']) && $attributes['menuMainMenuIconUnicode'] && $attributes['menuMainMenuIconPosition'] === 'before') {
                    $iconBefore = $attributes['menuMainMenuIconUnicode'];
                }
                $iconAfter = '';
                if (isset($attributes['menuMainMenuIconActive']) && $attributes['menuMainMenuIconActive'] && $attributes['menuMainMenuIconPosition'] === 'after' && isset($attributes['menuMainMenuIconUnicode']) && $attributes['menuMainMenuIconUnicode']) {
                    $iconAfter = $attributes['menuMainMenuIconUnicode'];
                }

                $final .= '<li ' . $role_li . '>';
                $final .= '<a' . $owns . ' href="' . $link . '" class="cc-menu-main menu-id-' . $id . ' ' . $current_item . '" ' . $role_type . ' aria-haspopup="true" aria-expanded="false"' . $aria_current . $attribute . $blank . $xfn . '>' . $iconBefore . '' . $title . '' . $iconAfter . '</a>';
                $final .= '<ul ' . $realID . ' class="cc-menu-dropdown" ' . $role_ul . ' aria-label="' . $title . '">';
                foreach ($children as $child) {
                    $final .= create_sub_menu($child, $attributes);
                }
                $final .= '</ul>';
                $final .= '</li>';
            } else {
                $final .= '<li ' . $role_li . '>';
                $final .= '<a href="' . $link . '" class="cc-menu-main menu-id-' . $id . ' ' . $current_item . '" ' . $role_type . '' . $aria_current . $attribute . $blank . $xfn . '>' . $title . '</a>';
                $final .= '</li>';
            }
            return $final;
        }
    }

    if ($menu_items) {
        foreach ($menu_items as $item) {
            $menu_list .= create_menu($item, $attributes);
        }
    }
    $menu_list .= '</ul>';

    return $menu_list;
}
