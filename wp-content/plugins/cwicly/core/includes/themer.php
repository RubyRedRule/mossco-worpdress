<?php
namespace Cwicly;

if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

class Themer
{

    /**
     * Themer constructor.
     */
    public function __construct()
    {
        add_action('template_redirect', [$this, 'add_global_fragments']);
        add_filter('get_block_templates', [$this, 'defaults_admin_namer'], 10, 3);
        add_filter('render_block', [$this, 'render_block'], 10, 3);
        remove_filter('wp_footer', 'the_block_template_skip_link');
        add_action('wp_footer', [$this, 'skip_link']);
    }

    /**
     * Add Cwicly stylesheets to the head
     * @param string $theme
     * @param string $slug
     * @param string $type
     */
    public static function add_template_styles($theme, $slug, $type)
    {
        if (!$theme && !$slug && !$type) {
            return;
        }
        $depencencies = array('CC', 'CCnorm', 'cc-global');
        if (!is_admin() && file_exists(wp_upload_dir()['basedir'] . '/cwicly/cc-global-stylesheets.css')) {
            $depencencies[] = 'cc-global-stylesheets';
        }
        if (!is_admin() && file_exists(wp_upload_dir()['basedir'] . '/cwicly/cc-global-classes.css')) {
            $depencencies[] = 'cc-global-classes';
        }

        if ($type === 'tp') {
            if (isset($theme) && $theme && isset($slug) && $slug) {
                if (!is_admin() && file_exists(wp_upload_dir()['basedir'] . '/cwicly/css/cc-tp-' . $theme . '_' . $slug . '.css')) {
                    wp_enqueue_style('cc-' . $theme . '_' . $slug . '', CC_UPLOAD_URL . '/cwicly/css/cc-tp-' . $theme . '_' . $slug . '.css', $depencencies, filemtime(wp_upload_dir()['basedir'] . '/cwicly/css/cc-tp-' . $theme . '_' . $slug . '.css'));
                }
            }
        } else if ($type === 'rb' && isset($slug) && $slug) {
            if (!is_admin() && file_exists(wp_upload_dir()['basedir'] . '/cwicly/css/cc-rb-' . $slug . '.css')) {
                wp_enqueue_style('cc-' . $slug . '', CC_UPLOAD_URL . '/cwicly/css/cc-rb-' . $slug . '.css', $depencencies, filemtime(wp_upload_dir()['basedir'] . '/cwicly/css/cc-rb-' . $slug . '.css'));
            }
        } else if ($type === 'post' && isset($slug) && $slug) {
            if (!is_admin() && file_exists(wp_upload_dir()['basedir'] . '/cwicly/css/cc-post-' . $slug . '.css')) {
                wp_enqueue_style('cc-' . $slug . '', CC_UPLOAD_URL . '/cwicly/css/cc-post-' . $slug . '.css', $depencencies, filemtime(wp_upload_dir()['basedir'] . '/cwicly/css/cc-post-' . $slug . '.css'));
            }
        }
    }

    /**
     * Retrieve all template parts for a given fragment
     * @param string $fragment
     * @return array
     */
    public static function get_fragment($fragment)
    {
        if (is_admin()) {
            return;
        }
        $option = get_option('cwicly_global_parts');
        $final = '';
        if (isset($option['fragments'][$fragment]['conditions']) && $option['fragments'][$fragment]['conditions']) {
            $final = cc_condition_checker($option['fragments'][$fragment]['conditions']);
        }
        return $final;
    }

    /**
     * Retrieve and add all global fragments
     */
    public static function add_global_fragments()
    {
        if (is_admin()) {
            return;
        }
        $header = self::get_fragment('globalheader');
        if (isset($header) && is_array($header)) {
            foreach ($header as $templates) {
                foreach ($templates as $template) {
                    $block = do_blocks($template->content);

                    if ($template->theme && $template->slug) {
                        self::add_template_styles($template->theme, $template->slug, 'tp');
                        self::namer($template->title, $template->slug, 'wp_template_part');
                    }

                    add_action('wp_body_open', function () use ($block) {
                        echo $block;
                    });
                }
            }
        }

        $footer = self::get_fragment('globalfooter');
        if (isset($footer) && is_array($footer)) {
            foreach ($footer as $templates) {
                foreach ($templates as $template) {
                    $block = do_blocks($template->content);

                    if ($template->theme && $template->slug) {
                        self::add_template_styles($template->theme, $template->slug, 'tp');
                        self::namer($template->theme, $template->slug, 'wp_template_part');
                    }

                    add_action('wp_footer', function () use ($block) {
                        echo $block;
                    });
                }
            }
        }
    }

