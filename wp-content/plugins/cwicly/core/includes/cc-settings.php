<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

if (function_exists('wp_is_block_theme') && wp_is_block_theme()) {
    remove_filter('term_description', 'wpautop');
    remove_filter('the_content', 'wpautop');
}

function cc_apis()
{
    // Settings Page
    register_rest_route(
        'cwicly/v1',
        '/upload_collection/',
        array(
            array(
                'methods' => 'POST',
                'callback' => 'cc_api_upload_collection',
                'permission_callback' => function () {
                    return current_user_can('edit_posts');
                },
            ),
        )
    );
    register_rest_route(
        'cwicly/v1',
        '/upload_icon/',
        array(
            array(
                'methods' => 'POST',
                'callback' => 'cc_api_upload_icon',
                'permission_callback' => function () {
                    return current_user_can('manage_options');
                },
                'args' => array(),
            ),
        )
    );
    register_rest_route(
        'cwicly/v1',
        '/upload_font/',
        array(
            array(
                'methods' => 'POST',
                'callback' => 'cc_api_upload_font',
                'permission_callback' => function () {
                    return current_user_can('manage_options');
                },
                'args' => array(),
            ),
        )
    );
    register_rest_route(
        'cwicly/v1',
        '/settings/',
        array(
            array(
                'methods' => 'POST',
                'callback' => 'cc_api_settings',
                'permission_callback' => function () {
                    return current_user_can('manage_options');
                },
                'args' => array(),
            ),
        )
    );
    register_rest_route(
        'cwicly/v1',
        '/render/',
        array(
            array(
                'methods' => 'GET',
                'callback' => 'cc_theme_render',
                'permission_callback' => function () {
                    return current_user_can('edit_posts');
                },
            ),
        )
    );
    register_rest_route(
        'cwicly/v1',
        '/themes/',
        array(
            array(
                'methods' => 'GET',
                'callback' => 'cc_change_theme',
                'permission_callback' => function () {
                    return current_user_can('manage_options');
                },
            ),
        )
    );
}
add_action('rest_api_init', 'cc_apis');

function cwicly_plugin_register_option()
{
    register_setting(
        'cwicly',
        'cwicly_plugin_license_key_status',
        array('show_in_rest' => true)
    );
    register_setting(
        'cwicly',
        'cwicly_font_cols',
        array('show_in_rest' => true)
    );
    register_setting(
        'cwicly',
        'cwicly_svg_cols',
        array('show_in_rest' => true)
    );
    register_setting(
        'cwicly',
        'cwicly_global_fonts',
        array('show_in_rest' => true)
    );
    register_setting(
        'cwicly',
        'cwicly_breakpoints',
        array(
            'show_in_rest' => true,
            'default' => array('md' => 992, 'sm' => 576),
        )
    );
    // register_setting(
    //     'cwicly',
    //     'cwicly_css',
    //     array('show_in_rest' => true)
    // );
    register_setting(
        'cwicly',
        'cwicly_classes',
        array('show_in_rest' => true)
    );
    // register_setting(
    //     'cwicly',
    //     'cwicly_classes_add',
    //     array('show_in_rest' => true)
    // );
    register_setting(
        'cwicly',
        'cwicly_gmap',
        array('show_in_rest' => true)
    );
    register_setting(
        'cwicly',
        'cwicly_license_check',
        array('show_in_rest' => true)
    );
    register_setting(
        'cwicly',
        'cwicly_theme_check',
        array('show_in_rest' => true)
    );
    register_setting(
        'cwicly',
        'cwicly_collection',
        array('show_in_rest' => true)
    );
    register_setting(
        'cwicly',
        'cwicly_ssl_verify',
        array(
            'show_in_rest' => true,
            'default' => "true",
        )
    );
    register_setting(
        'cwicly',
        'cwicly_close_importer',
        array(
            'show_in_rest' => true,
            'default' => "true",
        )
    );
    register_setting(
        'cwicly',
        'cwicly_custom_code',
        array('show_in_rest' => true, 'sanitize_callback' => 'cwicly_custom_code_sanitize')
    );
    register_setting(
        'cwicly',
        'cwicly_conditions',
        array('show_in_rest' => true, 'default' => array('singular' => [], 'archive' => [], 'all' => []))
    );
    register_setting(
        'cwicly',
        'cwicly_global_parts',
        array('show_in_rest' => true, 'default' => array('notices' => array('error' => array('template' => ''), 'notice' => array('template' => ''), 'success' => array('template' => '')), 'account' => [])),
    );
    register_setting(
        'cwicly',
        'cwicly_pre_conditions',
        array('show_in_rest' => true, 'default' => '{}')
    );
    register_setting(
        'cwicly',
        'cwicly_global_classes',
        array('show_in_rest' => true)
        // array('show_in_rest' => true, 'default' => new StdClass)
    );
    register_setting(
        'cwicly',
        'cwicly_global_classes_folders',
        array('show_in_rest' => true)
    );
    register_setting(
        'cwicly',
        'cwicly_global_stylesheets_folders',
        array('show_in_rest' => true)
    );
    register_setting(
        'cwicly',
        'cwicly_global_styles',
        array('show_in_rest' => true)
        // array('show_in_rest' => true, 'default' => new StdClass)
    );
    register_setting(
        'cwicly',
        'cwicly_global_classes_rendered',
        array('show_in_rest' => true)
        // array('show_in_rest' => true, 'default' => new StdClass)
    );
    register_setting(
        'cwicly',
        'cwicly_global_classes_save',
        array('show_in_rest' => true)
    );
    register_setting(
        'cwicly',
        'cwicly_global_stylesheets',
        array('show_in_rest' => true)
    );
    register_setting(
        'cwicly',
        'cwicly_global_stylesheets_rendered',
        array('show_in_rest' => true)
    );
    register_setting(
        'cwicly',
        'cwicly_pseudos',
        array('show_in_rest' => true)
    );
    register_setting(
        'cwicly',
        'cwicly_global_interactions',
        array('show_in_rest' => true)
    );
    register_setting(
        'cwicly',
        'cwicly_section_defaults',
        array('show_in_rest' => true)
    );
    register_setting(
        'cwicly',
        'cwicly_optimise',
        array('show_in_rest' => true)
    );
    register_setting(
        'cwicly',
        'cwicly_role_editor',
        array('show_in_rest' => true)
    );
    register_setting(
        'cwicly',
        'cwicly_external_classes',
        array('show_in_rest' => true)
    );
    register_setting(
        'cwicly',
        'cwicly_scss_compiler',
        array('show_in_rest' => true, 'sanitize_callback' => 'cwicly_scss_compiler_sanitize')
    );
    register_setting(
        'cwicly',
        'cwicly_acf_rest_frontend',
        array('show_in_rest' => true)
    );
    register_setting(
        'cwicly',
        'cwicly_hide_list_container',
        array('show_in_rest' => true)
    );
    register_setting(
        'cwicly',
        'cwicly_deactivate_heartbeat',
        array('show_in_rest' => true)
    );
    register_setting(
        'cwicly',
        'cwicly_design_auth',
        array('show_in_rest' => true, 'default' => '[]')
    );
}
add_action('admin_init', 'cwicly_plugin_register_option');
add_action('rest_api_init', 'cwicly_plugin_register_option');

