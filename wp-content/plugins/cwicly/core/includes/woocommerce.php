<?php
namespace Cwicly;

if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

class WooCommerce
{
    public function __construct()
    {
        add_filter('woocommerce_product_variation_title_include_attributes', '__return_true');
        add_action('admin_enqueue_scripts', [$this, 'enqueue_color_picker']);
        add_action('edit_term', [$this, 'cwicly_save_term_fields'], 10, 2);
        add_action('create_term', [$this, 'cwicly_save_term_fields'], 10, 2);
        $this->add_form_fields();
        add_action('current_screen', [$this, 'woo_current_screen']);
        add_filter('woocommerce_variation_is_active', [$this, 'grey_out_variations_out_of_stock'], 10, 2);
    }

    public static function dynamic_price($price, $price_format)
    {
        $contenter = $price;
        if (isset($price_format)) {
            if ($price_format === 'formatted') {
                $contenter = WooCommerce::format_price($price, array('ex_tax_label' => false));
            } else if ($price_format === 'formattedcurrency') {
                $contenter = WooCommerce::format_price($price, array('show_currency' => true, 'ex_tax_label' => false));
            } else if ($price_format === 'formattedtax') {
                $contenter = WooCommerce::format_price($price, array('ex_tax_label' => false));
            } else if ($price_format === 'formattedtaxcurrency') {
                $contenter = WooCommerce::format_price($price, array('show_currency' => true, 'ex_tax_label' => false));
            }
        } else {
            $contenter = $price;
        }
        return $contenter;
    }

    public static function format_price($price, $args = array())
    {
        $args = apply_filters(
            'wc_price_args',
            wp_parse_args(
                $args,
                array(
                    'ex_tax_label' => true,
                    'currency' => '',
                    'show_currency' => false,
                    'decimal_separator' => wc_get_price_decimal_separator(),
                    'thousand_separator' => wc_get_price_thousand_separator(),
                    'decimals' => wc_get_price_decimals(),
                    'price_format' => get_woocommerce_price_format(),
                )
            )
        );

        $original_price = $price;

        // Convert to float to avoid issues on PHP 8.
        $price = (float) $price;

        $unformatted_price = $price;
        $negative = $price < 0;

        /**
         * Filter raw price.
         *
         * @param float        $raw_price      Raw price.
         * @param float|string $original_price Original price as float, or empty string. Since 5.0.0.
         */
        $price = apply_filters('raw_woocommerce_price', $negative ? $price * -1 : $price, $original_price);

        /**
         * Filter formatted price.
         *
         * @param float        $formatted_price    Formatted price.
         * @param float        $price              Unformatted price.
         * @param int          $decimals           Number of decimals.
         * @param string       $decimal_separator  Decimal separator.
         * @param string       $thousand_separator Thousand separator.
         * @param float|string $original_price     Original price as float, or empty string. Since 5.0.0.
         */
        $price = apply_filters('formatted_woocommerce_price', number_format($price, $args['decimals'], $args['decimal_separator'], $args['thousand_separator']), $price, $args['decimals'], $args['decimal_separator'], $args['thousand_separator'], $original_price);

        if (apply_filters('woocommerce_price_trim_zeros', false) && $args['decimals'] > 0) {
            $price = wc_trim_zeros($price);
        }

        if ($args['show_currency']) {
            $currency = '<span class="currency">' . get_woocommerce_currency_symbol($args['currency']) . '</span>';
        } else {
            $currency = '';
        }

        $return = ($negative ? '-' : '') . sprintf($args['price_format'], $currency, $price);

        if ($args['ex_tax_label'] && wc_tax_enabled()) {
            // $return .= ' <small class="woocommerce-Price-taxLabel tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
            $return .= ' <small class="tax">' . WC()->countries->ex_tax_or_vat() . '</small>';
        }
        return $return;
    }