    /**
     * Check template parts and add styles to head
     *
     * @param string   $block_content The block content about to be appended.
     * @param array    $block         The full block, including name and attributes.
     * @param WP_Block $instance      The block instance.
     *
     * @return string
     */
    public function render_block($block_content, $block, $instance)
    {
        if (is_admin()) {
            return '';
        }

        if (isset($block['blockName']) && str_contains($block['blockName'], 'cwicly/') && isset($block['attrs']['fontFamily'])) {
            $this->local_font_maker($block['attrs']['fontFamily']);
        }
        if (isset($block['blockName']) && $block['blockName'] === 'cwicly/gallery') {
            $gallery_locations = array(
                'galleryFontTitleFamily',
                'galleryFontDescriptionFamily',
                'galleryFilterFontFamily',
                'galleryFilterActiveFontFamily',
            );
            foreach ($gallery_locations as $location) {
                if (isset($block['attrs'][$location])) {
                    $this->local_font_maker($block['attrs'][$location]);
                }
            }
        } else if (isset($block['blockName']) && $block['blockName'] === 'cwicly/menu') {
            $menu_locations = array(
                'menuMainMenuFontFamily',
                'menuSubMenuFontFamily',
            );
            foreach ($menu_locations as $location) {
                if (isset($block['attrs'][$location])) {
                    $this->local_font_maker($block['attrs'][$location]);
                }
            }
        }

        if (isset($block['blockName']) && $block['blockName'] === 'core/template-part' && isset($block['attrs']['slug']) && isset($block['attrs']['theme'])) {
            self::add_template_styles($block['attrs']['theme'], $block['attrs']['slug'], 'tp');
            $args = array(
                'name' => $block['attrs']['slug'],
                'post_type' => 'wp_template_part',
                'post_status' => 'publish',
                'numberposts' => 1,
            );
            $my_posts = get_posts($args);
            $name = '';
            if ($my_posts) {
                $name = $my_posts[0]->post_title;
            }
            self::namer($name, $block['attrs']['slug'], 'wp_template_part');
        } else if (isset($block['blockName']) && $block['blockName'] === 'core/block' && isset($block['attrs']['ref'])) {
            self::add_template_styles('', $block['attrs']['ref'], 'rb');
        }
        return $block_content;
    }

    public function local_font_maker($font_location)
    {
        $localfonts = get_option('cwicly_local_fonts');
        $localactivefonts = get_option('cwicly_local_active_fonts');

        if (isset($localactivefonts) && is_array($localactivefonts) && in_array($font_location, $localactivefonts)) {
            if (isset($localfonts) && is_array($localfonts) && isset($localfonts[$font_location]) && $localfonts[$font_location]) {
                $css = '';
                if (isset($localfonts[$font_location]['css']) && $localfonts[$font_location]['css']) {
                    $css = $localfonts[$font_location]['css'];
                } else if (isset($localfonts[$font_location]['originalCSS']) && $localfonts[$font_location]['originalCSS']) {
                    $css = $localfonts[$font_location]['originalCSS'];
                }
                $font = str_replace(' ', '-', $localfonts[$font_location]['family']);
                if (!wp_style_is('cc-cf-' . $font, 'enqueued')) {
                    wp_register_style('cc-cf-' . $font, false);
                    wp_enqueue_style('cc-cf-' . $font);

                    wp_add_inline_style('cc-cf-' . $font, $css);
                }
            }
        }
    }

    /**
     * if default template, add information to the admin bar
     *
     * @param WP_Block_Template[] $query_result  Array of found block templates.
     * @param array               $query         Optional. Arguments to retrieve templates.
     * @param string              $template_type wp_template or wp_template_part.
     *
     * @return WP_Block_Template[]
     */
    public function defaults_admin_namer($query_result, $query, $template_type)
    {
        if (is_admin()) {
            return $query_result;
        }
        if ($template_type === 'wp_template') {
            if (isset($query_result[0]->title) && isset($query_result[0]->slug)) {
                self::namer($query_result[0]->title, $query_result[0]->slug, 'wp_template');
                self::add_template_styles(get_stylesheet(), $query_result[0]->slug, 'tp');
            }
        }
        // filter...
        return $query_result;
    }

