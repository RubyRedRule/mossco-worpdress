<?php

/**
 * Cwicly Conditions
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
 * Cwicly Hide for Logged In
 *
 * Function to check if User is logged in and Block is hidden if true
 *
 * @package Cwicly\Functions
 * @version 1.1
 */
function cc_hide_logged_in($attributes)
{
    $hideLoggedIn = false;
    if ((isset($attributes['hideLoggedIn']) && $attributes['hideLoggedIn'] && !is_user_logged_in()) || (isset($attributes['hideLoggedIn']) && !$attributes['hideLoggedIn']) || !isset($attributes['hideLoggedIn'])) {
        $hideLoggedIn = true;
    }
    return $hideLoggedIn;
}

/**
 * Cwicly Hide for Guest
 *
 * Function to check if User is a guest in and Block is hidden if true
 *
 * @package Cwicly\Functions
 * @version 1.1
 */
function cc_hide_guest($attributes)
{
    $hideGuest = false;
    if ((isset($attributes['hideGuest']) && $attributes['hideGuest'] && is_user_logged_in()) || (isset($attributes['hideGuest']) && !$attributes['hideGuest']) || !isset($attributes['hideGuest'])) {
        $hideGuest = true;
    }
    return $hideGuest;
}

/**
 * Cwicly Conditions Maker
 *
 * Functions for creating static and dynamic conditions
 *
 * @package Cwicly\Functions
 * @version 1.1
 */
