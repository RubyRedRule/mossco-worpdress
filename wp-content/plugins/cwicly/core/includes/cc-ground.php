<?php

if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

require_once CWICLY_DIR_PATH . 'init.php';
/**
 * Basis of Cwicly
 */
class CWICLY
{

    public function __construct()
    {
        add_action('rest_api_init', array($this, 'cwicly_register_api_hook'));
    }

    public function cwicly_register_api_hook()
    {

        // EDITOR STARTUP
        register_rest_route(
            'cwicly/v1',
            '/editor_start/',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array($this, 'cc_editor_start'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                ),
            )
        );
        // EDITOR STARTUP

        // EDITOR SAVE
        register_rest_route(
            'cwicly/v1',
            '/editor_save/',
            array(
                array(
                    'methods' => 'POST',
                    'callback' => array($this, 'cc_editor_save'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                ),
            )
        );
        // EDITOR SAVE

        // GET/SAVE GLOBAL STYLES RAW
        register_rest_route(
            'cwicly/v1',
            '/global_styles/',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array($this, 'get_global_styles'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                ),
                array(
                    'methods' => 'POST',
                    'callback' => array($this, 'update_global_styles'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                    'args' => array(),
                ),
            )
        );
        // GET/SAVE GLOBAL STYLES RAW

        // GET ACF GROUPS
        register_rest_route(
            'cwicly/v1',
            '/acf_fields/',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array($this, 'cc_get_all_acf_fields'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                ),
            )
        );
        // GET ACF GROUPS

