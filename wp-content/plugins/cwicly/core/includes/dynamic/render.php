<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function slider_maker($attributes, $block)
{
    global $product;
    if (CC_WOOCOMMERCE && isset($product) && $product) {
        $content = '';
        $original = [];
        $full_url = [];
        $medium_url = [];
        $thumbnail_url = [];
        $main_image = [];
        $main_image[] = $product->get_image_id();
        $gallery_images = $product->get_gallery_image_ids();
        $attachment_ids = array_merge($main_image, $gallery_images);
        foreach ($attachment_ids as $images) {
            $original[] = wp_get_attachment_url($images);
            $originalsrcset[] = wp_get_attachment_image_srcset($images);
            $full_url[] = wp_get_attachment_image_src($images, 'full')[0];
            $medium_url[] = wp_get_attachment_image_src($images, 'medium')[0];
            $thumbnail_url[] = wp_get_attachment_image_src($images, 'thumbnail')[0];
        }

        foreach ($original as $key => $value) {
            if ($block->parsed_block['innerBlocks'][0]) {
                $block_content = (new WP_Block(
                    $block->parsed_block['innerBlocks'][0],
                    array(
                        'postType' => get_post_type(),
                        'postId' => get_the_ID(),
                        'woocommerce' => array($value, $originalsrcset[$key]),
                        'woocommerce_row' => $key + 1,
                    )
                ))->render(array('dynamic' => true));
                $content .= "<div class='swiper-slide cc-slider'>$block_content</div>";
            }
        }
        return $content;
    }
}

function cc_render($content, $attributes, $block, $args = [])
{
    if (isset($attributes['tooltipActive']) && $attributes['tooltipActive']) {
        wp_enqueue_script('cc-popper', CWICLY_DIR_URL . 'assets/js/popper.js', null, CWICLY_VERSION);
        wp_enqueue_script('cc-tooltip', CWICLY_DIR_URL . 'assets/js/tooltip.js', array('cc-popper'), CWICLY_VERSION, true);

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
    }

    if (isset($attributes['scrollDirectionActive']) && $attributes['scrollDirectionActive']) {
        wp_enqueue_script('cc-scrolld', CWICLY_DIR_URL . 'assets/js/cc-scrolld.min.js', null, CWICLY_VERSION, true);
    }
    if (isset($attributes['linkWrapperActive']) && $attributes['linkWrapperActive'] && isset($attributes['linkWrapperType']) && $attributes['linkWrapperType'] === 'action' && isset($attributes['linkWrapperAction']) && $attributes['linkWrapperAction'] === 'scrolltotop') {
        wp_enqueue_script('cc-backtop', CWICLY_DIR_URL . 'assets/js/cc-backtop.min.js', null, CWICLY_VERSION, true);
    }
    if (isset($attributes['dynamic']) && $attributes['dynamic'] === 'wordpress' && isset($attributes['dynamicWordPressType']) && $attributes['dynamicWordPressType'] === 'readtime') {
        wp_enqueue_script('cc-readtime', CWICLY_DIR_URL . 'assets/js/cc-readtime.min.js', null, CWICLY_VERSION, true);
    }
    if (isset($attributes['interactions']) && $attributes['interactions']) {
        foreach ($attributes['interactions'] as $key => $value) {
            if (preg_match('/click|dbclick|mousedown|mouseenter|mouseleave|mouseout|mouseover|mouseup|scrollinview|urlHash/', $key) && count($value) > 0) {
                wp_enqueue_script('cc-interactions', CWICLY_DIR_URL . 'assets/js/cc-interactions.min.js', null, CWICLY_VERSION, true);
                break;
            }
        }
    }

    if (isset($attributes['customCSS']) && $attributes['customCSS']) {
        $repeated = false;
        if (isset($block->context['rendered'])) {
            $repeated = true;
        }

        if (!$repeated) {
            $customcss = str_replace('blockclass', $attributes['classID'], $attributes['customCSS']);
            $customcss = str_replace('blockid', $attributes['id'], $customcss);
            $customcss = str_replace(array("\r", "\n"), '', $customcss);
            $customcss = preg_replace('!\s+!', ' ', $customcss);
            if (function_exists('wp_is_block_theme') && wp_is_block_theme()) {
                add_action('wp_head', function () use ($customcss, $attributes) {
                    echo '<style id="custom-css-' . $attributes['id'] . '">' . $customcss . '</style>' . PHP_EOL;
                });
            } else {
                add_action('wp_footer', function () use ($customcss, $attributes) {
                    echo '<style id="custom-css-' . $attributes['id'] . '">' . $customcss . '</style>' . PHP_EOL;
                });
            }
        }
    }

    if (isset($attributes['effectsTiltControl']) && $attributes['effectsTiltControl']) {
        wp_enqueue_script('cc-tilter', CWICLY_DIR_URL . 'assets/js/tilter.js', null, CWICLY_VERSION, false);
    }

    if (isset($attributes['animateOnScrollType']) && $attributes['animateOnScrollType']) {
        wp_enqueue_script('cc-aos', CWICLY_DIR_URL . 'assets/js/aos.js', null, CWICLY_VERSION, false);
        wp_enqueue_style('cc-aos', CWICLY_DIR_URL . 'assets/css/aos.css');
    }

    if (isset($attributes['interactions']) && $attributes['interactions']) {
        if (function_exists('wp_is_block_theme') && wp_is_block_theme()) {
            add_action('wp_head', array('Cwicly\Helpers', 'add_global_interactions_inline_script'));
        } else {
            add_action('wp_footer', array('Cwicly\Helpers', 'add_global_interactions_inline_script'));
        }
    }

    if (isset($attributes['linkWrapperActive']) && $attributes['linkWrapperActive']) {
        if (isset($attributes['linkWrapperType']) && $attributes['linkWrapperType'] === 'action' && isset($attributes['linkWrapperAction']) && $attributes['linkWrapperAction'] === 'lightbox') {
            wp_enqueue_style('cc-lightbox', CWICLY_DIR_URL . 'assets/css/lightbox.css');
            wp_enqueue_script('cc-lightbox', CWICLY_DIR_URL . 'assets/js/lightbox.js', null, CWICLY_VERSION, true);
        }
    }

    if ($block->parsed_block['blockName'] === 'cwicly/query') {
        if (isset($attributes['frontendRendering']) && $attributes['frontendRendering']) {
            $content = cc_parser($content, $attributes, $block);
            $content = str_replace('![start]!<div>', '', $content);
            $content = str_replace('</div>![end]!', '', $content);
        } else {
            $content = cc_parser($content, $attributes, $block);
            $value = cc_query_front_prep($attributes, $block);
            $hasPosts = $value['hasPosts'];

            if ((!$hasPosts && isset($args['hasToHaveItems']) && $args['hasToHaveItems']) || ($hasPosts && isset($args['hasToHaveItems']) && !$args['hasToHaveItems'])) {
                $content = '';
            } else {
                if ($value['content']) {
                    $value = $value['content'];
                } else {
                    $value = '';
                }

                $re = '/!\[start\]!(.*?)!\[end\]!/s';
                $value = addcslashes($value, '$');
                $content = preg_replace($re, $value, $content);
            }
        }
        return $content;
    } else if ($block->parsed_block['blockName'] === 'cwicly/query-template') {
        if (isset($block->context['frontendRendering']) && $block->context['frontendRendering']) {
            $skeleton_html_no_anim = (new CCSkeletoner)->cc_skeleton_block($block);
            $postsPerPage = get_option('posts_per_page');
            $value = '';
            if (isset($block->context['queryPerPage']) && $block->context['queryPerPage'] && isset($block->context['queryPerPage']['source']) && $block->context['queryPerPage']['source'] === 'static' && isset($block->context['queryPerPage']['field']) && $block->context['queryPerPage']['field']) {
                $postsPerPage = intval($block->context['queryPerPage']['field']);
            }
            for ($i = 0; $i < $postsPerPage; $i++) {
                $value .= '<div>' . $skeleton_html_no_anim . '</div>';
            }
            $content = cc_parser($content, $attributes, $block);
            $re = '/!\[start\]!<div>(.*?)<\/div>!\[end\]!/s';
            $content = preg_replace($re, $value, $content);
        } else {
            $content = cc_parser($content, $attributes, $block);
            $value = cc_query_front_maker($attributes, $block);
            $value = addcslashes($value, '$');
            $re = '/!\[start\]!<div>(.*?)<\/div>!\[end\]!/s';
            $content = preg_replace($re, $value, $content);
        }
        return $content;
    } else if ($block->parsed_block['blockName'] === 'cwicly/filter') {
        $content = cc_parser($content, $attributes, $block);
        $re = '/!\[start\]!<div>(.*?)<\/div>!\[end\]!/s';
        if (isset($attributes['filterType']) && ($attributes['filterType'] === 'userselection' || $attributes['filterType'] === 'clearselection')) {
            $content = preg_replace($re, '', $content);
        } else {
            $skeleton_html_no_anim = (new CCSkeletoner)->cc_skeleton_block($block);
            $value = '<div class="cc-loading-skeleton">' . $skeleton_html_no_anim . '</div>';
            $content = preg_replace($re, $value, $content);
        }
        return $content;
    } else if ($block->parsed_block['blockName'] === 'cwicly/repeater') {
        $content = cc_parser($content, $attributes, $block);
        $value = cc_repeater_maker($attributes, $block);
        $re = '/!\[start\]!(.*?)!\[end\]!/s';
        $content = preg_replace($re, $value, $content);
        return $content;
    } else if ($block->parsed_block['blockName'] === 'cwicly/slider') {
        $content = cc_parser($content, $attributes, $block);
        $content .= slider_maker($attributes, $block);
        return $content;
    } else if ($block->parsed_block['blockName'] === 'cwicly/taxonomyterms') {
        $content = cc_parser($content, $attributes, $block);
        $value = cc_taxonomyterms_maker_v2($attributes, $block);
        $re = '/!\[start\]!(.*?)!\[end\]!/s';
        $content = preg_replace($re, $value, $content);
        return $content;
    } else if (isset($attributes['dynamicContext']) && $attributes['dynamicContext'] === 'woocart') {
        $skeleton_html_no_anim = (new CCSkeletoner)->cc_skeleton_block($block);
        $content = cc_parser($content, $attributes, $block);
        $re = '/!\[start\]!<div>(.*?)<\/div>!\[end\]!/s';
        $value = $skeleton_html_no_anim;
        $content = preg_replace($re, $value, $content);
        return $content;
    } else {
        return cc_parser($content, $attributes, $block);
    }
}

function cc_parser($content, $attributes, $block)
{
    $regex = '/(?!{}){(?!"|&quot;)(.*?)}|<ccd>(.*?)<\/ccd>/';
    $final = preg_replace_callback($regex, function ($matches) use ($attributes, $block) {

        if ((isset($matches[1]) && $matches[1]) || (isset($matches[2]) && $matches[2])) {
            $args = strpos($matches[1] ?: $matches[2], '=') > 0 ? explode('=', $matches[1] ?: $matches[2]): [];

            $match = $matches[1] ?: $matches[2];
            if (!empty($args)) {
                $match = array_shift($args);
            }

            $transformedContent = cc_get_dyn($match, $args, $attributes, $block);

            return $transformedContent;
        }
    }, $content);

    return $final;
}