function cc_conditions_maker($attributes, $block)
{
    $finalConditions = array();
    $hideConditions = array();
    $conditionType = '&&';
    if (isset($attributes['hideConditionsType']) && $attributes['hideConditionsType']) {
        $conditionType = $attributes['hideConditionsType'];
    }

    global $post;
    $oldpost = $post;
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
    }

    if (isset($attributes['hideConditions']) && $attributes['hideConditions']) {
        $current_user = wp_get_current_user();
        $hideConditions = $attributes['hideConditions'];
        foreach ($hideConditions as $value) {
            if ($value['condition'] && $value['operator']) {
                $condition = '';
                // WOOCOMMERCE
                if (CC_WOOCOMMERCE) {
                    if ($product) {
                        if ($value['condition'] === 'wooshippingtaxable') {
                            $condition = $product->is_shipping_taxable();
                        }
                        if ($value['condition'] === 'wooshippingclass') {
                            $condition = $product->get_shipping_class();
                        }
                        if ($value['condition'] === 'wooshippingclassid') {
                            $condition = $product->get_shipping_class_id();
                        }
                        if ($value['condition'] === 'wootaxclass') {
                            $condition = $product->get_tax_class();
                        }
                        if ($value['condition'] === 'wootaxstatus') {
                            $condition = $product->get_tax_status();
                        }
                        if ($value['condition'] === 'woowidth') {
                            $condition = $product->get_width();
                        }
                        if ($value['condition'] === 'wooheigth') {
                            $condition = $product->get_height();
                        }
                        if ($value['condition'] === 'woolength') {
                            $condition = $product->get_length();
                        }
                        if ($value['condition'] === 'wooweight') {
                            $condition = $product->get_weight();
                        }
                        if ($value['condition'] === 'woopurchasable') {
                            $condition = $product->is_purchasable();
                        }
                        if ($value['condition'] === 'woostockquantity') {
                            $condition = $product->get_stock_quantity();
                        }
                        if ($value['condition'] === 'woosoldindividually') {
                            $condition = $product->is_sold_individually();
                        }
                        if ($value['condition'] === 'woobackordersallowed') {
                            $condition = $product->backorders_allowed();
                        }
                        if ($value['condition'] === 'woodownloadable') {
                            $condition = $product->is_downloadable();
                        }
                        if ($value['condition'] === 'woovirtual') {
                            $condition = $product->is_virtual();
                        }
                        if ($value['condition'] === 'woofeatured') {
                            $condition = $product->is_featured();
                        }
                        if ($value['condition'] === 'woomanagestock') {
                            $condition = $product->managing_stock();
                        }
                        if ($value['condition'] === 'wooonsale') {
                            if ($product->get_type() === 'variable') {
                                $condition = 'cc_pass';
                            } else {
                                if ($product->is_on_sale()) {
                                    $condition = true;
                                } else {
                                    $condition = false;
                                }
                            }
                        }
                        if ($value['condition'] === 'woohasgalleryitems') {
                            $condition = $product->get_gallery_image_ids();
                            if (is_array($condition) && count($condition) > 0) {
                                $condition = true;
                            } else {
                                $condition = false;
                            }
                        }
                        if ($value['condition'] === 'wooreviewsallowed') {
                            $condition = $product->get_reviews_allowed();
                        }
                        if ($value['condition'] === 'wooshippingrequired') {
                            $condition = $product->needs_shipping();
                        }
                        if ($value['condition'] === 'woocatalogvisibility') {
                            $condition = $product->get_catalog_visibility();
                        }
                        if ($value['condition'] === 'woostockstatus') {
                            $condition = $product->get_stock_status();
                        }
                        if ($value['condition'] === 'woototalsales') {
                            $condition = $product->get_total_sales();
                        }
                        if ($value['condition'] === 'woolowstockamount') {
                            $condition = $product->get_low_stock_amount();
                        }
                        if ($value['condition'] === 'wootype') {
                            $condition = $product->get_type();
                        }
                        if ($value['condition'] === 'woosaleprice') {
                            $condition = $product->get_sale_price();
                        }
                        if ($value['condition'] === 'woodescription') {
                            $condition = $product->get_description();
                        }
                        if ($value['condition'] === 'wooshortdescription') {
                            $condition = $product->get_short_description();
                        }
                        if ($value['condition'] === 'wooquantityinstock') {
                            $condition = $product->get_stock_quantity();
                        }
                        if ($value['condition'] === 'woomaxpurchasequantity') {
                            $condition = $product->get_max_purchase_quantity();
                        }
                        if ($value['condition'] === 'woominpurchasequantity') {
                            $condition = $product->get_min_purchase_quantity();
                        }
                        if ($value['condition'] === 'woosalefrom') {
                            $condition = $product->get_date_on_sale_from();
                        }
                        if ($value['condition'] === 'woosaletill') {
                            $condition = $product->get_date_on_sale_to();
                        }
                        if ($value['condition'] === 'woometa') {
                            $condition = $product->get_sale_price();
                        }
                        if ($value['condition'] === 'woosku') {
                            $condition = $product->get_sku();
                        }
                        if ($value['condition'] === 'wooreviews') {
                            $condition = $product->get_sale_price();
                        }
                        if ($value['condition'] === 'wooratingcount') {
                            $condition = $product->get_rating_count();
                        }
                        if ($value['condition'] === 'wooreviewcount') {
                            $condition = $product->get_review_count();
                        }
                        if ($value['condition'] === 'wooaveragerating') {
                            $condition = $product->get_average_rating();
                        }
                        if ($value['condition'] === 'woototalsold') {
                            $condition = get_post_meta($product->id, 'total_sales', true);
                        }
                        if ($value['condition'] === 'woohasrelatedproducts') {
                            $related_products = wc_get_related_products($product->get_id());
                            if (!empty($related_products)) {
                                $condition = true;
                            }
                        }
                    }
                }
                // WOOCOMMERCE
                if ($value['condition'] === 'authorname') {
                    $condition = get_the_author();
                }
                if ($value['condition'] === 'date') {
                    $condition = date_i18n("m/d/Y");
                }
                if ($value['condition'] === 'dayweek') {
                    $condition = date_i18n("l");
                }
                if ($value['condition'] === 'daymonth') {
                    $condition = date_i18n("d");
                }
                if ($value['condition'] === 'time') {
                    $condition = date_i18n("H:i:s");
                }
                if ($value['condition'] === 'postid') {
                    $condition = strval(get_the_ID());
                }
                if ($value['condition'] === 'postparentid') {
                    $condition = wp_get_post_parent_id(get_the_ID());
                }
                if ($value['condition'] === 'posttitle') {
                    $condition = get_the_title();
                }
                if ($value['condition'] === 'postfeaturedimage') {
                    if (has_post_thumbnail()) {
                        $condition = 'true';
                    } else {
                        $condition = 'false';
                    }
                }
                if ($value['condition'] === 'postcomments') {
                    $condition = strval(get_comments_number());
                }
                if ($value['condition'] === 'postexcerpt') {
                    if (has_excerpt() && get_the_excerpt()) {
                        $condition = 'true';
                    } else {
                        $condition = 'false';
                    }
                }
                if ($value['condition'] === 'postcontent') {
                    if (get_the_content()) {
                        $condition = 'true';
                    } else {
                        $condition = 'false';
                    }
                }
                if ($value['condition'] === 'posttype') {
                    $condition = get_post_type();
                }
                if ($value['condition'] === 'postcategory') {
                    $categories = get_the_category();
                    $category_list = [];
                    if (!empty($categories)) {
                        foreach ($categories as $category) {
                            $category_list[] = $category->name;
                        }
                    }
                }
                if ($value['condition'] === 'posttag') {
                    $post_tags = wp_get_post_terms(get_the_ID());
                    $tag_list = [];
                    if ($post_tags) {
                        foreach ($post_tags as $tag) {
                            $tag_list[] = strtolower($tag->name);
                        }
                    }
                }
                if ($value['condition'] === 'username') {
                    $condition = $current_user->user_login;
                }
                if ($value['condition'] === 'userid') {
                    $condition = strval($current_user->ID);
                }
                if ($value['condition'] === 'usercapabilities') {
                    if (current_user_can($value['data'])) {
                        $condition = true;
                    } else {
                        $condition = false;
                    }
                }
                if ($value['condition'] === 'commentsopen') {
                    if (comments_open()) {
                        $condition = 'true';
                    } else {
                        $condition = 'false';
                    }
                }
                if ($value['condition'] === 'commentapproved' && isset($block->context['commentQuery'])) {
                    if ($block->context['commentQuery']->comment_approved === '1') {
                        $condition = true;
                    } else {
                        $condition = false;
                    }
                }
                if ($value['condition'] === 'commentsregistration') {
                    if (get_option('comment_registration')) {
                        $condition = true;
                    } else {
                        $condition = false;
                    }
                }
                if ($value['condition'] === 'commentisauthor') {
                    $commenter = wp_get_current_commenter();
                    if (isset($block->context['commentQuery']->comment_author_email) && !empty($commenter)) {
                        if ($block->context['commentQuery']->comment_author_email === $commenter['comment_author_email']) {
                            $condition = true;
                        } else {
                            $condition = false;
                        }
                    } else {
                        $condition = false;
                    }
                }
                if ($value['condition'] === 'queryissinglepage') {
                    if (isset($block->context['queryTotal'])) {
                        if (intval($block->context['queryTotal']) === 1) {
                            $condition = true;
                        } else {
                            $condition = false;
                        }
                    }
                }
                if ($value['condition'] === 'queryhasitems') {
                    if ($block->parsed_block['blockName'] === 'cwicly/query') {
                        $condition = 'cc_pass';
                    } else if (isset($block->context['hasPosts']) && $block->context['hasPosts']) {
                        $condition = true;
                    } else {
                        $condition = false;
                    }
                }
                if ($value['condition'] === 'queryhasprevpage') {
                    if (isset($block->context['queryId']) && $block->context['queryId']) {
                        if (!cc_block_query_prev_next($block, 'prev')) {
                            $condition = false;
                        } else {
                            $condition = true;
                        }
                    } else {
                        if (!cc_block_query_prev_next($block, 'prev')) {
                            $condition = false;
                        } else {
                            $condition = true;
                        }
                    }
                }
                if ($value['condition'] === 'queryhasnextpage') {
                    if (isset($block->context['queryId']) && $block->context['queryId']) {
                        if (!cc_block_query_prev_next($block, 'next')) {
                            $condition = false;
                        } else {
                            $condition = true;
                        }
                    } else {
                        if (!cc_block_query_prev_next($block, 'next')) {
                            $condition = false;
                        } else {
                            $condition = true;
                        }
                    }
                }
                if ($value['condition'] === 'functionreturn') {
                    if (isset($value['function']) && $value['function']) {
                        $condition = cc_echo($value['function']);
                    }
                }
                if ($value['condition'] === 'urlparameter') {
                    if (isset($value['key']) && $value['key']) {
                        if (isset($_GET[$value['key']]) && $_GET[$value['key']]) {
                            $key = htmlspecialchars($_GET[$value['key']], ENT_QUOTES, 'UTF-8');
                            if ($value['operator'] === 'true' || $value['operator'] === 'false') {
                                $condition = filter_var($key, FILTER_VALIDATE_BOOLEAN);
                            } else {
                                $condition = $key;
                            }
                        }
                    }
                }
                if (isset($value['data']) && is_string($value['data']) && $value['data'] && $value['data'][0] == '{' && $value['data'][strlen($value['data']) - 1] == '}') {
                    $value['data'] = cc_parser('' . $value['data'] . '', $attributes, $block);
                }
                switch ($value['operator']) {
                    case "===":
                        if ($value['condition'] === 'cookie') {
                            $loop = true;
                            foreach ($_COOKIE as $key => $val) {
                                if ($key === $value['data']) {
                                    $finalConditions[] = 'true';
                                    $loop = false;
                                    break;
                                }
                            }
                            if ($loop) {
                                $finalConditions[] = 'false';
                            }
                        } else if ($value['condition'] === 'usercapabilities') {
                            if ($condition) {
                                $finalConditions[] = 'true';
                            } else {
                                $finalConditions[] = 'false';
                            }
                        } else if ($value['condition'] === 'dayweek') {
                            $date_now = strtotime('today');
                            $date_compared = strtotime('' . $value['data'] . ' this week');
                            if ($date_now === $date_compared) {
                                $finalConditions[] = 'true';
                            } else {
                                $finalConditions[] = 'false';
                            }
                        } else if ($value['condition'] === 'postcategory') {
                            if (in_array(get_cat_name($value['data']), $category_list)) {
                                $finalConditions[] = 'true';
                            } else {
                                $finalConditions[] = 'false';
                            }
                        } else if ($value['condition'] === 'posttag') {
                            if (in_array($value['data'], $tag_list)) {
                                $finalConditions[] = 'true';
                            } else {
                                $finalConditions[] = 'false';
                            }
                        } else if ($value['condition'] === 'userrole') {
                            if (in_array($value['data'], $current_user->roles, true)) {
                                $finalConditions[] = 'true';
                            } else {
                                $finalConditions[] = 'false';
                            }
                        } else if ($value['condition'] === 'woosalefrom' || $value['condition'] === 'woosaletill') {
                            $date_now = strtotime($condition);
                            $date_compared = strtotime($value['data']);
                            if ($date_now === $date_compared) {
                                $finalConditions[] = 'true';
                            } else {
                                $finalConditions[] = 'false';
                            }
                        } else if ($value['condition'] === 'acf') {
                            if (isset($value['acfGroup']) && isset($value['acfField'])) {
                                $location = false;
                                if (isset($value['acfLocation'])) {
                                    if ($value['acfLocation'] === 'currentpost') {
                                        $location = get_the_ID();
                                    } else if ($value['acfLocation'] === 'postid' && isset($value['acfLocationID'])) {
                                        $location = $value['acfLocationID'];
                                    } else if ($value['acfLocation'] === 'currentuser') {
                                        $location = 'user_' . get_current_user_id() . '';
                                    } else if ($value['acfLocation'] === 'currentauthor') {
                                        $location = 'user_' . get_the_author_meta('ID') . '';
                                    } else if ($value['acfLocation'] === 'option') {
                                        $location = 'option';
                                    } else if ($value['acfLocation'] === 'taxterm' && isset($block->context['taxterms'])) {
                                        $location = $block->context['taxterms'];
                                    } else if ($value['acfLocation'] === 'termquery' && isset($block->context['termQuery'])) {
                                        $location = $block->context['termQuery'];
                                    } else if ($value['acfLocation'] === 'userquery' && isset($block->context['userQuery'])) {
                                        $location = $block->context['userQuery'];
                                    } else if ($value['acfLocation'] === 'taxonomyterm' && isset($value['acfLocationID']) && isset($value['acfLocationID']['value'])) {
                                        $term = get_term($value['acfLocationID']['value']);
                                        $location = $term->taxonomy . '_' . $term->term_id;
                                    } else if (isset($value['acfLocationID'])) {
                                        $location = $value['acfLocationID'];
                                    }
                                }

                                if (isset($value['acfRepeaterField']) && $value['acfRepeaterField'] !== 'cc_overall') {
                                    $field = '';
                                    $repeater_array = [];
                                    if ($block->context && isset($block->context['repeaters']) && $block->context['repeaters']) {
                                        $repeater_array = $block->context['repeaters'];
                                    }
                                    $row = 0;
                                    if ($block->context && isset($block->context['repeater_row']) && $block->context['repeater_row']) {
                                        $row = $block->context['repeater_row'];
                                    }
                                    if ($repeater_array) {
                                        if ($repeater_array[$row][$value['acfRepeaterField']]) {
                                            $field = cc_acf_field_processor($repeater_array[$row][$value['acfRepeaterField']], null, $attributes, $block->parsed_block['blockName']);
                                        }
                                    }
                                    if ($field === $value['data']) {
                                        $finalConditions[] = 'true';
                                    } else {
                                        $finalConditions[] = 'false';
                                    }
                                } else {
                                    $field = get_field($value['acfField'], $location);
                                    if (is_array($field)) {
                                        $field = implode(" ", $field);
                                    } else {
                                        $field = strval($field);
                                    }
                                    if ($field === $value['data']) {
                                        $finalConditions[] = 'true';
                                    } else {
                                        $finalConditions[] = 'false';
                                    }
                                }
                            }
                        } else if ($value['condition'] === 'device') {
                            $detect = new Mobile_Detect;
                            if ($value['data'] === 'mobile') {
                                if ($detect->isMobile()) {
                                    $finalConditions[] = 'true';
                                } else {
                                    $finalConditions[] = 'false';
                                }
                            }
                            if ($value['data'] === 'tablet') {
                                if ($detect->isTablet()) {
                                    $finalConditions[] = 'true';
                                } else {
                                    $finalConditions[] = 'false';
                                }
                            }
                            if ($value['data'] === 'desktop') {
                                if (!$detect->isMobile() && !$detect->isTablet()) {
                                    $finalConditions[] = 'true';
                                } else {
                                    $finalConditions[] = 'false';
                                }
                            }
                        } else {
                            if ($condition === $value['data']) {
                                $finalConditions[] = 'true';
                            } else {
                                $finalConditions[] = 'false';
                            }
                        }
                        break;
                    case "!=":
                        if ($value['condition'] === 'cookie') {
                            $loop = true;
                            foreach ($_COOKIE as $key => $val) {
                                if ($key === $value['data']) {
                                    $finalConditions[] = 'false';
                                    $loop = false;
                                    break;
                                }
                            }
                            if ($loop) {
                                $finalConditions[] = 'true';
                            }
                        } else if ($value['condition'] === 'woosalefrom' || $value['condition'] === 'woosaletill') {
                            $date_now = strtotime($condition);
                            $date_compared = strtotime($value['data']);
                            if ($date_now != $date_compared) {
                                $finalConditions[] = 'true';
                            } else {
                                $finalConditions[] = 'false';
                            }
                        } else if ($value['condition'] === 'dayweek') {
                            $date_now = strtotime('today');
                            $date_compared = strtotime('' . $value['data'] . ' this week');
                            if ($date_now != $date_compared) {
                                $finalConditions[] = 'true';
                            } else {
                                $finalConditions[] = 'false';
                            }
                        } else if ($value['condition'] === 'postcategory') {
                            if (!in_array($value['data'], $category_list)) {
                                $finalConditions[] = 'true';
                            } else {
                                $finalConditions[] = 'false';
                            }
                        } else if ($value['condition'] === 'posttag') {
                            if (!in_array($value['data'], $tag_list)) {
                                $finalConditions[] = 'true';
                            } else {
                                $finalConditions[] = 'false';
                            }
                        } else if ($value['condition'] === 'userrole') {
                            if (!in_array($value['data'], $current_user->roles, true)) {
                                $finalConditions[] = 'true';
                            } else {
                                $finalConditions[] = 'false';
                            }
                        } else if ($value['condition'] === 'acf') {
                            if (isset($value['acfGroup']) && isset($value['acfField'])) {
                                $location = '';
                                if (isset($value['acfLocation'])) {
                                    if ($value['acfLocation'] === 'currentpost') {
                                        $location = get_the_ID();
                                    } else if ($value['acfLocation'] === 'postid' && isset($value['acfLocationID'])) {
                                        $location = $value['acfLocationID'];
                                    } else if ($value['acfLocation'] === 'currentuser') {
                                        $location = 'user_' . get_current_user_id() . '';
                                    } else if ($value['acfLocation'] === 'currentauthor') {
                                        $location = 'user_' . get_the_author_meta('ID') . '';
                                    } else if ($value['acfLocation'] === 'option') {
                                        $location = 'option';
                                    } else if ($value['acfLocation'] === 'taxterm' && isset($block->context['taxterms'])) {
                                        $location = $block->context['taxterms'];
                                    } else if ($value['acfLocation'] === 'termquery' && isset($block->context['termQuery'])) {
                                        $location = $block->context['termQuery'];
                                    } else if ($value['acfLocation'] === 'userquery' && isset($block->context['userQuery'])) {
                                        $location = $block->context['userQuery'];
                                    } else if ($value['acfLocation'] === 'taxonomyterm' && isset($value['acfLocationID']) && isset($value['acfLocationID']['value'])) {
                                        $term = get_term($value['acfLocationID']['value']);
                                        $location = $term->taxonomy . '_' . $term->term_id;
                                    } else if (isset($value['acfLocationID'])) {
                                        $location = $value['acfLocationID'];
                                    }
                                }

                                if (isset($value['acfRepeaterField']) && $value['acfRepeaterField'] !== 'cc_overall') {
                                    $field = '';
                                    $repeater_array = [];
                                    if ($block->context && isset($block->context['repeaters']) && $block->context['repeaters']) {
                                        $repeater_array = $block->context['repeaters'];
                                    }
                                    $row = 0;
                                    if ($block->context && isset($block->context['repeater_row']) && $block->context['repeater_row']) {
                                        $row = $block->context['repeater_row'];
                                    }
                                    if ($repeater_array) {
                                        if ($repeater_array[$row][$value['acfRepeaterField']]) {
                                            $field = cc_acf_field_processor($repeater_array[$row][$value['acfRepeaterField']], null, $attributes, $block->parsed_block['blockName']);
                                        }
                                    }
                                    if ($field != $value['data']) {
                                        $finalConditions[] = 'true';
                                    } else {
                                        $finalConditions[] = 'false';
                                    }
                                } else {
                                    $field = get_field($value['acfField'], $location);
                                    if (is_array($field)) {
                                        $field = implode(" ", $field);
                                    } else {
                                        $field = strval($field);
                                    }

                                    if ($field != $value['data']) {
                                        $finalConditions[] = 'true';
                                    } else {
                                        $finalConditions[] = 'false';
                                    }
                                }
                            }
                        } else if ($value['condition'] === 'device') {
                            $detect = new Mobile_Detect;
                            if ($value['data'] === 'mobile') {
                                if ($detect->isMobile()) {
                                    $finalConditions[] = 'false';
                                } else {
                                    $finalConditions[] = 'true';
                                }
                            }
                            if ($value['data'] === 'tablet') {
                                if ($detect->isTablet()) {
                                    $finalConditions[] = 'false';
                                } else {
                                    $finalConditions[] = 'true';
                                }
                            }
                            if ($value['data'] === 'desktop') {
                                if (!$detect->isMobile() && !$detect->isTablet()) {
                                    $finalConditions[] = 'false';
                                } else {
                                    $finalConditions[] = 'true';
                                }
                            }
                        } else {
                            if ($condition != $value['data']) {
                                $finalConditions[] = 'true';
                            } else {
                                $finalConditions[] = 'false';
                            }
                        }
                        break;
                    case "contains":
                        if ($value['condition'] === 'cookie') {
                            $loop = true;
                            foreach ($_COOKIE as $key => $val) {
                                if (strpos($key, $value['data']) !== false) {
                                    $finalConditions[] = 'true';
                                    $loop = false;
                                    break;
                                }
                            }
                            if ($loop) {
                                $finalConditions[] = 'false';
                            }
                        } else if ($value['condition'] === 'acf') {
                            if (isset($value['acfGroup']) && isset($value['acfField'])) {
                                $location = false;
                                if (isset($value['acfLocation'])) {
                                    if ($value['acfLocation'] === 'currentpost') {
                                        $location = get_the_ID();
                                    } else if ($value['acfLocation'] === 'postid' && isset($value['acfLocationID'])) {
                                        $location = $value['acfLocationID'];
                                    } else if ($value['acfLocation'] === 'currentuser') {
                                        $location = 'user_' . get_current_user_id() . '';
                                    } else if ($value['acfLocation'] === 'currentauthor') {
                                        $location = 'user_' . get_the_author_meta('ID') . '';
                                    } else if ($value['acfLocation'] === 'option') {
                                        $location = 'option';
                                    } else if ($value['acfLocation'] === 'taxterm' && isset($block->context['taxterms'])) {
                                        $location = $block->context['taxterms'];
                                    } else if ($value['acfLocation'] === 'termquery' && isset($block->context['termQuery'])) {
                                        $location = $block->context['termQuery'];
                                    } else if ($value['acfLocation'] === 'userquery' && isset($block->context['userQuery'])) {
                                        $location = $block->context['userQuery'];
                                    } else if ($value['acfLocation'] === 'taxonomyterm' && isset($value['acfLocationID']) && isset($value['acfLocationID']['value'])) {
                                        $term = get_term($value['acfLocationID']['value']);
                                        $location = $term->taxonomy . '_' . $term->term_id;
                                    } else if (isset($value['acfLocationID'])) {
                                        $location = $value['acfLocationID'];
                                    }
                                }

                                if (isset($value['acfRepeaterField']) && $value['acfRepeaterField'] !== 'cc_overall') {
                                    $field = '';
                                    $repeater_array = [];
                                    if ($block->context && isset($block->context['repeaters']) && $block->context['repeaters']) {
                                        $repeater_array = $block->context['repeaters'];
                                    }
                                    $row = 0;
                                    if ($block->context && isset($block->context['repeater_row']) && $block->context['repeater_row']) {
                                        $row = $block->context['repeater_row'];
                                    }
                                    if ($repeater_array) {
                                        if ($repeater_array[$row][$value['acfRepeaterField']]) {
                                            $field = cc_acf_field_processor($repeater_array[$row][$value['acfRepeaterField']], null, $attributes, $block->parsed_block['blockName']);
                                        }
                                    }
                                    if (strpos($field, $value['data']) !== false) {
                                        $finalConditions[] = 'true';
                                    } else {
                                        $finalConditions[] = 'false';
                                    }
                                } else {
                                    $field = get_field($value['acfField'], $location);
                                    if (is_array($field)) {
                                        $field = implode(" ", $field);
                                    } else {
                                        $field = strval($field);
                                    }

                                    if (strpos($field, $value['data']) !== false) {
                                        $finalConditions[] = 'true';
                                    } else {
                                        $finalConditions[] = 'false';
                                    }
                                }
                            }
                        } else {
                            if (strpos($condition, $value['data']) !== false) {
                                $finalConditions[] = 'true';
                            } else {
                                $finalConditions[] = 'false';
                            }
                        }
                        break;
                    case "notcontain":
                        if ($value['condition'] === 'cookie') {
                            $loop = true;
                            foreach ($_COOKIE as $key => $val) {
                                if (strpos($key, $value['data']) === false) {
                                    $finalConditions[] = 'true';
                                    $loop = false;
                                    break;
                                }
                            }
                            if ($loop) {
                                $finalConditions[] = 'false';
                            }
                        } else if ($value['condition'] === 'acf') {
                            if (isset($value['acfGroup']) && isset($value['acfField'])) {
                                $location = false;
                                if (isset($value['acfLocation'])) {
                                    if ($value['acfLocation'] === 'currentpost') {
                                        $location = get_the_ID();
                                    } else if ($value['acfLocation'] === 'postid' && isset($value['acfLocationID'])) {
                                        $location = $value['acfLocationID'];
                                    } else if ($value['acfLocation'] === 'currentuser') {
                                        $location = 'user_' . get_current_user_id() . '';
                                    } else if ($value['acfLocation'] === 'currentauthor') {
                                        $location = 'user_' . get_the_author_meta('ID') . '';
                                    } else if ($value['acfLocation'] === 'option') {
                                        $location = 'option';
                                    } else if ($value['acfLocation'] === 'taxterm' && isset($block->context['taxterms'])) {
                                        $location = $block->context['taxterms'];
                                    } else if ($value['acfLocation'] === 'termquery' && isset($block->context['termQuery'])) {
                                        $location = $block->context['termQuery'];
                                    } else if ($value['acfLocation'] === 'userquery' && isset($block->context['userQuery'])) {
                                        $location = $block->context['userQuery'];
                                    } else if ($value['acfLocation'] === 'taxonomyterm' && isset($value['acfLocationID']) && isset($value['acfLocationID']['value'])) {
                                        $term = get_term($value['acfLocationID']['value']);
                                        $location = $term->taxonomy . '_' . $term->term_id;
                                    } else if (isset($value['acfLocationID'])) {
                                        $location = $value['acfLocationID'];
                                    }
                                }

                                if (isset($value['acfRepeaterField']) && $value['acfRepeaterField'] !== 'cc_overall') {
                                    $field = '';
                                    $repeater_array = [];
                                    if ($block->context && isset($block->context['repeaters']) && $block->context['repeaters']) {
                                        $repeater_array = $block->context['repeaters'];
                                    }
                                    $row = 0;
                                    if ($block->context && isset($block->context['repeater_row']) && $block->context['repeater_row']) {
                                        $row = $block->context['repeater_row'];
                                    }
                                    if ($repeater_array) {
                                        if ($repeater_array[$row][$value['acfRepeaterField']]) {
                                            $field = cc_acf_field_processor($repeater_array[$row][$value['acfRepeaterField']], null, $attributes, $block->parsed_block['blockName']);
                                        }
                                    }
                                    if (strpos($field, $value['data']) === false) {
                                        $finalConditions[] = 'true';
                                    } else {
                                        $finalConditions[] = 'false';
                                    }
                                } else {
                                    $field = get_field($value['acfField'], $location);
                                    if (is_array($field)) {
                                        $field = implode(" ", $field);
                                    } else {
                                        $field = strval($field);
                                    }

                                    if (strpos($field, $value['data']) === false) {
                                        $finalConditions[] = 'true';
                                    } else {
                                        $finalConditions[] = 'false';
                                    }
                                }
                            }
                        } else {
                            if (strpos($condition, $value['data']) === false) {
                                $finalConditions[] = 'true';
                            } else {
                                $finalConditions[] = 'false';
                            }
                        }
                        break;
                    case "before":
                        if ($value['condition'] === 'dayweek') {
                            $date_now = strtotime('today');
                            $date_compared = strtotime('' . $value['data'] . ' this week');
                            if ($date_now < $date_compared) {
                                $finalConditions[] = 'true';
                            } else {
                                $finalConditions[] = 'false';
                            }
                        } else if ($value['condition'] === 'woosalefrom' || $value['condition'] === 'woosaletill') {
                            $date_now = strtotime($value['condition']);
                            $date_compared = strtotime($value['data']);
                            if ($date_now < $date_compared) {
                                $finalConditions[] = 'true';
                            } else {
                                $finalConditions[] = 'false';
                            }
                        } else {
                            if ($condition < $value['data']) {
                                $finalConditions[] = 'true';
                            } else {
                                $finalConditions[] = 'false';
                            }
                        }
                        break;
                    case "after":
                        if ($value['condition'] === 'dayweek') {
                            $date_now = strtotime('today');
                            $date_compared = strtotime('' . $value['data'] . ' this week');
                            if ($date_now > $date_compared) {
                                $finalConditions[] = 'true';
                            } else {
                                $finalConditions[] = 'false';
                            }
                        } else if ($value['condition'] === 'woosalefrom' || $value['condition'] === 'woosaletill') {
                            $date_now = strtotime($value['condition']);
                            $date_compared = strtotime($value['data']);
                            if ($date_now > $date_compared) {
                                $finalConditions[] = 'true';
                            } else {
                                $finalConditions[] = 'false';
                            }
                        } else {
                            if ($condition > $value['data']) {
                                $finalConditions[] = 'true';
                            } else {
                                $finalConditions[] = 'false';
                            }
                        }
                        break;
                    case "<":
                        if ($condition < $value['data']) {
                            $finalConditions[] = 'true';
                        } else {
                            $finalConditions[] = 'false';
                        }
                        break;
                    case ">":
                        if ($condition > $value['data']) {
                            $finalConditions[] = 'true';
                        } else {
                            $finalConditions[] = 'false';
                        }
                        break;
                    case ">=":
                        if ($condition >= $value['data']) {
                            $finalConditions[] = 'true';
                        } else {
                            $finalConditions[] = 'false';
                        }
                        break;
                    case "<=":
                        if ($condition <= $value['data']) {
                            $finalConditions[] = 'true';
                        } else {
                            $finalConditions[] = 'false';
                        }
                        break;
                    case "empty":
                        if ($value['condition'] === 'acf') {
                            if (isset($value['acfGroup']) && isset($value['acfField'])) {
                                $location = false;
                                if (isset($value['acfLocation'])) {
                                    if ($value['acfLocation'] === 'currentpost') {
                                        $location = get_the_ID();
                                    } else if ($value['acfLocation'] === 'postid' && isset($value['acfLocationID'])) {
                                        $location = $value['acfLocationID'];
                                    } else if ($value['acfLocation'] === 'currentuser') {
                                        $location = 'user_' . get_current_user_id() . '';
                                    } else if ($value['acfLocation'] === 'currentauthor') {
                                        $location = 'user_' . get_the_author_meta('ID') . '';
                                    } else if ($value['acfLocation'] === 'option') {
                                        $location = 'option';
                                    } else if ($value['acfLocation'] === 'taxterm' && isset($block->context['taxterms'])) {
                                        $location = $block->context['taxterms'];
                                    } else if ($value['acfLocation'] === 'termquery' && isset($block->context['termQuery'])) {
                                        $location = $block->context['termQuery'];
                                    } else if ($value['acfLocation'] === 'userquery' && isset($block->context['userQuery'])) {
                                        $location = $block->context['userQuery'];
                                    } else if ($value['acfLocation'] === 'taxonomyterm' && isset($value['acfLocationID']) && isset($value['acfLocationID']['value'])) {
                                        $term = get_term($value['acfLocationID']['value']);
                                        $location = $term->taxonomy . '_' . $term->term_id;
                                    } else if (isset($value['acfLocationID'])) {
                                        $location = $value['acfLocationID'];
                                    }
                                }

                                if (isset($value['acfRepeaterField']) && $value['acfRepeaterField'] !== 'cc_overall') {
                                    $field = '';
                                    $repeater_array = [];
                                    if ($block->context && isset($block->context['repeaters']) && $block->context['repeaters']) {
                                        $repeater_array = $block->context['repeaters'];
                                    }
                                    $row = 0;
                                    if ($block->context && isset($block->context['repeater_row']) && $block->context['repeater_row']) {
                                        $row = $block->context['repeater_row'];
                                    }
                                    if ($repeater_array) {
                                        if ($repeater_array[$row][$value['acfRepeaterField']]) {
                                            $field = cc_acf_field_processor($repeater_array[$row][$value['acfRepeaterField']], null, $attributes, $block->parsed_block['blockName']);
                                        }
                                    }

                                    if (empty($field)) {
                                        $finalConditions[] = 'true';
                                    } else {
                                        $finalConditions[] = 'false';
                                    }
                                } else {
                                    $field = get_field($value['acfField'], $location);
                                    if (empty($field)) {
                                        $finalConditions[] = 'true';
                                    } else {
                                        $finalConditions[] = 'false';
                                    }
                                }
                            }
                        }
                        break;
                    case "notempty":
                        if ($value['condition'] === 'acf') {
                            if (isset($value['acfGroup']) && isset($value['acfField'])) {
                                $location = false;
                                if (isset($value['acfLocation'])) {
                                    if ($value['acfLocation'] === 'currentpost') {
                                        $location = get_the_ID();
                                    } else if ($value['acfLocation'] === 'postid' && isset($value['acfLocationID'])) {
                                        $location = $value['acfLocationID'];
                                    } else if ($value['acfLocation'] === 'currentuser') {
                                        $location = 'user_' . get_current_user_id() . '';
                                    } else if ($value['acfLocation'] === 'currentauthor') {
                                        $location = 'user_' . get_the_author_meta('ID') . '';
                                    } else if ($value['acfLocation'] === 'option') {
                                        $location = 'option';
                                    } else if ($value['acfLocation'] === 'taxterm' && isset($block->context['taxterms'])) {
                                        $location = $block->context['taxterms'];
                                    } else if ($value['acfLocation'] === 'termquery' && isset($block->context['termQuery'])) {
                                        $location = $block->context['termQuery'];
                                    } else if ($value['acfLocation'] === 'userquery' && isset($block->context['userQuery'])) {
                                        $location = $block->context['userQuery'];
                                    } else if ($value['acfLocation'] === 'taxonomyterm' && isset($value['acfLocationID']) && isset($value['acfLocationID']['value'])) {
                                        $term = get_term($value['acfLocationID']['value']);
                                        $location = $term->taxonomy . '_' . $term->term_id;
                                    } else if (isset($value['acfLocationID'])) {
                                        $location = $value['acfLocationID'];
                                    }
                                }

                                if (isset($value['acfRepeaterField']) && $value['acfRepeaterField'] !== 'cc_overall') {
                                    $field = '';
                                    $repeater_array = [];
                                    if ($block->context && isset($block->context['repeaters']) && $block->context['repeaters']) {
                                        $repeater_array = $block->context['repeaters'];
                                    }
                                    $row = 0;
                                    if ($block->context && isset($block->context['repeater_row']) && $block->context['repeater_row']) {
                                        $row = $block->context['repeater_row'];
                                    }
                                    if ($repeater_array) {
                                        if ($repeater_array[$row][$value['acfRepeaterField']]) {
                                            $field = cc_acf_field_processor($repeater_array[$row][$value['acfRepeaterField']], null, $attributes, $block->parsed_block['blockName']);
                                        }
                                    }
                                    if (!empty($field)) {
                                        $finalConditions[] = 'true';
                                    } else {
                                        $finalConditions[] = 'false';
                                    }
                                } else {
                                    $field = get_field($value['acfField'], $location);
                                    if (!empty($field)) {
                                        $finalConditions[] = 'true';
                                    } else {
                                        $finalConditions[] = 'false';
                                    }
                                }
                            }
                        }
                        break;
                    case "true":
                        if ($condition === 'cc_pass') {
                            $finalConditions[] = 'true';
                        } else if ($value['condition'] === 'shortcode') {
                            $shortcode = do_shortcode('[' . $value['data'] . ']');
                            if ($shortcode) {
                                $finalConditions[] = 'true';
                            } else {
                                $finalConditions[] = 'false';
                            }
                        } else if ($value['condition'] === 'acf') {
                            if (isset($value['acfGroup']) && isset($value['acfField'])) {
                                $location = false;
                                if (isset($value['acfLocation'])) {
                                    if ($value['acfLocation'] === 'currentpost') {
                                        $location = get_the_ID();
                                    } else if ($value['acfLocation'] === 'postid' && isset($value['acfLocationID'])) {
                                        $location = $value['acfLocationID'];
                                    } else if ($value['acfLocation'] === 'currentuser') {
                                        $location = 'user_' . get_current_user_id() . '';
                                    } else if ($value['acfLocation'] === 'currentauthor') {
                                        $location = 'user_' . get_the_author_meta('ID') . '';
                                    } else if ($value['acfLocation'] === 'option') {
                                        $location = 'option';
                                    } else if ($value['acfLocation'] === 'taxterm' && isset($block->context['taxterms'])) {
                                        $location = $block->context['taxterms'];
                                    } else if ($value['acfLocation'] === 'termquery' && isset($block->context['termQuery'])) {
                                        $location = $block->context['termQuery'];
                                    } else if ($value['acfLocation'] === 'userquery' && isset($block->context['userQuery'])) {
                                        $location = $block->context['userQuery'];
                                    } else if ($value['acfLocation'] === 'taxonomyterm' && isset($value['acfLocationID']) && isset($value['acfLocationID']['value'])) {
                                        $term = get_term($value['acfLocationID']['value']);
                                        $location = $term->taxonomy . '_' . $term->term_id;
                                    } else if (isset($value['acfLocationID'])) {
                                        $location = $value['acfLocationID'];
                                    }
                                }

                                if (isset($value['acfRepeaterField']) && $value['acfRepeaterField'] !== 'cc_overall') {
                                    $field = '';
                                    $repeater_array = [];
                                    if ($block->context && isset($block->context['repeaters']) && $block->context['repeaters']) {
                                        $repeater_array = $block->context['repeaters'];
                                    }
                                    $row = 0;
                                    if ($block->context && isset($block->context['repeater_row']) && $block->context['repeater_row']) {
                                        $row = $block->context['repeater_row'];
                                    }
                                    if ($repeater_array) {
                                        if ($repeater_array[$row][$value['acfRepeaterField']]) {
                                            $field = cc_acf_field_processor($repeater_array[$row][$value['acfRepeaterField']], null, $attributes, $block->parsed_block['blockName']);
                                        }
                                    }
                                    if (boolval($field) === true) {
                                        $finalConditions[] = 'true';
                                    } else {
                                        $finalConditions[] = 'false';
                                    }
                                } else {
                                    $field = get_field($value['acfField'], $location);
                                    if (is_array($field)) {
                                        if (isset($field[0])) {
                                            $field = $field[0];
                                        }
                                    } else {
                                        $field = strval($field);
                                    }
                                    if (boolval($field) === true) {
                                        $finalConditions[] = 'true';
                                    } else {
                                        $finalConditions[] = 'false';
                                    }
                                }
                            }
                        } else if ($condition === true) {
                            $finalConditions[] = 'true';
                        } else {
                            $finalConditions[] = 'false';
                        }
                        break;
                    case "false":
                        if ($condition === 'cc_pass') {
                            $finalConditions[] = 'true';
                        } else if ($value['condition'] === 'shortcode') {
                            $shortcode = do_shortcode('[' . $value['data'] . ']');
                            if (!$shortcode) {
                                $finalConditions[] = 'true';
                            } else {
                                $finalConditions[] = 'false';
                            }
                        } else if ($value['condition'] === 'acf') {
                            $location = false;
                            if (isset($value['acfLocation'])) {
                                if ($value['acfLocation'] === 'currentpost') {
                                    $location = get_the_ID();
                                } else if ($value['acfLocation'] === 'postid' && isset($value['acfLocationID'])) {
                                    $location = $value['acfLocationID'];
                                } else if ($value['acfLocation'] === 'currentuser') {
                                    $location = 'user_' . get_current_user_id() . '';
                                } else if ($value['acfLocation'] === 'currentauthor') {
                                    $location = 'user_' . get_the_author_meta('ID') . '';
                                } else if ($value['acfLocation'] === 'option') {
                                    $location = 'option';
                                } else if ($value['acfLocation'] === 'taxterm' && isset($block->context['taxterms'])) {
                                    $location = $block->context['taxterms'];
                                } else if ($value['acfLocation'] === 'termquery' && isset($block->context['termQuery'])) {
                                    $location = $block->context['termQuery'];
                                } else if ($value['acfLocation'] === 'userquery' && isset($block->context['userQuery'])) {
                                    $location = $block->context['userQuery'];
                                } else if ($value['acfLocation'] === 'taxonomyterm' && isset($value['acfLocationID']) && isset($value['acfLocationID']['value'])) {
                                    $term = get_term($value['acfLocationID']['value']);
                                    $location = $term->taxonomy . '_' . $term->term_id;
                                } else if (isset($value['acfLocationID'])) {
                                    $location = $value['acfLocationID'];
                                }
                            }

                            if (isset($value['acfGroup']) && isset($value['acfField'])) {
                                if (isset($value['acfRepeaterField']) && $value['acfRepeaterField'] !== 'cc_overall') {
                                    $field = '';
                                    $repeater_array = [];
                                    if ($block->context && isset($block->context['repeaters']) && $block->context['repeaters']) {
                                        $repeater_array = $block->context['repeaters'];
                                    }
                                    $row = 0;
                                    if ($block->context && isset($block->context['repeater_row']) && $block->context['repeater_row']) {
                                        $row = $block->context['repeater_row'];
                                    }
                                    if ($repeater_array) {
                                        if ($repeater_array[$row][$value['acfRepeaterField']]) {
                                            $field = cc_acf_field_processor($repeater_array[$row][$value['acfRepeaterField']], null, $attributes, $block->parsed_block['blockName']);
                                        }
                                    }
                                    if (boolval($field) === false) {
                                        $finalConditions[] = 'true';
                                    } else {
                                        $finalConditions[] = 'false';
                                    }
                                } else {
                                    $field = get_field($value['acfField'], $location);
                                    if (is_array($field)) {
                                        if (isset($field[0])) {
                                            $field = $field[0];
                                        }
                                    } else {
                                        $field = strval($field);
                                    }
                                    if (boolval($field) === false) {
                                        $finalConditions[] = 'true';
                                    } else {
                                        $finalConditions[] = 'false';
                                    }
                                }
                            }
                        } else if ($condition === false) {
                            $finalConditions[] = 'true';
                        } else {
                            $finalConditions[] = 'false';
                        }
                        break;
                }
            }
        }
    }

    if (CC_WOOCOMMERCE) {
        $product = $old_product;
    }

    $post = $oldpost;

    // wp_reset_postdata();

    switch ($conditionType) {
        case "&&":
            if ($finalConditions && in_array('false', $finalConditions, true)) {
                return false;
            } else {
                return true;
            }
            break;
        case "||":
            if ($finalConditions && in_array('true', $finalConditions, true)) {
                return true;
            } else {
                return false;
            }
            break;
    }
}