    /**
     * Name templates in admin bar
     * @param string $templater
     * @param string $slug
     * @param string $type
     */
    public static function namer($templater, $slug, $type)
    {
        if (is_admin()) {
            return;
        }
        if (is_user_logged_in() && !Capabilities::permission('miscellaneous', 'hideAdminBarTemplateInfo') && (current_user_can('editor') || current_user_can('administrator'))) {

            $theme_text_domain = get_stylesheet();
            $linktoedit = '';

            if (WORDPRESS_VERSION >= 5.9) {
                $linktoedit = '' . admin_url('site-editor.php?postType=' . $type . '&postId=' . $theme_text_domain . '%2F%2F' . $slug . '') . '';
            } else {
                $linktoedit = '' . admin_url('themes.php?page=gutenberg-edit-site&postType=' . $type . '&postId=' . $theme_text_domain . '%2F%2F' . $slug . '') . '';
            }

            if ($type === 'wp_template') {
                $cwicly_icon = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTA4MCIgaGVpZ2h0PSIxMDgwIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgMTkyMCAxMDgwIiB4bWw6c3BhY2U9InByZXNlcnZlIj4KIDxnPgogIDx0aXRsZT5MYXllciAxPC90aXRsZT4KICA8ZyBpZD0ic3ZnXzIiPgogICA8ZyBpZD0ic3ZnXzMiPgogICAgPHBhdGggZmlsbD0iI2EyYWFiMiIgZD0ibTUwMC40NTMzOSw3MjMuMzc0MThjLTAuMiwxMSAtNS4zLDIxLjQgLTEzLjgsMjguNGMtMTEwLjgsODkuMSAtMjcxLjcsNzcuNyAtMzY4LjgsLTI2LjNjLTk3LjEsLTEwMy45IC05Ny42LC0yNjUuMiAtMS4xLC0zNjkuN2M5Ni41LC0xMDQuNSAyNTcuMiwtMTE3IDM2OC42LC0yOC41YzE2LjMsMTIuOSAxOS4xLDM2LjYgNi4yLDUzcy0zNi41LDE5LjMgLTUyLjksNi41Yy04MC4zLC02NCAtMTk2LjQsLTU1LjMgLTI2Ni4xLDIwYy02OS44LDc1LjMgLTY5LjYsMTkxLjcgMC4zLDI2Ni45czE4Ni4xLDgzLjYgMjY2LjIsMTkuNGMxNC40LC0xMS41IDM1LjEsLTEwLjkgNDguOCwxLjRjOC4zLDcuMyAxMi45LDE3LjkgMTIuNiwyOC45eiIgaWQ9InN2Z180Ii8+CiAgICA8cGF0aCBmaWxsPSIjYTJhYWIyIiBkPSJtNzYzLjY1MzM5LDI2OC4yNzQxOGMxMTkuMSwwIDIyNC4zLDc3LjYgMjU5LjUsMTkxLjRjMzUuMiwxMTMuOCAtNy45LDIzNy4zIC0xMDYuMiwzMDQuNXMtMjI5LDYyLjYgLTMyMi4zLC0xMS41Yy04LjYsLTYuOSAtMTMuNywtMTcuMiAtMTQsLTI4LjJzNC4yLC0yMS42IDEyLjQsLTI5YzEzLjQsLTEyLjQgMzMuOCwtMTMuNCA0OC4zLC0yLjJjODAuMyw2NCAxOTYuNCw1NS4zIDI2Ni4xLC0yMGM2OS44LC03NS4zIDY5LjYsLTE5MS43IC0wLjMsLTI2Ni45Yy03MCwtNzUuMiAtMTg2LjEsLTgzLjYgLTI2Ni4yLC0xOS40Yy0xNC40LDExLjUgLTM1LjEsMTAuOSAtNDguOCwtMS40Yy04LjIsLTcuMyAtMTIuOCwtMTcuOSAtMTIuNiwtMjguOWMwLjIsLTExIDUuMywtMjEuNCAxMy44LC0yOC4zYzQ4LjQsLTM4LjkgMTA4LjQsLTYwIDE3MC4zLC02MC4xbDAsMHoiIGlkPSJzdmdfNSIvPgogICA8L2c+CiAgPC9nPgogPC9nPgoKPC9zdmc+';
                $args = array(
                    'id' => 'cwiclythemer',
                    'title' => '<style>#wpadminbar #wp-admin-bar-cwiclythemer>.ab-item:before {content: "";top: 3px;width: 26px;height: 26px;background-position: center;background-repeat: no-repeat;background-size: 23px; background-image: url(' . $cwicly_icon . ')!important;}</style><span style="--hello: url(' . $cwicly_icon . ');">Template: ' . $templater . '</span>',
                    'href' => $linktoedit,
                );
                Helpers::add_admin_menu_item($args, '');
            }

            if ($type === 'wp_template') {
                $template = array(
                    'id' => 'fsetemplate',
                    'title' => 'Edit Template',
                    'parent' => 'cwiclythemer',
                    'href' => $linktoedit,
                    'meta' => array(
                        'title' => 'Edit ' . $templater . '',
                    ),
                );
                Helpers::add_admin_menu_item($template, '', 20);
            }

            if ($type === 'wp_template_part') {
                $template_parts = array(
                    'id' => 'cctemplatepart-' . $slug . '',
                    'title' => $templater,
                    'parent' => 'cctemplateparts',
                    'href' => $linktoedit,
                    'meta' => array(
                        'title' => 'Go to Cwicly Template Parts',
                    ),
                );
                Helpers::add_admin_menu_item($template_parts);
            }
        }
        return;
    }