/**
 * Gets/Removes the SCSS compiler assets
 */
function cwicly_scss_compiler_sanitize($option)
{
    if ($option === 'true') {
        return 'true';
    } else {
        $upload_dir = wp_upload_dir();
        $dir = trailingslashit($upload_dir['basedir']) . 'cwicly/assets/sass.worker.min.js';
        wp_delete_file($dir);
        return 'false';
    }
}

/**
 * Sets up all the necessary so that we don't have errors when accessing the option for the first time.
 */
function cc_options_setup()
{
    if (is_admin()) {
        $ssl_verify = get_option("cwicly_ssl_verify");
        $svg_cols = get_option("cwicly_svg_cols");
        $custom_code = get_option("cwicly_custom_code");
        $section_defaults = get_option("cwicly_section_defaults");
        $role_editor = get_option("cwicly_role_editor");
        $optimise = get_option("cwicly_optimise");
        $cwicly_acf_rest_frontend = get_option("cwicly_acf_rest_frontend");
        $heartbeat = get_option("cwicly_heartbeat");
        $themer_heartbeat = get_option("cwicly_themer_heartbeat");

        if (get_option('cwicly_classes_add')) {
            delete_option("cwicly_classes_add");
        }
        if (get_option('cwicly_css')) {
            delete_option("cwicly_css");
        }
        if (get_option('cwicly_theme_license_key')) {
            delete_option("cwicly_theme_license_key");
        }
        if (get_option('cwicly_plugin_license_key')) {
            delete_option("cwicly_plugin_license_key");
        }
        if (get_option('cwicly_theme_license_key_status')) {
            delete_option("cwicly_theme_license_key_status");
        }

        $cwiclyGlobalClasses = get_option("cwicly_global_classes");
        if ($cwiclyGlobalClasses && is_array($cwiclyGlobalClasses)) {
            update_option('cwicly_global_classes', json_encode($cwiclyGlobalClasses));
        } else if ($cwiclyGlobalClasses == false) {
            update_option('cwicly_global_classes', '{}');
        }
        $cwiclyGlobalStylesheets = get_option("cwicly_global_stylesheets");
        if ($cwiclyGlobalStylesheets && is_array($cwiclyGlobalStylesheets)) {
            update_option('cwicly_global_stylesheets', json_encode($cwiclyGlobalStylesheets));
        } else if ($cwiclyGlobalStylesheets == false) {
            update_option('cwicly_global_stylesheets', '[]');
        }
        $cwiclyExternalClasses = get_option("cwicly_external_classes");
        if ($cwiclyExternalClasses && is_array($cwiclyExternalClasses)) {
            update_option('cwicly_external_classes', json_encode($cwiclyExternalClasses));
        } else if ($cwiclyExternalClasses == false) {
            update_option('cwicly_external_classes', '[]');
        }
        $cwiclyGlobalStyles = get_option("cwicly_global_styles");
        if ($cwiclyGlobalStyles && is_array($cwiclyGlobalStyles)) {
            update_option('cwicly_global_styles', json_encode($cwiclyGlobalStyles));
        } else if ($cwiclyGlobalStyles == false) {
            update_option('cwicly_global_styles', '{}');
        }

        if (empty($svg_cols)) {

            $cols = array(
                "fontawesome" => "Font Awesome",
                "phosphorlight" => "Phosphor Light",
                "phosphorregular" => "Phosphor Regular",
                "phosphorduo" => "Phosphor Duotone",
            );
            update_option("cwicly_svg_cols", json_encode($cols));
        }
        $font_cols = get_option("cwicly_font_cols");
        if (empty($font_cols)) {

            $cols = "{}";
            update_option("cwicly_font_cols", $cols);
        }
        if (empty($ssl_verify)) {
            update_option("cwicly_ssl_verify", "true");
        }
        if (empty($custom_code)) {
            update_option("cwicly_custom_code", json_encode((object) []));
        }
        if (empty($optimise)) {
            update_option("cwicly_optimise", array());
        }
        if (empty($cwicly_acf_rest_frontend)) {
            update_option("cwicly_acf_rest_frontend", "true");
        }
        if (empty($section_defaults)) {
            update_option("cwicly_section_defaults", array('maxWidth' => array('lg' => '1120px'), 'width' => array('lg' => '90%'), 'paddingTop' => array('lg' => '150px'), 'paddingBottom' => array('lg' => '150px'), 'paddingLeft' => array('lg' => ''), 'paddingRight' => array('lg' => '')));
        }
        if (empty($heartbeat)) {
            update_option("cwicly_heartbeat", array(
                'cwicly_local_active_fonts' => time(),
                'cwicly_local_fonts' => time(),
                'cwicly_section_defaults' => time(),
                'cwicly_global_styles' => time(),
                'cwicly_breakpoints' => time(),
                'cwicly_global_classes' => time(),
                'cwicly_global_classes_folders' => time(),
                'cwicly_global_stylesheets' => time(),
                'cwicly_global_stylesheets_folders' => time(),
            ));
        }
        if (empty($themer_heartbeat)) {
            update_option("cwicly_heartbeat", array(
                'cwicly_global_parts' => time(),
                'cwicly_pre_conditions' => time(),
            ));
        }
        if (empty($role_editor)) {
            update_option("cwicly_role_editor", array(
                'administrator' => array(
                    'gutenbergEditor' => array(
                        'designLibrary' => true,
                        'headerToolbar' => true,
                        'hidePostTitle' => true,
                        'cwiclyNavigator' => true,
                        'quickInserter' => true,
                        'smartInserter' => true,
                        'globalStylesToggle' => true,
                        'hideListView' => false,
                    ),
                    'globalBlockBehaviour' => array(
                        'globalStylesPanel' => true,
                        'globalClassesPanel' => true,
                        'collectionPanel' => true,
                        'conditions' => true,
                        'link' => true,
                        'interactions' => true,
                        'idClassManager' => true,
                        'designTab' => true,
                        'advancedTab' => true,
                        'tagControl' => true,
                        'hoverAnimation' => true,
                        'headingTag' => true,
                        'specificProperties' => true,
                    ),
                    'blockToolbar' => array(
                        'controls' => true,
                        'dynamicValues' => true,
                        'richTextStyling' => true,
                    ),
                    'miscellaneous' => array(
                        'selectPseudoClasses' => true,
                        'addPseudoClasses' => true,
                    ),
                ),
            ));
        }
    }
}
add_action('admin_init', 'cc_options_setup');

