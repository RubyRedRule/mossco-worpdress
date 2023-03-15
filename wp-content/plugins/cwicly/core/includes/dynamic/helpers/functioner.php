<?php

/**
 * Cwicly Functioner
 *
 * Echo function
 *
 * @version 1.2.6
 */

function cc_echo($input)
{
    $callback = $input;
    $args = [];

    if (strpos($callback, '(') !== false) {
        $openstrpos = strpos($callback, "(");
        $closestrpos = strrpos($callback, ")");
        $match = substr($callback, $openstrpos + 1, $closestrpos - $openstrpos - 1);

        $args = explode(',', $match);

        if (count($args) > 0) {
            foreach ($args as $key => $arg) {
                $str = trim($arg);
                if (!empty($str)) {
                    if ($str[0] == '\'' && $str[strlen($str) - 1] == '\'') {
                        $str = substr($str, 1, -1);
                        $args[$key] = $str;
                    } else {
                        if (is_int($str)) {
                            $args[$key] = (int) $str;
                        } else if (is_float($str)) {
                            $args[$key] = (float) $str;
                        } else if (is_bool($str)) {
                            $args[$key] = (bool) $str;
                        } else if (strpos($str, '(') !== false) {
                            $args[$key] = cc_echo($str);
                        }
                    }
                }
            }
        }

        $callback = strtok($callback, '(');
        $callback = trim($callback);

    } else {
        $callback = trim($callback);
    }

    try {
        return function_exists($callback) ? call_user_func_array($callback, $args) : '';
    } catch (\Exception$error) {
        error_log('Exception: ' . print_r($error->getMessage(), true));
    } catch (\ParseError$error) {
        error_log('ParseError: ' . print_r($error->getMessage(), true));
    } catch (\Error$error) {
        error_log('Error: ' . print_r($error->getMessage(), true));
    }

    return '';
}

function cc_custom_taxonomies()
{
    // https://stackoverflow.com/questions/15502811/display-current-post-custom-taxonomy-in-wordpress
    global $post, $post_id;
    // get post by post id
    $post = get_post($post->ID);
    // get post type by post
    $post_type = $post->post_type;
    // get post type taxonomies
    $taxonomies = get_object_taxonomies($post_type);
    $final = [];
    foreach ($taxonomies as $taxonomy) {
        // get the terms related to post
        $terms = get_the_terms($post->ID, $taxonomy);
        if (!empty($terms)) {
            $final[] = $taxonomy;
        }
    }
    return $final;
}

function cc_custom_taxonomies_terms($postId)
{
    // https://stackoverflow.com/questions/15502811/display-current-post-custom-taxonomy-in-wordpress
    global $post;

    $query = null;
    if (isset($post->ID)) {
        $query = $post;
    } else if ($postId) {
        $query = $postId;
    } else {
        $query = get_the_ID();
    }

    $final = [];
    if ($query) {
        $post_type = get_post_type($query);
        // get post type taxonomies
        $taxonomies = get_object_taxonomies($post_type);
        $final = [];
        foreach ($taxonomies as $taxonomy) {
            // get the terms related to post
            $terms = get_the_terms($post, $taxonomy);
            if (!empty($terms)) {
                foreach ($terms as $term) {
                    $final[] = $term->term_id;
                }
            }
        }
    }
    return $final;
}
