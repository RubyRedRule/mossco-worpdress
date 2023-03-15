<?php
namespace Cwicly;

if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

class Setup
{
    public function __construct()
    {
        add_action('init', [$this, 'updater']);
        add_action('admin_bar_menu', [$this, 'admin_bar_menu'], 99);
        add_action('after_setup_theme', [$this, 'add_global_colors_to_iframe']);
        add_filter('wp_get_nav_menu_items', [$this, 'prefix_nav_menu_classes'], 10, 3);
        add_filter('plugin_action_links_' . plugin_basename(CWICLY_FILE), [$this, 'settings_links']);
        add_action('activated_plugin', [$this, 'activation_redirect']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_jquery_admin']);
        add_action('wp_ajax_cc_dismissed_notice_handler', [$this, 'ajax_notice_handler']);
    }

    /**
     * Add Cwicly admin menu bar base
     *
     */
    public static function admin_bar_menu(\WP_Admin_Bar$wp_admin_bar)
    {
        if (is_admin()) {
            return;
        }
        $cwicly_icon = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTA4MCIgaGVpZ2h0PSIxMDgwIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgMTkyMCAxMDgwIiB4bWw6c3BhY2U9InByZXNlcnZlIj4KIDxnPgogIDx0aXRsZT5MYXllciAxPC90aXRsZT4KICA8ZyBpZD0ic3ZnXzIiPgogICA8ZyBpZD0ic3ZnXzMiPgogICAgPHBhdGggZmlsbD0iI2EyYWFiMiIgZD0ibTUwMC40NTMzOSw3MjMuMzc0MThjLTAuMiwxMSAtNS4zLDIxLjQgLTEzLjgsMjguNGMtMTEwLjgsODkuMSAtMjcxLjcsNzcuNyAtMzY4LjgsLTI2LjNjLTk3LjEsLTEwMy45IC05Ny42LC0yNjUuMiAtMS4xLC0zNjkuN2M5Ni41LC0xMDQuNSAyNTcuMiwtMTE3IDM2OC42LC0yOC41YzE2LjMsMTIuOSAxOS4xLDM2LjYgNi4yLDUzcy0zNi41LDE5LjMgLTUyLjksNi41Yy04MC4zLC02NCAtMTk2LjQsLTU1LjMgLTI2Ni4xLDIwYy02OS44LDc1LjMgLTY5LjYsMTkxLjcgMC4zLDI2Ni45czE4Ni4xLDgzLjYgMjY2LjIsMTkuNGMxNC40LC0xMS41IDM1LjEsLTEwLjkgNDguOCwxLjRjOC4zLDcuMyAxMi45LDE3LjkgMTIuNiwyOC45eiIgaWQ9InN2Z180Ii8+CiAgICA8cGF0aCBmaWxsPSIjYTJhYWIyIiBkPSJtNzYzLjY1MzM5LDI2OC4yNzQxOGMxMTkuMSwwIDIyNC4zLDc3LjYgMjU5LjUsMTkxLjRjMzUuMiwxMTMuOCAtNy45LDIzNy4zIC0xMDYuMiwzMDQuNXMtMjI5LDYyLjYgLTMyMi4zLC0xMS41Yy04LjYsLTYuOSAtMTMuNywtMTcuMiAtMTQsLTI4LjJzNC4yLC0yMS42IDEyLjQsLTI5YzEzLjQsLTEyLjQgMzMuOCwtMTMuNCA0OC4zLC0yLjJjODAuMyw2NCAxOTYuNCw1NS4zIDI2Ni4xLC0yMGM2OS44LC03NS4zIDY5LjYsLTE5MS43IC0wLjMsLTI2Ni45Yy03MCwtNzUuMiAtMTg2LjEsLTgzLjYgLTI2Ni4yLC0xOS40Yy0xNC40LDExLjUgLTM1LjEsMTAuOSAtNDguOCwtMS40Yy04LjIsLTcuMyAtMTIuOCwtMTcuOSAtMTIuNiwtMjguOWMwLjIsLTExIDUuMywtMjEuNCAxMy44LC0yOC4zYzQ4LjQsLTM4LjkgMTA4LjQsLTYwIDE3MC4zLC02MC4xbDAsMHoiIGlkPSJzdmdfNSIvPgogICA8L2c+CiAgPC9nPgogPC9nPgoKPC9zdmc+';

        if (!Capabilities::permission('miscellaneous', 'hideAdminBarTemplateInfo')) {

            // Load admin.min.css to add styles to the quick edit links
            if (is_admin_bar_showing()) {
                wp_enqueue_style('cwicly-admin', CWICLY_DIR_URL . 'core/assets/css/admin.min.css', null, CWICLY_VERSION);
            }

            $args = array(
                'id' => 'cwiclythemer',
                'title' => '<style>#wpadminbar #wp-admin-bar-cwiclythemer>.ab-item:before {content: "";top: 3px;width: 26px;height: 26px;background-position: center;background-repeat: no-repeat;background-size: 23px; background-image: url(' . $cwicly_icon . ')!important;}</style><span style="--hello: url(' . $cwicly_icon . ');">Edit Template</span>',
                'meta' => array(
                    'class' => 'ccthemer',
                    'title' => 'Current Template in use',
                ),
            );
            $wp_admin_bar->add_menu($args);

            $template_parts = array(
                'id' => 'cctemplateparts',
                'title' => 'Template Parts',
                'parent' => 'cwiclythemer',
                'href' => '' . admin_url('site-editor.php?postType=wp_template_part') . '',
                'meta' => array(
                    'title' => 'Go to Template Parts',
                ),
            );
            $wp_admin_bar->add_node($template_parts);

            $themer = array(
                'id' => 'ccthemer',
                'title' => 'Themer',
                'parent' => 'cwiclythemer',
                'href' => '' . admin_url('admin.php?page=cwicly') . '',
                'meta' => array(
                    'title' => 'Go to Cwicly Themer',
                ),
            );
            $wp_admin_bar->add_node($themer);

            $settings = array(
                'id' => 'ccsettings',
                'title' => 'Settings',
                'parent' => 'cwiclythemer',
                'href' => '' . admin_url('admin.php?page=cwicly-settings') . '',
                'meta' => array(
                    'title' => 'Go to Cwicly Settings',
                ),
            );
            $wp_admin_bar->add_node($settings);
        }
    }

    /**
     * Make global colours for the Cwicly global style frame.
     */
    public static function add_global_colors_to_iframe()
    {
        $globals = get_option('cwicly_global_styles');
        $final = array();
        if ($globals && $globals != '{}') {
            $globals = json_decode($globals);
            if (isset($globals->styles->{$globals->activeStyle}->colors)) {
                $array = $globals->styles->{$globals->activeStyle}->colors;
                foreach ($array as $key => $value) {
                    $final[] = array(
                        'name' => $value->name,
                        'slug' => 'cc-color-' . ($key + 1) . '',
                        'color' => 'var(--cc-color-' . ($key + 1) . ')',
                    );
                }
            }
            add_theme_support('editor-color-palette', $final);
        }
    }

    /**
     * Adds a class prefix to the main Cwicly settings so that we can style the icon.
     */
    public static function prefix_nav_menu_classes($items, $menu, $args)
    {
        _wp_menu_item_classes_by_context($items);
        return $items;
    }

    /**
     * Add necessary links to the plugin page for Cwicly.
     */
    public static function settings_links($links)
    {
        $action_links = array(
            'settings' => '<a href="' . admin_url('admin.php?page=cwicly-settings') . '" aria-label="' . esc_attr__('View Cwicly settings', 'cwicly') . '">' . esc_html__('Settings', 'cwicly') . '</a>',
            'documentation' => '<a href="https://docs.cwicly.com/" aria-label="' . esc_attr__('View Cwicly documentation', 'cwicly') . '" target="_blank" rel="noopener noreferrer">' . esc_html__('Documentation', 'cwicly') . '</a>',
        );

        return array_merge($action_links, $links);
    }

    /**
     * Redirect to getting start or settings page after activation.
     */
    public static function activation_redirect($plugin)
    {
        if ($plugin == plugin_basename(CWICLY_FILE)) {
            if (!get_option('cwicly_new_install')) {
                update_option('cwicly_new_install', true);
                exit(wp_redirect(admin_url('admin.php?page=cwicly-welcome')));
            } else {
                exit(wp_redirect(admin_url('admin.php?page=cwicly-settings')));
            }
        }
    }

    public static function enqueue_jquery_admin()
    {
        wp_enqueue_script('jquery');
        wp_enqueue_script(
            'cwicly-notify',
            CWICLY_DIR_URL . 'core/assets/js/dismisser.js',
            array('jquery')
        );
    }

    /**
     * AJAX handler to store the state of dismissible notices.
     */
    public static function ajax_notice_handler()
    {
        // Store it in the options table
        update_option('cwicly_regenerate_html', 'false');
    }

    /**
     * Initialize the updater. Hooked into `init` to work with the
     * wp_version_check cron job, which allows auto-updates.
     */
    public static function updater()
    {
        // To support auto-updates, this needs to run during the wp_version_check cron job for privileged users.
        $doing_cron = defined('DOING_CRON') && DOING_CRON;
        if (!current_user_can('manage_options') && !$doing_cron) {
            return;
        }

        if (get_option('cwicly_plugin_license_key_status') === 'valid') {

            if (defined('CC_LICENSE_KEY')) {
                // setup the updater
                $cwicly_updater = new \Cwicly_Plugin_Updater(
                    CC_STORE_URL,
                    CWICLY_FILE,
                    array(
                        'version' => CWICLY_VERSION,
                        'license' => CC_LICENSE_KEY,
                        'item_id' => CC_PLUGIN_ID,
                        'author' => 'Cwicly',
                        'beta' => CWICLY_BETA,
                    )
                );
            }

            if (class_exists('Cwicly_Theme_Updater') && defined('CC_LICENSE_THEME_KEY')) {
                $cwicly_theme_updater = new \Cwicly_Theme_Updater(
                    array(
                        'remote_api_url' => CC_STORE_URL,
                        'version' => CWICLY_THEME_VERSION,
                        'license' => CC_LICENSE_THEME_KEY,
                        'item_name' => 'Cwicly',
                        'author' => 'Cwicly',
                        'beta' => CWICLY_BETA,
                        'item_id' => CC_THEME_ID,
                        'theme_slug' => 'cwicly',
                    )
                );
            }
        }
    }
}