        // GET SITE INFO
        register_rest_route(
            'cwicly/v1',
            '/site_info/',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array($this, 'cc_get_site_info'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                ),
            )
        );
        // GET SITE INFO

        // USED IN LINK MODAL || NOT REALLY USED
        register_rest_route(
            'cwicly/v1',
            '/search_posts/',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array($this, 'cc_search_posts'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                ),
            )
        );
        // USED IN LINK MODAL || NOT REALLY USED

        // RETRIEVE GLOBAL LICENSE
        register_rest_route(
            'cwicly/v1',
            '/cwicly_license/',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array($this, 'get_cwicly_license'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                ),
            )
        );
        // RETRIEVE GLOBAL LICENSE

        // SAVE GLOBAL STYLES CSS
        register_rest_route(
            'cwicly/v1',
            '/cwicly_global_css/',
            array(
                array(
                    'methods' => 'POST',
                    'callback' => array($this, 'update_global_css'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                    'args' => array(),
                ),
            )
        );

        register_rest_route(
            'cwicly/v1',
            '/cwicly_global_classes_save/',
            array(
                array(
                    'methods' => 'POST',
                    'callback' => array($this, 'update_global_classes'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                    'args' => array(),
                ),
            )
        );
        // SAVE GLOBAL STYLES CSS

        // GET MENUS
        register_rest_route(
            'cwicly/v1',
            '/cwicly_menus/',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array($this, 'cc_get_menus'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                ),
            )
        );
        // GET MENUS

        // GET SVG COLS
        register_rest_route(
            'cwicly/v1',
            '/cwicly_svgs/',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array($this, 'cc_get_svgs'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                ),
            )
        );
        // GET SVG COLS

        // GET FONT COLS
        register_rest_route(
            'cwicly/v1',
            '/cwicly_fonts/',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array($this, 'cc_get_fonts'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                ),
            )
        );
        // GET FONT COLS

        // GET OPTIONS
        register_rest_route(
            'cwicly/v1',
            '/options/',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array($this, 'get_options'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                ),
                array(
                    'methods' => 'POST',
                    'callback' => array($this, 'cc_update_options'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                    'args' => array(),
                ),
            )
        );
        // GET OPTIONS

        // GET ALL POSTS
        register_rest_route(
            'cwicly/v1',
            '/allposts/',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array($this, 'all_posts'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                ),
            )
        );
        // GET ALL POSTS

        // RENDER ALL POSTS
        register_rest_route(
            'cwicly/v1',
            '/allpostsrender/',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array($this, 'all_posts_render'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                ),
            )
        );
        // RENDER ALL POSTS

        // RENDER ALL POSTS IDS
        register_rest_route(
            'cwicly/v1',
            '/allpostsrenderids/',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array($this, 'all_posts_render_ids'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                ),
            )
        );
        // RENDER ALL POSTS IDS

        // RENDER ALL POSTS IDS
        register_rest_route(
            'cwicly/v1',
            '/getposts/',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array($this, 'cc_get_posts'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                ),
            )
        );
        // RENDER ALL POSTS IDS

        // RENDER HTML ALL POSTS
        register_rest_route(
            'cwicly/v1',
            '/post_html_render/',
            array(
                array(
                    'methods' => 'POST',
                    'callback' => array($this, 'cc_new_parser_render'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                    'args' => array(),
                ),
            )
        );
        // RENDER HTML ALL POSTS

        // RENDER ISSTYLING ALL POSTS
        register_rest_route(
            'cwicly/v1',
            '/post_isstyling_render/',
            array(
                array(
                    'methods' => 'POST',
                    'callback' => array($this, 'cc_isStyling_render'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                    'args' => array(),
                ),
            )
        );
        // RENDER ISSTYLING ALL POSTS

        // Set Options
        register_rest_route(
            'cwicly/v1',
            '/options_set/',
            array(
                array(
                    'methods' => 'POST',
                    'callback' => array($this, 'cc_update_options'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                    'args' => array(),
                ),
            )
        );

        // SET MAIN CSS
        register_rest_route(
            'cwicly/v1',
            '/make_css/',
            array(
                array(
                    'methods' => 'POST',
                    'callback' => array($this, 'cc_make_css'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                    'args' => array(),
                ),
            )
        );
        // SET MAIN CSS

        // CSS Maker
        register_rest_route(
            'cwicly/v1',
            '/cwicly_dynamic_preview/',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array($this, 'cc_dynamic_previewer'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                ),
            )
        );

        // BACKEND INFO
        register_rest_route(
            'cwicly/v1',
            '/backend_info/',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array($this, 'cc_backend_info_api'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                ),
            )
        );

        // SINGLE MAKE CSS
        register_rest_route(
            'cwicly/v1',
            '/single_make_css/',
            array(
                array(
                    'methods' => 'POST',
                    'callback' => array($this, 'cc_single_make_css'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                ),
            )
        );

        // POST CODE
        register_rest_route(
            'cwicly/v1',
            '/code/',
            array(
                array(
                    'methods' => 'POST',
                    'callback' => array($this, 'cc_code_maker'),
                    'permission_callback' => function () {
                        return current_user_can('manage_options');
                    },
                ),
            )
        );
        // POST CODE

        register_rest_route(
            'cwicly/v1',
            '/filter_query/',
            array(
                array(
                    'methods' => 'POST',
                    'callback' => array($this, 'cc_filter_query'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                    'args' => array(),
                ),
            )
        );

        register_rest_route(
            'cwicly/v1',
            '/cwicly_cart_backend/',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array($this, 'cc_cart_backend'),
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                ),
            )
        );
    }

    public function cc_new_parser_render($data)
    {
        try {
            if ($data->get_param('renders') && is_array($data->get_param('renders'))) {
                foreach ($data->get_param('renders') as $id => $post) {
                    $content = get_post($id);
                    if ($post && is_array($post) && !empty($post)) {
                        foreach ($post as $block_id => $html) {

                            $callback = function ($block) use ($block_id, $html) {
                                if (isset($html['renderedHTML']) && isset($block['attrs']['uniqueID']) && $block['attrs']['uniqueID'] === $block_id) {
                                    $parsed = parse_blocks($html['renderedHTML']);
                                    if (isset($parsed[0]) && isset($parsed[0]['innerBlocks'])) {
                                        $block['innerBlocks'] = $parsed[0]['innerBlocks'];
                                    }
                                    if (isset($parsed[0]) && isset($parsed[0]['innerContent'])) {
                                        $block['innerContent'] = $parsed[0]['innerContent'];
                                    }
                                    if (isset($block['attrs']['htmlRender']) && $block['attrs']['htmlRender']) {
                                        unset($block['attrs']['htmlRender']);
                                    }
                                    if (isset($html['additionals'])) {
                                        $block['attrs']['additionalClassesR'] = $html['additionals'];
                                    }
                                    if (isset($html['additionalsSection'])) {
                                        $block['attrs']['additionalClassesWrapperR'] = $html['additionalsSection'];
                                    }
                                }

                                return $block;
                            };

                            $content->post_content = \Cwicly\CCPostBlocks::getNewContent($content, $callback);
                        }
                        wp_update_post(wp_slash(
                            [
                                'ID' => $id,
                                'post_content' => $content->post_content,
                            ]
                        ), false, false);
                    }
                }
            }
            return ['success' => true, 'message' => 'Updated.'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function cc_isStyling_render($data)
    {
        try {
            if ($data->get_param('renders') && is_array($data->get_param('renders'))) {
                foreach ($data->get_param('renders') as $id => $post) {
                    $content = get_post($id);
                    if ($post && is_array($post) && !empty($post)) {
                        foreach ($post as $block_id => $html) {

                            $callback = function ($block) use ($block_id, $html) {
                                if (isset($html['renderedHTML']) && isset($block['attrs']['uniqueID']) && $block['attrs']['uniqueID'] === $block_id) {
                                    $parsed = parse_blocks($html['renderedHTML']);
                                    if (isset($parsed[0]) && isset($parsed[0]['innerBlocks'])) {
                                        $block['innerBlocks'] = $parsed[0]['innerBlocks'];
                                    }
                                    if (isset($parsed[0]) && isset($parsed[0]['innerContent'])) {
                                        $block['innerContent'] = $parsed[0]['innerContent'];
                                    }
                                    if (isset($block['attrs']['htmlRender']) && $block['attrs']['htmlRender']) {
                                        unset($block['attrs']['htmlRender']);
                                    }
                                    if (isset($html['additionals'])) {
                                        $block['attrs']['additionalClassesR'] = $html['additionals'];
                                    }
                                    if (isset($html['additionalsSection'])) {
                                        $block['attrs']['additionalClassesWrapperR'] = $html['additionalsSection'];
                                    }
                                    if (isset($html['isStyling']) && $html['isStyling']) {
                                        $block['attrs']['isStyling'] = $html['isStyling'];
                                    }
                                }

                                return $block;
                            };

                            $content->post_content = \Cwicly\CCPostBlocks::getNewContent($content, $callback);
                        }
                        wp_update_post(wp_slash(
                            [
                                'ID' => $id,
                                'post_content' => $content->post_content,
                            ]
                        ), false, false);
                    }
                }
            }
            return ['success' => true, 'message' => 'Updated.'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function cc_single_make_css($data)
    {
        try {

            $option = get_option('cwicly_breakpoints');
            $md = 992;
            if ($option && $option['md']) {
                $md = $option['md'];
            }
            $sm = 576;
            if ($option && $option['sm']) {
                $sm = $option['sm'];
            }

            global $wp_filesystem;
            if (!$wp_filesystem) {
                require_once ABSPATH . 'wp-admin/includes/file.php';
            }

            $allcss = '';
            if ($data->get_param('css')) {
                $allcss = $data->get_param('css');
            }
            if ($allcss) {
                foreach ($allcss as $key => $css) {

                    $global_fonts = array();
                    $common = array();
                    $font = array();
                    $responsive_lg = array();
                    $responsive_md = array();
                    $responsive_sm = array();

                    if ($css) {
                        foreach ($css['common'] as $value) {
                            array_push($common, $value);
                        }
                        foreach ($css['global'] as $value) {
                            array_push($global_fonts, $value);
                        }
                        foreach ($css['fontCSS'] as $value) {
                            array_push($font, $value);
                        }
                        foreach ($css['lg'] as $value) {
                            array_push($responsive_lg, $value);
                        }
                        foreach ($css['md'] as $value) {
                            array_push($responsive_md, $value);
                        }
                        foreach ($css['sm'] as $value) {
                            array_push($responsive_sm, $value);
                        }
                    }
                    $final_font = implode("", $font);
                    $final_global_font = implode("", $global_fonts);
                    $final_common = implode("", $common);
                    $final_lg = implode("", $responsive_lg);
                    $final_md = implode("", $responsive_md);
                    $final_sm = implode("", $responsive_sm);

                    if ($key) {
                        $keyForFile = str_replace('//', '_', $key);
                        $keyForFile = str_replace('/', '_', $keyForFile);
                        $filename = "cc-" . $keyForFile . ".css";
                    }

                    $upload_dir = wp_upload_dir();
                    $dir = trailingslashit($upload_dir['basedir']) . 'cwicly/css/';

                    WP_Filesystem(false, $upload_dir['basedir'], true);

                    if (!$wp_filesystem->is_dir($dir)) {
                        $wp_filesystem->mkdir($dir);
                    }

                    $content = '';
                    if ($final_md) {
                        $content .= '@media screen and (max-width: ' . $md . 'px){' . $final_md . '}';
                    }
                    if ($final_sm) {
                        $content .= '@media screen and (max-width: ' . $sm . 'px){' . $final_sm . '}';
                    }
                    $content = $final_font . $final_global_font . $final_common . $final_lg . $content;

                    if ($content) {
                        file_put_contents($dir . $filename, $content);
                    } else {
                        if (file_exists($dir . $filename)) {
                            unlink($dir . $filename);
                        }
                    }
                }
            }
            return ['success' => true, 'message' => 'Updated.'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function cc_make_css($data)
    {
        try {

            // CWICLY ADDITIONAL CLASSES
            if ($data->get_param('cwiclyClassesAdd')) {
                update_option('cwicly_classes_add', $data->get_param('cwiclyClassesAdd'));
            }
            // CWICLY ADDITIONAL CLASSES

            global $wp_filesystem;
            if (!$wp_filesystem) {
                require_once ABSPATH . 'wp-admin/includes/file.php';
            }

            $css = '';
            $global_fonts = array();
            $common = array();
            $font = array();
            $responsive_lg = array();
            $responsive_md = array();
            $responsive_sm = array();
            if ($data->get_param('css')) {
                $css = $data->get_param('css');
                update_option('cwicly_css', $css);
            }
            if ($css) {
                foreach ($css['common'] as $value) {
                    array_push($common, $value);
                }
                foreach ($css['global'] as $value) {
                    array_push($global_fonts, $value);
                }
                foreach ($css['fontCSS'] as $value) {
                    array_push($font, $value);
                }
                foreach ($css['lg'] as $value) {
                    array_push($responsive_lg, $value);
                }
                foreach ($css['md'] as $value) {
                    array_push($responsive_md, $value);
                }
                foreach ($css['sm'] as $value) {
                    array_push($responsive_sm, $value);
                }
            }
            $final_font = implode("", $font);
            $final_global_font = implode("", $global_fonts);
            $final_common = implode("", $common);
            $final_lg = implode("", $responsive_lg);
            $final_md = implode("", $responsive_md);
            $final_sm = implode("", $responsive_sm);

            $filename = "cc-main.css";

            $upload_dir = wp_upload_dir();
            $dir = trailingslashit($upload_dir['basedir']) . 'cwicly/';

            WP_Filesystem(false, $upload_dir['basedir'], true);

            if (!$wp_filesystem->is_dir($dir)) {
                $wp_filesystem->mkdir($dir);
            }

            $option = get_option('cwicly_breakpoints');
            $md = 992;
            if ($option && $option['md']) {
                $md = $option['md'];
            }
            $sm = 576;
            if ($option && $option['sm']) {
                $sm = $option['sm'];
            }

            file_put_contents($dir . $filename, $final_font . $final_global_font . $final_common . $final_lg . '@media screen and (max-width: ' . $md . 'px){' . $final_md . '}' . '@media screen and (max-width: ' . $sm . 'px){' . $final_sm . '}');

            return ['success' => true, 'message' => 'Updated.'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function all_posts()
    {
        try {
            $posts = array();
            $templateParts = array();
            $templateBlocks = array();
            $query = new WP_Query(array(
                'orderby' => 'date',
                'order' => 'ASC',
                'posts_per_page' => -1,
                'post_type' => 'wp_block',
                'post_status' => 'any',
                's' => 'cwicly/',
                'no_found_rows' => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false,
            ));
            foreach ($query->posts as $post) {
                if ($post->post_content) {
                    $posts['rb-' . $post->ID . ''] = $post->post_content;
                }
            }
            $query = new WP_Query(array(
                'orderby' => 'date',
                'order' => 'ASC',
                'posts_per_page' => -1,
                'post_type' => 'wp_template',
                'post_status' => 'any',
                // 's' => 'cwicly/'
                'no_found_rows' => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false,
            ));
            foreach ($query->posts as $post) {
                $templateBlocks[] = $post->post_name;
                if ($post->post_content) {
                    // $templateBlocks[] = $post->post_name;
                    $posts['tp-' . get_stylesheet() . '_' . $post->post_name . ''] = $post->post_content;
                }
            }
            $query = new WP_Query(array(
                'orderby' => 'date',
                'order' => 'ASC',
                'posts_per_page' => -1,
                'post_type' => 'wp_template_part',
                'post_status' => 'any',
                // 's' => 'cwicly/'
                'no_found_rows' => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false,
            ));
            foreach ($query->posts as $post) {
                $templateParts[] = $post->post_name;
                if ($post->post_content) {
                    // $templateParts[] = $post->post_name;
                    $posts['tp-' . get_stylesheet() . '_' . $post->post_name . ''] = $post->post_content;
                }
            }
            if (is_readable(get_stylesheet_directory() . '/block-templates/')) {
                $scan = scandir(get_stylesheet_directory() . '/block-templates/');
                if ($scan) {
                    foreach ($scan as $scanned) {
                        $path = get_stylesheet_directory() . '/block-templates/' . $scanned;
                        if (is_file($path)) {
                            $content = file_get_contents(get_stylesheet_directory() . '/block-templates/' . $scanned);
                            if ($content && strpos($content, 'cwicly') !== false && !in_array(basename($scanned, '.html'), $templateBlocks)) {
                                $posts[] = $content;
                            }
                        }
                    }
                }
            } else if (is_readable(get_stylesheet_directory() . '/templates/')) {
                $scan = scandir(get_stylesheet_directory() . '/templates/');
                if ($scan) {
                    foreach ($scan as $scanned) {
                        $path = get_stylesheet_directory() . '/templates/' . $scanned;
                        if (is_file($path)) {
                            $content = file_get_contents(get_stylesheet_directory() . '/templates/' . $scanned);
                            if ($content && strpos($content, 'cwicly') !== false && !in_array(basename($scanned, '.html'), $templateBlocks)) {
                                $posts[] = $content;
                            }
                        }
                    }
                }
            }
            if (is_readable(get_stylesheet_directory() . '/parts/')) {
                $scan = scandir(get_stylesheet_directory() . '/parts/');
                if ($scan) {
                    foreach ($scan as $scanned) {
                        $path = get_stylesheet_directory() . '/parts/' . $scanned;
                        if (is_file($path)) {
                            $content = file_get_contents(get_stylesheet_directory() . '/parts/' . $scanned);
                            if ($content && strpos($content, 'cwicly') !== false && !in_array(basename($scanned, '.html'), $templateParts)) {
                                $posts[] = $content;
                            }
                        }
                    }
                }
            } else if (is_readable(get_stylesheet_directory() . '/block-template-parts/')) {
                $scan = scandir(get_stylesheet_directory() . '/block-template-parts/');
                if ($scan) {
                    foreach ($scan as $scanned) {
                        $path = get_stylesheet_directory() . '/block-template-parts/' . $scanned;
                        if (is_file($path)) {
                            $content = file_get_contents(get_stylesheet_directory() . '/block-template-parts/' . $scanned);
                            if ($content && strpos($content, 'cwicly') !== false && !in_array(basename($scanned, '.html'), $templateParts)) {
                                $posts[] = $content;
                            }
                        }
                    }
                }
            }
            $query = new WP_Query(array(
                'orderby' => 'date',
                'order' => 'ASC',
                'posts_per_page' => -1,
                'post_type' => 'any',
                'post_status' => 'any',
                's' => 'cwicly/',
                'no_found_rows' => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false,
            ));
            foreach ($query->posts as $post) {
                if ($post->post_content && $post->ID) {
                    $posts['post-' . $post->ID . ''] = $post->post_content;
                }
            }
            return ['success' => true, 'parsed' => $posts];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function all_posts_render()
    {
        try {
            $posts = array();
            $templateParts = array();
            $templateBlocks = array();
            $query = new WP_Query(array(
                'orderby' => 'date',
                'order' => 'ASC',
                'posts_per_page' => -1,
                'post_type' => 'wp_block',
                'post_status' => 'any',
                's' => 'cwicly/',
                'no_found_rows' => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false,
            ));
            foreach ($query->posts as $post) {
                if ($post->post_content) {
                    $posts[] = array(
                        'content' => $post->post_content,
                        'id' => $post->ID,
                        'type' => $post->post_type,
                    );
                }
            }
            $query = new WP_Query(array(
                'orderby' => 'date',
                'order' => 'ASC',
                'posts_per_page' => -1,
                'post_type' => 'wp_template',
                'post_status' => 'any',
                // 's' => 'cwicly/'
                'no_found_rows' => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false,
            ));
            foreach ($query->posts as $post) {
                $templateBlocks[] = $post->post_name;
                if ($post->post_content) {
                    // $templateBlocks[] = $post->post_name;
                    $posts[] = array(
                        'content' => $post->post_content,
                        'id' => $post->ID,
                        'type' => $post->post_type,
                    );
                }
            }
            if (is_readable(get_stylesheet_directory() . '/block-templates/')) {
                $scan = scandir(get_stylesheet_directory() . '/block-templates/');
                if ($scan) {
                    foreach ($scan as $scanned) {
                        $path = get_stylesheet_directory() . '/block-templates/' . $scanned;
                        if (is_file($path)) {
                            $content = file_get_contents(get_stylesheet_directory() . '/block-templates/' . $scanned);
                            if ($content && strpos($content, 'cwicly') !== false && !in_array(basename($scanned, '.html'), $templateBlocks)) {
                                $the_slug = basename($scanned, '.html');
                                $args = array(
                                    'name' => $the_slug,
                                    'post_type' => 'wp_template',
                                    'post_status' => 'publish',
                                    'numberposts' => 1,
                                );
                                $my_posts = get_posts($args);
                                if ($my_posts) {
                                } else {
                                    $title = '';
                                    if (isset($default_template_types[$the_slug])) {
                                        $title = $default_template_types[$the_slug]['title'];
                                    } else {
                                        $title = $the_slug;
                                    }

                                    // Gather post data.
                                    $my_post = array(
                                        'post_title' => $title,
                                        'post_content' => $content,
                                        'post_status' => 'publish',
                                        'post_author' => 1,
                                        'post_type' => 'wp_template',
                                        'post_name' => $the_slug,
                                        'name' => $the_slug,
                                    );

                                    // Insert the post into the database.
                                    $posts[] = array(
                                        'content' => $content,
                                        'id' => wp_insert_post($my_post),
                                        'type' => 'wp_template',
                                    );
                                }
                            }
                        }
                    }
                }
            } else if (is_readable(get_stylesheet_directory() . '/templates/')) {
                $scan = scandir(get_stylesheet_directory() . '/templates/');
                $default_template_types = get_default_block_template_types();
                if ($scan) {
                    foreach ($scan as $scanned) {
                        $path = get_stylesheet_directory() . '/templates/' . $scanned;
                        if (is_file($path)) {
                            $content = file_get_contents(get_stylesheet_directory() . '/templates/' . $scanned);
                            if ($content && strpos($content, 'cwicly') !== false && !in_array(basename($scanned, '.html'), $templateBlocks)) {
                                $the_slug = basename($scanned, '.html');
                                $args = array(
                                    'name' => $the_slug,
                                    'post_type' => 'wp_template',
                                    'post_status' => 'publish',
                                    'numberposts' => 1,
                                );
                                $my_posts = get_posts($args);
                                if ($my_posts) {
                                } else {
                                    $title = '';
                                    $description = '';
                                    if (isset($default_template_types[$the_slug])) {
                                        $title = $default_template_types[$the_slug]['title'];
                                        $description = $default_template_types[$the_slug]['description'];
                                    } else {
                                        $title = $the_slug;
                                    }

                                    // Gather post data.
                                    $my_post = array(
                                        'post_title' => $title,
                                        'post_excerpt' => $description,
                                        'meta_input' => array(
                                            'origin' => 'theme',
                                        ),
                                        'tax_input' => array(
                                            'wp_theme' => wp_get_theme()->get_stylesheet(),
                                        ),
                                        'post_content' => $content,
                                        'post_status' => 'publish',
                                        'post_author' => 1,
                                        'post_type' => 'wp_template',
                                        'post_name' => $the_slug,
                                        'name' => $the_slug,
                                    );

                                    $id = wp_insert_post($my_post);
                                    $posts[] = array(
                                        'content' => $content,
                                        'id' => $id,
                                        'type' => 'wp_template',
                                    );
                                }
                            }
                        }
                    }
                }
            }
            $query = new WP_Query(array(
                'orderby' => 'date',
                'order' => 'ASC',
                'posts_per_page' => -1,
                'post_type' => 'wp_template_part',
                'post_status' => 'any',
                // 's' => 'cwicly/'
                'no_found_rows' => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false,
            ));
            foreach ($query->posts as $post) {
                $templateParts[] = $post->post_name;
                if ($post->post_content) {
                    // $templateParts[] = $post->post_name;
                    $posts[] = array(
                        'content' => $post->post_content,
                        'id' => $post->ID,
                        'type' => $post->post_type,
                    );
                }
            }
            $query = new WP_Query(array(
                'orderby' => 'date',
                'order' => 'ASC',
                'posts_per_page' => -1,
                'post_type' => 'any',
                'post_status' => 'any',
                's' => 'cwicly/',
                'no_found_rows' => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false,
            ));
            foreach ($query->posts as $post) {
                if ($post->post_content) {
                    $posts[] = array(
                        'content' => $post->post_content,
                        'id' => $post->ID,
                        'type' => $post->post_type,
                    );
                }
            }
            return ['success' => true, 'parsed' => $posts];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function all_posts_render_ids()
    {
        try {
            $posts = array();
            if (is_readable(get_stylesheet_directory() . '/block-templates/')) {
                $scan = scandir(get_stylesheet_directory() . '/block-templates/');
                if ($scan) {
                    foreach ($scan as $scanned) {
                        $path = get_stylesheet_directory() . '/block-templates/' . $scanned;
                        if (is_file($path)) {
                            $content = file_get_contents(get_stylesheet_directory() . '/block-templates/' . $scanned);
                            if ($content && strpos($content, 'cwicly') !== false) {
                                $the_slug = basename($scanned, '.html');
                                $args = array(
                                    'name' => $the_slug,
                                    'post_type' => 'wp_template',
                                    'post_status' => 'publish',
                                    'numberposts' => 1,
                                );
                                $my_posts = get_posts($args);
                                if ($my_posts && $my_posts[0]->ID) {
                                    $posts[] = $my_posts[0]->ID;
                                } else {
                                    $title = '';
                                    if (isset($default_template_types[$the_slug])) {
                                        $title = $default_template_types[$the_slug]['title'];
                                    } else {
                                        $title = $the_slug;
                                    }

                                    // Gather post data.
                                    $my_post = array(
                                        'post_title' => $title,
                                        'post_content' => $content,
                                        'post_status' => 'publish',
                                        'post_author' => 1,
                                        'post_type' => 'wp_template',
                                        'post_name' => $the_slug,
                                        'name' => $the_slug,
                                    );

                                    // Insert the post into the database.
                                    $posts[] = wp_insert_post($my_post);
                                }
                            }
                        }
                    }
                }
            } else if (is_readable(get_stylesheet_directory() . '/templates/')) {
                $scan = scandir(get_stylesheet_directory() . '/templates/');
                $default_template_types = get_default_block_template_types();
                if ($scan) {
                    foreach ($scan as $scanned) {
                        $path = get_stylesheet_directory() . '/templates/' . $scanned;
                        if (is_file($path)) {
                            $content = file_get_contents(get_stylesheet_directory() . '/templates/' . $scanned);
                            if ($content && strpos($content, 'cwicly') !== false) {
                                $the_slug = basename($scanned, '.html');
                                $args = array(
                                    'name' => $the_slug,
                                    'post_type' => 'wp_template',
                                    'post_status' => 'publish',
                                    'numberposts' => 1,
                                );
                                $my_posts = get_posts($args);
                                if ($my_posts && $my_posts[0]->ID) {
                                    $posts[] = $my_posts[0]->ID;
                                } else {
                                    $title = '';
                                    $description = '';
                                    if (isset($default_template_types[$the_slug])) {
                                        $title = $default_template_types[$the_slug]['title'];
                                        $description = $default_template_types[$the_slug]['description'];
                                    } else {
                                        $title = $the_slug;
                                    }

                                    // Gather post data.
                                    $my_post = array(
                                        'post_title' => $title,
                                        'post_excerpt' => $description,
                                        'meta_input' => array(
                                            'origin' => 'theme',
                                        ),
                                        'tax_input' => array(
                                            'wp_theme' => wp_get_theme()->get_stylesheet(),
                                        ),
                                        'post_content' => $content,
                                        'post_status' => 'publish',
                                        'post_author' => 1,
                                        'post_type' => 'wp_template',
                                        'post_name' => $the_slug,
                                        'name' => $the_slug,
                                    );

                                    // Insert the post into the database.
                                    $posts[] = wp_insert_post($my_post);
                                }
                            }
                        }
                    }
                }
            }
            $query = new WP_Query(array(
                'orderby' => 'date',
                'order' => 'ASC',
                'posts_per_page' => -1,
                'post_type' => 'wp_block',
                'post_status' => 'any',
                // 's' => 'cwicly/',
                'no_found_rows' => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false,
                'fields' => 'ids',
            ));
            foreach ($query->posts as $post) {
                $posts[] = $post;
            }
            $query = new WP_Query(array(
                'orderby' => 'date',
                'order' => 'ASC',
                'posts_per_page' => -1,
                'post_type' => 'wp_template',
                'post_status' => 'any',
                // 's' => 'cwicly/'
                'no_found_rows' => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false,
                'fields' => 'ids',
            ));
            foreach ($query->posts as $post) {
                $posts[] = $post;
            }
            $query = new WP_Query(array(
                'orderby' => 'date',
                'order' => 'ASC',
                'posts_per_page' => -1,
                'post_type' => 'wp_template_part',
                'post_status' => 'any',
                // 's' => 'cwicly/'
                'no_found_rows' => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false,
                'fields' => 'ids',
            ));
            foreach ($query->posts as $post) {
                $posts[] = $post;
            }
            $query = new WP_Query(array(
                'orderby' => 'date',
                'order' => 'ASC',
                'posts_per_page' => -1,
                'post_type' => 'any',
                'post_status' => 'any',
                's' => 'cwicly/',
                'no_found_rows' => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false,
                'fields' => 'ids',
            ));
            foreach ($query->posts as $post) {
                $posts[] = $post;
            }
            return $posts;
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function cc_get_posts($data)
    {
        try {
            if ($data->get_param('ids')) {
                $ids = $data->get_param('ids');
                $ids = explode(',', $ids);
                $posts = array();
                foreach ($ids as $id) {
                    $post = get_post($id);
                    $posts[] = array(
                        'content' => $post->post_content,
                        'id' => $post->ID,
                        'type' => $post->post_type,
                        'name' => $post->post_name,
                        'stylesheet' => get_stylesheet(),
                    );
                }
                return $posts;
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }

    }

    public function get_options($data)
    {
        try {
            if ($data->get_param('getCapabilities')) {
                $options = get_role('administrator')->capabilities;
            }
            if ($data->get_param('option')) {
                if ($data->get_param('option') === 'theone') {
                    $options = get_option('cwicly_license_check');
                } else {
                    $options = get_option($data->get_param('option'));
                }
            }
            return ['success' => true, 'settings' => $options];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function cc_update_options($data)
    {
        try {
            $value = '';
            if ($data->get_param('value')) {
                $value = $data->get_param('value');
            }
            if ($data->get_param('option')) {
                update_option($data->get_param('option'), $value);
            }
            return ['success' => true, 'message' => 'Updated.'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function cc_get_svgs()
    {
        try {
            $settings = '';
            $svg_cols = get_option("cwicly_svg_cols", array());
            if ($svg_cols) {
                $settings = $svg_cols;
            }

            return ['success' => true, 'settings' => $settings];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function cc_get_fonts()
    {
        try {
            $settings = '';
            $font_cols = get_option("cwicly_font_cols", array());
            if ($font_cols) {
                $settings = $font_cols;
            }

            return ['success' => true, 'settings' => $settings];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function get_cwicly_license()
    {
        try {
            {
                if (defined('CC_LICENSE_KEY')) {
                    return CC_LICENSE_KEY;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function update_global_css($request)
    {
        try {
            $params = $request->get_params();
            if (!isset($params['settings'])) {
                throw new Exception("Settings parameter is missing!");
            }

            $settings = $params['settings'];

            if (get_option('cwicly_global_css') == false) {
                add_option('cwicly_global_css', $settings);
            } else {
                update_option('cwicly_global_css', $settings);
            }

            return ['success' => true, 'message' => "Global CSS updated!"];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function update_global_classes($request)
    {
        try {
            $params = $request->get_params();
            if (!isset($params['settings'])) {
                throw new Exception("Settings parameter is missing!");
            }

            $settings = $params['settings'];

            cc_make_global_css($settings);

            return ['success' => true, 'message' => "Global Classes CSS updated!"];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function get_global_styles()
    {
        try {

            $settings = get_option('cwicly_global_styles');

            $settings = $settings == false ? json_decode('{}') : json_decode($settings);

            return ['success' => true, 'settings' => $settings];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function update_global_styles($request)
    {
        try {
            $params = $request->get_params();
            if (!isset($params['settings'])) {
                throw new Exception("Settings parameter is missing!");
            }

            $settings = $params['settings'];

            if (get_option('cwicly_global_styles') == false) {
                add_option('cwicly_global_styles', $settings);
            } else {
                update_option('cwicly_global_styles', $settings);
            }

            return ['success' => true, 'message' => "Global style updated!"];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function cc_editor_save($request)
    {
        try {
            $params = $request->get_params();

            if (isset($params['globalClasses'])) {
                update_option('cwicly_global_classes', $params['globalClasses']);
            }
            if (isset($params['globalInteractions'])) {
                update_option('cwicly_global_interactions', $params['globalInteractions']);
            }
            if (isset($params['globalClassesRendered'])) {
                update_option('cwicly_global_classes_rendered', $params['globalClassesRendered']);
            }
            if (isset($params['globalStylesheets'])) {
                update_option('cwicly_global_stylesheets', $params['globalStylesheets']);
            }
            if (isset($params['globalSettings'])) {
                update_option('cwicly_global_styles', $params['globalSettings']);
            }
            if (isset($params['globalCSS'])) {
                update_option('cwicly_global_css', $params['globalCSS']);
            }
            if (isset($params['breakpoints'])) {
                update_option('cwicly_breakpoints', $params['breakpoints']);
            }
            if (isset($params['globalPseudos'])) {
                update_option('cwicly_pseudos', $params['globalPseudos']);
            }
            if (isset($params['sectionDefaults'])) {
                update_option('cwicly_section_defaults', $params['sectionDefaults']);
            }
            if (isset($params['externalClasses'])) {
                update_option('cwicly_external_classes', $params['externalClasses']);
            }
            if (isset($params['globalClassMaker'])) {
                cc_make_global_css($params['globalClassMaker']);
            }
            if (isset($params['globalStylesheetSave'])) {
                cc_make_global_stylesheets($params['globalStylesheetSave']);
            }
            return ['success' => true, 'message' => "All saved! Thanks."];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function cc_search_posts()
    {
        try {
            $types_raw = get_post_types(array('public' => true), 'objects');
            $types = array();

            foreach ($types_raw as $type) {

                $types[] = array(
                    'label' => $type->label,
                    'value' => ucfirst(($type->rest_base) ? $type->rest_base : $type->name),
                );
            }
            return ['success' => true, 'posts' => $types];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function cc_get_all_acf_fields()
    {
        try {
            $groups = acf_get_field_groups();
            return ['success' => true, 'fields' => $groups];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function cc_editor_start()
    {
        try {

            // ROLES
            global $wp_roles;
            $all_roles = $wp_roles->roles;
            $editable_roles = apply_filters('editable_roles', $all_roles);
            $roles = $editable_roles;
            // ROLES

            // CAPABILITIES
            $capabilities = get_role('administrator')->capabilities;
            // CAPABILITIES

            // GLOBAL STYLESHEETS
            $globalstylesheets = get_option('cwicly_global_stylesheets');
            // GLOBAL STYLESHEETS

            // GLOBAL INTERACTIONS
            $globalinteractions = get_option('cwicly_global_interactions');
            // GLOBAL INTERACTIONS

            // GLOBAL CLASSES
            $globalclasses = get_option('cwicly_global_classes');
            // GLOBAL CLASSES

            // GLOBAL CLASSES RENDERED
            $globalclassesrendered = get_option('cwicly_global_classes_rendered');
            // GLOBAL CLASSES RENDERED

            // GLOBAL CLASSES
            // $additionalclasses = get_options('cwicly_classes_add');
            // GLOBAL CLASSES

            // LICENSE CHECK
            $licensecheck = get_option('cwicly_license_check');
            // LICENSE CHECK

            // BREAKPOINTS
            $breakpoints = get_option('cwicly_breakpoints');
            // BREAKPOINTS

            // GLOBAL FONTS
            $globalfonts = get_option('cwicly_global_fonts');
            // GLOBAL FONTS

            // LOCAL FONTS
            $localfonts = get_option('cwicly_local_fonts');
            // LOCAL FONTS

            // LOCAL ACTIVE FONTS
            $localactivefonts = get_option('cwicly_local_active_fonts');
            // LOCAL ACTIVE FONTS

            // HEARTBEAT
            $heartbeat = get_option('cwicly_heartbeat');
            // HEARTBEAT

            // SECTION DEFAULTS
            $sectiondefaults = get_option('cwicly_section_defaults');
            // SECTION DEFAULTS

            // POSTS PER PAGE DEFAULTS
            $postsperpage = get_option('posts_per_page');
            // POSTS PER PAGE DEFAULTS

            //  GLOBAL PARTS
            $globalparts = get_option('cwicly_global_parts');
            // GLOBAL PARTS

            // CWICLY PSEUDOS
            $cwiclypseudos = get_option('cwicly_pseudos');
            // CWICLY PSEUDOS

            // CWICLY COLLECTION
            $cwiclycollection = get_option('cwicly_collection');
            // CWICLY COLLECTION

            // CWICLY FONT COLS
            // $cwiclyfontcols = get_option('cwicly_font_cols');
            // CWICLY FONT COLS

            // WOO TAX CLASSES SLUG
            $wootaxclasses = '';
            if (CC_WOOCOMMERCE) {
                $wootaxclasses = WC_Tax::get_tax_class_slugs();
            }
            // WOO TAX CLASSES SLUG

            // WOO PRODUCT TYPES
            $wooproducttypes = '';
            if (CC_WOOCOMMERCE) {
                $wooproducttypes = wc_get_product_types();
            }
            // WOO PRODUCT TYPES

            // WOO SHIPPING CLASSES
            $wooshippingclasses = '';
            if (CC_WOOCOMMERCE) {
                $WC_Shipping = new WC_Shipping();
                $wooshippingclasses = $WC_Shipping->get_shipping_classes();
            }
            // WOO SHIPPING CLASSES

            // ALL IMAGE SIZES
            $allimagesizes = cc_get_all_image_sizes();
            // ALL IMAGE SIZES

            // ROLE EDITOR
            $roleeditor = get_option('cwicly_role_editor');
            // ROLE EDITOR

            // EXTERNAL CLASSES
            $externalclasses = get_option('cwicly_external_classes');
            // EXTERNAL CLASSES

            $globalstyles = get_option('cwicly_global_styles');

            $globalstyles = $globalstyles == false ? '{}' : $globalstyles;

            return [
                'success' => true,
                'roles' => $roles,
                'capabilities' => $capabilities,
                'globalstylesheets' => $globalstylesheets,
                'globalinteractions' => $globalinteractions,
                'globalclasses' => $globalclasses,
                'globalclassesrendered' => $globalclassesrendered,
                // 'additionalclasses' => $additionalclasses,
                'licensecheck' => $licensecheck,
                'breakpoints' => $breakpoints,
                'globalfonts' => $globalfonts,
                'localfonts' => $localfonts,
                'localactivefonts' => $localactivefonts,
                'heartbeat' => $heartbeat,
                'sectiondefaults' => $sectiondefaults,
                'wootaxclasses' => $wootaxclasses,
                'wooshippingclasses' => $wooshippingclasses,
                'wooproducttypes' => $wooproducttypes,
                'cwiclypseudos' => $cwiclypseudos,
                'cwiclycollection' => $cwiclycollection,
                // 'cwiclyfontcols' => $cwiclyfontcols,
                'postsperpage' => $postsperpage,
                'globalparts' => $globalparts,
                'allimagesizes' => $allimagesizes,
                'roleeditor' => $roleeditor,
                'externalclasses' => $externalclasses,

                'globalstyles' => $globalstyles,
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    public function cc_get_site_info($data)
    {
        try {
            $authormeta = '';
            $comments = '';
            $usermeta = '';
            $bloginfo = '';
            $groupfields = '';
            $acffield = '';
            $acffieldobject = '';
            $size = '';
            if (null !== ($data->get_param('getimagesize'))) {
                $size = getimagesize($data->get_param('getimagesize'));
            }
            if (null !== ($data->get_param('acfgroupid'))) {
                $groupfields = acf_get_fields($data->get_param('acfgroupid'));
            }
            if (null !== ($data->get_param('acfgroupfields'))) {
                $groups = acf_get_field_groups();
                $groupfields = [];
                foreach ($groups as $value) {
                    $groupfields[] = acf_get_fields($value['ID']);
                }
            }
            if (null !== ($data->get_param('postid'))) {
                $post_id = $data->get_param('postid');
            }
            if (null !== ($data->get_param('acffieldid'))) {
                $acffield = get_field($data->get_param('acffieldid'), $post_id);
                if ($post_id) {
                    $$post_id = json_decode($post_id);
                    $acffieldobject = get_field_object($data->get_param('acffieldid'), $post_id)['type'];
                } else {
                    $acffieldobject = get_field_object($data->get_param('acffieldid'))['type'];
                }
            }
            if (isset($post_id) && null !== $post_id) {
                $comments = get_comments_number($post_id);
            }
            if (null !== ($data->get_param('role'))) {
                if ($data->get_param('role') === 'author') {
                    $authormeta = nl2br(get_the_author_meta($data->get_param('authormeta'), $data->get_param('authorid')));
                }
                if ($data->get_param('role') === 'user') {
                    $current_user_id_meta = get_userdata(get_current_user_id());
                    $demand = $data->get_param('usermeta');
                    $usermeta = $current_user_id_meta->$demand;
                }
            }
            if (null !== ($data->get_param('bloginfo'))) {
                if ($data->get_param('bloginfo') === 'getposttaxonomies') {
                    $bloginfo = get_post_taxonomies($post_id);
                }
                if ($data->get_param('bloginfo') === 'getallblocks') {
                    $bloginfo = WP_Block_Type_Registry::get_instance()->get_all_registered();
                }
                if ($data->get_param('bloginfo') === 'gettheterms') {
                    $bloginfo = get_the_terms($post_id, $data->get_param('taxonomy'));
                }
                if ($data->get_param('bloginfo') === 'getterms') {
                    $bloginfo = get_terms(array(
                        'taxonomy' => $data->get_param('array') ? explode(',', $data->get_param('array')) : array(),
                        'orderby' => $data->get_param('orderby') ? $data->get_param('orderby') : 'name',
                        'order' => $data->get_param('order') ? $data->get_param('order') : 'ASC',
                        'hide_empty' => $data->get_param('hideempty'),
                        'exclude' => $data->get_param('exclude') ? $data->get_param('exclude') : '',
                        // 'offset' => $data->get_param('offset') ? $data->get_param('orderby') : '',
                        // 'parent'   => 0
                    ));
                }
                if ($data->get_param('bloginfo') === 'users') {
                    if ($data->get_param('keyword')) {
                        $search = $data->get_param('keyword');
                        $bloginfo = get_users(array('search' => $search));
                    } else {
                        $final = [];

                        $users = get_users(array('fields' => array('ID', 'user_login')));
                        // foreach ($users as $user) {
                        //     $user_meta = get_userdata($user);
                        //     $user_roles = $user_meta->roles;
                        //     $final[] = array("id" => $user, "roles" => $user_roles);
                        // }
                        $bloginfo = $users;
                    }
                }
                if ($data->get_param('bloginfo') === 'userroles') {
                    global $wp_roles;

                    $all_roles = $wp_roles->roles;
                    $editable_roles = apply_filters('editable_roles', $all_roles);

                    $bloginfo = $editable_roles;
                }
                if ($data->get_param('bloginfo') === 'pluginurl') {
                    $bloginfo = plugin_dir_url(__DIR__);
                }
                if ($data->get_param('bloginfo') === 'sitetitle') {
                    $bloginfo = get_bloginfo('name');
                }
                if ($data->get_param('bloginfo') === 'featuredimage') {
                    if (has_post_thumbnail($post_id)) {
                        $bloginfo = get_the_post_thumbnail_url($post_id);
                    } else {
                        $bloginfo = 'nofeaturedimage';
                    }
                }
                if ($data->get_param('bloginfo') === 'sitelogo') {
                    $bloginfo = get_custom_logo();
                }
                if ($data->get_param('bloginfo') === 'authorpicturewithid') {
                    $bloginfo = get_avatar_url(get_post_meta('post_author', $post_id));
                }
                if ($data->get_param('bloginfo') === 'getattributeterms') {
                    $bloginfo = array();
                    $variations = get_terms($data->get_param('term'));
                    foreach ($variations as $index => $element) {
                        $bloginfo[$index]['label'] = $element->name;
                        $bloginfo[$index]['value'] = $element->slug;
                        $bloginfo[$index]['id'] = $element->term_id;
                        if ($data->get_param('type')) {
                            if ($data->get_param('type') === '_cwicly_image_id') {
                                $bloginfo[$index]['extra'] = wp_get_attachment_url(get_term_meta($element->term_id, $data->get_param('type'), true));
                            } else {
                                $bloginfo[$index]['extra'] = get_term_meta($element->term_id, $data->get_param('type'), true);
                            }
                        }
                    }
                }
                if ($data->get_param('bloginfo') === 'authorpicture') {
                    $bloginfo = get_avatar_url($data->get_param('authorid'));
                }
                if ($data->get_param('bloginfo') === 'userpicture') {
                    $bloginfo = get_avatar_url(wp_get_current_user());
                }
                if ($data->get_param('bloginfo') === 'sitetagline') {
                    $bloginfo = get_bloginfo('description');
                }
                if ($data->get_param('bloginfo') === 'currentdate') {
                    $bloginfo = time();
                }
                if ($data->get_param('bloginfo') === 'postexcerpt') {
                    if (has_excerpt($post_id)) {
                        $bloginfo = wp_strip_all_tags(get_the_excerpt($post_id));
                    }
                }
                if ($data->get_param('bloginfo') === 'archivedescription') {
                    $bloginfo = get_the_archive_description();
                }
                if ($data->get_param('bloginfo') === 'previouspost' || $data->get_param('bloginfo') === 'nextpost') {
                    $taxonomy = 'category';
                    $in_same_term = false;
                    $excluded_terms = '';
                    if ($data->get_param('taxonomy')) {
                        $taxonomy = $data->get_param('taxonomy');
                    }
                    if ($data->get_param('in_same_term') === 'true') {
                        $in_same_term = true;
                    }
                    if ($data->get_param('excluded_terms')) {
                        $excluded_terms = $data->get_param('excluded_terms');
                    }
                    global $post;
                    $oldGlobal = $post;
                    $post = get_post($post_id);
                    $poster = '';
                    if ($data->get_param('bloginfo') === 'previouspost') {
                        $poster = get_previous_post($in_same_term, $excluded_terms, $taxonomy);
                    } else if ($data->get_param('bloginfo') === 'nextpost') {
                        $poster = get_next_post($in_same_term, $excluded_terms, $taxonomy);
                    }
                    $post = $oldGlobal;

                    if ('' == $poster) {
                        return 0;
                    }

                    $bloginfo = array('id' => $poster->ID, 'postType' => $poster->post_type);
                }
                if ($data->get_param('bloginfo') === 'archivetitle') {
                    $bloginfo = get_the_archive_title();
                }
                if ($data->get_param('bloginfo') === 'postcategory' && $post_id) {
                    $bloginfo = get_cat_name($post_id);
                }
                if ($data->get_param('bloginfo') === 'tags') {
                    $bloginfo = get_the_tags($post_id);
                }
                if ($data->get_param('bloginfo') === 'title') {
                    $bloginfo = esc_html(get_the_title($post_id));
                }
                if ($data->get_param('bloginfo') === 'postdate') {
                    if ($data->get_param('datetype') === 'modified') {
                        $bloginfo = esc_html(get_post_modified_time('c', false, $post_id));
                    }
                    if ($data->get_param('datetype') === 'modified' && $data->get_param('dategmt') === 'true') {
                        $bloginfo = esc_html(get_post_modified_time('c', true, $post_id));
                    }
                    if ($data->get_param('datetype') === 'published') {
                        $bloginfo = esc_html(get_post_time('c', false, $post_id));
                    }
                    if ($data->get_param('datetype') === 'published' && $data->get_param('dategmt') === 'true') {
                        $bloginfo = esc_html(get_post_time('c', true, $post_id));
                    }
                }
                if ($data->get_param('bloginfo') === 'time') {
                    if ($data->get_param('datetype') === 'modified') {
                        $bloginfo = esc_html(get_post_modified_time('c', false, $post_id));
                    }
                    if ($data->get_param('datetype') === 'modified' && $data->get_param('dategmt') === 'true') {
                        $bloginfo = esc_html(get_post_modified_time('c', true, $post_id));
                    }
                    if ($data->get_param('datetype') === 'published') {
                        $bloginfo = esc_html(get_post_time('c', false, $post_id));
                    }
                    if ($data->get_param('datetype') === 'published' && $data->get_param('dategmt') === 'true') {
                        $bloginfo = esc_html(get_post_time('c', true, $post_id));
                    }
                }
            }
            // WOOCOMMERCE
            if (null !== ($data->get_param('woocommerce')) && $data->get_param('woocommerce') === 'allinfo' && null !== ($data->get_param('postid'))) {
                $product = wc_get_product($post_id);
                $groupfields = array();
                // if ($product->get_type() != 'variable') {
                if ($product) {
                    $price = $product->get_price();
                    $saleprice = $product->get_sale_price();
                    $regularprice = $product->get_regular_price();
                    $groupfields['salepercentage'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::percentage_calculator($product)));
                    $groupfields['price'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($price, '')));
                    $groupfields['price_formatted'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($price, 'formatted')));
                    $groupfields['price_formattedcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($price, 'formattedcurrency')));
                    $groupfields['price_formattedtax'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($price, 'formattedtax')));
                    $groupfields['price_formattedtaxcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($price, 'formattedtaxcurrency')));
                    $groupfields['saleprice'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($saleprice, '')));
                    $groupfields['saleprice_formatted'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($saleprice, 'formatted')));
                    $groupfields['saleprice_formattedcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($saleprice, 'formattedcurrency')));
                    $groupfields['saleprice_formattedtax'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($saleprice, 'formattedtax')));
                    $groupfields['saleprice_formattedtaxcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($saleprice, 'formattedtaxcurrency')));
                    $groupfields['regularprice'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($regularprice, '')));
                    $groupfields['regularprice_formatted'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($regularprice, 'formatted')));
                    $groupfields['regularprice_formattedcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($regularprice, 'formattedcurrency')));
                    $groupfields['regularprice_formattedtax'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($regularprice, 'formattedtax')));
                    $groupfields['regularprice_formattedtaxcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($regularprice, 'formattedtaxcurrency')));
                }
                $groupfields['currency'] = get_woocommerce_currency();
                $groupfields['currencysymbol'] = html_entity_decode(get_woocommerce_currency_symbol());
                if ($product && $product->get_type() === 'variable') {
                    $variationminprice = $product->get_variation_price();
                    $variationmaxprice = $product->get_variation_price('max');
                    $variationregnminprice = $product->get_variation_regular_price();
                    $variationregnmaxprice = $product->get_variation_regular_price('max');
                    $variationsalenminprice = $product->get_variation_sale_price();
                    $variationsalenmaxprice = $product->get_variation_sale_price('max');

                    $groupfields['variationmin'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationminprice, '')));
                    $groupfields['variationmin_formatted'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationminprice, 'formatted')));
                    $groupfields['variationmin_formattedcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationminprice, 'formattedcurrency')));
                    $groupfields['variationmin_formattedtax'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationminprice, 'formattedtax')));
                    $groupfields['variationmin_formattedtaxcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationminprice, 'formattedtaxcurrency')));
                    $groupfields['variationmax'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationmaxprice, 'formatted')));
                    $groupfields['variationmax_formatted'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationmaxprice, 'formatted')));
                    $groupfields['variationmax_formattedcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationmaxprice, 'formattedcurrency')));
                    $groupfields['variationmax_formattedtax'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationmaxprice, 'formattedtax')));
                    $groupfields['variationmax_formattedtaxcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationmaxprice, 'formattedtaxcurrency')));

                    $groupfields['variationregmin'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationregnminprice, '')));
                    $groupfields['variationregmin_formatted'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationregnminprice, 'formatted')));
                    $groupfields['variationregmin_formattedcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationregnminprice, 'formattedcurrency')));
                    $groupfields['variationregmin_formattedtax'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationregnminprice, 'formattedtax')));
                    $groupfields['variationregmin_formattedtaxcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationregnminprice, 'formattedtaxcurrency')));
                    $groupfields['variationregmax'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationregnmaxprice, 'formatted')));
                    $groupfields['variationregmax_formatted'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationregnmaxprice, 'formatted')));
                    $groupfields['variationregmax_formattedcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationregnmaxprice, 'formattedcurrency')));
                    $groupfields['variationregmax_formattedtax'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationregnmaxprice, 'formattedtax')));
                    $groupfields['variationregmax_formattedtaxcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationregnmaxprice, 'formattedtaxcurrency')));

                    $groupfields['variationsalemin'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationsalenminprice, '')));
                    $groupfields['variationsalemin_formatted'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationsalenminprice, 'formatted')));
                    $groupfields['variationsalemin_formattedcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationsalenminprice, 'formattedcurrency')));
                    $groupfields['variationsalemin_formattedtax'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationsalenminprice, 'formattedtax')));
                    $groupfields['variationsalemin_formattedtaxcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationsalenminprice, 'formattedtaxcurrency')));
                    $groupfields['variationsalemax'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationsalenmaxprice, 'formatted')));
                    $groupfields['variationsalemax_formatted'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationsalenmaxprice, 'formatted')));
                    $groupfields['variationsalemax_formattedcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationsalenmaxprice, 'formattedcurrency')));
                    $groupfields['variationsalemax_formattedtax'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationsalenmaxprice, 'formattedtax')));
                    $groupfields['variationsalemax_formattedtaxcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationsalenmaxprice, 'formattedtaxcurrency')));
                }
            }
            if (null !== ($data->get_param('woocommerce')) && $data->get_param('woocommerce') === 'producttypes') {
                $groupfields = wc_get_product_types();
            }
            if (null !== ($data->get_param('woocommerce')) && $data->get_param('woocommerce') === 'price' && null !== ($data->get_param('postid'))) {
                $product = wc_get_product($post_id);
                $groupfields = $product->get_price();
            }
            if (null !== ($data->get_param('woocommerce')) && $data->get_param('woocommerce') === 'saleprice' && null !== ($data->get_param('postid'))) {
                $product = wc_get_product($post_id);
                $groupfields = $product->get_sale_price();
            }
            if (null !== ($data->get_param('woocommerce')) && $data->get_param('woocommerce') === 'regularprice' && null !== ($data->get_param('postid'))) {
                $product = wc_get_product($post_id);
                $groupfields = $product->get_regular_price();
            }
            if (null !== ($data->get_param('woocommerce')) && $data->get_param('woocommerce') === 'currencysymbol') {
                $groupfields = html_entity_decode(get_woocommerce_currency_symbol());
            }
            if (null !== ($data->get_param('woocommerce')) && $data->get_param('woocommerce') === 'currency') {
                $groupfields = get_woocommerce_currency();
            }
            if (null !== ($data->get_param('woocommerce')) && $data->get_param('woocommerce') === 'quantity' && null !== ($data->get_param('postid'))) {
                $product = wc_get_product($post_id);
                $groupfields = $product->get_stock_quantity();
            }
            if (null !== ($data->get_param('woocommerce')) && $data->get_param('woocommerce') === 'maxpurchasequantity' && null !== ($data->get_param('postid'))) {
                $product = wc_get_product($post_id);
                $groupfields = $product->get_max_purchase_quantity();
            }
            if (null !== ($data->get_param('woocommerce')) && $data->get_param('woocommerce') === 'minpurchasequantity' && null !== ($data->get_param('postid'))) {
                $product = wc_get_product($post_id);
                $groupfields = $product->get_min_purchase_quantity();
            }
            if (null !== ($data->get_param('woocommerce')) && $data->get_param('woocommerce') === 'salefrom' && null !== ($data->get_param('postid'))) {
                $product = wc_get_product($post_id);
                $groupfields = $product->get_date_on_sale_from();
            }
            if (null !== ($data->get_param('woocommerce')) && $data->get_param('woocommerce') === 'saletill' && null !== ($data->get_param('postid'))) {
                $product = wc_get_product($post_id);
                $groupfields = $product->get_date_on_sale_to();
            }
            if (null !== ($data->get_param('woocommerce')) && $data->get_param('woocommerce') === 'sku' && null !== ($data->get_param('postid'))) {
                $product = wc_get_product($post_id);
                $groupfields = $product->get_sku();
            }
            if (null !== ($data->get_param('woocommerce')) && $data->get_param('woocommerce') === 'ratingcount' && null !== ($data->get_param('postid'))) {
                $product = wc_get_product($post_id);
                $groupfields = $product->get_rating_count();
            }
            if (null !== ($data->get_param('woocommerce')) && $data->get_param('woocommerce') === 'reviewcount' && null !== ($data->get_param('postid'))) {
                $product = wc_get_product($post_id);
                $groupfields = $product->get_review_count();
            }
            if (null !== ($data->get_param('woocommerce')) && $data->get_param('woocommerce') === 'averagerating' && null !== ($data->get_param('postid'))) {
                $product = wc_get_product($post_id);
                $groupfields = $product->get_average_rating();
            }
            if (null !== ($data->get_param('woocommerce')) && $data->get_param('woocommerce') === 'salepercentage' && null !== ($data->get_param('postid'))) {
                $product = wc_get_product($post_id);
                $groupfields = Cwicly\WooCommerce::percentage_calculator($product);
            }
            if (null !== ($data->get_param('woocommerce')) && $data->get_param('woocommerce') === 'woogroups' && null !== ($data->get_param('postid'))) {
                $product = wc_get_product($post_id);
                if ($product->get_type() === 'grouped') {
                    $products = $product->get_children();
                    $groupfields = $products;
                }
            }
            if (null !== ($data->get_param('woocommerce')) && $data->get_param('woocommerce') === 'productattributes' && null !== ($data->get_param('postid'))) {
                $product = wc_get_product($post_id);
                if ($product && $product->get_type() === 'variable') {
                    // $groupfields = $product->get_variation_attributes();
                    foreach ($product->get_variation_attributes() as $taxonomy => $terms_slug) {
                        // To get the attribute label (in WooCommerce 3+)
                        $taxonomy_label = wc_attribute_label($taxonomy, $product);

                        // Setting some data in an array
                        $variations_attributes_and_values[$taxonomy] = array('label' => $taxonomy_label);
                        $variations_attributes_and_values[$taxonomy]['type'] = wc_get_attribute(wc_attribute_taxonomy_id_by_name($taxonomy))->type;
                        $variations_attributes_and_values[$taxonomy]['slug'] = $taxonomy;

                        foreach ($terms_slug as $term) {

                            // Getting the term object from the slug
                            $term_obj = get_term_by('slug', $term, $taxonomy);

                            $term_id = $term_obj->term_id; // The ID  <==  <==  <==  <==  <==  <==  HERE
                            $term_name = $term_obj->name; // The Name
                            $term_slug = $term_obj->slug; // The Slug
                            $term_type = '';
                            if ($variations_attributes_and_values[$taxonomy]['type'] && $variations_attributes_and_values[$taxonomy]['type'] === 'color') {
                                $term_type = get_term_meta($term_id, '_cwicly_color', true);
                            }
                            if ($variations_attributes_and_values[$taxonomy]['type'] && $variations_attributes_and_values[$taxonomy]['type'] === 'image') {
                                $term_type = wp_get_attachment_url(get_term_meta($term_id, '_cwicly_image_id', true));
                            }

                            // Setting the terms ID and values in the array
                            $variations_attributes_and_values[$taxonomy]['terms'][$term_id] = array(
                                'name' => $term_name,
                                'slug' => $term_slug,
                                'type' => $term_type,
                            );
                        }
                    }
                    $groupfields = $variations_attributes_and_values;
                }
            }
            if (null !== ($data->get_param('bloginfo')) && null !== ($data->get_param('postid'))) {
                if ($data->get_param('bloginfo') === 'productgallery') {
                    $original = [];
                    $full_url = [];
                    $medium_url = [];
                    $thumbnail_url = [];
                    $product = wc_get_product($post_id);
                    $main_image = [];
                    $main_image[] = $product->get_image_id();
                    $gallery_images = $product->get_gallery_image_ids();
                    $attachment_ids = array_merge($main_image, $gallery_images);
                    foreach ($attachment_ids as $images) {
                        $original[] = wp_get_attachment_url($images);
                        $full_url[] = wp_get_attachment_image_src($images, 'full')[0];
                        $medium_url[] = wp_get_attachment_image_src($images, 'medium')[0];
                        $thumbnail_url[] = wp_get_attachment_image_src($images, 'thumbnail')[0];
                    }
                    $bloginfo = array($original, $full_url, $medium_url, $thumbnail_url);
                }
            }
            // WOOCOMMERCE
            return ['success' => true, 'comments' => $comments, 'authormeta' => $authormeta, 'usermeta' => $usermeta, 'bloginfo' => $bloginfo, 'groupfields' => $groupfields, 'acffieldscontent' => $acffield, 'acffieldobject' => $acffieldobject, 'imagesize' => $size];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function cc_get_menus($data)
    {
        try {
            $settings = '';
            if ($data->get_param('menus')) {
                $settings = wp_get_nav_menus();
            }
            if ($data->get_param('menu')) {
                $menu_items = wp_get_nav_menu_items($data->get_param('menu'), array('update_post_term_cache' => false));
                foreach ($menu_items as &$item) {
                    $item->title = wp_strip_all_tags(html_entity_decode($item->title));
                }
                $settings = $menu_items;
            }

            return ['success' => true, 'settings' => $settings];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function cc_global_fonts()
    {
        $globalFonts = get_option('cwicly_global_fonts');
        if ($globalFonts) {
            echo $globalFonts;
        }
    }

    public function cc_backend_info_api($data)
    {
        try {
            if ($data->get_param('taxonomies')) {
                global $wp_taxonomies;
                $taxonomies = array();
                $count = 0;
                foreach ($wp_taxonomies as $tax_name => $tax_obj) {
                    $final = $tax_obj;
                    $final->id = $count;
                    $count = $count + 1;
                    $taxonomies[] = $final;
                }
                return rest_ensure_response($taxonomies);
            } else if ($data->get_param('terms')) {
                global $wp_taxonomies;
                $taxonomies = array();
                foreach ($wp_taxonomies as $tax_name => $tax_obj) {
                    $taxonomies[$tax_name] = get_terms(array(
                        'taxonomy' => $tax_name,
                        'hide_empty' => false,
                        'number' => 10,
                        'search' => $data->get_param('terms') ? $data->get_param('search') : '',
                    ));
                    // $taxonomies[$tax_name] = $tax_obj;
                }
                return rest_ensure_response($taxonomies);
            } else if ($data->get_param('acfgroups')) {
                $acfgroups = acf_get_field_groups();
                return rest_ensure_response($acfgroups);
            } else if ($data->get_param('acffields')) {
                $acfallfields = acf_get_fields($data->get_param('acffields'));
                return rest_ensure_response($acfallfields);
            } else if ($data->get_param('acffield') && $data->get_param('postid')) {
                $acfallfield = get_field_object($data->get_param('acffield'), $data->get_param('postid'));
                return rest_ensure_response($acfallfield);
            } else if ($data->get_param('posttaxonomies')) {
                $posttaxonomies = get_post_taxonomies($data->get_param('posttaxonomies'));
                return rest_ensure_response($posttaxonomies);
            } else if ($data->get_param('getterms') && $data->get_param('taxonomy')) {
                $taxonomies = explode(',', $data->get_param('taxonomy'));
                $terms = array();

                $taxIncludes = $data->get_param('taxIncludes') ? $data->get_param('taxIncludes') : array();

                if ($taxIncludes) {
                    $taxIncludes = explode(',', $taxIncludes);
                }

                foreach ($taxonomies as $taxonomy) {
                    if (in_array($taxonomy, $taxIncludes) || !$taxIncludes) {
                        $term = get_the_terms($data->get_param('getterms'), $taxonomy);
                        if ($term) {
                            $terms = array_merge($terms, $term);
                        }
                    }
                }
                // $terms = get_the_terms($data->get_param('getterms'), $taxonomies);
                return rest_ensure_response($terms);
            } else if ($data->get_param('gettermscustom')) {
                $terms = get_terms(array(
                    'taxonomy' => $data->get_param('taxonomy') ? explode(',', $data->get_param('taxonomy')) : array(),
                    'orderby' => $data->get_param('orderby') ? $data->get_param('orderby') : 'name',
                    'order' => $data->get_param('order') ? $data->get_param('order') : 'ASC',
                    'hide_empty' => $data->get_param('hideempty') ? filter_var($data->get_param('hideempty'), FILTER_VALIDATE_BOOLEAN) : false,
                    'exclude' => $data->get_param('exclude') ? $data->get_param('exclude') : '',
                    'include' => $data->get_param('include') ? $data->get_param('include') : '',
                ));
                return rest_ensure_response($terms);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function cc_dynamic_previewer($data)
    {
        try {
            $post_type = 'any';
            if ($data->get_param('posttype')) {
                $post_type = $data->get_param('posttype');
            }
            if ($data->get_param('taxonomies')) {
                global $wp_taxonomies;
                $taxonomies = array();
                foreach ($wp_taxonomies as $tax_name => $tax_obj) {
                    $taxonomies[$tax_name] = $tax_obj;
                }
                return ['success' => true, 'taxonomies' => $taxonomies];
            } else if ($data->get_param('terms')) {
                global $wp_taxonomies;
                $taxonomies = array();
                foreach ($wp_taxonomies as $tax_name => $tax_obj) {
                    $taxonomies[$tax_name] = get_terms(array(
                        'taxonomy' => $tax_name,
                        'hide_empty' => false,
                    ));
                    // $taxonomies[$tax_name] = $tax_obj;
                }
                return ['success' => true, 'terms' => $taxonomies];
            } else if ($data->get_param('product')) {
                // query for your post type
                $post_type_query = new WP_Query(
                    array(
                        'post_type' => 'product',
                        'posts_per_page' => -1,
                        's' => $data->get_param('keyword'),
                    )
                );
                // we need the array of posts
                $posts_array = $post_type_query->posts;
                // create a list with needed information
                // the key equals the ID, the value is the post_title
                $post_title_array = wp_list_pluck($posts_array, 'post_title', 'ID');
                $post_type_array = wp_list_pluck($posts_array, 'post_type', 'ID');
                return ['success' => true, 'title' => $post_title_array, 'type' => $post_type_array];
            } else if ($data->get_param('woocategories')) {
                $category = get_categories(array(
                    'taxonomy' => 'product_cat',
                    // 'posts_per_page' => -1,
                    'search' => $data->get_param('keyword'),
                ));
                return ['success' => true, 'categories' => $category];
            } else if ($data->get_param('wootags')) {
                $tags = get_terms('product_tag', array(
                    'hide_empty' => false,
                    'search' => $data->get_param('keyword'),
                ));
                return ['success' => true, 'tags' => $tags];
            } else {
                // query for your post type
                $post_type_query = new WP_Query(
                    array(
                        'post_type' => $post_type,
                        'posts_per_page' => -1,
                        's' => $data->get_param('keyword'),
                    )
                );
                // we need the array of posts
                $posts_array = $post_type_query->posts;
                // create a list with needed information
                // the key equals the ID, the value is the post_title
                $post_title_array = wp_list_pluck($posts_array, 'post_title', 'ID');
                $post_type_array = wp_list_pluck($posts_array, 'post_type', 'ID');
                return ['success' => true, 'title' => $post_title_array, 'type' => $post_type_array];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function cc_filter_query($data)
    {
        try {

            $args = array();
            $args = cc_filter_args_maker(
                $data->get_param('filterData'),
                $data->get_param('filterInclude'),
                $data->get_param('filterExclude'),
                $data->get_param('filterParent'),
                $data->get_param('filterOrderBy'),
                $data->get_param('filterOrder'),
                $data->get_param('filterChildless'),
                $data->get_param('filterHideEmpty')
            );

            $query = new WP_Term_Query($args);

            return ['success' => true, 'query' => $query->terms, 'args' => $args];
            // return ['success' => true, 'query' => $query->posts, 'result' => $final];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function cc_cart_backend($data)
    {
        try {
            if ($data->get_param('variations')) {
                $final = array();
                foreach (wc_get_attribute_taxonomies() as $values) {
                    $term_names = get_terms(array('taxonomy' => 'pa_' . $values->attribute_name, 'fields' => 'names'));
                    $final[] = array('label' => $values->attribute_label, 'value' => $term_names[0]);
                }
                return ['success' => true, 'attributes' => $final];
            } else {
                $query_prep = new WC_Product_Query(array('limit' => 5));

                // $query_prep = new WC_Product_Query(array('limit' => 5));
                $products_query = $query_prep->get_products();
                $query = array();
                foreach ($products_query as $product) {
                    $producter = $product->get_data();
                    $producter['cc_featuredimage'] = get_the_post_thumbnail_url($producter['id'], 'full');

                    $original = [];
                    $main_image = [];
                    $main_image[] = $product->get_image_id();
                    $gallery_images = $product->get_gallery_image_ids();
                    $attachment_ids = array_merge($main_image, $gallery_images);
                    foreach ($attachment_ids as $images) {
                        $original[] = array(
                            'src' => wp_get_attachment_url($images),
                            'name' => get_the_title($images),
                            'caption' => wp_get_attachment_caption($images),
                        );
                    }

                    $producter['cc_images'] = $original;
                    $query[] = $producter;
                }

                return ['success' => true, 'query' => $query];
                // return ['success' => true, 'query' => $query->posts, 'result' => $final];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function cc_code_maker($data)
    {
        try {
            $body = json_decode($data->get_body(), true);

            $code = $body['code'] ?? null;
            $postId = $body['postId'] ?? null;
            $postType = $body['postType'] ?? null;
            if ($code) {

                ob_start();

                global $post;
                $post = get_post($postId);
                setup_postdata($post);

                // ERROR
                $error_reporting = error_reporting(E_ALL);
                $display_errors = ini_get('display_errors');
                ini_set('display_errors', 1);

                try {
                    $eval = eval(' ?>' . $code . '<?php ');
                    $output = ob_get_clean();
                } catch (Exception $e) {
                    wp_reset_postdata();
                    ob_get_clean();
                    return ['success' => false, 'message' => 'Exception: ' . $e->getMessage()];
                } catch (ParseError $e) {
                    wp_reset_postdata();
                    ob_get_clean();
                    return ['success' => false, 'message' => 'ParseError: ' . $e->getMessage()];
                } catch (Error $e) {
                    wp_reset_postdata();
                    ob_get_clean();
                    return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
                }

                // RESET ERROR
                ini_set('display_errors', $display_errors);
                error_reporting($error_reporting);

                wp_reset_postdata();

                return ['success' => true, 'code' => $output];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function cc_woo_variationer_local()
    {
        global $product;
        if (!is_object($product)) {
            $product = wc_get_product(get_the_ID());
        }

        if ($product && $product->get_type() === 'variable' && $product->get_attributes()) {
            $attributes = array_keys($product->get_attributes());
            $default_attributes = $product->get_default_attributes();
            foreach ($attributes as $attribute) {
                if (isset($default_attributes[$attribute])) {
                    $default_variations[$attribute] = $default_attributes[$attribute];
                } else {
                    $default_variations[$attribute] = '';
                }
            }
            return array(
                'variations' => wp_json_encode($product->get_available_variations()),
                'default_variations' => wp_json_encode($default_variations),
            );
        }
        return;
    }
}
new CWICLY();
