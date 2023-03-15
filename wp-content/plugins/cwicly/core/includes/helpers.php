<?php
namespace Cwicly;

if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

class Helpers
{
    /**
     * Checks if the current request is a WP REST API request.
     *
     * Case #1: After WP_REST_Request initialisation
     * Case #2: Support "plain" permalink settings and check if `rest_route` starts with `/`
     * Case #3: It can happen that WP_Rewrite is not yet initialized,
     *          so do this (wp-settings.php)
     * Case #4: URL Path begins with wp-json/ (your REST prefix)
     *          Also supports WP installations in subfolders
     *
     * @returns boolean
     * @author matzeeable
     */
    public static function is_rest()
    {
        if (
            defined('REST_REQUEST') && REST_REQUEST// (#1)
            || isset($_GET['rest_route']) // (#2)
            && strpos($_GET['rest_route'], '/', 0) === 0
        ) {
            return true;
        }

        // (#3)
        global $wp_rewrite;
        if ($wp_rewrite === null) {
            $wp_rewrite = new WP_Rewrite();
        }

        // (#4)
        $rest_url = wp_parse_url(trailingslashit(rest_url()));
        $current_url = wp_parse_url(add_query_arg(array()));

        // Add check for 'path' key
        if (isset($rest_url['path']) && isset($current_url['path'])) {
            return strpos($current_url['path'], $rest_url['path'], 0) === 0;
        }

        return false;
    }

    /**
     * Add admin menu item to existing Cwicly menu
     * @param array $args
     * @param string $check
     * @param int $priority
     */
    public static function add_admin_menu_item($args, $check = '', $priority = 99)
    {
        add_action('admin_bar_menu', function ($wp_admin_bar) use ($args, $check) {
            $checker = false;
            if ($check) {
                $checker = $wp_admin_bar->get_node($check);
            }
            if (!$checker) {
                $wp_admin_bar->add_node($args);
            }
        }, $priority);
    }

    /**
     * Get the current user role of the logged in user
     */
    public static function get_current_user_roles()
    {
        if (is_user_logged_in()) {
            $user = wp_get_current_user();
            $roles = (array) $user->roles;
            return $roles; // This returns an array

            // Use this to return a single value
            // return $roles[0];

        }
        return array();
    }

    /**
     * Get correct server address
     */
    // https://stackoverflow.com/questions/5705082/is-serverserver-addr-safe-to-rely-on
    public static function get_server_address()
    {
        if (array_key_exists('SERVER_ADDR', $_SERVER)) {
            return $_SERVER['SERVER_ADDR'];
        } elseif (array_key_exists('LOCAL_ADDR', $_SERVER)) {
            return $_SERVER['LOCAL_ADDR'];
        } elseif (array_key_exists('SERVER_NAME', $_SERVER)) {
            return gethostbyname($_SERVER['SERVER_NAME']);
        } else {
            // Running CLI
            if (stristr(PHP_OS, 'WIN')) {
                return gethostbyname(php_uname("n"));
            } else {
                $ifconfig = shell_exec('/sbin/ifconfig eth0');
                preg_match('/addr:([\d\.]+)/', $ifconfig, $match);
                return $match[1];
            }
        }
    }

    /**
     * Allows us to write to log safely
     */
    public static function write_log($log)
    {
        if (is_array($log) || is_object($log)) {
            error_log(print_r($log, true));
        } else {
            error_log($log);
        }
    }

    /**
     * Function for checking if there is an array of needles inside string.
     *
     */
    public static function strposa($str, array $arr)
    {
        if (stripos(json_encode($arr), $str) !== false) {
            return true;
        }
        return false;
    }