    /**
     * Prints the skip-link script & styles.
     *
     * @access private
     * @since 5.8.0
     *
     * @global string $_wp_current_template_content
     *
     * @return void
     */
    public static function skip_link()
    {
        global $_wp_current_template_content;

        // Early exit if not a block theme.
        if (!current_theme_supports('block-templates')) {
            return;
        }

        // Early exit if not a block template.
        if (!$_wp_current_template_content) {
            return;
        }

        $shortcut = apply_filters('cc_skip_link', null);
        if (!is_null($shortcut)) {
            return $shortcut;
        }
        ?>

    <?php
/**
         * Print the skip-link styles.
         */
        ?>
    <style id="skip-link-styles">.skip-link.screen-reader-text{border:0;clip:rect(1px,1px,1px,1px);clip-path:inset(50%);height:1px;margin:-1px;overflow:hidden;padding:0;position:absolute!important;width:1px;word-wrap:normal!important}.skip-link.screen-reader-text:focus{background-color:#eee;clip:auto!important;clip-path:none;color:#444;display:block;font-size:1em;height:auto;left:5px;line-height:normal;padding:15px 23px 14px;text-decoration:none;top:5px;width:auto;z-index:100000}</style>
    <?php
/**
         * Print the skip-link script.
         */
        ?>
    <script>
        (function() {
            var skipLinkTarget = document.querySelector('main'),
                sibling,
                skipLinkTargetID,
                skipLink;

            // Early exit if a skip-link target can't be located.
            if (!skipLinkTarget) {
                return;
            }

            // Get the site wrapper.
            // The skip-link will be injected in the beginning of it.
            sibling = document.body && document.body.firstChild;

            // Early exit if the root element was not found.
            if (!sibling) {
                return;
            }

            // Get the skip-link target's ID, and generate one if it doesn't exist.
            skipLinkTargetID = skipLinkTarget.id;
            if (!skipLinkTargetID) {
                skipLinkTargetID = 'wp--skip-link--target';
                skipLinkTarget.id = skipLinkTargetID;
            }

            // Create the skip link.
            skipLink = document.createElement('a');
            skipLink.classList.add('skip-link', 'screen-reader-text');
            skipLink.href = '#' + skipLinkTargetID;
            skipLink.innerHTML = '<?php esc_html_e('Skip to content');?>';

            // Inject the skip link.
            sibling.parentElement.insertBefore(skipLink, sibling);
        }());
    </script>
<?php
}
}