    public static function price_maker($product, $args = [], $type = '')
    {
        if (isset($product) && $product && is_object($product)) {
            $price = $product->get_price();
            if ($type === 'regular') {
                $price = $product->get_regular_price();
            }
            $value = '';

            if ($product->get_type() === 'variable') {
                // get min and max price of variable product
                $prices = $product->get_variation_prices();
                $min_price = current($prices['price']);
                $max_price = end($prices['price']);
                if ($min_price !== $max_price) {
                    $price = wc_price($min_price) . ' - ' . wc_price($max_price);
                    if (isset($args[0]) && $args[0]) {
                        $price = $product->get_price();
                        $value = WooCommerce::dynamic_price($min_price, $args[0]) . ' - ' . WooCommerce::dynamic_price($max_price, $args[0]);
                    } else {
                        $value = WooCommerce::dynamic_price($min_price, false);
                    }
                } else if (isset($args[0]) && $args[0]) {
                    $value = WooCommerce::dynamic_price($price, $args[0]);
                } else {
                    $value = $product->get_price();
                }
            } else if ($product->get_type() === 'grouped') {
                // Check if the product is a grouped product
                if ($product->is_type('grouped')) {
                    // Get the child products of the grouped product
                    $child_products = $product->get_children();

                    // Initialize variables for minimum and maximum price
                    $min_price = PHP_INT_MAX;
                    $max_price = 0;

                    // Loop through the child products
                    foreach ($child_products as $child_product_id) {
                        // Get the child product object
                        $child_product = wc_get_product($child_product_id);

                        // Get the price of the child product
                        $price = $child_product->get_price();

                        // Update the minimum and maximum price variables
                        $min_price = min($min_price, $price);
                        $max_price = max($max_price, $price);
                    }
                    if ($min_price !== $max_price) {
                        $price = wc_price($min_price) . ' - ' . wc_price($max_price);
                        if (isset($args[0]) && $args[0]) {
                            $price = $product->get_price();
                            $value = WooCommerce::dynamic_price($min_price, $args[0]) . ' - ' . WooCommerce::dynamic_price($max_price, $args[0]);
                        } else {
                            $value = WooCommerce::dynamic_price($min_price, false);
                        }
                    } else if (isset($args[0]) && $args[0]) {
                        $value = WooCommerce::dynamic_price($price, $args[0]);
                    } else {
                        $value = $product->get_price();
                    }
                }
            } else if (isset($args[0]) && $args[0]) {
                $value = WooCommerce::dynamic_price($price, $args[0]);
            } else {
                $value = $price;
            }
            return $value;
        }
    }

    public static function percentage_calculator($product)
    {
        $percentage = '';
        if ($product->is_type('variable')) {
            $percentages = array();

            // Get all variation prices
            $prices = $product->get_variation_prices();

            // Loop through variation prices
            foreach ($prices['price'] as $key => $price) {
                // Only on sale variations
                if ($prices['regular_price'][$key] !== $price) {
                    // Calculate and set in the array the percentage for each variation on sale
                    $percentages[] = round(100 - (floatval($prices['sale_price'][$key]) / floatval($prices['regular_price'][$key]) * 100));
                }
            }
            // We keep the highest value
            if ($percentage) {
                $percentage = max($percentages) . '%';
            }
        } elseif ($product->is_type('grouped')) {
            $percentages = array();

            // Get all variation prices
            $children_ids = $product->get_children();

            // Loop through variation prices
            foreach ($children_ids as $child_id) {
                $child_product = wc_get_product($child_id);

                $regular_price = (float) $child_product->get_regular_price();
                $sale_price = (float) $child_product->get_sale_price();

                if ($sale_price != 0 || !empty($sale_price)) {
                    // Calculate and set in the array the percentage for each child on sale
                    $percentages[] = round(100 - ($sale_price / $regular_price * 100));
                }
            }
            // We keep the highest value
            if ($percentage) {
                $percentage = max($percentages) . '%';
            }
        } else {
            $regular_price = (float) $product->get_regular_price();
            $sale_price = (float) $product->get_sale_price();

            if ($sale_price != 0 || !empty($sale_price)) {
                $percentage = round(100 - ($sale_price / $regular_price * 100)) . '%';
            }
        }
        return $percentage;
    }

    public function enqueue_color_picker()
    {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('cwicly-backend', CWICLY_DIR_URL . 'core/assets/js/backend.js', array('wp-color-picker'), false, true);
        wp_enqueue_media();
    }

