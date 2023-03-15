<?php

/**
 * Theme Maker
 *
 *
 * @since     1.0.8.3
 * @package Cwicly
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

function cc_themer_maker($block_templates, $query, $template_type)
{
    if (!Cwicly\Helpers::is_rest() && !is_admin() && $template_type === 'wp_template') {
        global $post;
        $conditions = get_option('cwicly_conditions');
        if ($conditions && is_string($conditions)) {
            $conditions = json_decode($conditions);
        }
        $name = [];
        $slug = [];
        $customTemplate = [];

        $finalTemplates = [];
        $templateList = [];

        $templater = [];

        $priorities = [];

        $statusCodes = [];

        $overridePageTemplate = [];

        if (isset($conditions) && isset($conditions->include) && $conditions->include) {
            foreach ($conditions->include as $template => $value) {
                $send = [];
                if ($value->all === 'true') {
                    $send[] = 'true';
                }
                if (sizeof($value->singular) > 0) {
                    foreach ($value->singular as $condition) {
                        $uniqueSend = false;
                        if (isset($condition->target) && $condition->target) {
                            if ($condition->target === 'all') {
                                if (is_404()) {
                                    $uniqueSend = 'true';
                                }
                                if (is_front_page()) {
                                    $uniqueSend = 'true';
                                }
                                if (is_singular()) {
                                    $uniqueSend = 'true';
                                }
                            } else {
                                if ($condition->target === '404') {
                                    if (is_404()) {
                                        $uniqueSend = 'true';
                                    } else {
                                        $uniqueSend = 'false';
                                    }
                                } else if ($condition->target === 'frontPage') {
                                    if (is_front_page()) {
                                        $uniqueSend = 'true';
                                    } else {
                                        $uniqueSend = 'false';
                                    }
                                } else if (is_singular()) {
                                    if ($condition->target && is_singular($condition->target)) {
                                        if (!isset($condition->data) || ($condition->data && $condition->data === 'all')) {
                                            $uniqueSend = 'true';
                                        } else {
                                            $uniqueSend = 'false';
                                        }
                                        if (isset($condition->data) && $condition->data && $condition->data != 'all') {
                                            if (!isset($condition->data) || ($condition->data && $condition->data === 'directchildof')) {
                                                $parent_id = get_the_ID();
                                                $parent_page = wp_get_post_parent_id($parent_id);
                                                if (isset($condition->extra) && $parent_page == $condition->extra) {
                                                    $uniqueSend = 'true';
                                                } else {
                                                    $uniqueSend = 'false';
                                                }
                                            } else if (!isset($condition->extra) || ($condition->extra && $condition->extra === 'all')) {
                                                if (!is_array($condition->data) && has_term('', $condition->data)) {
                                                    $uniqueSend = 'true';
                                                } else if (is_array($condition->data)) {
                                                    foreach ($condition->data as $data) {
                                                        if ($post->ID === $data) {
                                                            $uniqueSend = 'true';
                                                        }
                                                    }
                                                } else {
                                                    $uniqueSend = 'false';
                                                }
                                            } else if (isset($condition->extra) && $condition->extra && $condition->extra != 'all') {
                                                if (has_term($condition->extra, $condition->data)) {
                                                    $uniqueSend = 'true';
                                                } else {
                                                    $uniqueSend = 'false';
                                                }
                                                if (isset($condition->extraData) && $condition->extraData && $condition->extraData != 'all') {
                                                    if ($condition->extraData === get_the_ID()) {
                                                        $uniqueSend = 'true';
                                                    } else {
                                                        $uniqueSend = 'false';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $send[] = $uniqueSend;
                    }
                }
                if (sizeof($value->archive) > 0) {
                    foreach ($value->archive as $condition) {
                        $uniqueSend = false;

                        if (isset($condition->target) && $condition->target === 'search' && is_search()) {
                            $uniqueSend = 'true';
                        }
                        if (is_archive()) {
                            if (isset($condition->target) && $condition->target) {
                                $postType = '';
                                if (isset(get_queried_object()->taxonomy)) {
                                    $postType = get_taxonomy(get_queried_object()->taxonomy)->object_type[0];
                                } else if (is_post_type_archive($condition->target)) {
                                    $postType = $condition->target;
                                }
                                if ($condition->target === 'all') {
                                    $uniqueSend = 'true';
                                } else if ((!isset($condition->data) || ($condition->data && $condition->data === 'all')) && $postType === $condition->target) {
                                    $uniqueSend = 'true';
                                } else if ($postType === $condition->target && isset($condition->data) && $condition->data === get_queried_object()->taxonomy && (!isset($condition->extra) || ($condition->extra && $condition->extra === 'all'))) {
                                    $uniqueSend = 'true';
                                } else if ($postType === $condition->target && isset($condition->data) && $condition->data === get_queried_object()->taxonomy && isset($condition->extra) && $condition->extra === get_queried_object()->term_id) {
                                    $uniqueSend = 'true';
                                }
                            }
                        }
                        $send[] = $uniqueSend;
                    }
                }
                if (sizeof($value->author) > 0) {
                    foreach ($value->author as $condition) {
                        $uniqueSend = false;
                        if (is_author()) {
                            if ($condition === true) {
                                $uniqueSend = 'true';
                            } else if (isset($condition->target) && $condition->target && is_author($condition->target)) {
                                $uniqueSend = 'true';
                            }
                        }
                        $send[] = $uniqueSend;
                    }
                }
                if (sizeof($value->custom) > 0) {
                    $current_user = wp_get_current_user();
                    foreach ($value->custom as $condition) {
                        $uniqueSend = false;
                        $conditioner = '';
                        if ($condition->target === 'date') {
                            $conditioner = date("m/d/Y");
                        }
                        if ($condition->target === 'dayweek') {
                            $conditioner = date("l");
                        }
                        if ($condition->target === 'daymonth') {
                            $conditioner = date("d");
                        }
                        if ($condition->target === 'time') {
                            $conditioner = date("H:i:s");
                        }
                        if ($condition->target === 'username') {
                            $conditioner = $current_user->user_login;
                        }
                        if ($condition->target === 'userid') {
                            $conditioner = strval($current_user->ID);
                        }
                        if ($condition->target === 'usercapabilities') {
                            if (current_user_can($condition->extraData)) {
                                $conditioner = 'true';
                            }
                        }
                        if ($condition->target === 'urlparameter') {
                            if (isset($condition->key) && $condition->key) {
                                if (isset($_GET[$condition->key]) && $_GET[$condition->key]) {
                                    $key = htmlspecialchars($_GET[$condition->key], ENT_QUOTES, 'UTF-8');
                                    if ($condition->extra === 'true' || $condition->extra === 'false') {
                                        $conditioner = filter_var($key, FILTER_VALIDATE_BOOLEAN);
                                    } else {
                                        $conditioner = $key;
                                    }
                                }
                            }
                        }
                        switch ($condition->extra) {
                            case "===":
                                if ($condition->target === 'cookie') {
                                    $loop = true;
                                    foreach ($_COOKIE as $key => $val) {
                                        if ($key === $condition->extraData) {
                                            $uniqueSend = 'true';
                                            $loop = false;
                                            break;
                                        }
                                    }
                                    if ($loop) {
                                        $uniqueSend = 'false';
                                    }
                                } else if ($condition->target === 'dayweek') {
                                    $date_now = strtotime('today');
                                    $date_compared = strtotime('' . $condition->extraData . ' this week');
                                    if ($date_now === $date_compared) {
                                        $uniqueSend = 'true';
                                    }
                                } else if ($condition->target === 'userrole') {
                                    if (in_array($condition->extraData, $current_user->roles, true)) {
                                        $uniqueSend = 'true';
                                    }
                                } else if ($condition->target === 'usercapabilities') {
                                    if (current_user_can($condition->extraData)) {
                                        $uniqueSend = 'true';
                                    }
                                } else if ($condition->target === 'acf') {
                                    if (isset($condition->group) && isset($condition->field)) {
                                        $location = false;
                                        if (isset($condition->acfLocation)) {
                                            if ($condition->acfLocation === 'currentpost') {
                                                $location = get_the_ID();
                                            } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            } else if ($condition->acfLocation === 'currentuser') {
                                                $location = 'user_' . get_current_user_id() . '';
                                            } else if ($condition->acfLocation === 'currentauthor') {
                                                $location = 'user_' . get_the_author_meta('ID') . '';
                                            } else if ($condition->acfLocation === 'option') {
                                                $location = 'option';
                                            } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                                $term = get_term($condition->acfLocationID->value);
                                                $location = $term->taxonomy . '_' . $term->term_id;
                                            } else if (isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            }
                                        }

                                        $field = get_field($condition->field, $location);
                                        if (is_array($field)) {
                                            $field = implode(" ", $field);
                                        } else {
                                            $field = strval($field);
                                        }

                                        if ($field === $condition->extraData) {
                                            $uniqueSend = 'true';
                                        }
                                    }
                                } else {
                                    if ($conditioner === $condition->extraData) {
                                        $uniqueSend = 'true';
                                    }
                                }
                                break;
                            case "!=":
                                if ($condition->target === 'cookie') {
                                    $loop = true;
                                    foreach ($_COOKIE as $key => $val) {
                                        if ($key === $condition->extraData) {
                                            $uniqueSend = 'false';
                                            $loop = false;
                                            break;
                                        }
                                    }
                                    if ($loop) {
                                        $uniqueSend = 'true';
                                    }
                                } else if ($condition->target === 'dayweek') {
                                    $date_now = strtotime('today');
                                    $date_compared = strtotime('' . $condition->extraData . ' this week');
                                    if ($date_now != $date_compared) {
                                        $uniqueSend = 'true';
                                    }
                                } else if ($condition->target === 'userrole') {
                                    if (!in_array($condition->extraData, $current_user->roles, true)) {
                                        $uniqueSend = 'true';
                                    }
                                } else if ($condition->target === 'usercapabilities') {
                                    if (!current_user_can($condition->extraData)) {
                                        $uniqueSend = 'true';
                                    }
                                } else if ($condition->target === 'acf') {
                                    if (isset($condition->group) && isset($condition->field)) {
                                        $location = false;
                                        if (isset($condition->acfLocation)) {
                                            if ($condition->acfLocation === 'currentpost') {
                                                $location = get_the_ID();
                                            } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            } else if ($condition->acfLocation === 'currentuser') {
                                                $location = 'user_' . get_current_user_id() . '';
                                            } else if ($condition->acfLocation === 'currentauthor') {
                                                $location = 'user_' . get_the_author_meta('ID') . '';
                                            } else if ($condition->acfLocation === 'option') {
                                                $location = 'option';
                                            } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                                $term = get_term($condition->acfLocationID->value);
                                                $location = $term->taxonomy . '_' . $term->term_id;
                                            } else if (isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            }
                                        }

                                        $field = get_field($condition->field, $location);
                                        if (is_array($field)) {
                                            $field = implode(" ", $field);
                                        } else {
                                            $field = strval($field);
                                        }

                                        if ($field != $condition->extraData) {
                                            $uniqueSend = 'true';
                                        }
                                    }
                                } else {
                                    if ($conditioner != $condition->extraData) {
                                        $uniqueSend = 'true';
                                    }
                                }
                                break;
                            case "contains":
                                if ($condition->target === 'cookie') {
                                    $loop = true;
                                    foreach ($_COOKIE as $key => $val) {
                                        if (strpos($key, $condition->extraData) !== false) {
                                            $uniqueSend = 'true';
                                            $loop = false;
                                            break;
                                        }
                                    }
                                    if ($loop) {
                                        $uniqueSend = 'false';
                                    }
                                } else if ($condition->target === 'acf') {
                                    if (isset($condition->group) && isset($condition->field)) {
                                        $location = false;
                                        if (isset($condition->acfLocation)) {
                                            if ($condition->acfLocation === 'currentpost') {
                                                $location = get_the_ID();
                                            } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            } else if ($condition->acfLocation === 'currentuser') {
                                                $location = 'user_' . get_current_user_id() . '';
                                            } else if ($condition->acfLocation === 'currentauthor') {
                                                $location = 'user_' . get_the_author_meta('ID') . '';
                                            } else if ($condition->acfLocation === 'option') {
                                                $location = 'option';
                                            } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                                $term = get_term($condition->acfLocationID->value);
                                                $location = $term->taxonomy . '_' . $term->term_id;
                                            } else if (isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            }
                                        }

                                        $field = get_field($condition->field, $location);
                                        if (is_array($field)) {
                                            $field = implode(" ", $field);
                                        } else {
                                            $field = strval($field);
                                        }

                                        if (strpos($field, $condition->extraData) !== false) {
                                            $uniqueSend = 'true';
                                        }
                                    }
                                } else {
                                    if (strpos($conditioner, $condition->extraData) !== false) {
                                        $uniqueSend = 'true';
                                    }
                                }
                                break;
                            case "notcontain":
                                if ($condition->target === 'cookie') {
                                    $loop = true;
                                    foreach ($_COOKIE as $key => $val) {
                                        if (strpos($key, $condition->extraData) === false) {
                                            $uniqueSend = 'true';
                                            $loop = false;
                                            break;
                                        }
                                    }
                                    if ($loop) {
                                        $uniqueSend = 'false';
                                    }
                                } else if ($condition->target === 'acf') {
                                    if (isset($condition->group) && isset($condition->field)) {
                                        $location = false;
                                        if (isset($condition->acfLocation)) {
                                            if ($condition->acfLocation === 'currentpost') {
                                                $location = get_the_ID();
                                            } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            } else if ($condition->acfLocation === 'currentuser') {
                                                $location = 'user_' . get_current_user_id() . '';
                                            } else if ($condition->acfLocation === 'currentauthor') {
                                                $location = 'user_' . get_the_author_meta('ID') . '';
                                            } else if ($condition->acfLocation === 'option') {
                                                $location = 'option';
                                            } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                                $term = get_term($condition->acfLocationID->value);
                                                $location = $term->taxonomy . '_' . $term->term_id;
                                            } else if (isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            }
                                        }

                                        $field = get_field($condition->field, $location);
                                        if (is_array($field)) {
                                            $field = implode(" ", $field);
                                        } else {
                                            $field = strval($field);
                                        }

                                        if (strpos($field, $condition->extraData) === false) {
                                            $uniqueSend = 'true';
                                        }
                                    }
                                } else {
                                    if (strpos($conditioner, $condition->extraData) === false) {
                                        $uniqueSend = 'true';
                                    }
                                }
                                break;
                            case "before":
                                if ($condition->target === 'dayweek') {
                                    $date_now = strtotime('today');
                                    $date_compared = strtotime('' . $condition->extraData . ' this week');
                                    if ($date_now < $date_compared) {
                                        $uniqueSend = 'true';
                                    }
                                } else {
                                    if ($conditioner < $condition->extraData) {
                                        $uniqueSend = 'true';
                                    }
                                }
                                break;
                            case "after":
                                if ($condition->target === 'dayweek') {
                                    $date_now = strtotime('today');
                                    $date_compared = strtotime('' . $condition->extraData . ' this week');
                                    if ($date_now > $date_compared) {
                                        $uniqueSend = 'true';
                                    }
                                } else {
                                    if ($conditioner > $condition->extraData) {
                                        $uniqueSend = 'true';
                                    }
                                }
                                break;
                            case "<":
                                if ($conditioner < $condition->extraData) {
                                    $uniqueSend = 'true';
                                }
                                break;
                            case ">":
                                if ($conditioner > $condition->extraData) {
                                    $uniqueSend = 'true';
                                }
                                break;
                            case ">=":
                                if ($conditioner >= $condition->extraData) {
                                    $uniqueSend = 'true';
                                }
                                break;
                            case "<=":
                                if ($conditioner <= $condition->extraData) {
                                    $uniqueSend = 'true';
                                }
                                break;
                            case "empty":
                                if ($condition->target === 'acf') {
                                    if (isset($condition->group) && isset($condition->field)) {
                                        $location = false;
                                        if (isset($condition->acfLocation)) {
                                            if ($condition->acfLocation === 'currentpost') {
                                                $location = get_the_ID();
                                            } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            } else if ($condition->acfLocation === 'currentuser') {
                                                $location = 'user_' . get_current_user_id() . '';
                                            } else if ($condition->acfLocation === 'currentauthor') {
                                                $location = 'user_' . get_the_author_meta('ID') . '';
                                            } else if ($condition->acfLocation === 'option') {
                                                $location = 'option';
                                            } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                                $term = get_term($condition->acfLocationID->value);
                                                $location = $term->taxonomy . '_' . $term->term_id;
                                            } else if (isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            }
                                        }

                                        $field = get_field($condition->field, $location);
                                        if (is_array($field)) {
                                            $field = implode(" ", $field);
                                        } else {
                                            $field = strval($field);
                                        }

                                        if (empty($field)) {
                                            $uniqueSend = 'true';
                                        }
                                    }
                                }
                                break;
                            case "notempty":
                                if ($condition->target === 'acf') {
                                    if (isset($condition->group) && isset($condition->field)) {
                                        $location = false;
                                        if (isset($condition->acfLocation)) {
                                            if ($condition->acfLocation === 'currentpost') {
                                                $location = get_the_ID();
                                            } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            } else if ($condition->acfLocation === 'currentuser') {
                                                $location = 'user_' . get_current_user_id() . '';
                                            } else if ($condition->acfLocation === 'currentauthor') {
                                                $location = 'user_' . get_the_author_meta('ID') . '';
                                            } else if ($condition->acfLocation === 'option') {
                                                $location = 'option';
                                            } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                                $term = get_term($condition->acfLocationID->value);
                                                $location = $term->taxonomy . '_' . $term->term_id;
                                            } else if (isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            }
                                        }

                                        $field = get_field($condition->field, $location);
                                        if (is_array($field)) {
                                            $field = implode(" ", $field);
                                        } else {
                                            $field = strval($field);
                                        }

                                        if (!empty($field)) {
                                            $uniqueSend = 'true';
                                        }
                                    }
                                }
                                break;
                            case "true":
                                if ($condition->target === 'shortcode') {
                                    if (do_shortcode('[' . $condition->extraData . ']') === 'true') {
                                        $uniqueSend = 'true';
                                    }
                                }
                                if ($condition->target === 'loggedin') {
                                    if (is_user_logged_in()) {
                                        $uniqueSend = 'true';
                                    }
                                }
                                if ($condition->target === 'acf') {
                                    if (isset($condition->group) && isset($condition->field)) {
                                        $location = false;
                                        if (isset($condition->acfLocation)) {
                                            if ($condition->acfLocation === 'currentpost') {
                                                $location = get_the_ID();
                                            } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            } else if ($condition->acfLocation === 'currentuser') {
                                                $location = 'user_' . get_current_user_id() . '';
                                            } else if ($condition->acfLocation === 'currentauthor') {
                                                $location = 'user_' . get_the_author_meta('ID') . '';
                                            } else if ($condition->acfLocation === 'option') {
                                                $location = 'option';
                                            } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                                $term = get_term($condition->acfLocationID->value);
                                                $location = $term->taxonomy . '_' . $term->term_id;
                                            } else if (isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            }
                                        }

                                        $field = get_field($condition->field, $location);
                                        if (is_array($field)) {
                                            $field = implode(" ", $field);
                                        } else {
                                            $field = strval($field);
                                        }

                                        // if (boolval($field) === true) {
                                        if (filter_var($field, FILTER_VALIDATE_BOOLEAN) === true) {
                                            $uniqueSend = 'true';
                                        }
                                    }
                                }
                                break;
                            case "false":
                                if ($condition->target === 'shortcode') {
                                    if (do_shortcode('[' . $condition->extraData . ']') === 'false') {
                                        $uniqueSend = 'true';
                                    }
                                }
                                if ($condition->target === 'loggedin') {
                                    if (!is_user_logged_in()) {
                                        $uniqueSend = 'true';
                                    }
                                }
                                if ($condition->target === 'acf') {
                                    if (isset($condition->group) && isset($condition->field)) {
                                        $location = false;
                                        if (isset($condition->acfLocation)) {
                                            if ($condition->acfLocation === 'currentpost') {
                                                $location = get_the_ID();
                                            } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            } else if ($condition->acfLocation === 'currentuser') {
                                                $location = 'user_' . get_current_user_id() . '';
                                            } else if ($condition->acfLocation === 'currentauthor') {
                                                $location = 'user_' . get_the_author_meta('ID') . '';
                                            } else if ($condition->acfLocation === 'option') {
                                                $location = 'option';
                                            } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                                $term = get_term($condition->acfLocationID->value);
                                                $location = $term->taxonomy . '_' . $term->term_id;
                                            } else if (isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            }
                                        }

                                        $field = get_field($condition->field, $location);
                                        if (is_array($field)) {
                                            $field = implode(" ", $field);
                                        } else {
                                            $field = strval($field);
                                        }

                                        // if (boolval($field) === false) {
                                        if (filter_var($field, FILTER_VALIDATE_BOOLEAN) === false) {
                                            $uniqueSend = 'true';
                                        }
                                    }
                                }
                                break;
                        }
                        $send[] = $uniqueSend;
                    }
                }
                if (isset($value->priority) && $value->priority) {
                    $priorities[$template] = $value->priority;
                } else {
                    $priorities[$template] = 0;
                }
                if (isset($value->overridePageTemplate) && $value->overridePageTemplate) {
                    $overridePageTemplate[$template] = true;
                }
                if (isset($value->statusCode) && $value->statusCode) {
                    $statusCodes[$template] = $value->statusCode;
                }
                if ($value->includeCondition && $value->includeCondition === 'and' && array_unique($send) == array('true')) {
                    $customTemplate[$template] = [get_block_template(get_stylesheet() . '//' . $template . '', 'wp_template')];
                    $templater[] = $template;

                    $args = array(
                        'name' => $template,
                        'post_type' => 'wp_template',
                        'post_status' => 'publish',
                        'numberposts' => 1,
                    );
                    $my_posts = get_posts($args);
                    if ($my_posts):
                        $id = $my_posts[0]->ID;
                        $name[$template] = get_the_title($id);
                        $slug[$template] = $template;
                    endif;
                    // break;
                } else if ($value->includeCondition && $value->includeCondition === 'or' && in_array("true", $send)) {
                    $customTemplate[$template] = [get_block_template(get_stylesheet() . '//' . $template . '', 'wp_template')];
                    $templater[] = $template;

                    $args = array(
                        'name' => $template,
                        'post_type' => 'wp_template',
                        'post_status' => 'publish',
                        'numberposts' => 1,
                    );
                    $my_posts = get_posts($args);
                    if ($my_posts):
                        $id = $my_posts[0]->ID;
                        $name[$template] = get_the_title($id);
                        $slug[$template] = $template;
                    endif;
                    // break;
                }
                // }
            }
        }
        // $exclude = [];
        // $noExclude = [];
        foreach ($templater as $templaterer) {
            if ($templaterer && $conditions->exclude->$templaterer) {
                $exclude = [];
                $noExclude = [];
                $value = $conditions->exclude->$templaterer;
                if ($value->all === 'true') {
                    $exclude[] = 'true';
                    $noExclude[] = 'false';
                } else {
                    $noExclude[] = 'true';
                }
                if (sizeof($value->singular) > 0) {
                    foreach ($value->singular as $condition) {
                        $uniqueSend = 'false';
                        if (isset($condition->target) && $condition->target) {
                            if ($condition->target === 'all') {
                                if (is_404()) {
                                    $uniqueSend = 'true';
                                }
                                if (is_front_page()) {
                                    $uniqueSend = 'true';
                                }
                                if (is_singular()) {
                                    $uniqueSend = 'true';
                                }
                            } else {
                                if ($condition->target === '404') {
                                    if (is_404()) {
                                        $uniqueSend = 'true';
                                    } else {
                                        $uniqueSend = 'false';
                                    }
                                } else if ($condition->target === 'frontPage') {
                                    if (is_front_page()) {
                                        $uniqueSend = 'true';
                                    } else {
                                        $uniqueSend = 'false';
                                    }
                                } else if (is_singular()) {
                                    if ($condition->target && is_singular($condition->target)) {
                                        if (!isset($condition->data) || ($condition->data && $condition->data === 'all')) {
                                            $uniqueSend = 'true';
                                        } else {
                                            $uniqueSend = 'false';
                                        }
                                        if (isset($condition->data) && $condition->data && $condition->data != 'all') {
                                            if (!isset($condition->data) || ($condition->data && $condition->data === 'directchildof')) {
                                                $parent_id = get_the_ID();
                                                $parent_page = wp_get_post_parent_id($parent_id);
                                                if (isset($condition->extra) && $parent_page == $condition->extra) {
                                                    $uniqueSend = 'true';
                                                } else {
                                                    $uniqueSend = 'false';
                                                }
                                            } else if (!isset($condition->extra) || ($condition->extra && $condition->extra === 'all')) {
                                                if (!is_array($condition->data) && has_term('', $condition->data)) {
                                                    $uniqueSend = 'true';
                                                } else if (is_array($condition->data)) {
                                                    foreach ($condition->data as $data) {
                                                        if ($post->ID === $data) {
                                                            $uniqueSend = 'true';
                                                        }
                                                    }
                                                } else {
                                                    $uniqueSend = 'false';
                                                }
                                            } else if (isset($condition->extra) && $condition->extra && $condition->extra != 'all') {
                                                if (has_term($condition->extra, $condition->data)) {
                                                    $uniqueSend = 'true';
                                                } else {
                                                    $uniqueSend = 'false';
                                                }
                                                if (isset($condition->extraData) && $condition->extraData && $condition->extraData != 'all') {
                                                    if ($condition->extraData === get_the_ID()) {
                                                        $uniqueSend = 'true';
                                                    } else {
                                                        $uniqueSend = 'false';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $exclude[] = $uniqueSend;
                    }
                    $noExclude[] = 'false';
                } else {
                    $noExclude[] = 'true';
                }
                if (sizeof($value->archive) > 0) {
                    foreach ($value->archive as $condition) {
                        $uniqueSend = 'false';

                        if ($condition->target === 'search' && is_search()) {
                            $uniqueSend = 'true';
                        }
                        if (is_archive()) {
                            if (isset($condition->target) && $condition->target) {
                                $postType = '';
                                if (isset(get_queried_object()->taxonomy)) {
                                    $postType = get_taxonomy(get_queried_object()->taxonomy)->object_type[0];
                                } else if (is_post_type_archive($condition->target)) {
                                    $postType = $condition->target;
                                }
                                if ($condition->target === 'all') {
                                    $uniqueSend = 'true';
                                } else if ((!isset($condition->data) || ($condition->data && $condition->data === 'all')) && $postType === $condition->target) {
                                    $uniqueSend = 'true';
                                } else if ($postType === $condition->target && isset($condition->data) && $condition->data === get_queried_object()->taxonomy && (!isset($condition->extra) || ($condition->extra && $condition->extra === 'all'))) {
                                    $uniqueSend = 'true';
                                } else if ($postType === $condition->target && isset($condition->data) && $condition->data === get_queried_object()->taxonomy && isset($condition->extra) && $condition->extra === get_queried_object()->term_id) {
                                    $uniqueSend = 'true';
                                }
                            }
                        }
                        $exclude[] = $uniqueSend;
                    }
                    $noExclude[] = 'false';
                } else {
                    $noExclude[] = 'true';
                }
                if (sizeof($value->author) > 0) {
                    foreach ($value->author as $condition) {
                        $uniqueSend = 'false';
                        if (is_author()) {
                            if ($condition === true) {
                                $uniqueSend = 'true';
                            } else if (isset($condition->target) && $condition->target && is_author($condition->target)) {
                                $uniqueSend = 'true';
                            }
                        }
                        $exclude[] = $uniqueSend;
                    }
                    $noExclude[] = 'false';
                } else {
                    $noExclude[] = 'true';
                }
                if (sizeof($value->custom) > 0) {
                    $current_user = wp_get_current_user();
                    foreach ($value->custom as $condition) {
                        $uniqueSend = 'false';
                        $conditioner = '';
                        if ($condition->target === 'date') {
                            $conditioner = date("m/d/Y");
                        }
                        if ($condition->target === 'dayweek') {
                            $conditioner = date("l");
                        }
                        if ($condition->target === 'daymonth') {
                            $conditioner = date("d");
                        }
                        if ($condition->target === 'time') {
                            $conditioner = date("H:i:s");
                        }
                        if ($condition->target === 'username') {
                            $conditioner = $current_user->user_login;
                        }
                        if ($condition->target === 'userid') {
                            $conditioner = strval($current_user->ID);
                        }
                        if ($condition->target === 'usercapabilities') {
                            if (current_user_can($condition->extraData)) {
                                $conditioner = 'true';
                            }
                        }
                        if ($condition->target === 'urlparameter') {
                            if (isset($condition->key) && $condition->key) {
                                if (isset($_GET[$condition->key]) && $_GET[$condition->key]) {
                                    $key = htmlspecialchars($_GET[$condition->key], ENT_QUOTES, 'UTF-8');
                                    if ($condition->extra === 'true' || $condition->extra === 'false') {
                                        $conditioner = filter_var($key, FILTER_VALIDATE_BOOLEAN);
                                    } else {
                                        $conditioner = $key;
                                    }
                                }
                            }
                        }
                        switch ($condition->extra) {
                            case "===":
                                if ($condition->target === 'cookie') {
                                    $loop = true;
                                    foreach ($_COOKIE as $key => $val) {
                                        if ($key === $condition->extraData) {
                                            $uniqueSend = 'true';
                                            $loop = false;
                                            break;
                                        }
                                    }
                                    if ($loop) {
                                        $uniqueSend = 'false';
                                    }
                                } else if ($condition->target === 'dayweek') {
                                    $date_now = strtotime('today');
                                    $date_compared = strtotime('' . $condition->extraData . ' this week');
                                    if ($date_now === $date_compared) {
                                        $uniqueSend = 'true';
                                    }
                                } else if ($condition->target === 'userrole') {
                                    if (in_array($condition->extraData, $current_user->roles, true)) {
                                        $uniqueSend = 'true';
                                    }
                                } else if ($condition->target === 'usercapabilities') {
                                    if (current_user_can($condition->extraData)) {
                                        $uniqueSend = 'true';
                                    }
                                } else if ($condition->target === 'acf') {
                                    if (isset($condition->group) && isset($condition->field)) {
                                        $location = false;
                                        if (isset($condition->acfLocation)) {
                                            if ($condition->acfLocation === 'currentpost') {
                                                $location = get_the_ID();
                                            } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            } else if ($condition->acfLocation === 'currentuser') {
                                                $location = 'user_' . get_current_user_id() . '';
                                            } else if ($condition->acfLocation === 'currentauthor') {
                                                $location = 'user_' . get_the_author_meta('ID') . '';
                                            } else if ($condition->acfLocation === 'option') {
                                                $location = 'option';
                                            } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                                $term = get_term($condition->acfLocationID->value);
                                                $location = $term->taxonomy . '_' . $term->term_id;
                                            } else if (isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            }
                                        }

                                        $field = get_field($condition->field, $location);
                                        if (is_array($field)) {
                                            $field = implode(" ", $field);
                                        } else {
                                            $field = strval($field);
                                        }

                                        if ($field === $condition->extraData) {
                                            $uniqueSend = 'true';
                                        }
                                    }
                                } else {
                                    if ($conditioner === $condition->extraData) {
                                        $uniqueSend = 'true';
                                    }
                                }
                                break;
                            case "!=":
                                if ($condition->target === 'cookie') {
                                    $loop = true;
                                    foreach ($_COOKIE as $key => $val) {
                                        if ($key === $condition->extraData) {
                                            $uniqueSend = 'false';
                                            $loop = false;
                                            break;
                                        }
                                    }
                                    if ($loop) {
                                        $uniqueSend = 'true';
                                    }
                                } else if ($condition->target === 'dayweek') {
                                    $date_now = strtotime('today');
                                    $date_compared = strtotime('' . $condition->extraData . ' this week');
                                    if ($date_now != $date_compared) {
                                        $uniqueSend = 'true';
                                    }
                                } else if ($condition->target === 'userrole') {
                                    if (!in_array($condition->extraData, $current_user->roles, true)) {
                                        $uniqueSend = 'true';
                                    }
                                } else if ($condition->target === 'usercapabilities') {
                                    if (!current_user_can($condition->extraData)) {
                                        $uniqueSend = 'true';
                                    }
                                } else if ($condition->target === 'acf') {
                                    if (isset($condition->group) && isset($condition->field)) {
                                        $location = false;
                                        if (isset($condition->acfLocation)) {
                                            if ($condition->acfLocation === 'currentpost') {
                                                $location = get_the_ID();
                                            } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            } else if ($condition->acfLocation === 'currentuser') {
                                                $location = 'user_' . get_current_user_id() . '';
                                            } else if ($condition->acfLocation === 'currentauthor') {
                                                $location = 'user_' . get_the_author_meta('ID') . '';
                                            } else if ($condition->acfLocation === 'option') {
                                                $location = 'option';
                                            } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                                $term = get_term($condition->acfLocationID->value);
                                                $location = $term->taxonomy . '_' . $term->term_id;
                                            } else if (isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            }
                                        }

                                        $field = get_field($condition->field, $location);
                                        if (is_array($field)) {
                                            $field = implode(" ", $field);
                                        } else {
                                            $field = strval($field);
                                        }

                                        if ($field != $condition->extraData) {
                                            $uniqueSend = 'true';
                                        }
                                    }
                                } else {
                                    if ($conditioner != $condition->extraData) {
                                        $uniqueSend = 'true';
                                    }
                                }
                                break;
                            case "contains":
                                if ($condition->target === 'cookie') {
                                    $loop = true;
                                    foreach ($_COOKIE as $key => $val) {
                                        if (strpos($key, $condition->extraData) !== false) {
                                            $uniqueSend = 'true';
                                            $loop = false;
                                            break;
                                        }
                                    }
                                    if ($loop) {
                                        $uniqueSend = 'false';
                                    }
                                } else if ($condition->target === 'acf') {
                                    if (isset($condition->group) && isset($condition->field)) {
                                        $location = false;
                                        if (isset($condition->acfLocation)) {
                                            if ($condition->acfLocation === 'currentpost') {
                                                $location = get_the_ID();
                                            } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            } else if ($condition->acfLocation === 'currentuser') {
                                                $location = 'user_' . get_current_user_id() . '';
                                            } else if ($condition->acfLocation === 'currentauthor') {
                                                $location = 'user_' . get_the_author_meta('ID') . '';
                                            } else if ($condition->acfLocation === 'option') {
                                                $location = 'option';
                                            } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                                $term = get_term($condition->acfLocationID->value);
                                                $location = $term->taxonomy . '_' . $term->term_id;
                                            } else if (isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            }
                                        }

                                        $field = get_field($condition->field, $location);
                                        if (is_array($field)) {
                                            $field = implode(" ", $field);
                                        } else {
                                            $field = strval($field);
                                        }

                                        if (strpos($field, $condition->extraData) !== false) {
                                            $uniqueSend = 'true';
                                        }
                                    }
                                } else {
                                    if (strpos($conditioner, $condition->extraData) !== false) {
                                        $uniqueSend = 'true';
                                    }
                                }
                                break;
                            case "notcontain":
                                if ($condition->target === 'cookie') {
                                    $loop = true;
                                    foreach ($_COOKIE as $key => $val) {
                                        if (strpos($key, $condition->extraData) === false) {
                                            $uniqueSend = 'true';
                                            $loop = false;
                                            break;
                                        }
                                    }
                                    if ($loop) {
                                        $uniqueSend = 'false';
                                    }
                                } else if ($condition->target === 'acf') {
                                    if (isset($condition->group) && isset($condition->field)) {
                                        $location = false;
                                        if (isset($condition->acfLocation)) {
                                            if ($condition->acfLocation === 'currentpost') {
                                                $location = get_the_ID();
                                            } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            } else if ($condition->acfLocation === 'currentuser') {
                                                $location = 'user_' . get_current_user_id() . '';
                                            } else if ($condition->acfLocation === 'currentauthor') {
                                                $location = 'user_' . get_the_author_meta('ID') . '';
                                            } else if ($condition->acfLocation === 'option') {
                                                $location = 'option';
                                            } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                                $term = get_term($condition->acfLocationID->value);
                                                $location = $term->taxonomy . '_' . $term->term_id;
                                            } else if (isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            }
                                        }

                                        $field = get_field($condition->field, $location);
                                        if (is_array($field)) {
                                            $field = implode(" ", $field);
                                        } else {
                                            $field = strval($field);
                                        }

                                        if (strpos($field, $condition->extraData) === false) {
                                            $uniqueSend = 'true';
                                        }
                                    }
                                } else {
                                    if (strpos($conditioner, $condition->extraData) === false) {
                                        $uniqueSend = 'true';
                                    }
                                }
                                break;
                            case "before":
                                if ($condition->target === 'dayweek') {
                                    $date_now = strtotime('today');
                                    $date_compared = strtotime('' . $condition->extraData . ' this week');
                                    if ($date_now < $date_compared) {
                                        $uniqueSend = 'true';
                                    }
                                } else {
                                    if ($conditioner < $condition->extraData) {
                                        $uniqueSend = 'true';
                                    }
                                }
                                break;
                            case "after":
                                if ($condition->target === 'dayweek') {
                                    $date_now = strtotime('today');
                                    $date_compared = strtotime('' . $condition->extraData . ' this week');
                                    if ($date_now > $date_compared) {
                                        $uniqueSend = 'true';
                                    }
                                } else {
                                    if ($conditioner > $condition->extraData) {
                                        $uniqueSend = 'true';
                                    }
                                }
                                break;
                            case "<":
                                if ($conditioner < $condition->extraData) {
                                    $uniqueSend = 'true';
                                }
                                break;
                            case ">":
                                if ($conditioner > $condition->extraData) {
                                    $uniqueSend = 'true';
                                }
                                break;
                            case ">=":
                                if ($conditioner >= $condition->extraData) {
                                    $uniqueSend = 'true';
                                }
                                break;
                            case "<=":
                                if ($conditioner <= $condition->extraData) {
                                    $uniqueSend = 'true';
                                }
                                break;
                            case "empty":
                                if ($condition->target === 'acf') {
                                    if (isset($condition->group) && isset($condition->field)) {
                                        $location = false;
                                        if (isset($condition->acfLocation)) {
                                            if ($condition->acfLocation === 'currentpost') {
                                                $location = get_the_ID();
                                            } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            } else if ($condition->acfLocation === 'currentuser') {
                                                $location = 'user_' . get_current_user_id() . '';
                                            } else if ($condition->acfLocation === 'currentauthor') {
                                                $location = 'user_' . get_the_author_meta('ID') . '';
                                            } else if ($condition->acfLocation === 'option') {
                                                $location = 'option';
                                            } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                                $term = get_term($condition->acfLocationID->value);
                                                $location = $term->taxonomy . '_' . $term->term_id;
                                            } else if (isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            }
                                        }

                                        $field = get_field($condition->field, $location);
                                        if (is_array($field)) {
                                            $field = implode(" ", $field);
                                        } else {
                                            $field = strval($field);
                                        }

                                        if (empty($field)) {
                                            $uniqueSend = 'true';
                                        }
                                    }
                                }
                                break;
                            case "notempty":
                                if ($condition->target === 'acf') {
                                    if (isset($condition->group) && isset($condition->field)) {
                                        $location = false;
                                        if (isset($condition->acfLocation)) {
                                            if ($condition->acfLocation === 'currentpost') {
                                                $location = get_the_ID();
                                            } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            } else if ($condition->acfLocation === 'currentuser') {
                                                $location = 'user_' . get_current_user_id() . '';
                                            } else if ($condition->acfLocation === 'currentauthor') {
                                                $location = 'user_' . get_the_author_meta('ID') . '';
                                            } else if ($condition->acfLocation === 'option') {
                                                $location = 'option';
                                            } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                                $term = get_term($condition->acfLocationID->value);
                                                $location = $term->taxonomy . '_' . $term->term_id;
                                            } else if (isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            }
                                        }

                                        $field = get_field($condition->field, $location);
                                        if (is_array($field)) {
                                            $field = implode(" ", $field);
                                        } else {
                                            $field = strval($field);
                                        }

                                        if (!empty($field)) {
                                            $uniqueSend = 'true';
                                        }
                                    }
                                }
                                break;
                            case "true":
                                if ($condition->target === 'shortcode') {
                                    // if (do_shortcode('[' . $condition->extraData . ']') === 'true') {
                                    if (boolval(do_shortcode('[' . $condition->extraData . ']')) === true) {
                                        $uniqueSend = 'true';
                                    }
                                } else if ($condition->target === 'loggedin') {
                                    if (is_user_logged_in()) {
                                        $uniqueSend = 'true';
                                    }
                                } else if ($condition->target === 'acf') {
                                    if (isset($condition->group) && isset($condition->field)) {
                                        $location = false;
                                        if (isset($condition->acfLocation)) {
                                            if ($condition->acfLocation === 'currentpost') {
                                                $location = get_the_ID();
                                            } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            } else if ($condition->acfLocation === 'currentuser') {
                                                $location = 'user_' . get_current_user_id() . '';
                                            } else if ($condition->acfLocation === 'currentauthor') {
                                                $location = 'user_' . get_the_author_meta('ID') . '';
                                            } else if ($condition->acfLocation === 'option') {
                                                $location = 'option';
                                            } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                                $term = get_term($condition->acfLocationID->value);
                                                $location = $term->taxonomy . '_' . $term->term_id;
                                            } else if (isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            }
                                        }

                                        $field = get_field($condition->field, $location);
                                        if (is_array($field)) {
                                            $field = implode(" ", $field);
                                        } else {
                                            $field = strval($field);
                                        }
                                        // if (boolval($field) === true) {
                                        if (filter_var($field, FILTER_VALIDATE_BOOLEAN) === true) {
                                            $uniqueSend = 'true';
                                        }
                                    }
                                }
                                break;
                            case "false":
                                if ($condition->target === 'shortcode') {
                                    // if (do_shortcode('[' . $condition->extraData . ']') === 'false') {
                                    if (boolval(do_shortcode('[' . $condition->extraData . ']')) === false) {
                                        $uniqueSend = 'true';
                                    }
                                } else if ($condition->target === 'loggedin') {
                                    if (!is_user_logged_in()) {
                                        $uniqueSend = 'true';
                                    }
                                } else if (isset($condition->group) && isset($condition->field)) {
                                    $location = false;
                                    if (isset($condition->acfLocation)) {
                                        if ($condition->acfLocation === 'currentpost') {
                                            $location = get_the_ID();
                                        } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                            $location = $condition->acfLocationID;
                                        } else if ($condition->acfLocation === 'currentuser') {
                                            $location = 'user_' . get_current_user_id() . '';
                                        } else if ($condition->acfLocation === 'currentauthor') {
                                            $location = 'user_' . get_the_author_meta('ID') . '';
                                        } else if ($condition->acfLocation === 'option') {
                                            $location = 'option';
                                        } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                            $term = get_term($condition->acfLocationID->value);
                                            $location = $term->taxonomy . '_' . $term->term_id;
                                        } else if (isset($condition->acfLocationID)) {
                                            $location = $condition->acfLocationID;
                                        }
                                    }

                                    $field = get_field($condition->field, $location);
                                    if (is_array($field)) {
                                        $field = implode(" ", $field);
                                    } else {
                                        $field = strval($field);
                                    }

                                    // if (boolval($field) === false) {
                                    if (filter_var($field, FILTER_VALIDATE_BOOLEAN) === false) {
                                        $uniqueSend = 'true';
                                    }
                                }
                                break;
                        }
                        $exclude[] = $uniqueSend;
                    }
                    $noExclude[] = 'false';
                } else {
                    $noExclude[] = 'true';
                }
                if ($templaterer) {
                    if (array_unique($noExclude) == array('true')) {
                        $finalTemplates[$templaterer] = $customTemplate[$templaterer];
                        $templateList[] = $templaterer;
                    } else if ($templaterer && $conditions->exclude->$templaterer->excludeCondition && $conditions->exclude->$templaterer->excludeCondition === 'and' && array_unique($exclude) != array('true')) {
                        $finalTemplates[$templaterer] = $customTemplate[$templaterer];
                        $templateList[] = $templaterer;
                    } else if ($templaterer && $conditions->exclude->$templaterer->excludeCondition && $conditions->exclude->$templaterer->excludeCondition === 'or' && !in_array("true", $exclude)) {
                        $finalTemplates[$templaterer] = $customTemplate[$templaterer];
                        $templateList[] = $templaterer;
                    }
                }
            }
        }

        if (isset($query['slug__in'])) {
            if (Cwicly\Helpers::strposa('product', $query['slug__in'])) {
                if (in_array('single-product', $query['slug__in'], true)) {
                    if ($finalTemplates) {
                    } else {
                        Cwicly\Themer::add_template_styles('woocommerce_woocommerce', 'single-product', 'tp');
                        return null;
                    }
                } else if (in_array('product-search-results', $query['slug__in'], true)) {
                    if ($finalTemplates) {
                    } else {
                        Cwicly\Themer::add_template_styles('woocommerce_woocommerce', 'product-search-results', 'tp');
                        return null;
                    }
                } else if (in_array('taxonomy-product_cat', $query['slug__in'], true)) {
                    if ($finalTemplates) {
                    } else {
                        Cwicly\Themer::add_template_styles('woocommerce_woocommerce', 'taxonomy-product_cat', 'tp');
                        return null;
                    }
                } else if (in_array('archive-product', $query['slug__in'], true)) {
                    if ($finalTemplates) {
                    } else {
                        Cwicly\Themer::add_template_styles('woocommerce_woocommerce', 'archive-product', 'tp');
                        return null;
                    }
                } else if (in_array('taxonomy-product_tag', $query['slug__in'], true)) {
                    if ($finalTemplates) {
                    } else {
                        Cwicly\Themer::add_template_styles('woocommerce_woocommerce', 'taxonomy-product_tag', 'tp');
                        return null;
                    }
                }
            }
        }

        foreach ($priorities as $namer => $level) {
            if (!in_array($namer, $templateList)) {
                unset($priorities[$namer]);
            }
        }

        if ($priorities) {
            $final = array_search(max($priorities), $priorities);
            if ($finalTemplates[$final] && isset($name[$final]) && isset($slug[$final])) {
                Cwicly\Themer::namer($name[$final], $slug[$final], $template_type);

                if (isset($finalTemplates[$final][0]->theme) && $finalTemplates[$final][0]->theme && isset($finalTemplates[$final][0]->slug) && $finalTemplates[$final][0]->slug) {
                    if (!is_admin()) {
                        if (isset($statusCodes[$finalTemplates[$final][0]->slug])) {
                            status_header($statusCodes[$finalTemplates[$final][0]->slug]);
                        }
                        Cwicly\Themer::add_template_styles($finalTemplates[$final][0]->theme, $finalTemplates[$final][0]->slug, 'tp');
                    }
                }
                // return $finalTemplates[$final];
                if (!is_page_template() || (isset($overridePageTemplate[$finalTemplates[$final][0]->slug]) && $overridePageTemplate[$finalTemplates[$final][0]->slug])) {
                    return apply_filters('get_block_template', $finalTemplates[$final], '' . $finalTemplates[$final][0]->theme . '//' . $name[$final] . '', $template_type);
                }
            }
        } else {
            if ($finalTemplates && array_values($finalTemplates)[0]) {
                Cwicly\Themer::namer(array_values($name)[0], array_values($slug)[0], $template_type);

                if (isset(array_values($finalTemplates)[0][0]->theme) && array_values($finalTemplates)[0][0]->theme && isset(array_values($finalTemplates)[0][0]->slug) && array_values($finalTemplates)[0][0]->slug) {
                    if (!is_admin()) {
                        if (isset($statusCodes[array_values($finalTemplates)[0][0]->slug])) {
                            status_header($statusCodes[array_values($finalTemplates)[0][0]->slug]);
                        }
                        Cwicly\Themer::add_template_styles(array_values($finalTemplates)[0][0]->theme, array_values($finalTemplates)[0][0]->slug, 'tp');
                    }
                }
                // return array_values($finalTemplates)[0];
                if (!is_page_template() || (isset($overridePageTemplate[array_values($finalTemplates)[0][0]->slug]) && $overridePageTemplate[array_values($finalTemplates)[0][0]->slug])) {
                    return apply_filters('get_block_template', array_values($finalTemplates)[0], '' . array_values($finalTemplates)[0][0]->theme . '//' . array_values($name)[0] . '', $template_type);
                }
            }
        }
    }
    return null;
}

if (function_exists('wp_is_block_theme') && wp_is_block_theme()) {
    add_filter('pre_get_block_templates', 'cc_themer_maker', 10, 3);
}