function cc_get_dyn($dyn, $args, $attributes, $block, $id = '')
{

    if (CC_WOOCOMMERCE) {
        global $product;
        if (!is_object($product)) {
            $product = wc_get_product(get_the_ID());
        }

        $old_product = $product;
        if (isset($block->context['product']) && $block->context['product']) {
            $product = $block->context['product'];
        }
    }

    $value = '';
    $post_id = get_the_ID();

    switch ($dyn) {

        case 'readtime';
            $value = '<span class="cc-read-time"></span>';
            break;

        case 'postcontent';
            $value = cc_content_maker($block);
            break;

        case 'idadd':
        case 'loop-id':
            $repeaterID = '';
            $queryID = '';
            if (isset($block->context['product_index']) && $block->context['product_index']) {
                $repeaterID = '-p-' . $block->context['product_index'] . '';
            }
            if (isset($block->context['taxterms_index']) && $block->context['taxterms_index']) {
                $repeaterID = '-tt-' . $block->context['taxterms_index'] . '';
            }
            if (isset($block->context['repeater_row']) && $block->context['repeater_row']) {
                $repeaterID = '-r-' . $block->context['repeater_row'] . '';
            }
            if (isset($block->context['query_index']) && $block->context['query_index'] && $block->context['query_index'] - 1) {
                $queryID = '-q-' . $block->context['query_index'] . '';
            }
            if ($queryID && !$repeaterID) {
                $value = $queryID;
            }
            if (!$queryID && $repeaterID) {
                $value = $repeaterID;
            }
            if ($queryID && $repeaterID) {
                $value = '' . $queryID . $repeaterID . '';
            }
            break;

        // ADDITIONAL CLASSES
        case 'class':
            if (isset($attributes['classID']) && $attributes['classID']) {
                $value = $attributes['classID'];
            }
            break;

        case 'acl':
            $value = Cwicly\Helpers::additional_classes($attributes);
            break;

        case 'sacl':
            $classWrapper = '';
            $classesAdd = Cwicly\Helpers::additional_classes($attributes);
            if ($classesAdd) {
                $classesAdd = explode(" ", $classesAdd);
                if (count($classesAdd) === 1) {
                    $classWrapper = '' . implode("", $classesAdd) . '-wrapper';
                } else {
                    $classWrapper = '' . implode("-wrapper ", $classesAdd) . '-wrapper';
                }
            }
            if ($classWrapper) {
                $value = $classWrapper;
            }
            break;

        // GLOBAL CLASSES
        case 'gcl':
            $value = Cwicly\Helpers::global_classes($attributes);
            break;

        // IMAGES
        case 'iwgi':
            if (CC_WOOCOMMERCE) {
                global $product;
                if (isset($args[0])) {
                    if ($args[0] === 0 && $product) {
                        $main = $product->get_image_id();
                        $value = wp_get_attachment_image_src($main, 'full')[0];
                    } else if ($product) {
                        $gallery_images = $product->get_gallery_image_ids();
                        if ($gallery_images) {
                            $value = wp_get_attachment_image_src($gallery_images[$args[0] - 1], 'full')[0];
                        }
                    }
                }
            }
            break;

        case 'image':
            if (isset($args[0]) && $args[0]) {
                $value = wp_get_attachment_url($args[0]);
            }
            break;

        case 'imagealt':
            if (isset($args[0]) && $args[0]) {
                if ($args[0] === 'woogallery' && isset($block->context['gallery_image_id']) && $block->context['gallery_image_id']) {
                    $value = get_post_meta($block->context['gallery_image_id'], '_wp_attachment_image_alt', true);
                } else {
                    $value = get_post_meta($args[0], '_wp_attachment_image_alt', true);
                }
            }
            break;

        case 'wooimage':
            if (CC_WOOCOMMERCE && $block->context && isset($block->context['woocommerce']) && $block->context['woocommerce']) {
                $value = '' . $block->context['woocommerce'][0] . '" srcset="' . $block->context['woocommerce'][1] . '';
            }
            break;

        case 'woo_gallery_id':
            if (CC_WOOCOMMERCE && $block->context && isset($block->context['gallery_image_id']) && $block->context['gallery_image_id']) {
                $value = $block->context['gallery_image_id'];
            }
            break;

        case 'imagesrc':
            if (isset($args[0]) && $args[0]) {
                $size = '';
                if (isset($args[1]) && $args[1]) {
                    $size = $args[1];
                }
                $image = [];
                if ($args[0] === 'woogallery' && isset($block->context['gallery_image_id']) && $block->context['gallery_image_id']) {
                    $image = wp_get_attachment_image_src($block->context['gallery_image_id'], $size);
                } else {
                    $image = wp_get_attachment_image_src($args[0], $size);
                }
                if (is_array($image) && $image[0]) {
                    $value = $image[0];
                }
            }
            break;

        case 'imageset':
            if (isset($args[0]) && $args[0]) {
                if ($args[0] === 'woogallery' && isset($block->context['gallery_image_id']) && $block->context['gallery_image_id']) {
                    $value = esc_attr(wp_get_attachment_image_srcset($block->context['gallery_image_id'], 'full'));
                } else {
                    $value = esc_attr(wp_get_attachment_image_srcset($args[0], 'full'));
                }
            }
            break;

        case 'imagesizes':
            if (isset($args[0]) && $args[0]) {
                if ($args[0] === 'woogallery' && isset($block->context['gallery_image_id']) && $block->context['gallery_image_id']) {
                    if (isset($args[1]) && $args[1]) {
                        $value = esc_attr(wp_get_attachment_image_sizes($block->context['gallery_image_id'], $args[1]));
                    } else {
                        $value = esc_attr(wp_get_attachment_image_sizes($block->context['gallery_image_id'], 'full'));
                    }
                } else {
                    if (isset($args[1]) && $args[1]) {
                        $value = esc_attr(wp_get_attachment_image_sizes($args[0], $args[1]));
                    } else {
                        $value = esc_attr(wp_get_attachment_image_sizes($args[0], 'full'));
                    }
                }
            }
            break;

        case 'imagewidth':
            if (isset($args[0]) && $args[0]) {
                if ($args[0] === 'woogallery' && isset($block->context['gallery_image_id']) && $block->context['gallery_image_id']) {
                    $image = wp_get_attachment_image_src($block->context['gallery_image_id'], 'full');
                    if ($image && isset($image[1])) {
                        $value = $image[1];
                    }
                } else {
                    $image = wp_get_attachment_image_src($args[0], 'full');
                    if ($image && isset($image[1])) {
                        $value = $image[1];
                    }
                }
            }
            break;

        case 'imageheight':
            if (isset($args[0]) && $args[0]) {
                if ($args[0] === 'woogallery' && isset($block->context['gallery_image_id']) && $block->context['gallery_image_id']) {
                    $image = wp_get_attachment_image_src($block->context['gallery_image_id'], 'full');
                    if ($image && isset($image[2])) {
                        $value = $image[2];
                    }
                } else {
                    $image = wp_get_attachment_image_src($args[0], 'full');
                    if ($image && isset($image[2])) {
                        $value = $image[2];
                    }
                }
            }
            break;

        case 'cartthumbnail':
            if (CC_WOOCOMMERCE && isset($block->context['cart_item']) && $block->context['cart_item'] && isset($block->context['cart_key']) && $block->context['cart_key']) {
                $_product = apply_filters('woocommerce_cart_item_product', $block->context['cart_item']['data'], $block->context['cart_item'], $block->context['cart_key']);
                $value = wp_get_attachment_url($_product->get_image_id());
            }
            break;

        case 'cartthumbnailsrcset':
            if (CC_WOOCOMMERCE && isset($block->context['cart_item']) && $block->context['cart_item'] && isset($block->context['cart_key']) && $block->context['cart_key']) {
                $_product = apply_filters('woocommerce_cart_item_product', $block->context['cart_item']['data'], $block->context['cart_item'], $block->context['cart_key']);
                $value = wp_get_attachment_image_srcset($_product->get_image_id());
            }
            break;

        case 'featuredimage':
            if (!get_the_post_thumbnail_url() && isset($attributes['dynamicStaticFallbackURL']) && $attributes['dynamicStaticFallbackURL']) {
                $value = $attributes['dynamicStaticFallbackURL'];
            } else {
                if (get_the_post_thumbnail_url()) {
                    if (isset($args[0]) && $args[0]) {
                        $post_thumbnail_id = get_post_thumbnail_id();
                        $alt = '';
                        if (isset($args[3]) && $args[3]) {
                            $alty = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true);
                            if ($alty) {
                                $alt = ' alt="' . $alty . '"';
                            }
                        }
                        if (isset($args[1]) && $args[1]) {
                            $image = wp_get_attachment_image_src($post_thumbnail_id, $args[1]);
                            $width = $image[1];
                            $height = $image[2];
                            $value = '' . $image[0] . '"' . $alt . ' height="' . $height . '" width="' . $width . '';
                        } else {
                            $image = wp_get_attachment_image_src($post_thumbnail_id, 'full');
                            $width = $image[1];
                            $height = $image[2];
                            $value = '' . $image[0] . '"' . $alt . ' " height="' . $height . '" width="' . $width . '';
                        }
                        if (isset($args[2]) && $args[2] === 'false') {
                            $value .= '" srcset="' . wp_get_attachment_image_srcset($post_thumbnail_id, 'full') . '';
                            if (isset($args[1]) && $args[1]) {
                                $value .= '" sizes="' . wp_get_attachment_image_sizes($post_thumbnail_id, $args[1]) . '';
                            } else {
                                $value .= '" sizes="' . wp_get_attachment_image_sizes($post_thumbnail_id, 'full') . '';
                            }
                        }
                    } else {
                        $value = get_the_post_thumbnail_url();
                    }
                } else {
                    $value = CWICLY_URL . 'assets/images/placeholder.jpg';
                }
            }
            break;

        case 'authorpicture':
        case 'author_avatar':
            $avatar = '';
            if (!get_the_author_meta('ID')) {
                $author_id = get_post_field('post_author', get_the_ID());
                $avatar = get_avatar_data($author_id);
            } else {
                $avatar = get_avatar_data(get_the_author_meta('ID'));
            }
            if (!$avatar['found_avatar'] && isset($attributes['dynamicStaticFallbackURL']) && $attributes['dynamicStaticFallbackURL']) {
                $value = $attributes['dynamicStaticFallbackURL'];
            } else {
                if ($avatar['url']) {
                    $value = $avatar['url'];
                } else {
                    $value = CWICLY_URL . 'assets/images/placeholder.jpg';
                }
            }
            break;

        case 'userpicture':
        case 'user_avatar':
            $avatar = get_avatar_data(get_current_user_id());
            if (!$avatar['found_avatar'] && isset($attributes['dynamicStaticFallbackURL']) && $attributes['dynamicStaticFallbackURL']) {
                $value = $attributes['dynamicStaticFallbackURL'];
            } else {
                if ($avatar['url']) {
                    $value = $avatar['url'];
                } else {
                    $value = CWICLY_URL . 'assets/images/placeholder.jpg';
                }
            }
            break;

        case 'bgfeaturedimage':
            if (!get_the_post_thumbnail_url() && isset($attributes['backgroundDynamicStaticFallbackURL']) && $attributes['backgroundDynamicStaticFallbackURL']) {
                $value = $attributes['backgroundDynamicStaticFallbackURL'];
            } else {
                if (get_the_post_thumbnail_url()) {
                    $value = get_the_post_thumbnail_url();
                } else {
                    $value = CWICLY_URL . 'assets/images/placeholder.jpg';
                }
            }
            break;

        case 'bgauthorpicture':
            if (!get_avatar_url(get_the_author_meta('ID')) && isset($attributes['backgroundDynamicStaticFallbackURL']) && $attributes['backgroundDynamicStaticFallbackURL']) {
                $value = $attributes['backgroundDynamicStaticFallbackURL'];
            } else {
                if (get_avatar_url(get_the_author_meta('ID'))) {
                    $value = get_avatar_url(get_the_author_meta('ID'));
                } else {
                    $value = CWICLY_URL . 'assets/images/placeholder.jpg';
                }
            }
            break;

        case 'bguserpicture':
            if (!get_avatar_url(get_current_user_id()) && isset($attributes['backgroundDynamicStaticFallbackURL']) && $attributes['backgroundDynamicStaticFallbackURL']) {
                $value = $attributes['backgroundDynamicStaticFallbackURL'];
            } else {
                // if (get_avatar_url(wp_get_current_user()) && get_current_user_id() != 0) {
                if (get_avatar_url(wp_get_current_user())) {
                    $value = get_avatar_url(get_current_user_id());
                } else {
                    $value = CWICLY_URL . 'assets/images/placeholder.jpg';
                }
            }
            break;

        case 'filterimage':
            break;

        case 'acffield':
        case 'acf_field':
            if (isset($args[0]) && $args[0]) {
                $options = [];
                if (isset($args[4]) && $args[4]) {
                    $options = explode('-', $args[4]);
                }

                if (isset($args[1]) && $args[1] != 'false' && isset($args[2]) && $args[2] != 'false') { // LOCATION + SPECIFIC OBJECT
                    $field = get_field($args[0], $args[1]);

                    $fallback = '';
                    if (isset($args[3]) && $args[3]) {
                        $fallback = $args[3];
                    } else if (isset($attributes['dynamicStaticFallbackURL']) && $attributes['dynamicStaticFallbackURL']) {
                        $fallback = $attributes['dynamicStaticFallbackURL'];
                    } else if (isset($attributes['dynamicStaticFallback']) && $attributes['dynamicStaticFallback']) {
                        $fallback = $attributes['dynamicStaticFallback'];
                    }

                    if ($field) {
                        if (!is_object($field) && !is_array($field)) {
                            $value = cc_acf_field_processor($field, $fallback, $attributes, $block->parsed_block['blockName'], null, $options);
                        } else if (is_object($field)) {
                            $itis = $field->{$args[2]};
                            $value = cc_acf_field_processor($itis, $fallback, $attributes, $block->parsed_block['blockName'], null, $options);
                        } else if (is_array($field)) {
                            $itis = $field[$args[2]];
                            $value = cc_acf_field_processor($itis, $fallback, $attributes, $block->parsed_block['blockName'], null, $options);
                        }
                    } else if ($fallback) {
                        $value = $fallback;
                    }
                } else if (isset($args[1]) && $args[1] != 'false') { // LOCATION ONLY
                    $field = '';
                    if ($args[1] === 'currentuser') {
                        $field = get_field($args[0], 'user_' . get_current_user_id() . '');
                    } else if ($args[1] === 'currentauthor') {
                        $field = get_field($args[0], 'user_' . get_the_author_meta('ID') . '');
                    } else if ($args[1] === 'option') {
                        $field = get_field($args[0], 'option');
                    }
                    //  else if (strpos($args[1], 'taxterm_') !== false && isset($args[1]) && $args[1]) {
                    //     $args[1] = str_replace('taxterm_', '', $args[1]);
                    //     $term = get_term($args[1]);
                    //     $location = $term->taxonomy . '_' . $term->term_id;
                    //     $field = get_field($args[0], $location);
                    // }
                    else if ($args[1] === 'taxterm' && isset($block->context['taxterms'])) {
                        $field = get_field($args[0], $block->context['taxterms']);
                    } else if ($args[1] === 'termquery' && isset($block->context['termQuery'])) {
                        $field = get_field($args[0], $block->context['termQuery']);
                    } else if ($args[1] === 'userquery' && isset($block->context['userQuery'])) {
                        $field = get_field($args[0], $block->context['userQuery']);
                    } else {
                        $field = get_field($args[0], $args[1]);
                    }
                    $fallback = '';
                    if (isset($args[3]) && $args[3]) {
                        $fallback = $args[3];
                    } else if (isset($attributes['dynamicStaticFallbackURL']) && $attributes['dynamicStaticFallbackURL']) {
                        $fallback = $attributes['dynamicStaticFallbackURL'];
                    } else if (isset($attributes['dynamicStaticFallback']) && $attributes['dynamicStaticFallback']) {
                        $fallback = $attributes['dynamicStaticFallback'];
                    }
                    $value = cc_acf_field_processor($field, $fallback, $attributes, $block->parsed_block['blockName'], null, $options);
                } else if (isset($args[2]) && $args[2] != 'false') { // NO LOCATION + SPECIFIC OBJECT
                    $field = get_field($args[0]);

                    $fallback = '';
                    if (isset($args[3]) && $args[3]) {
                        $fallback = $args[3];
                    } else if (isset($attributes['dynamicStaticFallbackURL']) && $attributes['dynamicStaticFallbackURL']) {
                        $fallback = $attributes['dynamicStaticFallbackURL'];
                    } else if (isset($attributes['dynamicStaticFallback']) && $attributes['dynamicStaticFallback']) {
                        $fallback = $attributes['dynamicStaticFallback'];
                    }

                    if ($field) {
                        if (!is_object($field) && !is_array($field)) {
                            $value = cc_acf_field_processor($field, $fallback, $attributes, $block->parsed_block['blockName'], null, $options);
                        } else if (is_object($field)) {
                            $itis = $field->{$args[2]};
                            $value = cc_acf_field_processor($itis, $fallback, $attributes, $block->parsed_block['blockName'], null, $options);
                        } else if (is_array($field)) {
                            $itis = $field[$args[2]];
                            $value = cc_acf_field_processor($itis, $fallback, $attributes, $block->parsed_block['blockName'], null, $options);
                        }
                    } else if ($fallback) {
                        $value = $fallback;
                    }
                } else { // NO LOCATION + NO SPECIFIC OBJECT
                    $field = get_field(sanitize_text_field($args[0]));

                    $fallback = '';
                    if (isset($args[3]) && $args[3]) {
                        $fallback = $args[3];
                    } else if (isset($attributes['dynamicStaticFallbackURL']) && $attributes['dynamicStaticFallbackURL']) {
                        $fallback = $attributes['dynamicStaticFallbackURL'];
                    } else if (isset($attributes['dynamicStaticFallback']) && $attributes['dynamicStaticFallback']) {
                        $fallback = $attributes['dynamicStaticFallback'];
                    }

                    $value = cc_acf_field_processor($field, $fallback, $attributes, $block->parsed_block['blockName'], null, $options);
                }
            }
            break;

        case 'acf_group_field':
            if (isset($args[0]) && $args[0] && isset($args[1]) && $args[1]) {
                $options = [];
                if (isset($args[5]) && $args[5]) {
                    $options = explode('-', $args[5]);
                }

                if (isset($args[2]) && $args[2] != 'false' && isset($args[3]) && $args[3] != 'false') { // LOCATION + SPECIFIC OBJECT
                    $field = cc_get_group_field($args[0], $args[1], $args[2]);

                    $fallback = '';
                    if (isset($args[4]) && $args[4]) {
                        $fallback = $args[4];
                    } else if (isset($attributes['dynamicStaticFallbackURL']) && $attributes['dynamicStaticFallbackURL']) {
                        $fallback = $attributes['dynamicStaticFallbackURL'];
                    } else if (isset($attributes['dynamicStaticFallback']) && $attributes['dynamicStaticFallback']) {
                        $fallback = $attributes['dynamicStaticFallback'];
                    }

                    if ($field) {
                        if (!is_object($field) && !is_array($field)) {
                            $value = cc_acf_field_processor($field, $fallback, $attributes, $block->parsed_block['blockName'], null, $options);
                        } else if (is_object($field)) {
                            $itis = $field->{$args[3]};
                            $value = cc_acf_field_processor($itis, $fallback, $attributes, $block->parsed_block['blockName'], null, $options);
                        } else if (is_array($field)) {
                            $itis = $field[$args[3]];
                            $value = cc_acf_field_processor($itis, $fallback, $attributes, $block->parsed_block['blockName'], null, $options);
                        }
                    } else if ($fallback) {
                        $value = $fallback;
                    }
                } else if (isset($args[2]) && $args[2] != 'false') { // LOCATION ONLY
                    $field = '';
                    if ($args[2] === 'currentuser') {
                        $field = cc_get_group_field($args[0], $args[1], 'user_' . get_current_user_id() . '');
                    } else if ($args[2] === 'currentauthor') {
                        $field = cc_get_group_field($args[0], $args[1], 'user_' . get_the_author_meta('ID') . '');
                    } else if ($args[2] === 'option') {
                        $field = cc_get_group_field($args[0], $args[1], 'option');
                    } else if ($args[2] === 'taxterm' && isset($block->context['taxterms'])) {
                        $field = cc_get_group_field($args[0], $args[1], $block->context['taxterms']);
                    } else if ($args[2] === 'termquery' && isset($block->context['termQuery'])) {
                        $field = cc_get_group_field($args[0], $args[1], $block->context['termQuery']);
                    } else if ($args[2] === 'userquery' && isset($block->context['userQuery'])) {
                        $field = cc_get_group_field($args[0], $args[1], $block->context['userQuery']);
                    } else {
                        $field = cc_get_group_field($args[0], $args[1], $args[2]);
                    }
                    $fallback = '';
                    if (isset($args[4]) && $args[4]) {
                        $fallback = $args[4];
                    } else if (isset($attributes['dynamicStaticFallbackURL']) && $attributes['dynamicStaticFallbackURL']) {
                        $fallback = $attributes['dynamicStaticFallbackURL'];
                    } else if (isset($attributes['dynamicStaticFallback']) && $attributes['dynamicStaticFallback']) {
                        $fallback = $attributes['dynamicStaticFallback'];
                    }
                    $value = cc_acf_field_processor($field, $fallback, $attributes, $block->parsed_block['blockName'], null, $options);
                } else if (isset($args[3]) && $args[3] != 'false') { // NO LOCATION + SPECIFIC OBJECT
                    $field = cc_get_group_field($args[0], $args[1]);

                    $fallback = '';
                    if (isset($args[4]) && $args[4]) {
                        $fallback = $args[4];
                    } else if (isset($attributes['dynamicStaticFallbackURL']) && $attributes['dynamicStaticFallbackURL']) {
                        $fallback = $attributes['dynamicStaticFallbackURL'];
                    } else if (isset($attributes['dynamicStaticFallback']) && $attributes['dynamicStaticFallback']) {
                        $fallback = $attributes['dynamicStaticFallback'];
                    }

                    if ($field) {
                        if (!is_object($field) && !is_array($field)) {
                            $value = cc_acf_field_processor($field, $fallback, $attributes, $block->parsed_block['blockName'], null, $options);
                        } else if (is_object($field)) {
                            $itis = $field->{$args[3]};
                            $value = cc_acf_field_processor($itis, $fallback, $attributes, $block->parsed_block['blockName'], null, $options);
                        } else if (is_array($field)) {
                            $itis = $field[$args[3]];
                            $value = cc_acf_field_processor($itis, $fallback, $attributes, $block->parsed_block['blockName'], null, $options);
                        }
                    } else if ($fallback) {
                        $value = $fallback;
                    }
                } else { // NO LOCATION + NO SPECIFIC OBJECT
                    $field = cc_get_group_field(sanitize_text_field($args[0]), sanitize_text_field($args[1]));

                    $fallback = '';
                    if (isset($args[4]) && $args[4]) {
                        $fallback = $args[4];
                    } else if (isset($attributes['dynamicStaticFallbackURL']) && $attributes['dynamicStaticFallbackURL']) {
                        $fallback = $attributes['dynamicStaticFallbackURL'];
                    } else if (isset($attributes['dynamicStaticFallback']) && $attributes['dynamicStaticFallback']) {
                        $fallback = $attributes['dynamicStaticFallback'];
                    }

                    $value = cc_acf_field_processor($field, $fallback, $attributes, $block->parsed_block['blockName'], null, $options);
                }
            }
            break;

        case 'acfrepeater':
        case 'acf_repeater':
            if (isset($args[0]) && $args[0]) {
                $options = [];
                if (isset($args[3]) && $args[3]) {
                    $options = explode('-', $args[3]);
                }
                $repeater_array = [];
                if ($block->context && isset($block->context['repeaters']) && $block->context['repeaters']) {
                    $repeater_array = $block->context['repeaters'];
                }
                $row = 0;
                if ($block->context && isset($block->context['repeater_row']) && $block->context['repeater_row']) {
                    $row = $block->context['repeater_row'];
                }
                if ($repeater_array) {
                    if (isset($repeater_array[$row][$args[0]]) && $repeater_array[$row][$args[0]]) {
                        $field = $repeater_array[$row][$args[0]];
                        $itis = '';
                        if (!is_object($field) && !is_array($field)) {
                            $itis = $field;
                        } else if (isset($args[1]) && $args[1] && $args[1] != 'false') {
                            if (is_object($field)) {
                                $itis = $field->{$args[1]};
                            } else if (is_array($field)) {
                                $itis = $field[$args[1]];
                            }
                        } else {
                            $itis = $field;
                        }

                        $value = cc_acf_field_processor($itis, isset($args[0]) ? $args[0] : null, $attributes, $block->parsed_block['blockName'], null, $options);
                    } else if (isset($args[0]) && $args[0]) {
                        if (isset($attributes['dynamicStaticFallbackURL']) && $attributes['dynamicStaticFallbackURL']) {
                            $value = $attributes['dynamicStaticFallbackURL'];
                        }
                    }
                }
            }
            break;

        case 'acfvideo':
            $value = cc_video_final_maker_v2($attributes);
            break;

        case 'acfvideourl':
            if (isset($args[0]) && $args[0]) {
                $value = cc_video_url($attributes, $args[0]);
            }
            break;

        // ATTRIBUTES
        case 'date':
            $value = date_i18n("m/d/Y");
            break;

        case 'dayweek':
        case 'day_week':
            $value = date_i18n("l");
            break;

        case 'daymonth':
        case 'day_month':
            $value = date_i18n("d");
            break;

        case 'settime':
            $value = date_i18n("H:i:s");
            break;

        case 'postparentid':
        case 'post_parent_id':
            $value = wp_get_post_parent_id(get_the_ID());
            break;

        case 'posttype':
        case 'post_type':
            $value = get_post_type();
            break;

        case 'postcategories':
            $categories = get_the_category();
            $category_list = [];
            if (!empty($categories)) {
                foreach ($categories as $category) {
                    $category_list[] = $category->name;
                }
            }
            $value = implode(" ", $category_list);
            break;

        case 'posttags':
        case 'post_tags':
            $post_tags = get_the_tags();
            $tag_list = [];
            if ($post_tags) {
                foreach ($post_tags as $tag) {
                    $tag_list[] = $tag->name;
                }
            }
            $value = implode(" ", $tag_list);
            break;

        case 'shortcode':
            if (isset($args[0]) && $args[0]) {
                $short = do_shortcode('[' . $args[0] . ']');
                if ($short != '[' . $args[0] . ']') {
                    $value = $short;
                }
            }
            break;

        case 'userid':
        case 'user_id':
            $current_user = wp_get_current_user();
            $value = strval($current_user->ID);
            break;

        // WORDPRESS
        case 'id':
            $value = $post_id;
            break;

        case 'post_title':
        case 'title':
            $value = get_the_title();
            break;

        case 'postexcerpt':
        case 'post_excerpt':
            add_filter('get_the_excerpt', 'cc_excerpt_gutenberg', 10, 2);
            remove_filter('get_the_excerpt', 'wp_trim_excerpt');
            $characterLimit = '';
            if (isset($args[0]) && $args[0]) {
                $characterLimit = $args[0];
            }
            if (get_the_excerpt()) {
                if ($characterLimit) {
                    $excerpt = wp_strip_all_tags(get_the_excerpt());
                    $excerpt = substr($excerpt, 0, $characterLimit);
                    $value = substr($excerpt, 0, strrpos($excerpt, ' '));
                } else {
                    $value = wp_strip_all_tags(get_the_excerpt());
                }
            } else if (isset($attributes['dynamicStaticFallback']) && $attributes['dynamicStaticFallback']) {
                $value = $attributes['dynamicStaticFallback'];
            }
            remove_filter('get_the_excerpt', 'cc_excerpt_gutenberg');
            add_filter('get_the_excerpt', 'wp_trim_excerpt');
            break;

        case 'pagetitle':
        case 'page_title':
            $value = esc_html(wp_title('', false));
            break;

        case 'archivedescription':
        case 'archive_description':
            if (get_the_archive_description()) {
                $value = esc_html(get_the_archive_description());
            } else if (isset($attributes['dynamicStaticFallback']) && $attributes['dynamicStaticFallback']) {
                $value = $attributes['dynamicStaticFallback'];
            }
            break;

        case 'sitetitle':
        case 'site_title':
            $value = get_bloginfo('name', 'display');
            break;

        case 'sitetagline':
        case 'site_tagline':
            $value = get_bloginfo('description', 'display');
            break;

        case 'siteoption':
        case 'site_option':
            if (isset($args[0]) && $args[0]) {
                $value = get_option($args[0]);
            }
            break;

        case 'authorcustomfield':
        case 'author_custom_field':
            if (isset($args[0]) && $args[0]) {
                $value = get_user_meta(get_the_author_meta('ID'), $args[0], true);
            }
            break;

        case 'usercustomfield':
        case 'user_custom_field':
            if (isset($args[0]) && $args[0]) {
                $value = get_user_meta(get_current_user_id(), $args[0], true);
            }
            break;

        case 'customfield':
        case 'custom_field':
            if (isset($args[0]) && $args[0]) {
                $value = get_post_meta(get_the_ID(), $args[0], true);
            }
            break;

        case 'postcategory':
        case 'post_category':
            $categories = get_the_category();
            if (!empty($categories)) {
                if (isset($attributes['dynamicCategoryIndex']) && $attributes['dynamicCategoryIndex']) {
                    $value = esc_html($categories[$attributes['dynamicCategoryIndex'] - 1]->name);
                } else {
                    $value = esc_html($categories[0]->name);
                }
            }
            break;

        case 'tag':
            $tags = get_the_tags();
            if (!empty($tags)) {
                if (isset($attributes['dynamicTagIndex']) && $attributes['dynamicTagIndex']) {
                    $value = esc_html($tags[$attributes['dynamicTagIndex'] - 1]->name);
                } else {
                    $value = esc_html($tags[0]->name);
                }
            }
            break;

        case 'archivetitle':
        case 'archive_title':
            if (is_category()) {
                $value = single_cat_title('', false);
            } elseif (is_tag()) {
                $value = single_tag_title('', false);
            } elseif (is_author()) {
                $value = get_the_author();
            } elseif (is_year()) {
                $value = get_the_date(_x('Y', 'yearly archives date format'));
            } elseif (is_month()) {
                $value = get_the_date(_x('F Y', 'monthly archives date format'));
            } elseif (is_day()) {
                $value = get_the_date(_x('F j, Y', 'daily archives date format'));
            } elseif (is_tax('post_format')) {
                if (is_tax('post_format', 'post-format-aside')) {
                    $value = _x('Asides', 'post format archive title');
                } elseif (is_tax('post_format', 'post-format-gallery')) {
                    $value = _x('Galleries', 'post format archive title');
                } elseif (is_tax('post_format', 'post-format-image')) {
                    $value = _x('Images', 'post format archive title');
                } elseif (is_tax('post_format', 'post-format-video')) {
                    $value = _x('Videos', 'post format archive title');
                } elseif (is_tax('post_format', 'post-format-quote')) {
                    $value = _x('Quotes', 'post format archive title');
                } elseif (is_tax('post_format', 'post-format-link')) {
                    $value = _x('Links', 'post format archive title');
                } elseif (is_tax('post_format', 'post-format-status')) {
                    $value = _x('Statuses', 'post format archive title');
                } elseif (is_tax('post_format', 'post-format-audio')) {
                    $value = _x('Audio', 'post format archive title');
                } elseif (is_tax('post_format', 'post-format-chat')) {
                    $value = _x('Chats', 'post format archive title');
                }
            } elseif (is_post_type_archive()) {
                $value = post_type_archive_title('', false);
            } elseif (is_tax()) {
                $queried_object = get_queried_object();
                if ($queried_object) {
                    $value = single_term_title('', false);
                }
            }
            // $category = get_queried_object();
            // if ($category) {
            //     $value = esc_html($category->name);
            // }
            break;

        case 'tags':
            $post_tags = get_the_tags();
            if (!empty($post_tags)) {
                foreach ($post_tags as $tag) {
                    $value .= $tag->name . $attributes['dynamicTagSeparator'];
                }
                $value = trim($value, $attributes['dynamicTagSeparator']);
            } else if (isset($attributes['dynamicStaticFallback']) && $attributes['dynamicStaticFallback']) {
                $value = $attributes['dynamicStaticFallback'];
            }
            break;

        case 'postcomments':
        case 'post_comments':
            $comments = strval(get_comments_number());
            if (!$comments) {
                $comments = '0';
            }
            if (isset($args[0]) && $args[0] && $comments === '0') {
                $value = '' . $args[0] . '';
            } else if (isset($args[1]) && $args[1] && $comments === '1') {
                $value = '1 ' . $args[1] . '';
            } else if (isset($args[2]) && $args[2] && intval($comments) > 1) {
                $value = '' . $comments . ' ' . $args[2] . '';
            }
            break;

        case 'username':
            $current_user = get_current_user_id();
            $current_user_meta = get_userdata($current_user);
            $demand = 'display_name';
            if ($current_user != 0) {
                $value = esc_html($current_user_meta->$demand);
            } else if (isset($attributes['dynamicStaticFallback']) && $attributes['dynamicStaticFallback']) {
                $value = $attributes['dynamicStaticFallback'];
            }
            break;

        case 'customcurrentdate':
        case 'custom_current_date':
            $custom_format = '';
            if (isset($args[0]) && $args[0]) {
                $custom_format = $args[0];
            }
            $value = esc_html(date_i18n($custom_format, current_time('timestamp', 0)));
            break;

        case 'currentdate':
        case 'current_date':
            $time_format = '';
            $date_format = '';
            if (isset($args[0]) && $args[0]) {
                if ($args[0] === 'default') {
                    $time_format .= 'g:i a';
                } else if ($args[0] === '1') {
                    $time_format .= 'g:i a';
                } else if ($args[0] === '2') {
                    $time_format .= 'g:i A';
                } else if ($args[0] === '3') {
                    $time_format .= 'H:i';
                } else if ($args[0] === '4') {
                    $time_format .= '';
                }
            } else {
                $time_format .= 'g:i a';
            }
            if (isset($args[1]) && $args[1]) {
                if ($args[1] === 'default') {
                    $date_format .= 'F j, Y';
                } else if ($args[1] === '1') {
                    $date_format .= 'F j, Y';
                } else if ($args[1] === '2') {
                    $date_format .= 'Y-m-d';
                } else if ($args[1] === '3') {
                    $date_format .= 'm/d/Y';
                } else if ($args[1] === '4') {
                    $date_format .= 'd/m/Y';
                } else if ($args[1] === '5') {
                    $date_format .= '';
                }
            } else {
                $date_format .= 'F j, Y';
            }
            $value = esc_html(date_i18n($date_format . ' ' . $time_format, current_time('timestamp', 0)));
            break;

        case 'userinfo':
            $current_user = get_current_user_id();
            $current_user_meta = get_userdata($current_user);
            $demand = $attributes['dynamicWordPressUserInfo'];
            if ($current_user != 0) {
                if ($attributes['dynamicWordPressUserInfo'] != '') {
                    $value = nl2br($current_user_meta->$demand);
                }
            } else if (isset($attributes['dynamicStaticFallback']) && $attributes['dynamicStaticFallback']) {
                $value = $attributes['dynamicStaticFallback'];
            }
            break;

        case 'user_info':
            if (isset($args[0]) && $args[0]) {
                $current_user = get_current_user_id();
                $current_user_meta = get_userdata($current_user);
                $demand = $args[0];
                if ($current_user != 0) {
                    $value = nl2br($current_user_meta->$demand);
                }
            }
            break;

        case 'authorinfo':
        case 'author_info':
            $demand = $attributes['dynamicWordPressAuthorInfo'];
            $authorID = get_post_field('post_author', $post_id);
            $final = get_the_author_meta($demand, $authorID);
            if ($final) {
                $value = nl2br($final);
            } else if (isset($attributes['dynamicStaticFallback']) && $attributes['dynamicStaticFallback']) {
                $value = $attributes['dynamicStaticFallback'];
            }
            break;

        case 'authorname':
        case 'author_name':
            $authorID = get_post_field('post_author', $post_id);
            $authorName = '';
            if ($authorID) {
                $authorName = get_the_author_meta('display_name', $authorID);
            }
            if ($authorName) {
                $value = $authorName;
            } else if (isset($attributes['dynamicStaticFallback']) && $attributes['dynamicStaticFallback']) {
                $value = $attributes['dynamicStaticFallback'];
            }
            break;

        case 'postdate':
        case 'post_date':
            if (isset($args[0]) && $args[0] === 'published' && isset($args[1])) {
                if ($args[1] === 'default') {
                    $value = get_the_date('F j, Y');
                }
                if ($args[1] === '1') {
                    $value = get_the_date('F j, Y');
                }
                if ($args[1] === '2') {
                    $value = get_the_date('Y-m-d');
                }
                if ($args[1] === '3') {
                    $value = get_the_date('m/d/Y');
                }
                if ($args[1] === '4') {
                    $value = get_the_date('d/m/Y');
                }
                if ($args[1] === '5') {
                    $value = esc_html(human_time_diff(get_the_time('U'), current_time('timestamp'))) . ' ago';
                }
                if ($args[1] === 'custom' && $args[2] != '') {
                    $value = get_the_date($args[2]);
                }
            } else if (isset($args[0]) && $args[0] === 'modified' && isset($args[1])) {
                if ($args[1] === 'default') {
                    $value = get_the_modified_date('F j, Y');
                }
                if ($args[1] === '1') {
                    $value = get_the_modified_date('F j, Y');
                }
                if ($args[1] === '2') {
                    $value = get_the_modified_date('Y-m-d');
                }
                if ($args[1] === '3') {
                    $value = get_the_modified_date('m/d/Y');
                }
                if ($args[1] === '4') {
                    $value = get_the_modified_date('d/m/Y');
                }
                if ($args[1] === '5') {
                    $value = esc_html(human_time_diff(get_the_modified_date('U'), current_time('timestamp'))) . ' ago';
                }
                if ($args[1] === 'custom' && $args[2] != '') {
                    $value = get_the_modified_date($args[2]);
                }
            } else {
                $value = get_the_date('F j, Y');
            }
            break;

        case 'time':
        case 'post_time':
            if (isset($args[0]) && $args[0] === 'published' && isset($args[1])) {
                if ($args[1] === 'default') {
                    $value = get_the_time('g:i a');
                }
                if ($args[1] === '1') {
                    $value = get_the_time('g:i a');
                }
                if ($args[1] === '2') {
                    $value = get_the_time('g:i A');
                }
                if ($args[1] === '3') {
                    $value = get_the_time('H:i');
                }
                if ($args[1] === 'custom' && $args[2] != '') {
                    $value = get_the_time($attributes['dynamicWordPressTimeCustom']);
                }
            } else if (isset($args[0]) && $args[0] === 'modified' && isset($args[1])) {
                if ($args[1] === 'default') {
                    $value = get_the_modified_time('g:i a');
                }
                if ($args[1] === '1') {
                    $value = get_the_modified_time('g:i a');
                }
                if ($args[1] === '2') {
                    $value = get_the_modified_time('g:i A');
                }
                if ($args[1] === '3') {
                    $value = get_the_modified_time('H:i');
                }
                if ($args[1] === 'custom' && $args[2] != '') {
                    $value = get_the_modified_time($attributes['dynamicWordPressTimeCustom']);
                }
            } else {
                $value = get_the_time('g:i a');
            }
            break;

        // TAX TERMS
        case 'taxterms':
            if (isset($block->context['taxterms']) && $block->context['taxterms'] && isset($args[0]) && $args[0]) {
                $value = $block->context['taxterms']->{$args[0]};
            }
            ;
            break;

        // TERM QUERY
        case 'termquery':
            if (isset($block->context['termQuery']) && $block->context['termQuery'] && isset($args[0]) && $args[0]) {
                $value = $block->context['termQuery']->{$args[0]};
            }
            ;
            break;

        // USER QUERY
        case 'userquery':
            if (isset($block->context['userQuery']) && $block->context['userQuery'] && isset($args[0]) && $args[0]) {
                $value = $block->context['userQuery']->{$args[0]};
            }
            ;
            break;

        // COMMENT QUERY
        case 'commentquery':
            if (isset($block->context['commentQuery']) && $block->context['commentQuery'] && isset($args[0]) && $args[0]) {
                if ($args[0] === 'avatar') {
                    if (!get_avatar_url($block->context['commentQuery']) && isset($attributes['dynamicStaticFallbackURL']) && $attributes['dynamicStaticFallbackURL']) {
                        $value = $attributes['dynamicStaticFallbackURL'];
                    } else {
                        if (get_avatar_url($block->context['commentQuery'])) {
                            $value = get_avatar_url($block->context['commentQuery']);
                        } else {
                            $value = CWICLY_URL . 'assets/images/placeholder.jpg';
                        }
                    }
                } else if ($args[0] === 'comment_date' && isset($args[1])) {
                    if ($args[1] === 'default') {
                        $value = get_comment_date('F j, Y', $block->context['commentQuery']);
                    } else if ($args[1] === '1') {
                        $value = get_comment_date('F j, Y', $block->context['commentQuery']);
                    } else if ($args[1] === '2') {
                        $value = get_comment_date('Y-m-d', $block->context['commentQuery']);
                    } else if ($args[1] === '3') {
                        $value = get_comment_date('m/d/Y', $block->context['commentQuery']);
                    } else if ($args[1] === '4') {
                        $value = get_comment_date('d/m/Y', $block->context['commentQuery']);
                    } else if ($args[1] === '5') {
                        $value = esc_html(human_time_diff(get_comment_date('U', $block->context['commentQuery']), current_time('timestamp'))) . ' ago';
                    } else if ($args[1] === 'custom' && isset($args[2])) {
                        $value = get_comment_date($args[2], $block->context['commentQuery']);
                    }
                } else if ($args[0] === 'comment_time' && isset($args[1])) {
                    if ($args[1] === 'default') {
                        $value = get_comment_date('g:i a', $block->context['commentQuery']);
                    } else if ($args[1] === '1') {
                        $value = get_comment_date('g:i a', $block->context['commentQuery']);
                    } else if ($args[1] === '2') {
                        $value = get_comment_date('g:i A', $block->context['commentQuery']);
                    } else if ($args[1] === '3') {
                        $value = get_comment_date('H:i', $block->context['commentQuery']);
                    } else if ($args[1] === '4') {
                        $value = human_time_diff(get_comment_date('U', $block->context['commentQuery']), current_time('timestamp'));
                    }
                    if ($args[1] === 'custom' && isset($args[2]) && $args[2] != '') {
                        $value = get_comment_date($args[2], $block->context['commentQuery']);
                    }
                } else {
                    $value = $block->context['commentQuery']->{$args[0]};
                }
            }
            ;
            break;

        case 'commentqueryauthorarchive':
            if (isset($block->context['commentQuery']->user_id) && $block->context['commentQuery']->user_id) {
                $value = get_author_posts_url($block->context['commentQuery']->user_id);
            }
            break;

        case 'commenturl':
            if (isset($block->context['commentQuery']->comment_ID) && $block->context['commentQuery']->comment_ID) {
                $value = get_comment_link($block->context['commentQuery']->comment_ID);
            }
            break;

        case 'formcomment':
            $final = '';
            $final .= '" action="' . site_url('/wp-comments-post.php') . '';
            $final .= '" method="post';
            $value = $final;
            break;

        case 'currentcommenter':
            if (isset($args[0]) && $args[0]) {
                $value = wp_get_current_commenter()[$args[0]];
            }
            break;

        case 'commentreplyurl':
            if (isset($block->context['commentQuery']->comment_ID) && $block->context['commentQuery']->comment_ID) {
                if (get_option('page_comments')) {
                    $permalink = str_replace('#comment-' . $block->context['commentQuery']->comment_ID, '', get_comment_link($block->context['commentQuery']));
                } else {
                    $permalink = get_permalink($post_id);
                }
                $value = esc_url(
                    add_query_arg(
                        array(
                            'replytocom' => $block->context['commentQuery']->comment_ID,
                            'unapproved' => false,
                            'moderation-hash' => false,
                        ),
                        $permalink
                    )
                ) . '#respond';
            }
            break;

        case 'editcommenturl':
            if (isset($block->context['commentQuery']->comment_ID) && $block->context['commentQuery']->comment_ID) {
                $value = get_edit_comment_link($block->context['commentQuery']->comment_ID);
            }
            break;

        case 'commentcookiescheck':
            $commenter = wp_get_current_commenter();
            $consent = empty($commenter['comment_author_email']) ? '' : ' checked="checked"';
            if ($consent) {
                $value = '" ' . $consent . '';
            }
            break;
        // COMMENT QUERY

        // WOOCOMMERCE
        case 'watc':
            global $product;
            if (isset($block->context['product']) && $block->context['product']) {
                $product = $block->context['product'];
            }
            if (isset($product) && $product && $product->get_type() === 'variable') {
                $value = 'variations_form cart';
            } else if (isset($product) && $product && $product->get_type() === 'grouped') {
                $value = 'cart grouped_form';
            }
            break;

        case 'woocheckouturl':
            if (CC_WOOCOMMERCE) {
                $value = esc_url(wc_get_checkout_url());
            }
            break;

        case 'woocarturl':
            if (CC_WOOCOMMERCE) {
                $value = esc_url(wc_get_cart_url());
            }
            break;

        case 'carttotal':
            if (CC_WOOCOMMERCE && WC()->cart) {
                $value = WC()->cart->get_cart_total();
            }
            break;

        case 'cartitemname':
            if (CC_WOOCOMMERCE && isset($block->context['cart_item']) && $block->context['cart_item'] && isset($block->context['cart_key']) && $block->context['cart_key']) {
                $_product = apply_filters('woocommerce_cart_item_product', $block->context['cart_item']['data'], $block->context['cart_item'], $block->context['cart_key']);
                $name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $block->context['cart_item'], $block->context['cart_key']);
                $value = $name;
            }
            break;

        case 'cartitemquantity':
            if (isset($block->context['cart_item']) && $block->context['cart_item']) {
                $value = $block->context['cart_item']['quantity'];
            }
            break;

        case 'cartitemprice':
            if (CC_WOOCOMMERCE && isset($block->context['cart_item']) && $block->context['cart_item'] && isset($block->context['cart_key']) && $block->context['cart_key']) {
                $_product = apply_filters('woocommerce_cart_item_product', $block->context['cart_item']['data'], $block->context['cart_item'], $block->context['cart_key']);
                $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $block->context['cart_item'], $block->context['cart_key']);
                $value = $product_price;
            }
            break;

        case 'cartsubtotal':
            if (CC_WOOCOMMERCE && isset($block->context['cart_item']) && $block->context['cart_item'] && isset($block->context['cart_key']) && $block->context['cart_key']) {
                $_product = apply_filters('woocommerce_cart_item_product', $block->context['cart_item']['data'], $block->context['cart_item'], $block->context['cart_key']);
                $subtotal = apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $block->context['cart_item']['quantity']), $block->context['cart_item'], $block->context['cart_key']);
                $value = $subtotal;
            }
            break;

        case 'cartitemscount':
            if (CC_WOOCOMMERCE && WC()->cart) {
                $value = WC()->cart->get_cart_contents_count();
            }
            break;

        case 'price':
            // the_post();
            if (CC_WOOCOMMERCE) {
                global $product;
                $old_product = $product;
                if (isset($block->context['product']) && $block->context['product']) {
                    $product = $block->context['product'];
                }
                $value = Cwicly\WooCommerce::price_maker($product, $args);
                $product = $old_product;
            }
            break;

        case 'saleprice':
            if (CC_WOOCOMMERCE) {
                global $product;
                $old_product = $product;
                if (isset($block->context['product']) && $block->context['product']) {
                    $product = $block->context['product'];
                }
                if (isset($product) && $product) {
                    if (isset($args[0]) && $args[0]) {
                        $price = $product->get_sale_price();
                        $value = Cwicly\WooCommerce::dynamic_price($price, $args[0]);
                    } else {
                        $value = $product->get_sale_price();
                    }
                }
                $product = $old_product;
            }
            break;

        case 'regularprice':
            if (CC_WOOCOMMERCE) {
                global $product;
                $old_product = $product;
                if (isset($block->context['product']) && $block->context['product']) {
                    $product = $block->context['product'];
                }
                $value = Cwicly\WooCommerce::price_maker($product, $args, 'regular');
                $product = $old_product;
            }
            break;

        case 'currency':
            if (CC_WOOCOMMERCE) {
                $value = get_woocommerce_currency();
            }
            break;

        case 'currencysymbol':
            if (CC_WOOCOMMERCE && function_exists('get_woocommerce_currency_symbol')) {
                $value = html_entity_decode(get_woocommerce_currency_symbol());

                global $product;
                $old_product = $product;
                if (isset($block->context['product']) && $block->context['product']) {
                    $product = $block->context['product'];
                }
                if (isset($product) && $product && isset($args[0]) && $args[0]) {
                    if ($product->get_type() && $product->get_type() === 'variable') {
                        if ($dyn === 'variationnmin') {
                            $price = $product->get_variation_price();
                            $value = Cwicly\WooCommerce::dynamic_price($price, $args[0]);
                        } else if ($dyn === 'variationmax') {
                            $price = $product->get_variation_price('max');
                            $value = Cwicly\WooCommerce::dynamic_price($price, $args[0]);
                        } else if ($dyn === 'variationregnmin') {
                            $price = $product->get_variation_regular_price();
                            $value = Cwicly\WooCommerce::dynamic_price($price, $args[0]);
                        } else if ($dyn === 'variationregnmax') {
                            $price = $product->get_variation_regular_price('max');
                            $value = Cwicly\WooCommerce::dynamic_price($price, $args[0]);
                        } else if ($dyn === 'variationsalemin') {
                            $price = $product->get_variation_sale_price();
                            $value = Cwicly\WooCommerce::dynamic_price($price, $args[0]);
                        } else if ($dyn === 'variationsalemax') {
                            $price = $product->get_variation_sale_price('max');
                            $value = Cwicly\WooCommerce::dynamic_price($price, $args[0]);
                        } else if (isset($block->context['wooVariable']) && $block->context['wooVariable'] && isset($block->context['repeater_row']) && $block->context['repeater_row']) {
                            if ($block->context['wooVariable']['label']) {
                                $value = $block->context['wooVariable']['label'];
                            }
                        }
                    }
                    $product = $old_product;
                }
            }
            break;

        case 'weight':
            global $product;
            $old_product = $product;
            if (isset($block->context['product']) && $block->context['product']) {
                $product = $block->context['product'];
            }
            if (isset($product) && $product) {
                $value = '<span class="weight">' . $product->get_weight() . '</span>';
            }
            $product = $old_product;
            break;

        case 'height':
            global $product;
            $old_product = $product;
            if (isset($block->context['product']) && $block->context['product']) {
                $product = $block->context['product'];
            }
            if (isset($product) && $product) {
                $value = $product->get_height();
            }
            $product = $old_product;
            break;

        case 'width':
            global $product;
            $old_product = $product;
            if (isset($block->context['product']) && $block->context['product']) {
                $product = $block->context['product'];
            }
            if (isset($product) && $product) {
                $value = $product->get_width();
            }
            $product = $old_product;
            break;

        case 'length':
            global $product;
            $old_product = $product;
            if (isset($block->context['product']) && $block->context['product']) {
                $product = $block->context['product'];
            }
            if (isset($product) && $product) {
                $value = $product->get_length();
            }
            $product = $old_product;
            break;

        case 'quantity':
            global $product;
            $old_product = $product;
            if (isset($block->context['product']) && $block->context['product']) {
                $product = $block->context['product'];
            }
            if (isset($product) && $product) {
                $value = '<span class="availability">' . $product->get_stock_quantity() . '</span>';
            }
            $product = $old_product;
            break;

        case 'description':
            global $product;
            $old_product = $product;
            if (isset($block->context['product']) && $block->context['product']) {
                $product = $block->context['product'];
            }
            if (isset($product) && $product) {
                $value = '<span class="description">' . $product->get_description() . '</span>';
            }
            $product = $old_product;
            break;

        case 'shortdescription':
            global $product;
            $old_product = $product;
            if (isset($block->context['product']) && $block->context['product']) {
                $product = $block->context['product'];
            }
            if (isset($product) && $product) {
                $value = $product->get_short_description();
            }
            $product = $old_product;
            break;

        case 'maxpurchasequantity':
            global $product;
            $old_product = $product;
            if (isset($block->context['product']) && $block->context['product']) {
                $product = $block->context['product'];
            }
            if (isset($product) && $product) {
                $value = $product->get_max_purchase_quantity();
            }
            $product = $old_product;
            break;

        case 'minpurchasequantity':
            global $product;
            $old_product = $product;
            if (isset($block->context['product']) && $block->context['product']) {
                $product = $block->context['product'];
            }
            if (isset($product) && $product) {
                $value = $product->get_min_purchase_quantity();
            }
            $product = $old_product;
            break;

        case 'salefrom':
            global $product;
            $old_product = $product;
            if (isset($block->context['product']) && $block->context['product']) {
                $product = $block->context['product'];
            }
            if (isset($product) && $product) {
                $date = $args[0];
                if (isset($date) && $date) {
                    if ($date === 'default') {
                        $value = date('F j, Y', strtotime($product->get_date_on_sale_from()));
                    } else if ($date === '1') {
                        $value = date('F j, Y', strtotime($product->get_date_on_sale_from()));
                    } else if ($date === '2') {
                        $value = date('Y-m-d', strtotime($product->get_date_on_sale_from()));
                    } else if ($date === '3') {
                        $value = date('m/d/Y', strtotime($product->get_date_on_sale_from()));
                    } else if ($date === '4') {
                        $value = date('d/m/Y', strtotime($product->get_date_on_sale_from()));
                    } else if ($date === '5') {
                        $value = esc_html(human_time_diff(strtotime($product->get_date_on_sale_from()), current_time('timestamp'))) . ' ago';
                    } else if ($date === 'custom' && $args[1] != '') {
                        $value = date($args[1], strtotime($product->get_date_on_sale_from()));
                    }
                } else {
                    $value = $product->get_date_on_sale_from();
                }
            }
            $product = $old_product;
            break;

        case 'saletill':
            global $product;
            $old_product = $product;
            if (isset($block->context['product']) && $block->context['product']) {
                $product = $block->context['product'];
            }
            if (isset($product) && $product) {
                $date = $args[0];
                if (isset($date) && $date) {
                    if ($date === 'default') {
                        $value = date('F j, Y', strtotime($product->get_date_on_sale_to()));
                    } else if ($date === '1') {
                        $value = date('F j, Y', strtotime($product->get_date_on_sale_to()));
                    } else if ($date === '2') {
                        $value = date('Y-m-d', strtotime($product->get_date_on_sale_to()));
                    } else if ($date === '3') {
                        $value = date('m/d/Y', strtotime($product->get_date_on_sale_to()));
                    } else if ($date === '4') {
                        $value = date('d/m/Y', strtotime($product->get_date_on_sale_to()));
                    } else if ($date === '5') {
                        $value = esc_html(human_time_diff(strtotime($product->get_date_on_sale_to()), current_time('timestamp'))) . ' ago';
                    } else if ($date === 'custom' && $args[1] != '') {
                        $value = date($args[1], strtotime($product->get_date_on_sale_to()));
                    }
                } else {
                    $value = $product->get_date_on_sale_to();
                }
            }
            $product = $old_product;
            break;

        case 'sku':
            global $product;
            $old_product = $product;
            if (isset($block->context['product']) && $block->context['product']) {
                $product = $block->context['product'];
            }
            if (isset($product) && $product) {
                $value = $product->get_sku();
            }
            $product = $old_product;
            break;

        case 'ratingcount':
            global $product;
            $old_product = $product;
            if (isset($block->context['product']) && $block->context['product']) {
                $product = $block->context['product'];
            }
            if (isset($product) && $product) {
                $value = $product->get_rating_count();
            }
            $product = $old_product;
            break;

        case 'reviewcount':
            global $product;
            $old_product = $product;
            if (isset($block->context['product']) && $block->context['product']) {
                $product = $block->context['product'];
            }
            if (isset($product) && $product) {
                $value = $product->get_review_count();
            }
            $product = $old_product;
            break;

        case 'averagerating':
            global $product;
            $old_product = $product;
            if (isset($block->context['product']) && $block->context['product']) {
                $product = $block->context['product'];
            }
            if (isset($product) && $product) {
                $value = $product->get_average_rating();
            }
            $product = $old_product;
            break;

        case 'salepercentage':
            global $product;
            $old_product = $product;
            if (isset($block->context['product']) && $block->context['product']) {
                $product = $block->context['product'];
            }
            if (isset($product) && $product) {
                $value = Cwicly\WooCommerce::percentage_calculator($product);
            }
            $product = $old_product;
            break;

        case 'totalsold':
            global $product;
            $old_product = $product;
            if (isset($block->context['product']) && $block->context['product']) {
                $product = $block->context['product'];
            }
            if (isset($product) && $product) {
                $total_sold = get_post_meta($product->id, 'total_sales', true);
                if ($total_sold) {
                    $value = $total_sold;
                } else {
                    $value = 0;
                }
            }
            $product = $old_product;
            break;

        case 'woo_item_min':
            if (CC_WOOCOMMERCE) {
                global $product;
                $old_product = $product;
                if (isset($block->context['product']) && $block->context['product']) {
                    $product = $block->context['product'];
                }
                if (is_bool($product)) {
                } else {
                    $value = $product->get_min_purchase_quantity();
                }
            }
            break;

        case 'woo_item_max':
            if (CC_WOOCOMMERCE) {
                global $product;
                $old_product = $product;
                if (isset($block->context['product']) && $block->context['product']) {
                    $product = $block->context['product'];
                }
                if (is_bool($product)) {
                } else {
                    $value = $product->get_max_purchase_quantity() === -1 ? 999 : $product->get_max_purchase_quantity();
                }
            }
            break;
        // WOOCOMMERCE

        // TOOLTIP
        case 'tooltipacf':
            $field = get_field($attributes['tooltipACFField']);
            if ($field) {
                $value = wp_filter_post_kses(htmlspecialchars($field));
            }
            break;

        // LINKS
        case 'taxonomytermsurl':
            if (isset($block->context['taxterms']) && $block->context['taxterms'] && $block->context['taxterms']->term_id) {
                $value = get_term_link($block->context['taxterms']->term_id);
            }
            break;

        case 'taxonomyqueryurl':
            if (isset($block->context['termQuery']) && $block->context['termQuery'] && $block->context['termQuery']->term_id) {
                $value = get_term_link($block->context['termQuery']->term_id);
            }
            break;

        case 'userqueryurl':
            if (isset($block->context['userQuery']) && $block->context['userQuery'] && $block->context['userQuery']->ID) {
                $value = get_author_posts_url($block->context['userQuery']->ID);
            }
            break;

        case 'previouspost':
            $taxonomy = 'category';
            $in_same_term = false;
            $excluded_terms = '';
            if (isset($args[0]) && $args[0]) {
                $taxonomy = $args[0];
            }
            if (isset($args[1]) && $args[1] === 'true') {
                $in_same_term = true;
            }
            if (isset($args[2]) && $args[2]) {
                $excluded_terms = $args[2];
            }
            $value = get_permalink(get_adjacent_post($in_same_term, $excluded_terms, true, $taxonomy));
            break;

        case 'nextpost':
            $taxonomy = 'category';
            $in_same_term = false;
            $excluded_terms = '';
            if (isset($args[0]) && $args[0]) {
                $taxonomy = $args[0];
            }
            if (isset($args[1]) && $args[1] === 'true') {
                $in_same_term = true;
            }
            if (isset($args[2]) && $args[2]) {
                $excluded_terms = $args[2];
            }
            $value = get_permalink(get_adjacent_post($in_same_term, $excluded_terms, false, $taxonomy));
            break;

        case 'pageurl':
        case 'page_url':
            $value = get_permalink();
            break;

        case 'archiveurl':
            $post_type = get_post_type();
            $value = get_post_type_archive_link($post_type);
            break;

        case 'postarchiveurl':
            $post_type = get_post_type();
            $value = get_post_type_archive_link($post_type);
            break;

        case 'homeurl':
            $value = get_home_url();
            break;

        case 'siteurl':
            $value = get_site_url();
            break;

        case 'directlogout':
            if (isset($args[0]) && $args[0] && $args[0] != 'specific') {
                $url = '';
                if ($args[0] === 'homeurl') {
                    $url = get_home_url();
                } else if ($args[0] === 'siteurl') {
                    $url = get_site_url();
                } else if ($args[0] === 'currentpage') {
                    $url = get_permalink();
                }
                $value = wp_logout_url($url);
            } else if (isset($args[0]) && $args[0] && $args[0] === 'specific' && isset($args[1]) && $args[1]) {
                $url = $args[1];
                $value = wp_logout_url($url);
            } else {
                $value = wp_logout_url();
            }
            break;

        case 'loginurl':
            if (isset($args[0]) && $args[0] && $args[0] != 'specific') {
                $url = '';
                if ($args[0] === 'homeurl') {
                    $url = get_home_url();
                } else if ($args[0] === 'siteurl') {
                    $url = get_site_url();
                } else if ($args[0] === 'currentpage') {
                    $url = get_permalink();
                }
                $value = wp_login_url($url);
            } else if (isset($args[0]) && $args[0] && $args[0] === 'specific' && isset($args[1]) && $args[1]) {
                $url = $args[1];
                $value = wp_login_url($url);
            } else {
                $value = wp_login_url();
            }
            break;

        case 'authorurl':
            $authorID = get_post_field('post_author', $post_id);
            $authorURL = '';
            if ($authorID) {
                $authorURL = get_author_posts_url($authorID);
            }
            if ($authorURL) {
                $value = $authorURL;
            }
            // $value = get_author_posts_url(get_the_author_meta('ID'));
            break;

        case 'commentsurl':
            $value = '' . get_permalink() . '#respond';
            break;

        case 'removecartitem':
        case 'removecartitemajax':
            if (isset($block->context['cart_key']) && $block->context['cart_key']) {
                $value = esc_url(wc_get_cart_remove_url($block->context['cart_key']));
            }
            break;

        case 'cartitemkey':
            if (isset($block->context['cart_key']) && $block->context['cart_key']) {
                $value = $block->context['cart_key'];
            }
            break;

        case 'filter':
            if (isset($args[0]) && $args[0]) {
                if (isset($block->context['filterInfo']) && $block->context['filterInfo'] && $block->context['filterInfo'][$args[0]]) {
                    $value = $block->context['filterInfo'][$args[0]];
                }
            }
            break;

        case 'filterlink':
            $final = '';
            if (isset($block->context['filterInfo']['plainQueryID']) && $block->context['filterInfo']['plainQueryID']) {
                $final .= '' . $block->context['filterInfo']['plainQueryID'] . '"';
            } else {
                $final .= '0"';
            }
            if (isset($block->context['filterInfo']['plainTarget']) && $block->context['filterInfo']['plainTarget']) {
                $final .= ' data-filter-target="' . $block->context['filterInfo']['plainTarget'] . '"';
            }
            if (isset($block->context['filterInfo']['value']) && $block->context['filterInfo']['value']) {
                $final .= ' data-filter-value="' . $block->context['filterInfo']['value'] . '"';
            }
            if (isset($block->context['filterInfo']['filter_id']) && $block->context['filterInfo']['filter_id']) {
                $final .= ' data-filter-id="' . $block->context['filterInfo']['filter_id'] . '"';
            }
            if (isset($block->context['filterType']) && $block->context['filterType']) {
                $final .= 'data-filter-type="' . $block->context['filterType'] . '"';
            }
            if (isset($block->context['filterInfo']) && $block->context['filterInfo']) {
                $child_targets = new stdClass();
                if (isset($block->context['filterInfo']['children']) && $block->context['filterInfo']['children']) {
                    foreach ($block->context['filterInfo']['children'] as $index => $child) {
                        if (isset($child['target']) && $child['target'] && isset($child['value']) && $child['value']) {
                            $child_targets->{$child['target']} = $child['value'];
                            // $child_targets[] = (object) [$child['target'] => $child['value']];
                        }
                    }
                }
                if ($child_targets) {
                    $final .= ' data-filter-child-target=\'' . wp_json_encode($child_targets) . '\'';
                }
            }
            $value = $final;
            break;

        // FILTER
        case 'urlparam':
            $value = '';
            if (isset($args[0]) && $args[0] && isset($args[1]) && $args[1]) {
                if (isset($_GET[$args[0]])) {
                    $url = $_GET[$args[0]];
                    if ($url && $url === $args[1]) {
                        $value = 'selected';
                    }
                }
            }
            break;

        case 'filterstatus':
            $value = '';
            if (isset($block->context['filterType']) && $block->context['filterType'] && $block->context['filterType'] === 'single') {
                if (isset($_GET[$block->context['filterInfo']['plainTarget']]) && $_GET[$block->context['filterInfo']['plainTarget']] == $block->context['filterInfo']['value']) {
                    $value = 'selected';
                }
            }
            if (isset($block->context['filterType']) && $block->context['filterType'] && $block->context['filterType'] === 'multiple') {
                $get_value = $_GET[$block->context['filterInfo']['plainTarget']];
                $get_array = explode(',', $get_value);
                if (in_array($block->context['filterInfo']['value'], $get_array)) {
                    $value = 'selected';
                }
            }
            break;
        // FILTER

        // SWATCH

        case 'swatchclass':
            if (CC_WOOCOMMERCE && isset($args[0]) && $args[0]) {
                if (!isset($block->context['repeater'])) {
                    if ($product && $product->get_type() === 'variable') {
                        if ($attributes['swatchType'] === 'select') {
                            $value = ' ' . $args[0] . '';
                        }
                    }
                } else if (isset($block->context['wooVariable']) && $block->context['wooVariable']['type'] === 'select') {
                    $value = ' ' . $args[0] . '';
                }
            }
            break;

        case 'swatchid':
            $final = '';
            if (isset($block->context['queryId']) && isset($block->context['query_index']) && $block->context['query_index']) {
                $final .= '" data-variation_query_id="' . $block->context['queryId'] . '-' . $block->context['query_index'] . '';
            }
            if (isset($block->context['wooVariable']) && $block->context['wooVariable']['type'] === 'select') {
                // if ($final) {
                $final .= '" data-variation_id="' . $block->context['wooVariable']['slug'] . '';
                // } else {
                //     $final .= ' data-variation_id="' . $block->context['wooVariable']['slug'] . '';
                // }
            }
            if (isset($attributes['swatchSlug']) && $attributes['swatchSlug'] && isset($attributes['swatchType']) && $attributes['swatchType'] === 'select') {
                // if ($final) {
                $final .= '" data-variation_id="' . $attributes['swatchSlug'] . '';
                // } else {
                //     $final .= ' data-variation_id="' . $attributes['swatchSlug'] . '';
                // }
            }
            if ($final) {
                $value = $final;
            }
            break;

        case 'htmltag':
            if (!isset($block->context['repeater'])) {
                if (CC_WOOCOMMERCE && $product && $product->get_type() === 'variable') {
                    if ($attributes['swatchType'] === 'select') {
                        $value = 'select';
                    } else {
                        $value = 'div';
                    }
                }
            } else {
                if (CC_WOOCOMMERCE && isset($block->context['wooVariable']) && $block->context['wooVariable']['type'] === 'select') {
                    $value = 'select';
                } else {
                    $value = 'div';
                }
            }
            break;

        case 'swatch':
            if (isset($args[0]) && $args[0]) {
                $value = cc_swatch_maker($attributes, $block, $args[0], '', '');
            }
            break;
        // SWATCH

        // WOO ATTRIBUTES
        case 'woocouponnonce':
            if (!Cwicly\Helpers::is_rest() && !is_admin() && CC_WOOCOMMERCE) {
                $value = wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce');
                break;
            }

        case 'wooaddtocartajax':
            if (CC_WOOCOMMERCE) {
                $value = get_the_ID();
            }
            break;
        case 'wooaddtocart':
            if (!is_admin() && CC_WOOCOMMERCE) {
                global $product;
                $old_product = $product;
                if (isset($block->context['product']) && $block->context['product']) {
                    $product = $block->context['product'];
                }

                $preRel = '';
                if (isset($attributes['linkWrapperRel']) && $attributes['linkWrapperRel']) {
                    $preRel = ' ' . $attributes['linkWrapperRel'] . '';
                }
                $rel = '' . $preRel . '';
                $target = '';
                if (isset($attributes['linkWrapperNewTab']) && $attributes['linkWrapperNewTab']) {
                    $target = ' target="_blank"';
                } else {
                    $target = ' target="_self"';
                }

                if (isset($attributes['linkWrapperActionExtra']) && $attributes['linkWrapperActionExtra'] && isset($attributes['linkWrapperActionExtra']['redirectSimple'])) {
                    if (!is_bool($product)) {
                        $value = '" href="' . $product->get_permalink() . '" ' . $target . ' rel="' . $rel . '" data-cc-redirect="';
                    }
                } else if (isset($attributes['linkWrapperActionExtra']) && $attributes['linkWrapperActionExtra'] && isset($attributes['linkWrapperActionExtra']['redirectVariable'])) {
                    if (!is_bool($product)) {
                        $value = '" href="' . $product->get_permalink() . '" ' . $target . ' rel="' . $rel . '" data-cc-redirect="';
                    }
                } else if (isset($attributes['linkWrapperActionExtra']) && $attributes['linkWrapperActionExtra'] && isset($attributes['linkWrapperActionExtra']['redirectExternal'])) {
                    if (!is_bool($product)) {
                        $value = '" href="' . $product->get_permalink() . '" ' . $target . ' rel="' . $rel . '" data-cc-redirect="';
                    }
                } else if (isset($attributes['linkWrapperActionExtra']) && $attributes['linkWrapperActionExtra'] && isset($attributes['linkWrapperActionExtra']['redirectGrouped'])) {
                    if (!is_bool($product)) {
                        $value = '" href="' . $product->get_permalink() . '" ' . $target . ' rel="' . $rel . '" data-cc-redirect="';
                    }
                } else if (!is_bool($product) && $product && $product->is_in_stock() && $product->is_purchasable() && $product->is_type('simple')) {
                } else if (!is_bool($product) && $product->is_type('grouped')) {
                } else if (!is_bool($product) && $product->is_type('external')) {
                    $value = '" href="' . $product->get_product_url() . '" ' . $target . ' rel="' . $rel . '" data-cc-redirect="';
                } else {
                    $value = '" disabled="';
                }
            }
            break;

        case 'formwoocoupon':
            $final = '';
            $final .= '" action="' . esc_url(wc_get_cart_url()) . '';
            $final .= '" method="post';
            $value = $final;
            break;

        case 'formaddtocart':
            $final = '';
            if ($product) {
                if ($product->get_type() === 'variable') {
                    if (class_exists('WC_Frontend_Scripts')) {
                        $frontend_scripts = new \WC_Frontend_Scripts();
                        $frontend_scripts::load_scripts();
                    }
                    wp_enqueue_script('wc-add-to-cart-variation');
                    // do_action('woocommerce_variable_add_to_cart');
                }
                if ($product->is_type('simple')) {
                    $final .= '" action="' . esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())) . '';
                } else if ($product->is_type('variable')) {
                    if (isset($block->context['queryId']) && isset($block->context['query_index']) && $block->context['query_index']) {
                        $final .= '" data-variation_query_id="' . $block->context['queryId'] . '-' . $block->context['query_index'] . '';
                    }
                    $get_variations = count($product->get_children()) <= apply_filters('woocommerce_ajax_variation_threshold', 30, $product);
                    $available_variations = $get_variations ? $product->get_available_variations() : false;
                    $variations_json = wp_json_encode($available_variations);
                    $variations_attr = function_exists('wc_esc_json') ? wc_esc_json($variations_json) : _wp_specialchars($variations_json, ENT_QUOTES, 'UTF-8', true);
                    $final .= '" action="' . esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())) . '" data-product_id="' . absint($product->get_id()) . '" data-product_variations="' . $variations_attr . '';
                } else if ($product->is_type('grouped')) {
                    $final .= '" action="' . esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())) . '';
                } else if ($product->is_type('external')) {
                    $final .= '" action="' . esc_url($product->add_to_cart_url()) . '';
                }

                if ($product->is_type('external')) {
                    $final .= '" method="get';
                } else {
                    $final .= '" method="' . $attributes['formMethod'] . '';
                }

                if (!$product->is_type('external')) {
                    if (isset($attributes['formEnctype']) && $attributes['formEnctype']) {
                        $final .= '" enctype="multipart/form-data';
                    }
                }
            }
            $value = $final;
            break;

        case 'producttype':
            if ($product && $product->get_type()) {
                $value = $product->get_type();
            }
            break;

        case 'forminneraddtocart':
            if ($product && $product->get_type() === 'variable') {
                $get_variations = count($product->get_children()) <= apply_filters('woocommerce_ajax_variation_threshold', 30, $product);
                $available_variations = $get_variations ? $product->get_available_variations() : false;
                $attributes = $product->get_variation_attributes();
                ob_start();
                ?>
                <table class="variations" cellspacing="0">
                    <tbody>
                        <?php foreach ($attributes as $attribute_name => $options): ?>
                            <tr>
                                <td class="value">
                                    <?php
wc_dropdown_variation_attribute_options(
                    array(
                        'options' => $options,
                        'attribute' => $attribute_name,
                        'product' => $product,
                    )
                );
                ?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                <div class="woocommerce-variation single_variation"></div>
                <div class="single_variation_wrap">
                    <input type="hidden" name="add-to-cart" value="<?php echo absint($product->get_id()); ?>" />
                    <input type="hidden" name="product_id" value="<?php echo absint($product->get_id()); ?>" />
                    <input type="hidden" name="variation_id" class="variation_id" value="0" />
                </div>
<?php
// do_action('woocommerce_variable_add_to_cart');
                // do_action('woocommerce_single_variation');
                $value = ob_get_clean();
            }
            break;

        case 'variationqueryid':
            if (CC_WOOCOMMERCE && $product && $product->get_type() === 'variable') {
                if (isset($block->context['queryId']) && isset($block->context['query_index']) && $block->context['query_index']) {
                    $value = '" data-variation_query_id="' . $block->context['queryId'] . '-' . $block->context['query_index'] . '';
                }
            }
            break;

        case 'variationprice':
            if (CC_WOOCOMMERCE && $product && $product->get_type() === 'variable') {
                if (isset($args[0]) && $args[0]) {
                    $value = '" data-variation_price="' . $args[0] . '';
                } else {
                    $value = '" data-variation_price="';
                }
            }
            break;

        case 'variationsaleprice':
            if (CC_WOOCOMMERCE && $product && $product->get_type() === 'variable') {
                if (isset($args[0]) && $args[0]) {
                    $value = '" data-variation_saleprice="' . $args[0] . '';
                } else {
                    $value = '" data-variation_saleprice="';
                }
            }
            break;

        case 'variationsalepercentage':
            if (CC_WOOCOMMERCE && $product && $product->get_type() === 'variable') {
                if (isset($args[0]) && $args[0]) {
                    $value = '" data-variation_salepercentage="' . $args[0] . '';
                } else {
                    $value = '" data-variation_salepercentage="';
                }
            }
            break;

        case 'variationregularprice':
            if (CC_WOOCOMMERCE && $product && $product->get_type() === 'variable') {
                if (isset($args[0]) && $args[0]) {
                    $value = '" data-variation_regularprice="' . $args[0] . '';
                } else {
                    $value = '" data-variation_regularprice="';
                }
            }
            break;

        case 'variationquanity':
            if (CC_WOOCOMMERCE && $product && $product->get_type() === 'variable') {
                $value = '" data-variation_stock="';
            }
            break;

        case 'variationheight':
            if (CC_WOOCOMMERCE && $product && $product->get_type() === 'variable') {
                $value = '" data-variation_height="';
            }
            break;

        case 'variationwidth':
            if (CC_WOOCOMMERCE && $product && $product->get_type() === 'variable') {
                $value = '" data-variation_width="';
            }
            break;

        case 'variationlength':
            if (CC_WOOCOMMERCE && $product && $product->get_type() === 'variable') {
                $value = '" data-variation_length="';
            }
            break;

        case 'variationdescription':
            if (CC_WOOCOMMERCE && $product && $product->get_type() === 'variable') {
                $value = '" data-variation_description="';
            }
            break;

        case 'variationminpurchasequantity':
            if (CC_WOOCOMMERCE && $product && $product->get_type() === 'variable') {
                $value = '" data-variation_minpurchasequantity="';
            }
            break;

        case 'variationmaxpurchasequantity':
            if (CC_WOOCOMMERCE && $product && $product->get_type() === 'variable') {
                $value = '" data-variation_maxpurchasequantity="';
            }
            break;

        case 'variationlabel':
            if (isset($block->context['wooVariable']) && $block->context['wooVariable'] && $block->context['wooVariable']['label']) {
                $value = $block->context['wooVariable']['label'];
            }
            break;

        case 'variationtype':
            if (isset($block->context['wooVariable']) && $block->context['wooVariable'] && $block->context['wooVariable']['type']) {
                $value = $block->context['wooVariable']['label'];
            }
            break;

        case 'variationslug':
            if (isset($block->context['wooVariable']) && $block->context['wooVariable'] && $block->context['wooVariable']['slug']) {
                $value = $block->context['wooVariable']['label'];
            }
            break;

        case 'hide':
            if (isset($args[0]) && $args[0]) {
                if ($args[0] === 'is_var_is_group') {
                    if ($product && ($product->get_type() === 'variable')) {
                        $final = '';
                        $final .= '" hidden="true" cc-hidden="true';
                        $value = $final;
                    }
                }
            }
            break;
        // WOO ATTRIBUTES

        // GALLERY
        case 'acfgallery':
            if (isset($args[0]) && $args[0]) {
                // OVERLAY
                $galleryOverlay = '';
                if (isset($attributes['galleryOverlay']) && $attributes['galleryOverlay']) {
                    $galleryOverlay = $attributes['galleryOverlay'];
                }
                // OVERLAY
                // IMAGE
                $imageProps = '';
                if (isset($attributes['galleryType']) && $attributes['galleryType'] === 'masonry') {
                    $imageProps = 'style="width: 100%; height: 100%;"';
                } else {
                    if (isset($attributes['galleryOverlay']) && $attributes['galleryOverlay'] === 'gallery-sunrise') {
                        $imageProps = 'style="object-fit: cover;"';
                    } else {
                        $imageProps = 'style="width: 100%; height: 100%; object-fit: cover;"';
                    }
                }

                $lazyLoad = '';
                if (isset($attributes['galleryLazyLoad']) && $attributes['galleryLazyLoad']) {
                    $lazyLoad = ' loading="lazy"';
                }
                // IMAGE

                $content = '';
                $gallery = [];
                $gallery = get_field($args[0]);
                if (isset($gallery) && $gallery) {
                    foreach ($gallery as $index => $valuer) {
                        $url = '';
                        if (isset($attributes['galleryThumbnailSize']) && $attributes['galleryThumbnailSize'] && $valuer['sizes'] && $valuer['sizes'][$attributes['galleryThumbnailSize']]) {
                            $url = $valuer['sizes'][$attributes['galleryThumbnailSize']];
                        } else if ($valuer['url']) {
                            $url = $valuer['url'];
                        }

                        $urled = false;
                        $content .= '<figure class="cc-gallery-card ' . $galleryOverlay . ' gallery-1" data-ccgalleryname="gallery-1">';
                        $content .= '<div class="cc-gallery-lightbox" style="overflow: hidden; width: 100%; position: relative;">';
                        if (isset($attributes['linkWrapperActive']) && $attributes['linkWrapperActive'] && isset($attributes['linkWrapperType']) && $attributes['linkWrapperType'] === 'lightbox') {
                            $content .= '<a class="cc-lightbox cc-gallery-lightbox" href="' . $valuer['url'] . '">';
                            $urled = true;
                        }
                        $content .= '<img ' . $imageProps . ' src=' . $url . $lazyLoad . '></img>';
                        $content .= '<figcaption>';
                        if ((isset($attributes['galleryTitleControl']) && $attributes['galleryTitleControl']) || (isset($attributes['galleryDescriptionControl']) && $attributes['galleryDescriptionControl'])) {
                            if ($attributes['galleryTitleControl'] && isset($valuer['title']) && $valuer['title']) {
                                $content .= '<p class="cc-gallery-title">' . $valuer['title'] . '</p>';
                            }
                            if (isset($attributes['galleryDescriptionControl']) && isset($valuer['caption']) && $valuer['caption']) {
                                $content .= '<p class="cc-gallery-description">' . $valuer['caption'] . '</p>';
                            }
                        }
                        $content .= '</figcaption>';
                        if ($urled) {
                            $content .= '</a>';
                        }
                        if ($urled === 'active') {
                            $content .= '</div>';
                        }
                        $content .= '</div>';
                        $content .= '</figure>';
                    }
                }
                $value = $content;
            }
            break;

        case 'woogallery':
            if (isset($args[0]) && $args[0] && CC_WOOCOMMERCE) {
                // OVERLAY
                $galleryOverlay = '';
                if (isset($attributes['galleryOverlay']) && $attributes['galleryOverlay']) {
                    $galleryOverlay = $attributes['galleryOverlay'];
                }
                // OVERLAY
                // IMAGE
                $imageProps = '';
                if (isset($attributes['galleryType']) && $attributes['galleryType'] === 'masonry') {
                    $imageProps = 'style="width: 100%;"';
                } else {
                    if (isset($attributes['galleryOverlay']) && $attributes['galleryOverlay'] === 'gallery-sunrise') {
                        $imageProps = 'style="object-fit: cover;"';
                    } else {
                        $imageProps = 'style="width: 100%; height: 100%; object-fit: cover;"';
                    }
                }
                // IMAGE

                $content = '';
                if (isset($product) && $product) {
                    $original = [];
                    $full_url = [];
                    $medium_url = [];
                    $thumbnail_url = [];
                    $main_image = [];
                    $main_image[] = $product->get_image_id();
                    $gallery_images = $product->get_gallery_image_ids();
                    $attachment_ids = array_merge($main_image, $gallery_images);
                    if ($attributes['galleryDynamicWordpressType'] === 'wooGallery') {
                        array_splice($attachment_ids, 0, 1);
                    }
                    foreach ($attachment_ids as $images) {
                        $original[] = wp_get_attachment_url($images);
                        $originalsrcset[] = wp_get_attachment_image_srcset($images);
                        $full_url[] = wp_get_attachment_image_src($images, 'full')[0];
                        $medium_url[] = wp_get_attachment_image_src($images, 'medium')[0];
                        $thumbnail_url[] = wp_get_attachment_image_src($images, 'thumbnail')[0];
                    }
                    foreach ($original as $key => $value) {
                        $urled = false;
                        $content .= '<figure class="cc-gallery-card ' . $galleryOverlay . ' gallery-1" data-ccgalleryname="gallery-1">';
                        $content .= '<div style="overflow: hidden; width: 100%; position: relative;">';
                        if (isset($attributes['linkWrapperActive']) && $attributes['linkWrapperActive'] && isset($attributes['linkWrapperType']) && $attributes['linkWrapperType'] === 'lightbox') {
                            $content .= '<a class="cc-lightbox cc-gallery-lightbox" href="' . $value . '">';
                            $urled = true;
                        }
                        $content .= '<img ' . $imageProps . ' srcset="' . $originalsrcset[$key] . '" src="' . $value . '"></img>';
                        // $content .= '<img ' . $imageProps . ' ' . $originalsrcset[$key] . ' src=' . $valuer['url'] . '></img>';
                        $content .= '<figcaption>';
                        if ((isset($attributes['galleryTitleControl']) && $attributes['galleryTitleControl']) || (isset($attributes['galleryDescriptionControl']) && $attributes['galleryDescriptionControl'])) {
                            if ($attributes['galleryTitleControl']) {
                                $attachment_title = get_the_title($attachment_ids[$key]);
                                if ($attachment_title) {
                                    $content .= '<p class="cc-gallery-title">' . $attachment_title . '</p>';
                                }
                            }
                            // if (isset($attributes['galleryDescriptionControl']) && isset($valuer['caption']) && $valuer['caption']) {
                            //     $content .= '<p class="cc-gallery-description">' . $valuer['caption'] . '</p>';
                            // }
                        }
                        $content .= '</figcaption>';
                        if ($urled) {
                            $content .= '</a>';
                        }
                        if ($urled === 'active') {
                            $content .= '</div>';
                        }
                        $content .= '</div>';
                        $content .= '</figure>';
                    }
                }
                $value = $content;
            }
            break;
        // GALLERY

        // MENU
        case 'menu':
            $value = cc_menu_maker($attributes);
            break;

        case 'menuname':
            if (isset($attributes['menuSelected']) && $attributes['menuSelected']) {
                if (isset($attributes['menuAriaLabel']) && $attributes['menuAriaLabel']) {
                    $value = $attributes['menuAriaLabel'];
                } else {
                    $menu = wp_get_nav_menu_object($attributes['menuSelected']);
                    if ($menu) {
                        $value = $menu->name;
                    }
                }
            }
            break;
        // MENU

        // SLIDER
        case 'breakpointmd':
            $breaks = get_option('cwicly_breakpoints');
            if (!$breaks) {
                $breaks = array('md' => 992, 'sm' => 576);
                update_option('cwicly_breakpoints', $breaks);
            }
            if ($breaks && isset($breaks['md']) && $breaks['md']) {
                $value = $breaks['md'];
            }
            break;

        case 'breakpointsm':
            $breaks = get_option('cwicly_breakpoints');
            if (!$breaks) {
                $breaks = array('md' => 992, 'sm' => 576);
                update_option('cwicly_breakpoints', $breaks);
            }
            if ($breaks && isset($breaks['sm']) && $breaks['sm']) {
                $value = $breaks['sm'];
            }
            break;
        // SLIDER

        // QUERY PAGINATION NUMBERS
        case 'pagination':
            if (isset($block->context['queryInherit']) && $block->context['queryInherit']) {
                $paginate_args = array(
                    'prev_next' => false,
                );
                $value = paginate_links($paginate_args);
            } else {
                if (isset($block->context['paginateArgs']) && $block->context['paginateArgs']) {
                    if (isset($block->context['queryInherit']) && $block->context['queryInherit']) {
                        $paginate_args = array(
                            'prev_next' => false,
                        );
                        $value = paginate_links($paginate_args);
                    } else if ($block->context['queryType'] === 'products') {
                        $value = paginate_links(
                            apply_filters(
                                'woocommerce_pagination_args',
                                $block->context['paginateArgs']
                            )
                        );
                    } else {
                        $value = paginate_links($block->context['paginateArgs']);
                    }
                }
            }
            break;
        // QUERY PAGINATION NUMBERS

        // QUERY PREV NEXT
        case 'nextquery':
            if (isset($block->context['queryId']) && $block->context['queryId']) {
                $value = '' . cc_block_query_prev_next($block, 'next') . '" cc-qp-next-button="' . $block->context['queryId'] . '';
            } else {
                $value = cc_block_query_prev_next($block, 'next');
            }
            break;
        case 'prevquery':
            if (isset($block->context['queryId']) && $block->context['queryId']) {
                $value = '' . cc_block_query_prev_next($block, 'prev') . '" cc-qp-prev-button="' . $block->context['queryId'] . '';
            } else {
                $value = cc_block_query_prev_next($block, 'prev');
            }
            break;

        case 'nextqb':
            if (isset($block->context['queryId']) && $block->context['queryId']) {
                if (!cc_block_query_prev_next($block, 'next')) {
                    $value = 'disabled';
                } else {
                    $value = 'cc-placeholder';
                }
            } else {
                if (!cc_block_query_prev_next($block, 'next')) {
                    $value = 'disabled';
                } else {
                    $value = 'cc-placeholder';
                }
            }
            break;
        case 'prevqb':
            if (isset($block->context['queryId']) && $block->context['queryId']) {
                if (!cc_block_query_prev_next($block, 'prev')) {
                    $value = 'disabled';
                } else {
                    $value = 'cc-placeholder';
                }
            } else {
                if (!cc_block_query_prev_next($block, 'prev')) {
                    $value = 'disabled';
                } else {
                    $value = 'cc-placeholder';
                }
            }
            break;

        // FUNCTION RETURN
        case 'return':
            if (isset($args[0]) && $args[0]) {
                $function = $args[0];
                $value = cc_echo($function);
            }
            break;

        // WOO NOTICES
        case 'woonotice':
            if (isset($block->context['wooNotice']) && $block->context['wooNotice']) {
                $value = wc_kses_notice($block->context['wooNotice']);
            }
            break;

        default:
            $value = '{' . $dyn . '}';
            break;
    }

    return $value;
}
