<?php
namespace Cwicly;

if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

class Frontend
{
    public function __construct()
    {
        add_action('enqueue_block_assets', array($this, 'enqueue_block_assets'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue'));
        add_action('wp_head', array($this, 'global_fonts'));
    }

    public function enqueue_block_assets()
    {
        // LOAD CWICLY NORMALISER
        $url = apply_filters('cc_normaliser_frontend', CWICLY_DIR_URL . 'assets/css/base.css');
        wp_enqueue_style('CCnorm', $url, array(), CWICLY_VERSION);
        // LOAD CWICLY NORMALISER

        wp_enqueue_style('CC', CWICLY_DIR_URL . 'build/style-index.css', array('CCnorm'), CWICLY_VERSION);
    }

    public function enqueue()
    {
        if (!is_admin()) {
            wp_enqueue_script('CCers', CWICLY_DIR_URL . 'assets/js/ccers.min.js', null, CWICLY_VERSION, true);

            if (CC_WOOCOMMERCE && is_product()) {
                wp_enqueue_script('CCWoo', CWICLY_DIR_URL . 'assets/js/cc-woocommerce.min.js', null, CWICLY_VERSION, true);
            }
            // LOAD GLOBAL STYLES
            if (!is_admin()) {
                $globalCSS = get_option('cwicly_global_css');
                wp_register_style('cc-global', false);
                wp_enqueue_style('cc-global');

                wp_add_inline_style('cc-global', $globalCSS);
            }
            // LOAD GLOBAL STYLES

            // LOAD GLOBAL STYLESHEET
            if (!is_admin() && file_exists(wp_upload_dir()['basedir'] . '/cwicly/cc-global-stylesheets.css')) {
                wp_enqueue_style('cc-global-stylesheets', CC_UPLOAD_URL . '/cwicly/cc-global-stylesheets.css', array(), filemtime(wp_upload_dir()['basedir'] . '/cwicly/cc-global-stylesheets.css'));
            }

            // LOAD GLOBAL CLASSES
            if (!is_admin() && file_exists(wp_upload_dir()['basedir'] . '/cwicly/cc-global-classes.css')) {
                wp_enqueue_style('cc-global-classes', CC_UPLOAD_URL . '/cwicly/cc-global-classes.css', array(), filemtime(wp_upload_dir()['basedir'] . '/cwicly/cc-global-classes.css'));
            }

            if (!is_admin() && get_the_ID() && file_exists(wp_upload_dir()['basedir'] . '/cwicly/css/cc-post-' . get_the_ID() . '.css')) {
                wp_enqueue_style('cc-post-' . get_the_ID() . '', CC_UPLOAD_URL . '/cwicly/css/cc-post-' . get_the_ID() . '.css', array(), filemtime(wp_upload_dir()['basedir'] . '/cwicly/css/cc-post-' . get_the_ID() . '.css'));
            }

            $cwiclyOptimise = get_option('cwicly_optimise');
            $cwiclyDefaults = 'false';
            if (isset($cwiclyOptimise['cwiclyDefaults']) && $cwiclyOptimise['cwiclyDefaults'] === 'true') {
                $cwiclyDefaults = 'true';
            }
            $removeIDsClasses = 'false';
            if (isset($cwiclyOptimise['removeIDsClasses']) && $cwiclyOptimise['removeIDsClasses'] === 'true') {
                $removeIDsClasses = 'true';
            }

            $ccers = array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'restBase' => untrailingslashit(rest_url()),
                'nonce' => wp_create_nonce('wp_rest'),
                'logoutNonce' => wp_create_nonce('log-out'),
                'loggedIn' => is_user_logged_in() ? true : false,
                'cwiclyDefaults' => $cwiclyDefaults,
                'postID' => get_the_ID(),
                'removeIDsClasses' => $removeIDsClasses,
            );

            if (CC_WOOCOMMERCE) {
                $ccers['woo'] = array(
                    'currency' => html_entity_decode(get_woocommerce_currency_symbol()),
                    'currencyCode' => get_woocommerce_currency(),
                    'currencyPosition' => get_option('woocommerce_currency_pos'),
                    'nonce' => wp_create_nonce('wc_store_api'),
                    'chooseOption' => __('Choose an option', 'woocommerce'),
                    'mainVariations' => $this->cc_woo_variationer_local(),
                    'checkoutURL' => wc_get_checkout_url(),
                    'cartURL' => wc_get_cart_url(),
                );
            }

            wp_localize_script('CCers', 'CCers', $ccers);
        }

        $localfonts = get_option('cwicly_local_fonts');
        $localactivefonts = get_option('cwicly_local_active_fonts');

        $global_local_fonts = get_option('cwicly_global_css_fonts');
        if ($global_local_fonts) {
            foreach ($global_local_fonts as $global_font) {
                if (str_contains($global_font, 'google-') || str_contains($global_font, 'custom-')) {
                    if (isset($localactivefonts) && is_array($localactivefonts) && in_array($global_font, $localactivefonts)) {
                        if (isset($localfonts) && is_array($localfonts) && isset($localfonts[$global_font]) && $localfonts[$global_font]) {
                            $css = '';
                            if (isset($localfonts[$global_font]['css']) && $localfonts[$global_font]['css']) {
                                $css = $localfonts[$global_font]['css'];
                            } else if (isset($localfonts[$global_font]['originalCSS']) && $localfonts[$global_font]['originalCSS']) {
                                $css = $localfonts[$global_font]['originalCSS'];
                            }
                            $font = str_replace(' ', '-', $localfonts[$global_font]['family']);
                            if (!wp_style_is('cc-cf-' . $font, 'enqueued')) {
                                wp_register_style('cc-cf-' . $font, false);
                                wp_enqueue_style('cc-cf-' . $font);

                                wp_add_inline_style('cc-cf-' . $font, $css);
                            }
                        }
                    }
                }
            }
        }

        $cwicly_global_classes = get_option('cwicly_global_classes');
        if ($cwicly_global_classes && $localactivefonts && is_array($localactivefonts) && count($localactivefonts) > 0) {
            $global_classes = $this->get_custom_fonts_global_classes($cwicly_global_classes);
            foreach ($global_classes as $global_class) {
                if (str_contains($global_class, 'google-') || str_contains($global_class, 'custom-')) {
                    if (isset($localactivefonts) && is_array($localactivefonts) && in_array($global_class, $localactivefonts)) {
                        if (isset($localfonts) && is_array($localfonts) && isset($localfonts[$global_class]) && $localfonts[$global_class]) {
                            $css = '';
                            if (isset($localfonts[$global_class]['css']) && $localfonts[$global_class]['css']) {
                                $css = $localfonts[$global_class]['css'];
                            } else if (isset($localfonts[$global_class]['originalCSS']) && $localfonts[$global_class]['originalCSS']) {
                                $css = $localfonts[$global_class]['originalCSS'];
                            }
                            $font = str_replace(' ', '-', $localfonts[$global_class]['family']);
                            if (!wp_style_is('cc-cf-' . $font, 'enqueued')) {
                                wp_register_style('cc-cf-' . $font, false);
                                wp_enqueue_style('cc-cf-' . $font);

                                wp_add_inline_style('cc-cf-' . $font, $css);
                            }
                        }
                    }
                }
            }
        }
    }

    public function get_custom_fonts_global_classes($inputString)
    {
        $parsedInput = json_decode($inputString, true);
        $fontFamilies = array();

        foreach ($parsedInput as $key => $value) {
            $attributes = $value['attributes'];
            if ($attributes['fontLocation'] === 'custom' && isset($attributes['fontFamily'])) {
                array_push($fontFamilies, $attributes['fontFamily']);
            }
        }

        return $fontFamilies;
    }

    public function global_fonts()
    {
        $globalFonts = get_option('cwicly_global_fonts');
        if ($globalFonts) {
            echo $globalFonts;
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