    public function cwicly_save_term_fields($term_id, $taxonomy)
    {

        if (isset($_POST['_cwicly_color']) && !empty($_POST['_cwicly_color'])) {
            update_term_meta($term_id, '_cwicly_color', sanitize_hex_color($_POST['_cwicly_color']));
        }

        if (isset($_POST['_cwicly_image_id'])) {
            update_term_meta($term_id, '_cwicly_image_id', absint($_POST['_cwicly_image_id']));
        }
    }

    public function woo_current_screen()
    {
        if (function_exists('get_current_screen')) {

            $pt = get_current_screen()->base;
            if ($pt === 'product_page_product_attributes') {
                add_filter("product_attributes_type_selector", function ($array) {
                    $array["button"] = __('Button', 'woocommerce');
                    // $array["radio"] = __('Radio', 'woocommerce');
                    $array["color"] = __('Color', 'woocommerce');
                    $array["image"] = __('Image', 'woocommerce');
                    return $array;
                });
            }
        }
    }

    public function add_form_fields()
    {
        if (isset($_GET['taxonomy']) && !empty($_GET['taxonomy'])) {
            $taxonomy_name = $_GET['taxonomy'];

            if (strpos($taxonomy_name, 'pa_') !== false) {
                add_action($taxonomy_name . '_add_form_fields', [$this, 'add_woo_pa_field'], 10, 2);
                add_action($taxonomy_name . '_edit_form_fields', [$this, 'add_woo_pa_field_edit'], 10, 2);
            }
        }
    }

    public function add_woo_pa_field($term)
    {
        $get_terms_id = wc_attribute_taxonomy_id_by_name($term);
        $get_terms = wc_get_attribute($get_terms_id);
        if ($get_terms->type === 'color') {
            ?>
        <div class="form-field">
            <label for="term-colorpicker"><?php echo __('Color', 'woocommerce'); ?></label>
            <input type="text" name="_cwicly_color" class="colorpicker" id="term-colorpicker" />
            <!-- <p><?php echo __('Color HEX goes here.', 'woocommerce'); ?></p> -->
        </div>
    <?php
}
        if ($get_terms->type === 'image') {
            ?>
        <div class="form-field term-thumbnail-wrap">
            <label><?php esc_html_e('Image', 'woocommerce');?></label>
            <div id="product_cat_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url(wc_placeholder_img_src()); ?>" width="60px" height="60px" /></div>
            <div style="line-height: 60px;">
                <input type="hidden" id="_cwicly_image_id" name="_cwicly_image_id" />
                <button type="button" class="upload_image_button button"><?php esc_html_e('Upload/Add image', 'woocommerce');?></button>
                <button type="button" class="remove_image_button button"><?php esc_html_e('Remove image', 'woocommerce');?></button>
            </div>
            <script type="text/javascript">
                // Only show the "remove image" button when needed
                if (!jQuery('#_cwicly_image_id').val()) {
                    jQuery('.remove_image_button').hide();
                }

                // Uploading files
                var file_frame;

                jQuery(document).on('click', '.upload_image_button', function(event) {

                    event.preventDefault();

                    // If the media frame already exists, reopen it.
                    if (file_frame) {
                        file_frame.open();
                        return;
                    }

                    // Create the media frame.
                    file_frame = wp.media.frames.downloadable_file = wp.media({
                        title: '<?php esc_html_e('Choose an image', 'woocommerce');?>',
                        button: {
                            text: '<?php esc_html_e('Use image', 'woocommerce');?>'
                        },
                        multiple: false
                    });

                    // When an image is selected, run a callback.
                    file_frame.on('select', function() {
                        var attachment = file_frame.state().get('selection').first().toJSON();
                        var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

                        jQuery('#_cwicly_image_id').val(attachment.id);
                        jQuery('#product_cat_thumbnail').find('img').attr('src', attachment_thumbnail.url);
                        jQuery('.remove_image_button').show();
                    });

                    // Finally, open the modal.
                    file_frame.open();
                });

                jQuery(document).on('click', '.remove_image_button', function() {
                    jQuery('#product_cat_thumbnail').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
                    jQuery('#_cwicly_image_id').val('');
                    jQuery('.remove_image_button').hide();
                    return false;
                });

                jQuery(document).ajaxComplete(function(event, request, options) {
                    if (request && 4 === request.readyState && 200 === request.status &&
                        options.data && 0 <= options.data.indexOf('action=add-tag')) {

                        var res = wpAjax.parseAjaxResponse(request.responseXML, 'ajax-response');
                        if (!res || res.errors) {
                            return;
                        }
                        // Clear Thumbnail fields on submit
                        jQuery('#product_cat_thumbnail').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
                        jQuery('#_cwicly_image_id').val('');
                        jQuery('.remove_image_button').hide();
                        // Clear Display type field on submit
                        jQuery('#display_type').val('');
                        return;
                    }
                });
            </script>
            <div class="clear"></div>
        </div>
    <?php
}
    }