    /**
     * Function for checking if a value exists even if equals 0.
     *
     */
    public static function check_if_exists($value)
    {
        if (isset($value) && ($value == 0 || $value == '0' || !empty($value)) && $value != '') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks if the post is in one of the categories or any child category. // Thanks to https://wordpress.stackexchange.com/a/375247
     *
     * @param  int|string|array $category_ids (Single category id) or (comma separated string or array of category ids).
     * @param  int              $post_id      Post ID to check. Default to `get_the_ID()`.
     * @return bool true, iff post is in any category or child category.
     */
    public static function cc_is_post_in_category($category_ids, $post_id = null)
    {
        $args = array(
            'include' => $post_id ?? get_the_ID(),
            'category' => $category_ids,
            'fields' => 'ids',
        );
        return 0 < count(get_posts($args));
    }

    /**
     * Function to create and sort Additional Classes
     */
    public static function additional_classes($attributes)
    {
        $classes = '';
        $additionalClassesRef = json_decode(CC_CLASSES);
        $additionalClasses = [];
        if (isset($attributes['additionalClass']) && $attributes['additionalClass']) {
            foreach ($attributes['additionalClass'] as $value) {
                if (is_array($value)) {
                    if ((isset($value['visibility']) && !$value['visibility']) || !isset($value['visibility'])) {
                        if ($value['isLinked']) {
                            array_push($additionalClasses, $value['value']);
                        } elseif (isset($additionalClassesRef->{$value['value']})) {
                            array_push($additionalClasses, $additionalClassesRef->{$value['value']});
                        }
                    }
                }
            }
        }
        $classes .= '' . implode(" ", $additionalClasses) . '';
        return $classes;
    }

    /**
     * Function to create and sort Global Classes from the Site Options
     */
    public static function global_classes($attributes)
    {
        $classes = '';
        $globals = get_option('cwicly_global_classes');
        if ($globals) {
            $globals = json_decode($globals, true);
        } else {
            return;
        }
        $globalClasses = [];
        if (isset($attributes['globalClass']) && $attributes['globalClass']) {
            foreach ($attributes['globalClass'] as $value) {
                if (isset($globals) && $globals && isset($globals[$value]) && $globals[$value] && isset($globals[$value]['attributes']) && $globals[$value]['attributes'] && isset($globals[$value]['attributes']['classID']) && $globals[$value]['attributes']['classID']) {
                    array_push($globalClasses, $globals[$value]['attributes']['classID']);
                }
            }
        }
        $classes .= '' . implode(" ", $globalClasses) . '';
        return $classes;
    }

    /**
     * Function to insert in the body the Global Interactions scripts
     */
    public static function add_global_interactions_inline_script()
    {
        echo '<script id="cc-global-interactions" type="application/json">' . PHP_EOL;

        echo json_encode(get_option('cwicly_global_interactions'), JSON_HEX_APOS);

        echo '</script>' . PHP_EOL;
    }

    /**
     * Function to transform ACF Field into Video embed overlay
     */
    public static function get_dynamic_video_url($attributes, $field)
    {
        $final = '';
        if (strpos($field, 'youtube') > 0) {
            $branding = 0;
            if (isset($attributes['videoBranding']) && $attributes['videoBranding']) {
                $branding = 1;
            }
            $youtubeURL = 'youtube';
            if (isset($attributes['videoPrivacy']) && $attributes['videoPrivacy']) {
                $youtubeURL = 'youtube-nocookie';
            }
            preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $field, $vidid);
            $embedURL = 'https://www.' . $youtubeURL . '.com/embed/' . $vidid[1] . '?modestbranding=' . $branding . '';
            if (isset($attributes['videoStart']) && $attributes['videoStart']) {
                $embedURL .= '&start=' . $attributes['videoStart'] . '';
            }
            if (isset($attributes['videoEnd']) && $attributes['videoEnd']) {
                $embedURL .= '&end=' . $attributes['videoEnd'] . '';
            }
            if (isset($attributes['videoAutoplay']) && $attributes['videoAutoplay']) {
                $embedURL .= '&autoplay=1';
            }
            if (isset($attributes['videoMute']) && $attributes['videoMute']) {
                $embedURL .= '&mute=1';
            }
            if (isset($attributes['videoLoop']) && $attributes['videoLoop']) {
                $embedURL .= '&loop=1';
            }
            if (isset($attributes['videoControls']) && !$attributes['videoControls']) {
                $embedURL .= '&controls=0';
            }
            // $final .= '<div id="' . $attributes['id'] . '-videoe-iframe" class="cc-iframe-container">';
            $final .= '<div class="cc-iframe-container">';
            if (isset($attributes['videoImageOverlay']) && $attributes['videoImageOverlay']) {
                $final .= '<iframe width="560" height="315" src="' . $embedURL . '" srcdoc="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
            } else {
                $final .= '<iframe width="560" height="315" src="' . $embedURL . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
            }
            $final .= '</div>';
        } else if (strpos($field, 'vimeo') > 0) {
            preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $field, $vidid);
            $embedURL = 'https://player.vimeo.com/video/' . $vidid[3] . '?transparent=1';
            if (isset($attributes['videoStart']) && $attributes['videoStart']) {
                $embedURL .= '&#t=' . $attributes['videoStart'] . '';
            }
            if (isset($attributes['videoAutoplay']) && $attributes['videoAutoplay']) {
                $embedURL .= '&autoplay=true';
            }
            if (isset($attributes['videoMute']) && $attributes['videoMute']) {
                $embedURL .= '&muted=1';
            }
            if (isset($attributes['videoLoop']) && $attributes['videoLoop']) {
                $embedURL .= '&loop=1';
            }
            if (isset($attributes['videoPrivacy']) && $attributes['videoPrivacy']) {
                $embedURL .= '&dnt=1';
            }
            // $final .= '<div id="' . $attributes['id'] . '-videoe-iframe" class="cc-iframe-container">';
            $final .= '<div class="cc-iframe-container">';
            if (isset($attributes['videoImageOverlay']) && $attributes['videoImageOverlay']) {
                $final .= '<iframe width="560" height="315" src="' . $embedURL . '" srcdoc="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
            } else {
                $final .= '<iframe width="560" height="315" src="' . $embedURL . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
            }
            $final .= '</div>';
        } else if ($field) {
            $args = [];
            $embedURL = $field;
            if (isset($attributes['videoAutoplay']) && $attributes['videoAutoplay']) {
                $args['autoplay'] = true;
                $args['data-autoplay'] = true;
            }
            if (isset($attributes['videoMute']) && $attributes['videoMute']) {
                $args['muted'] = true;
            }
            if (isset($attributes['videoLoop']) && $attributes['videoLoop']) {
                $args['loop'] = true;
            }
            if (isset($attributes['videoControls']) && $attributes['videoControls']) {
                $args['controls'] = true;
            }

            $argsString = '';
            foreach ($args as $key => $value) {
                $argsString .= $key . '="' . $value . '" ';
            }
            if (isset($attributes['videoImageOverlay']) && $attributes['videoImageOverlay']) {
                $final .= '<video id="' . $attributes['id'] . '-videoe-local"></video>';
            } else {
                $final = '<video id="' . $attributes['id'] . '-videoe-local" src="' . $embedURL . '" ' . $argsString . ' controlslist="nodownload">Sorry, your browser doesn\'t support embedded videos.</video>';
            }
        }
        return $final;
    }

    /**
     * Function to transform ACF Field into Video embed overlay
     */
    public static function get_dynamic_video_overlay_url($attributes, $field)
    {
        $embedURL = '';
        if (strpos($field, 'youtube') > 0) {
            $branding = 0;
            if (isset($attributes['videoBranding']) && $attributes['videoBranding']) {
                $branding = 1;
            }
            $youtubeURL = 'youtube';
            if (isset($attributes['videoPrivacy']) && $attributes['videoPrivacy']) {
                $youtubeURL = 'youtube-nocookie';
            }
            preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $field, $vidid);
            $embedURL = 'https://www.' . $youtubeURL . '.com/embed/' . $vidid[1] . '?modestbranding=' . $branding . '';
            if (isset($attributes['videoStart']) && $attributes['videoStart']) {
                $embedURL .= '&start=' . $attributes['videoStart'] . '';
            }
            if (isset($attributes['videoEnd']) && $attributes['videoEnd']) {
                $embedURL .= '&end=' . $attributes['videoEnd'] . '';
            }
            if (isset($attributes['videoAutoplay']) && $attributes['videoAutoplay']) {
                $embedURL .= '&autoplay=1';
            }
            if (isset($attributes['videoMute']) && $attributes['videoMute']) {
                $embedURL .= '&mute=1';
            }
            if (isset($attributes['videoLoop']) && $attributes['videoLoop']) {
                $embedURL .= '&loop=1';
            }
            if (isset($attributes['videoControls']) && !$attributes['videoControls']) {
                $embedURL .= '&controls=0';
            }
        } elseif (strpos($field, 'vimeo') > 0) {
            preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $field, $vidid);
            $embedURL = 'https://player.vimeo.com/video/' . $vidid[3] . '?transparent=1';
            if (isset($attributes['videoStart']) && $attributes['videoStart']) {
                $embedURL .= '&#t=' . $attributes['videoStart'] . '';
            }
            if (isset($attributes['videoAutoplay']) && $attributes['videoAutoplay']) {
                $embedURL .= '&autoplay=true';
            }
            if (isset($attributes['videoMute']) && $attributes['videoMute']) {
                $embedURL .= '&muted=1';
            }
            if (isset($attributes['videoLoop']) && $attributes['videoLoop']) {
                $embedURL .= '&loop=1';
            }
            if (isset($attributes['videoPrivacy']) && $attributes['videoPrivacy']) {
                $embedURL .= '&dnt=1';
            }
        } elseif ($field) {
            $embedURL = $field;
        }
        return $embedURL;
    }
}