/**
 * Get all templates for rendering on the Themer page.
 */
function cc_theme_render()
{
    try {

        function cc_style_head($theme, $slug, $type = 'tp')
        {
            ob_start();
            Cwicly\Themer::add_template_styles($theme, $slug, $type);
            return ob_get_clean();
        }

        $final = new stdClass();
        $all_posts = new stdClass();
        $head = new stdClass();

        $blockTemplates = get_block_templates();

        foreach ($blockTemplates as $template) {
            $templateHTML = '';
            $blocks = parse_blocks($template->content);
            if (empty($blocks)) {
                $final->{$template->slug} = $templateHTML;
                $all_posts->{$template->slug} = $template;
            } else {
                foreach ($blocks as $block) {
                    $render_block = true;
                    if (strpos($block['blockName'], 'woocommerce/') !== false) {
                        $render_block = false;
                    }
                    if (isset($block['innerBlocks']) && !empty($block['innerBlocks'])) {
                        foreach ($block['innerBlocks'] as $inner_block) {
                            if (strpos($inner_block['blockName'], 'woocommerce/') !== false) {
                                $render_block = false;
                            }
                        }
                    }
                    if ($render_block) {
                        $templateHTML .= apply_filters('the_content', render_block($block));
                    }
                    $final->{$template->slug} = $templateHTML;
                    $all_posts->{$template->slug} = $template;

                    $head->{$template->slug} = cc_style_head($template->theme, $template->slug);
                }
            }
        }

        // get all template parts using wp_template_part post type
        $templateParts = get_posts(array(
            'post_type' => 'wp_template_part',
            'posts_per_page' => -1,
        ));

        $all_template_parts = new stdClass();
        $parts_html = new stdClass();

        foreach ($templateParts as $templatePart) {
            $templateHTML = '';
            $blocks = parse_blocks($templatePart->post_content);
            if (empty($blocks)) {
                $parts_html->{$templatePart->post_name} = $templateHTML;
                $all_template_parts->{$templatePart->post_name} = $templatePart;
            } else {
                foreach ($blocks as $block) {
                    $render_block = true;
                    if (strpos($block['blockName'], 'woocommerce/') !== false) {
                        $render_block = false;
                    }
                    if (isset($block['innerBlocks']) && !empty($block['innerBlocks'])) {
                        foreach ($block['innerBlocks'] as $inner_block) {
                            if (strpos($inner_block['blockName'], 'woocommerce/') !== false) {
                                $render_block = false;
                            }
                        }
                    }
                    if ($render_block) {
                        $templateHTML .= apply_filters('the_content', render_block($block));
                    }
                    $parts_html->{$templatePart->post_name} = $templateHTML;
                    $all_template_parts->{$templatePart->post_name} = $templatePart;

                    $theme = get_option('stylesheet');
                    $head->{$templatePart->post_name} = cc_style_head($theme, $templatePart->post_name, 'tp');
                }
            }
        }

        /**
         * Use output buffering to convert a function that echoes
         * to a return string instead
         */
        function cc_get_head()
        {
            ob_start();
            wp_head();
            return ob_get_clean();
        }

        return ['success' => true, 'message' => $final, 'allPosts' => $all_posts, 'allTemplateParts' => $all_template_parts, 'parts' => $parts_html, 'head' => cc_get_head()];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

/**
 * Checks if the code transient exists. If false, then creates it.
 */
function cc_check_custom_code_transient()
{
    $transient = get_transient('cwicly_custom_code');
    if (!$transient) {
        $option = get_option('cwicly_custom_code');
        if ($option) {
            cwicly_custom_code_sanitize($option);
        }
    }
}
add_action('init', 'cc_check_custom_code_transient');

/**
 * Echoes all scripts created in Cwicly settings just after body open.
 */
function cc_before_body_tag_code()
{
    $transient = get_transient('cwicly_custom_code');
    if ($transient && !empty($transient[1])) {
        echo $transient[1];
    }
}
add_action('wp_body_open', 'cc_before_body_tag_code');

/**
 * Echoes all scripts created in Cwicly settings for head.
 */
function cc_head_tag_code()
{
    $transient = get_transient('cwicly_custom_code');
    if ($transient && !empty($transient[0])) {
        echo $transient[0];
    }
}
add_action('wp_head', 'cc_head_tag_code');

/**
 * Echoes all scripts created in Cwicly settings for footer.
 */
function cc_footer_tag_code()
{
    $transient = get_transient('cwicly_custom_code');
    if ($transient && !empty($transient[2])) {
        echo $transient[2];
    }
}
add_action('wp_footer', 'cc_footer_tag_code');

/**
 * Sanitise and prepare custom code before inputting to database.
 */
function cwicly_custom_code_sanitize($code)
{
    if ($code) {
        $coded = json_decode($code);
        $head = [];
        $bodyStart = [];
        $bodyEnd = [];

        foreach ($coded as $k => $v) {
            if ($v->position === 'head') {
                $head[] = $v->code;
            }
            if ($v->position === 'bodyStart') {
                $bodyStart[] = $v->code;
            }
            if ($v->position === 'bodyEnd') {
                $bodyEnd[] = $v->code;
            }
        }

        $head = implode(" ", $head);
        $bodyStart = implode(" ", $bodyStart);
        $bodyEnd = implode(" ", $bodyEnd);

        $final = array($head, $bodyStart, $bodyEnd);
        delete_transient('cwicly_custom_code');
        set_transient('cwicly_custom_code', $final, 30 * DAY_IN_SECONDS);
    }

    return $code;
}

/**
 * Process Collection
 */
function cc_api_upload_collection($request)
{
    try {
        $params = $request->get_params();
        if ($params['imgBase64'] && $params['random']) {
            $img = $params['imgBase64'];
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);
            //saving
            $fileName = '' . $params['random'] . '.png';

            global $wp_filesystem;
            if (!$wp_filesystem) {
                require_once ABSPATH . 'wp-admin/includes/file.php';
            }

            $upload_dir = wp_upload_dir();
            $dir = trailingslashit($upload_dir['basedir']) . 'cwicly/my-collection/';

            WP_Filesystem(false, $upload_dir['basedir'], true);

            if (!$wp_filesystem->is_dir($dir)) {
                $wp_filesystem->mkdir($dir);
            }
            $target_file = $dir . basename($fileName);

            file_put_contents($target_file, $fileData);
            // move_uploaded_file($file["tmp_name"], $target_file);
        }
        if (isset($params['toDelete'])) {
            require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
            require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';
            $wp_filesystem_direct = new WP_Filesystem_Direct('');
            $fileName = '' . $params['toDelete'] . '.png';
            $upload_dir = wp_upload_dir();
            $dir = trailingslashit($upload_dir['basedir']) . 'cwicly/my-collection/' . $fileName . '';
            if (file_exists($dir)) {
                $wp_filesystem_direct->delete($dir, true);
            }
        }
        return ['success' => true, 'message' => "Successful upload"];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

/**
 * Process Icon upload
 */
function cc_api_upload_icon($request)
{
    try {
        $files = $request->get_file_params();

        $file = $files['file'];

        global $wp_filesystem;
        if (!$wp_filesystem) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
        }

        $upload_dir = wp_upload_dir();
        $dir = trailingslashit($upload_dir['basedir']) . 'cwicly/icons/';
        $target_file = $dir . basename($file["name"]);

        WP_Filesystem(false, $upload_dir['basedir'], true);

        if (!$wp_filesystem->is_dir($dir)) {
            $wp_filesystem->mkdir($dir);
        }

        move_uploaded_file($file["tmp_name"], $target_file);
        return ['success' => true, 'message' => "Successful upload"];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

/**
 * Process Font upload
 */
function cc_api_upload_font($request)
{
    try {
        $params = $request->get_params();

        if ($request->get_file_params()) {
            $files = $request->get_file_params();
        }

        if (isset($params['deleteFontVariation']) && $params['deleteFontVariation'] && isset($params['fontName']) && $params['fontName']) {
            $fontName = $params['fontName'];
            $fontNameVariation = $params['deleteFontVariation'];
            $upload_dir = wp_upload_dir();
            $dir = trailingslashit($upload_dir['basedir']) . 'cwicly/fonts/' . $fontName . '/' . $fontNameVariation . '.woff2';
            wp_delete_file($dir);
        }

        if (isset($params['deleteFont'])) {
            require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
            require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';
            $wp_filesystem_direct = new WP_Filesystem_Direct('');
            $fontName = $params['deleteFont'];
            $upload_dir = wp_upload_dir();
            $dir = trailingslashit($upload_dir['basedir']) . 'cwicly/fonts/' . $fontName . '/';
            if (file_exists($dir)) {
                $wp_filesystem_direct->delete($dir, true);
            }
        }

        if (isset($files['file']) && isset($params['fontName'])) {
            global $wp_filesystem;
            if (!$wp_filesystem) {
                require_once ABSPATH . 'wp-admin/includes/file.php';
            }
            $fontName = $params['fontName'];
            $file = $files['file'];
            $upload_dir = wp_upload_dir();
            $dir = trailingslashit($upload_dir['basedir']) . '/cwicly/fonts/' . $fontName . '/';
            $target_file = $dir . basename($file["name"]);

            WP_Filesystem(false, $upload_dir['basedir'], true);

            if (!$wp_filesystem->is_dir($dir)) {
                wp_mkdir_p($dir);
            }

            move_uploaded_file($file["tmp_name"], $target_file);
        }
        return ['success' => true, 'message' => "Successful upload"];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

/**
 * Remove Icon
 */
function cc_api_settings($request)
{
    try {
        if ($request->get_params()) {
            $params = $request->get_params();
        }

        if (isset($params['deleteIcon'])) {
            global $wp_filesystem;
            if (!$wp_filesystem) {
                require_once ABSPATH . 'wp-admin/includes/file.php';
            }
            $upload_dir = wp_upload_dir();
            $dir = trailingslashit($upload_dir['basedir']) . 'cwicly/icons/';
            $target_file = $dir . $params['deleteIcon'] . '.svg';
            wp_delete_file($target_file);
        }

        return ['success' => true, 'message' => "Global CSS updated!"];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

/**
 * Process excerpt for Cwicly blocks
 */
function cc_excerpt_gutenberg(string $post_excerpt, WP_Post $post)
{
    $cc_allowed_wrapper_blocks = array(
        'cwicly/div',
        'cwicly/section',
        'cwicly/column',
        'cwicly/columns',
    );

    $cc_allowed_inner_blocks = array(
        'cwicly/heading',
        'cwicly/paragraph',
        'cwicly/list',
        'core/paragraph',
        'core/heading',
    );

    $blocks = parse_blocks($post->post_content);
    $output = '';
    foreach ($blocks as $block) {
        if (!empty($block['innerBlocks'])) {
            if (in_array($block['blockName'], $cc_allowed_wrapper_blocks, true)) {
                $output .= cc_excerpt_render_inner_blocks($block, $cc_allowed_inner_blocks);
                continue;
            }

            // Skip the block if it has disallowed or nested inner blocks.
            foreach ($block['innerBlocks'] as $inner_block) {
                if (
                    !in_array($inner_block['blockName'], $cc_allowed_inner_blocks, true) ||
                    !empty($inner_block['innerBlocks'])
                ) {
                    continue 2;
                }
            }
        }
        if (isset($block['attrs']['dynamic']) && $block['attrs']['dynamic'] && $block['attrs']['dynamic'] === 'wordpress' && isset($block['attrs']['dynamicWordPressType']) && $block['attrs']['dynamicWordPressType'] && $block['attrs']['dynamicWordPressType'] == 'postexcerpt') {
        } else {
            $output .= render_block($block);
            // $output .= ' ';
        }
    }
    if ($post_excerpt) {
        return $post_excerpt;
    } else if ($output) {
        return $output;
    } else {
        return $post_excerpt;
    }
}

// add_filter('excerpt_allowed_wrapper_blocks', 'cc_excerpt_allowed_wrapper_blocks_filter');
// function cc_excerpt_allowed_wrapper_blocks_filter($allowed_wrapper_blocks)
// {

//     $allowed_wrapper_blocks[] = 'cwicly/div';
//     $allowed_wrapper_blocks[] = 'cwicly/section';
//     $allowed_wrapper_blocks[] = 'cwicly/columns';
//     $allowed_wrapper_blocks[] = 'cwicly/column';
//     return $allowed_wrapper_blocks;
// }

// add_filter('excerpt_allowed_blocks', 'cc_excerpt_allowed_blocks_filter');
// function cc_excerpt_allowed_blocks_filter($allowed_blocks)
// {

//     $allowed_blocks[] = 'cwicly/heading';
//     $allowed_blocks[] = 'cwicly/paragraph';
//     $allowed_blocks[] = 'cwicly/list';

//     return $allowed_blocks;
// }

/**
 * Process excerpt for Cwicly inner blocks
 */
function cc_excerpt_render_inner_blocks($parsed_block, $allowed_blocks)
{
    $output = '';

    foreach ($parsed_block['innerBlocks'] as $inner_block) {
        if (!in_array($inner_block['blockName'], $allowed_blocks, true)) {
            continue;
        }

        $cc_allowed_wrapper_blocks = array(
            'cwicly/div',
            'cwicly/section',
            'cwicly/columns',
            'cwicly/column',
        );

        if (empty($inner_block['innerBlocks'])) {
            if (isset($inner_block['attrs']['dynamic']) && $inner_block['attrs']['dynamic'] && $inner_block['attrs']['dynamic'] === 'wordpress' && isset($inner_block['attrs']['dynamicWordPressType']) && $inner_block['attrs']['dynamicWordPressType'] && $inner_block['attrs']['dynamicWordPressType'] == 'postexcerpt') {
            } else {
                $output .= render_block($inner_block);
                $output .= ' ';
            }
        } else {
            $output .= cc_excerpt_render_inner_blocks($inner_block, $cc_allowed_wrapper_blocks);
        }
    }

    return $output;
}

/**
 * Disable the emoji's
 */
function cc_disable_emojis()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', 'cc_disable_emojis_tinymce');
    add_filter('wp_resource_hints', 'cc_disable_emojis_remove_dns_prefetch', 10, 2);
}

/**
 * Filter function used to remove the tinymce emoji plugin.
 *
 * @param array $plugins
 * @return array Difference betwen the two arrays
 */
function cc_disable_emojis_tinymce($plugins)
{
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array Difference betwen the two arrays.
 */
function cc_disable_emojis_remove_dns_prefetch($urls, $relation_type)
{
    if ('dns-prefetch' == $relation_type) {
        /** This filter is documented in wp-includes/formatting.php */
        $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');

        $urls = array_diff($urls, array($emoji_svg_url));
    }

    return $urls;
}

/**
 * Optimisations provided by Cwicly
 */
function cc_optimiser()
{
    $option = get_option('cwicly_optimise');
    if (isset($option['svgFilter']) && $option['svgFilter'] === 'true') {
        remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
    }
    if (isset($option['wordPressGlobalStyles']) && $option['wordPressGlobalStyles'] === 'true') {
        remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
    }
    if (isset($option['wordPressEmojis']) && $option['wordPressEmojis'] === 'true') {
        cc_disable_emojis();
    }
    if (!isset($option['wooStylesheets']) || (isset($option['wooStylesheets']) && $option['wooStylesheets'] != 'true')) {
        add_filter('woocommerce_enqueue_styles', '__return_empty_array');
    }
    if (!isset($option['wooScripts']) || (isset($option['wooScripts']) && $option['wooScripts'] != 'true')) {
        remove_theme_support('wc-product-gallery-zoom');
        remove_theme_support('wc-product-gallery-lightbox');
        remove_theme_support('wc-product-gallery-slider');
    }
    if (isset($option['templatePartWrapper']) && $option['templatePartWrapper'] === 'true') {
        add_filter('register_block_type_args', 'cc_template_part_override', 999, 2);
    }
}
add_action('after_setup_theme', 'cc_optimiser');

function cc_admin_notice__regenerate()
{
    $option = get_option('cwicly_regenerate_html');

    if ($option === 'true') {
        ?>
        <div class="notice notice-warning is-dismissible notice-cwicly" style="display: flex; align-items: center;">
            <p><strong><?php _e('Cwicly HTML/CSS regeneration required.', 'cwicly');?></strong></p>
            <a href="<?php echo get_admin_url(); ?>admin.php?page=cwicly-settings" style="margin-left: 8px;" class="button button-primary"><?php _e('Cwicly Settings', 'cwicly');?></a>
            <a style="margin-left: 8px;" class="button"><?php _e('Dismiss.', 'cwicly');?></a>
        </div>
    <?php
} else if (!$option) {
        ?>
        <div class="notice notice-warning is-dismissible notice-cwicly" style="display: flex; align-items: center;">
            <p><?php _e('If you are updating from a previous Cwicly installation, please regenerate your Cwicly HTML.', 'cwicly');?></p>
            <a href="<?php echo get_admin_url(); ?>admin.php?page=cwicly-settings" style="margin-left: 8px;" class="button button-primary"><?php _e('Cwicly Settings', 'cwicly');?></a>
            <a style="margin-left: 8px;" class="button"><?php _e('Dismiss.', 'cwicly');?></a>
        </div>
    <?php
}
}
add_action('admin_notices', 'cc_admin_notice__regenerate');

function cc_shortcode_renderer($block_content, $block, $instance)
{
    $final = do_shortcode(wpautop($block_content));
    return $final;
}
add_filter('render_block_core/shortcode', 'cc_shortcode_renderer', 10, 3);

add_filter('pre_render_block', 'cc_pre_renderer', 10, 3);

/**
 * Function for `pre_render_block` filter-hook.
 *
 * @param string|null   $pre_render   The pre-rendered content.
 * @param array         $parsed_block The block being rendered.
 * @param WP_Block|null $parent_block If this is a nested block, a reference to the parent block.
 *
 * @return string|null
 */
function cc_pre_renderer($pre_render, $parsed_block, $parent_block)
{
    if (isset($parsed_block['attrs']['dynamicContext']) && $parsed_block['attrs']['dynamicContext'] && ($parsed_block['attrs']['dynamicContext'] === 'previouspost' || $parsed_block['attrs']['dynamicContext'] === 'nextpost')) {
        $taxonomy = 'category';
        $in_same_term = false;
        $excluded_terms = '';
        if (isset($parsed_block['attrs']['dynamicAdjacentPost']['taxonomy']) && $parsed_block['attrs']['dynamicAdjacentPost']['taxonomy']) {
            $taxonomy = $parsed_block['attrs']['dynamicAdjacentPost']['taxonomy'];
        }
        if (isset($parsed_block['attrs']['dynamicAdjacentPost']['in_same_term']) && $parsed_block['attrs']['dynamicAdjacentPost']['in_same_term']) {
            $in_same_term = true;
        }
        if (isset($parsed_block['attrs']['dynamicAdjacentPost']['excluded_terms']) && $parsed_block['attrs']['dynamicAdjacentPost']['excluded_terms']) {
            $terms = array();
            foreach ($parsed_block['attrs']['dynamicAdjacentPost']['excluded_terms'] as $term) {
                if (isset($term['value'])) {
                    $terms[] = $term['value'];
                }
            }
            $excluded_terms = $terms;
        }

        global $post;
        if ($parsed_block['attrs']['dynamicContext'] === 'previouspost') {
            $post = get_previous_post($in_same_term, $excluded_terms, $taxonomy);
        } else if ($parsed_block['attrs']['dynamicContext'] === 'nextpost') {
            $post = get_next_post($in_same_term, $excluded_terms, $taxonomy);
        }
        setup_postdata($post);
        $final = (new WP_Block(
            $parsed_block,
            array(
                'postType' => get_post_type(),
                'postId' => get_the_ID(),
            )
        ))->render(array('dynamic' => true));
        wp_reset_postdata();
        return $final;
    }
    return $pre_render;
}

/**
 * Get all the registered image sizes along with their dimensions
 *
 * @global array $_wp_additional_image_sizes
 *
 * @link http://core.trac.wordpress.org/ticket/18947 Reference ticket
 *
 * @return array $image_sizes The image sizes
 */
function cc_get_all_image_sizes()
{
    global $_wp_additional_image_sizes;

    $default_image_sizes = get_intermediate_image_sizes();

    foreach ($default_image_sizes as $size) {
        $image_sizes[$size]['width'] = intval(get_option("{$size}_size_w"));
        $image_sizes[$size]['height'] = intval(get_option("{$size}_size_h"));
        $image_sizes[$size]['crop'] = get_option("{$size}_crop") ? get_option("{$size}_crop") : false;
    }

    if (isset($_wp_additional_image_sizes) && count($_wp_additional_image_sizes)) {
        $image_sizes = array_merge($image_sizes, $_wp_additional_image_sizes);
    }

    return $image_sizes;
}

add_filter('script_loader_tag', 'cc_add_type_attribute', 10, 3);
/**
 * Change script tag for specific files
 */
function cc_add_type_attribute($tag, $handle, $src)
{
    // if not your script, do nothing and return original $tag
    if (!str_contains($handle, 'CCdyn') && !str_contains($handle, 'cc-m-')) {
        return $tag;
    }
    // change the script tag by adding type="module" and return it.
    $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
    return $tag;
}

add_filter('woocommerce_product_data_store_cpt_get_products_query', function ($wp_query_args, $query_vars, $data_store_cpt) {
    if (!empty($query_vars['meta_query'])) {
        $wp_query_args['meta_query'][] = $query_vars['meta_query'];
    }
    return $wp_query_args;
}, 10, 3);

//https://gist.github.com/Daniel217D/11c0ac0c2a70676448ff8007cb7cdce9
function cc_get_filtered_price($args)
{
    global $wpdb;

    // $args       = wc()->query->get_main_query();

    $tax_query = isset($args->tax_query->queries) ? $args->tax_query->queries : array();
    $meta_query = isset($args->query_vars['meta_query']) ? $args->query_vars['meta_query'] : array();

    foreach ($meta_query + $tax_query as $key => $query) {
        if (!empty($query['price_filter']) || !empty($query['rating_filter'])) {
            unset($meta_query[$key]);
        }
    }

    $meta_query = new \WP_Meta_Query($meta_query);
    $tax_query = new \WP_Tax_Query($tax_query);

    $meta_query_sql = $meta_query->get_sql('post', $wpdb->posts, 'ID');
    $tax_query_sql = $tax_query->get_sql($wpdb->posts, 'ID');

    $sql = "SELECT min( FLOOR( price_meta.meta_value ) ) as min_price, max( CEILING( price_meta.meta_value ) ) as max_price FROM {$wpdb->posts} ";
    $sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
    $sql .= " 	WHERE {$wpdb->posts}.post_type IN ('product')
			AND {$wpdb->posts}.post_status = 'publish'
			AND price_meta.meta_key IN ('_price')
			AND price_meta.meta_value > '' ";
    $sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

    // $search = \WC_Query::get_main_search_query_sql();
    // if ($search) {
    //     $sql .= ' AND ' . $search;
    // }

    $prices = $wpdb->get_row($sql); // WPCS: unprepared SQL ok.

    return [
        'min' => floor($prices->min_price),
        'max' => ceil($prices->max_price),
    ];
}

function cc_change_theme($data)
{
    try {

        if (null !== $data->get_param('install') && $data->get_param('install')) {
            cc_install_themer();
        }

        if (null !== $data->get_param('settheme') && $data->get_param('settheme')) {
            if ($data->get_param('settheme') === 'default') {
                switch_theme(WP_DEFAULT_THEME);
            } else {
                switch_theme($data->get_param('settheme'));
            }
        }

        $themes = wp_get_themes();
        foreach ($themes as $theme) {
            $theme->description = strip_tags($theme->description);
            $theme->name = strip_tags($theme->name);
        }

        return ['active' => get_stylesheet(), 'result' => $themes, 'default' => WP_DEFAULT_THEME];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

function cc_install_themer()
{

    //includes necessary for Plugin_Upgrader and Plugin_Installer_Skin
    include_once ABSPATH . 'wp-admin/includes/file.php';
    include_once ABSPATH . 'wp-admin/includes/misc.php';
    include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

    wp_cache_flush();

    $theme = CWICLY_DIR_PATH . 'core/assets/theme/cwicly_theme_v1.0.3.zip';

    $upgrader = new Theme_Upgrader(new CC_Theme_Upgrader_Skin());
    $installed = $upgrader->install($theme);

    if (!is_wp_error($installed) && $installed && wp_get_theme('cwicly')->exists()) {
        switch_theme('cwicly');
    }

    return $installed;
}

// https://support.advancedcustomfields.com/forums/topic/how-to-get-field-data-from-a-group-inside-a-group/
function cc_get_group_field(string $group, string $field, $location = 0)
{
    $group_data = get_field($group, $location);
    if (is_array($group_data) && array_key_exists($field, $group_data)) {
        return $group_data[$field];
    }
    return null;
}