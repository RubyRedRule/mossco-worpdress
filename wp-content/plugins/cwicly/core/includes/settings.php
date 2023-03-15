<?php
namespace Cwicly;

if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

class Settings
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'register_menu_page']);
        add_action('admin_menu', [$this, 'register_themer']);
        add_action('admin_menu', [$this, 'register_settings']);
        add_action('admin_menu', [$this, 'register_roleeditor']);
        add_action('admin_menu', [$this, 'register_welcome']);
        remove_filter('admin_head', 'wp_check_widget_editor_deps');
    }

    /**
     * Register the main Cwicly menu page
     */
    public function register_menu_page()
    {
        $cwicly_icon = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTA4MCIgaGVpZ2h0PSIxMDgwIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgMTkyMCAxMDgwIiB4bWw6c3BhY2U9InByZXNlcnZlIj4KIDxnPgogIDx0aXRsZT5MYXllciAxPC90aXRsZT4KICA8ZyBpZD0ic3ZnXzIiPgogICA8ZyBpZD0ic3ZnXzMiPgogICAgPHBhdGggZmlsbD0iI2EyYWFiMiIgZD0ibTUwMC40NTMzOSw3MjMuMzc0MThjLTAuMiwxMSAtNS4zLDIxLjQgLTEzLjgsMjguNGMtMTEwLjgsODkuMSAtMjcxLjcsNzcuNyAtMzY4LjgsLTI2LjNjLTk3LjEsLTEwMy45IC05Ny42LC0yNjUuMiAtMS4xLC0zNjkuN2M5Ni41LC0xMDQuNSAyNTcuMiwtMTE3IDM2OC42LC0yOC41YzE2LjMsMTIuOSAxOS4xLDM2LjYgNi4yLDUzcy0zNi41LDE5LjMgLTUyLjksNi41Yy04MC4zLC02NCAtMTk2LjQsLTU1LjMgLTI2Ni4xLDIwYy02OS44LDc1LjMgLTY5LjYsMTkxLjcgMC4zLDI2Ni45czE4Ni4xLDgzLjYgMjY2LjIsMTkuNGMxNC40LC0xMS41IDM1LjEsLTEwLjkgNDguOCwxLjRjOC4zLDcuMyAxMi45LDE3LjkgMTIuNiwyOC45eiIgaWQ9InN2Z180Ii8+CiAgICA8cGF0aCBmaWxsPSIjYTJhYWIyIiBkPSJtNzYzLjY1MzM5LDI2OC4yNzQxOGMxMTkuMSwwIDIyNC4zLDc3LjYgMjU5LjUsMTkxLjRjMzUuMiwxMTMuOCAtNy45LDIzNy4zIC0xMDYuMiwzMDQuNXMtMjI5LDYyLjYgLTMyMi4zLC0xMS41Yy04LjYsLTYuOSAtMTMuNywtMTcuMiAtMTQsLTI4LjJzNC4yLC0yMS42IDEyLjQsLTI5YzEzLjQsLTEyLjQgMzMuOCwtMTMuNCA0OC4zLC0yLjJjODAuMyw2NCAxOTYuNCw1NS4zIDI2Ni4xLC0yMGM2OS44LC03NS4zIDY5LjYsLTE5MS43IC0wLjMsLTI2Ni45Yy03MCwtNzUuMiAtMTg2LjEsLTgzLjYgLTI2Ni4yLC0xOS40Yy0xNC40LDExLjUgLTM1LjEsMTAuOSAtNDguOCwtMS40Yy04LjIsLTcuMyAtMTIuOCwtMTcuOSAtMTIuNiwtMjguOWMwLjIsLTExIDUuMywtMjEuNCAxMy44LC0yOC4zYzQ4LjQsLTM4LjkgMTA4LjQsLTYwIDE3MC4zLC02MC4xbDAsMHoiIGlkPSJzdmdfNSIvPgogICA8L2c+CiAgPC9nPgogPC9nPgoKPC9zdmc+';
        add_menu_page(
            __('Cwicly', 'cwicly'),
            __('Cwicly', 'cwicly'),
            'manage_options',
            'cwicly',
            [$this, 'themer_callback'],
            $cwicly_icon,
        );
    }

    /**
     * Register the themer submenu page and enqueue the scripts
     */
    public function register_themer()
    {
        $page_hook_suffix = add_submenu_page('cwicly', 'Cwicly Themer', 'Themer', 'manage_options', 'cwicly');
        add_action("admin_print_scripts-{$page_hook_suffix}", [$this, 'themer_enqueue']);
    }

    /**
     * Register the settings submenu page and enqueue the scripts
     */
    public function register_settings()
    {
        $settings_hook_suffix = add_submenu_page('cwicly', 'Cwicly Settings', 'Settings', 'manage_options', 'cwicly-settings', [$this, 'settings_callback']);
        add_action("admin_print_scripts-{$settings_hook_suffix}", [$this, 'settings_enqueue']);
    }

    /**
     * Register the role editor submenu page and enqueue the scripts
     */
    public function register_roleeditor()
    {
        $roleeditor_hook_suffix = add_submenu_page('cwicly', 'Cwicly Role Editor', 'Role Editor', 'manage_options', 'cwicly-roleeditor', [$this, 'roleeditor_callback']);
        add_action("admin_print_scripts-{$roleeditor_hook_suffix}", [$this, 'roleeditor_enqueue']);
    }

    /**
     * Register the welcome submenu page and enqueue the scripts
     */
    public function register_welcome()
    {
        $welcome_hook_suffix = add_submenu_page('cwicly', 'Cwicly Getting Started', 'Getting Started', 'manage_options', 'cwicly-welcome', [$this, 'welcome_callback']);
        add_action("admin_print_scripts-{$welcome_hook_suffix}", [$this, 'welcome_enqueue']);
    }

    /**
     * Enqueue files for the Cwicly settings menu. Also localises it.
     */
    public function settings_enqueue()
    {
        wp_enqueue_code_editor(array('type' => 'text/html'));
        wp_enqueue_script('CodeMirrorCSS', CWICLY_DIR_URL . 'core/assets/js/css.js', array('wp-codemirror'), CWICLY_VERSION, false);
        wp_enqueue_style('material', CWICLY_DIR_URL . 'core/assets/css/material.css');
        wp_enqueue_style('CCnorm', CWICLY_DIR_URL . 'assets/css/base.css', array(), CWICLY_VERSION);
        wp_enqueue_script('cc-settings-script', CWICLY_DIR_URL . 'core/includes/js/index.js', array('react', 'wp-api', 'wp-i18n', 'wp-blocks', 'wp-editor', 'wp-block-editor', 'wp-element', 'wp-block-library', 'lodash', 'wp-components', 'wp-api-fetch', 'wp-core-data', 'wp-data', 'wp-polyfill', 'wp-notices'), CWICLY_VERSION, true);
        wp_enqueue_style('cc-settings-style', CWICLY_DIR_URL . 'core/includes/js/style-index.css', array('wp-components'), CWICLY_VERSION);
        wp_enqueue_script('jquery');

        wp_enqueue_editor();
        wp_enqueue_script('wp-format-library');
        do_action('enqueue_block_editor_assets');

        $block_editor_context = new \WP_Block_Editor_Context(array('name' => 'core/edit-site'));
        $custom_settings = array(
            'siteUrl' => site_url(),
            'postsPerPage' => get_option('posts_per_page'),
            'styles' => get_block_editor_theme_styles(),
            'defaultTemplatePartAreas' => get_allowed_block_template_part_areas(),
            'supportsLayout' => \WP_Theme_JSON_Resolver::theme_has_support(),
            'supportsTemplatePartsMode' => !wp_is_block_theme() && current_theme_supports('block-template-parts'),
        );

        /**
         * Home template resolution is not needed when block template parts are supported.
         * Set the value to `true` to satisfy the editor initialization guard clause.
         */
        if ($custom_settings['supportsTemplatePartsMode']) {
            $custom_settings['__unstableHomeTemplate'] = true;
        }

        $editor_settings = get_block_editor_settings($custom_settings, $block_editor_context);

        $preload_paths = array();

        block_editor_rest_api_preload($preload_paths, $block_editor_context);

        wp_add_inline_script(
            'wp-edit-site',
            sprintf(
                'wp.domReady( function() {
			wp.editSite.initializeEditor( "site-editor", %s );
		} );',
                wp_json_encode($editor_settings)
            )
        );

        wp_add_inline_script(
            'wp-blocks',
            'wp.blocks.unstable__bootstrapServerSideBlockDefinitions(' . wp_json_encode(get_block_editor_server_block_settings()) . ');'
        );

        wp_add_inline_script(
            'wp-blocks',
            sprintf('wp.blocks.setCategories( %s );', wp_json_encode(isset($editor_settings['blockCategories']) ? $editor_settings['blockCategories'] : array())),
            'after'
        );

        $cwiclyOptimise = get_option('cwicly_optimise');
        $cwiclyDefaults = 'false';
        if (isset($cwiclyOptimise['cwiclyDefaults']) && $cwiclyOptimise['cwiclyDefaults'] === 'true') {
            $cwiclyDefaults = 'true';
        }
        $removeIDsClasses = 'false';
        if (isset($cwiclyOptimise['removeIDsClasses']) && $cwiclyOptimise['removeIDsClasses'] === 'true') {
            $removeIDsClasses = 'true';
        }

        $blocks = \WP_Block_Type_Registry::get_instance()->get_all_registered();
        $cwiclyblocks = array();
        if ($blocks) {
            foreach ($blocks as $block) {
                if (isset($block->name) && strpos($block->name, 'cwicly/') !== false) {
                    $cwiclyblocks[] = $block;
                }
            }
        }

        wp_localize_script(
            'cc-settings-script',
            'cwicly_info',
            array(
                'plugin' => CWICLY_DIR_URL,
                'url' => get_home_url(),
                'uploads' => wp_upload_dir()['baseurl'],
                'admin' => get_admin_url(),
                'version' => CWICLY_VERSION,
                'wordpress' => WORDPRESS_VERSION,
                'cwiclyDefaults' => $cwiclyDefaults,
                'cwiclyBlocks' => $cwiclyblocks,
                'removeIDsClasses' => $removeIDsClasses,
            )
        );
    }

    /**
     * Enqueue files for the Cwicly themer menu. Also localises it.
     */
    public function themer_enqueue()
    {
        wp_enqueue_code_editor(array('type' => 'text/html'));
        wp_enqueue_script('CodeMirrorCSS', CWICLY_DIR_URL . 'core/assets/js/css.js', null, CWICLY_VERSION, false);
        wp_enqueue_style('material', CWICLY_DIR_URL . 'core/assets/css/material.css');
        wp_enqueue_style('CCnorm', CWICLY_DIR_URL . 'assets/css/base.css', array(), CWICLY_VERSION);
        wp_enqueue_script('cc-themer-script', CWICLY_DIR_URL . 'core/includes/js/themer/build/index.js', array('wp-preferences', 'wp-api', 'wp-i18n', 'wp-blocks', 'wp-block-editor', 'wp-components', 'wp-element', 'wp-api-fetch', 'wp-core-data', 'lodash'), CWICLY_VERSION, true);
        wp_enqueue_style('cc-themer-style', CWICLY_DIR_URL . 'core/includes/js/themer/build/style-index.css', array('wp-components'), CWICLY_VERSION);
        wp_enqueue_style('cc-themer-nstyle', CWICLY_DIR_URL . 'core/includes/js/themer/build/index.css', array('wp-components'), CWICLY_VERSION);
        wp_enqueue_script('jquery');
        // if (!file_exists(wp_upload_dir()['basedir'] . '/cwicly/cc-main.css')) {
        //     wp_enqueue_style('cc', get_template_directory_uri() . '/includes/cc-main.css');
        // } else
        if (file_exists(wp_upload_dir()['basedir'] . '/cwicly/cc-main.css')) {
            wp_enqueue_style('cc', wp_upload_dir()['baseurl'] . '/cwicly/cc-main.css', array(), filemtime(wp_upload_dir()['basedir'] . '/cwicly/cc-main.css'));
        }
        wp_localize_script(
            'cc-themer-script',
            'cwicly_info',
            array(
                'plugin' => CWICLY_DIR_URL,
                'theme' => get_option('stylesheet'),
                'url' => get_home_url(),
                'uploads' => wp_upload_dir()['baseurl'],
                'admin' => get_admin_url(),
                'version' => CWICLY_VERSION,
                'nonce' => wp_create_nonce('cc-nonce'),
                'wordpress' => WORDPRESS_VERSION,
            )
        );
    }

    /**
     * Enqueue files for the Cwicly role editor menu. Also localises it.
     */
    public function roleeditor_enqueue()
    {
        // LOAD CWICLY NORMALISER
        wp_enqueue_style('CCnorm', CWICLY_DIR_URL . 'assets/css/base.css', array(), CWICLY_VERSION);
        // LOAD CWICLY NORMALISER

        // LOAD CWICLY JS ROLE EDITOR
        wp_enqueue_script('cc-roleeditor-script', CWICLY_DIR_URL . 'core/includes/js/role-editor/build/index.js', array('wp-api', 'wp-i18n', 'wp-blocks', 'wp-block-editor', 'wp-components', 'wp-element', 'wp-api-fetch', 'wp-core-data', 'lodash'), CWICLY_VERSION, true);
        // LOAD CWICLY JS ROLE EDITOR

        // LOAD CWICLY CSS ROLE EDITOR
        wp_enqueue_style('cc-roleeditor-style', CWICLY_DIR_URL . 'core/includes/js/role-editor/build/style-index.css', array('wp-components'));
        // LOAD CWICLY CSS ROLE EDITOR

        wp_localize_script(
            'cc-roleeditor-script',
            'cwicly_info',
            array(
                'plugin' => CWICLY_DIR_URL,
                'theme' => get_option('stylesheet'),
                'url' => get_home_url(),
                'uploads' => wp_upload_dir()['baseurl'],
                'admin' => get_admin_url(),
                'version' => CWICLY_VERSION,
                'nonce' => wp_create_nonce('cc-nonce'),
                'wordpress' => WORDPRESS_VERSION,
                'current_user' => get_current_user_id(),
            )
        );
    }

    /**
     * Enqueue files for the Cwicly role editor menu. Also localises it.
     */
    public function welcome_enqueue()
    {
        // LOAD CWICLY NORMALISER
        wp_enqueue_style('CCnorm', CWICLY_DIR_URL . 'assets/css/base.css', array(), CWICLY_VERSION);
        // LOAD CWICLY NORMALISER

        // LOAD CWICLY JS ROLE EDITOR
        wp_enqueue_script('cc-welcome-script', CWICLY_DIR_URL . 'core/includes/js/welcome/build/index.js', array('wp-preferences', 'wp-preferences-persistence', 'wp-api', 'wp-i18n', 'wp-blocks', 'wp-block-editor', 'wp-components', 'wp-element', 'wp-api-fetch', 'wp-core-data', 'lodash'), CWICLY_VERSION, true);
        // LOAD CWICLY JS ROLE EDITOR

        // LOAD CWICLY CSS ROLE EDITOR
        wp_enqueue_style('cc-welcome-style', CWICLY_DIR_URL . 'core/includes/js/welcome/build/style-index.css', array('wp-components'));
        // LOAD CWICLY CSS ROLE EDITOR

        if (!did_action('wp_enqueue_media')) {
            wp_enqueue_media();
        }

        wp_localize_script(
            'cc-welcome-script',
            'cwicly_info',
            array(
                'plugin' => CWICLY_DIR_URL,
                'theme' => get_option('stylesheet'),
                'url' => get_home_url(),
                'uploads' => wp_upload_dir()['baseurl'],
                'admin' => get_admin_url(),
                'version' => CWICLY_VERSION,
                'nonce' => wp_create_nonce('cc-nonce'),
                'wordpress' => WORDPRESS_VERSION,
                'current_user' => get_current_user_id(),
            )
        );
    }

    /**
     * Cwicly settings callback. Div that allows us to render inside the div.
     */
    public function settings_callback()
    {
        echo '<div id="cc-settings-page"></div>';
    }

    /**
     * Cwicly role editor callback. Div that allows us to render inside the div.
     */
    public function roleeditor_callback()
    {
        echo '<div id="cc-settings-page"></div>';
    }

    /**
     * Cwicly themer callback. Div that allows us to render inside the div.
     */
    public function themer_callback()
    {
        echo '<div id="cc-themer-page"></div>';
    }

    /**
     * Cwicly themer callback. Div that allows us to render inside the div.
     */
    public function welcome_callback()
    {
        echo '<div id="cc-welcome-page"></div>';
    }
}