    public function add_woo_pa_field_edit($term, $taxonomy)
    {
        $get_terms_id = wc_attribute_taxonomy_id_by_name($taxonomy);
        $get_terms = wc_get_attribute($get_terms_id);
        if ($get_terms->type === 'color') {
            $value = get_term_meta($term->term_id, '_cwicly_color', true);
            ?>
        <tr class="form-field">
            <th>
                <label for="term-colorpicker"><?php echo __('Color', 'woocommerce'); ?></label>
            </th>
            <td>
                <input type="text" name="_cwicly_color" id="term-colorpicker" class="colorpicker" value="<?php echo esc_attr($value); ?>" />
                <!-- <p><?php echo __('Color HEX goes here.', 'woocommerce'); ?></p> -->
            </td>
        </tr>
    <?php
}

        if ($get_terms->type === 'image') {

            $thumbnail_id = absint(get_term_meta($term->term_id, '_cwicly_image_id', true));

            if ($thumbnail_id) {
                $image = wp_get_attachment_thumb_url($thumbnail_id);
            } else {
                $image = wc_placeholder_img_src();
            }
            ?>
        <tr class="form-field term-thumbnail-wrap">
            <th scope="row" valign="top"><label><?php esc_html_e('Image', 'woocommerce');?></label></th>
            <td>
                <div id="product_cat_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url($image); ?>" width="60px" height="60px" /></div>
                <div style="line-height: 60px;">
                    <input type="hidden" id="_cwicly_image_id" name="_cwicly_image_id" value="<?php echo esc_attr($thumbnail_id); ?>" />
                    <button type="button" class="upload_image_button button"><?php esc_html_e('Upload/Add image', 'woocommerce');?></button>
                    <button type="button" class="remove_image_button button"><?php esc_html_e('Remove image', 'woocommerce');?></button>
                </div>
                <script type="text/javascript">
                    // Only show the "remove image" button when needed
                    if ('0' === jQuery('#_cwicly_image_id').val()) {
                        jQuery('.remove_image_button').hide();
                    }

                    // Uploading files
                    var file_frame;

                    jQuery(document).on('click', '.upload_image_button', function(event) {

                        event.preventDefault();

                        // If the media frame already exists, reopen it.
                        if (file_frame) {
                            file_frame.open();
                            return;
                        }

                        // Create the media frame.
                        file_frame = wp.media.frames.downloadable_file = wp.media({
                            title: '<?php esc_html_e('Choose an image', 'woocommerce');?>',
                            button: {
                                text: '<?php esc_html_e('Use image', 'woocommerce');?>'
                            },
                            multiple: false
                        });

                        // When an image is selected, run a callback.
                        file_frame.on('select', function() {
                            var attachment = file_frame.state().get('selection').first().toJSON();
                            var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

                            jQuery('#_cwicly_image_id').val(attachment.id);
                            jQuery('#product_cat_thumbnail').find('img').attr('src', attachment_thumbnail.url);
                            jQuery('.remove_image_button').show();
                        });

                        // Finally, open the modal.
                        file_frame.open();
                    });

                    jQuery(document).on('click', '.remove_image_button', function() {
                        jQuery('#product_cat_thumbnail').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
                        jQuery('#_cwicly_image_id').val('');
                        jQuery('.remove_image_button').hide();
                        return false;
                    });
                </script>
                <div class="clear"></div>
            </td>
        </tr>
<?php
}
    }

    public function grey_out_variations_out_of_stock($is_active, $variation)
    {
        if (!$variation->is_in_stock()) {
            return false;
        }

        return $is_active;
    }
}
