<?php
/**
 * WooCommerce Subscriptions Extend Store API.
 *
 * A class to extend the store public API with subscription related data
 * for each subscription item
 *
 * @package WooCommerce Subscriptions
 */
use Automattic\WooCommerce\StoreApi\Schemas\ExtendSchema;
use Automattic\WooCommerce\StoreApi\Schemas\V1\CartItemSchema;
use Automattic\WooCommerce\StoreApi\Schemas\V1\CartSchema;
use Automattic\WooCommerce\StoreApi\Schemas\V1\ProductSchema;
use Automattic\WooCommerce\StoreApi\StoreApi;

add_action('woocommerce_blocks_loaded', function () {
    $extend = StoreApi::container()->get(ExtendSchema::class);
    CC_Extend_Store_Endpoint::init($extend);
});

class CC_Extend_Store_Endpoint
{
    /**
     * Stores Rest Extending instance.
     *
     * @var ExtendSchema
     */
    private static $extend;

    /**
     * Plugin Identifier, unique to each plugin.
     *
     * @var string
     */
    const IDENTIFIER = 'cwicly';

    /**
     * Bootstraps the class and hooks required data.
     *
     * @param ExtendSchema $extend_rest_api An instance of the ExtendSchema class.
     *
     * @since 3.1.0
     */
    public static function init(ExtendSchema $extend_rest_api)
    {
        self::$extend = $extend_rest_api;
        self::extend_store();
    }

    /**
     * Registers the actual data into each endpoint.
     */
    public static function extend_store()
    {

        // Register into `cart/items`
        self::$extend->register_endpoint_data(
            array(
                'endpoint' => CartItemSchema::IDENTIFIER,
                'namespace' => self::IDENTIFIER,
                'data_callback' => array('CC_Extend_Store_Endpoint', 'extend_cart_item_data'),
            )
        );

        // Register into `cart/items`
        self::$extend->register_endpoint_data(
            array(
                'endpoint' => ProductSchema::IDENTIFIER,
                'namespace' => self::IDENTIFIER,
                'data_callback' => array('CC_Extend_Store_Endpoint', 'extend_product_item_data'),
            )
        );

        // Register into `cart/items`
        self::$extend->register_endpoint_data(
            array(
                'endpoint' => CartSchema::IDENTIFIER,
                'namespace' => self::IDENTIFIER,
                'data_callback' => array('CC_Extend_Store_Endpoint', 'extend_cart_data'),
            )
        );
    }

    /**
     * Register Cwicly product data into cart/items endpoint.
     *
     * @param array $cart_item Current cart item data.
     *
     * @return array $item_data Registered data or empty array if condition is not satisfied.
     */
    public static function extend_cart_item_data($cart_item)
    {
        $product = $cart_item['data'];

        $price = $product->get_price();
        $saleprice = $product->get_sale_price();
        $regularprice = $product->get_regular_price();
        $line_total = $cart_item['line_total'];
        $item_data = array(
            'price' => array(
                'percentage' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::percentage_calculator($product))),
                'salepercentage' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::percentage_calculator($product))),
                'price' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($price, ''))),
                'price_formatted' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($price, 'formatted'))),
                'price_formattedcurrency' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($price, 'formattedcurrency'))),
                'price_formattedtax' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($price, 'formattedtax'))),
                'price_formattedtaxcurrency' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($price, 'formattedtaxcurrency'))),
                'saleprice' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($saleprice, ''))),
                'saleprice_formatted' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($saleprice, 'formatted'))),
                'saleprice_formattedcurrency' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($saleprice, 'formattedcurrency'))),
                'saleprice_formattedtax' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($saleprice, 'formattedtax'))),
                'saleprice_formattedtaxcurrency' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($saleprice, 'formattedtaxcurrency'))),
                'regularprice' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($regularprice, ''))),
                'regularprice_formatted' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($regularprice, 'formatted'))),
                'regularprice_formattedcurrency' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($regularprice, 'formattedcurrency'))),
                'regularprice_formattedtax' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($regularprice, 'formattedtax'))),
                'regularprice_formattedtaxcurrency' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($regularprice, 'formattedtaxcurrency'))),
            ),
            'image' => self::get_image($product),
            'line_total' => array(
                // 'percentage' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::percentage_calculator($product))),
                // 'salepercentage' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::percentage_calculator($product))),
                'price' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($line_total, ''))),
                'price_formatted' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($line_total, 'formatted'))),
                'price_formattedcurrency' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($line_total, 'formattedcurrency'))),
                'price_formattedtax' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($line_total, 'formattedtax'))),
                'price_formattedtaxcurrency' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($line_total, 'formattedtaxcurrency'))),
            ),
            'on_sale' => $product->is_on_sale(),
        );

        return $item_data;
    }

    /**
     * Register Cwicly product data into cart/items endpoint.
     *
     * @param array $cart_item Current cart item data.
     *
     * @return array $item_data Registered data or empty array if condition is not satisfied.
     */
    public static function extend_product_item_data($cart_item)
    {
        // get woocommerce product
        $product_id = $cart_item->get_id();
        $product = wc_get_product($product_id);

        $price = $product->get_price();
        $saleprice = $product->get_sale_price();
        $regularprice = $product->get_regular_price();
        $item_data = array(
            'price' => array(
                'percentage' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::percentage_calculator($product))),
                'salepercentage' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::percentage_calculator($product))),
                'price' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($price, ''))),
                'price_formatted' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($price, 'formatted'))),
                'price_formattedcurrency' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($price, 'formattedcurrency'))),
                'price_formattedtax' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($price, 'formattedtax'))),
                'price_formattedtaxcurrency' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($price, 'formattedtaxcurrency'))),
                'saleprice' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($saleprice, ''))),
                'saleprice_formatted' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($saleprice, 'formatted'))),
                'saleprice_formattedcurrency' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($saleprice, 'formattedcurrency'))),
                'saleprice_formattedtax' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($saleprice, 'formattedtax'))),
                'saleprice_formattedtaxcurrency' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($saleprice, 'formattedtaxcurrency'))),
                'regularprice' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($regularprice, ''))),
                'regularprice_formatted' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($regularprice, 'formatted'))),
                'regularprice_formattedcurrency' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($regularprice, 'formattedcurrency'))),
                'regularprice_formattedtax' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($regularprice, 'formattedtax'))),
                'regularprice_formattedtaxcurrency' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($regularprice, 'formattedtaxcurrency'))),
            ),
            'image' => self::get_image($product),
            'on_sale' => $product->is_on_sale(),
        );

        return $item_data;
    }

    /**
     * Register Cwicly main cart data into cart/items endpoint.
     *
     * @param array $cart_item Current cart item data.
     *
     * @return array $item_data Registered data or empty array if condition is not satisfied.
     */
    public static function extend_cart_data()
    {
        $shipping_total = WC()->cart->get_shipping_total();
        $shipping_total = array(
            'price' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($shipping_total, ''))),
            'price_formatted' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($shipping_total, 'formatted'))),
            'price_formattedcurrency' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($shipping_total, 'formattedcurrency'))),
            'price_formattedtax' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($shipping_total, 'formattedtax'))),
            'price_formattedtaxcurrency' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($shipping_total, 'formattedtaxcurrency'))),
        );

        $sub_total = WC()->cart->get_subtotal();
        $sub_total = array(
            'price' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($sub_total, ''))),
            'price_formatted' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($sub_total, 'formatted'))),
            'price_formattedcurrency' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($sub_total, 'formattedcurrency'))),
            'price_formattedtax' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($sub_total, 'formattedtax'))),
            'price_formattedtaxcurrency' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($sub_total, 'formattedtaxcurrency'))),
        );

        $total = WC()->cart->get_total('raw');
        $total = array(
            'price' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($total, ''))),
            'price_formatted' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($total, 'formatted'))),
            'price_formattedcurrency' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($total, 'formattedcurrency'))),
            'price_formattedtax' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($total, 'formattedtax'))),
            'price_formattedtaxcurrency' => html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($total, 'formattedtaxcurrency'))),
        );

        return array(
            'shipping_total' => $shipping_total,
            'sub_total' => $sub_total,
            'total' => $total,
        );
    }

    /**
     * Get image
     *
     * @param int $attachment_id Image attachment ID.
     * @return array|null
     */
    private static function get_image($product)
    {
        $attachment_id = $product->get_image_id();

        if (!$attachment_id) {
            return null;
        }

        $allimagesizes = cc_get_all_image_sizes();
        $src = [];
        foreach ($allimagesizes as $key => $value) {
            $src[$key] = wp_get_attachment_image_src($attachment_id, $key);
        }

        $attachment = wp_get_attachment_image_src($attachment_id, 'full');

        if (!is_array($attachment)) {
            return [];
        }

        $thumbnail = wp_get_attachment_image_src($attachment_id, 'thumbnail');

        return [
            'id' => (int) $attachment_id,
            'src' => current($attachment),
            'thumbnail' => current($thumbnail),
            'srcset' => (string) wp_get_attachment_image_srcset($attachment_id, 'full'),
            'sizes' => array('width' => $attachment[1], 'height' => $attachment[2]),
            'name' => get_the_title($attachment_id),
            'alt' => get_post_meta($attachment_id, '_wp_attachment_image_alt', true),
            'all' => $src,
        ];
    }
}

function cc_woo_api()
{
    register_rest_route(
        'cwicly/v1',
        '/woo_variation/',
        array(
            array(
                'methods' => 'GET',
                'callback' => 'cc_woo_variation',
                'permission_callback' => '__return_true',
            ),
        )
    );
}
add_action('rest_api_init', 'cc_woo_api');

/**
 * Find matching product variation
 *
 * @param $product_id
 * @param $attributes
 * @return int
 */
function cc_find_matching_product_variation_id($product_id, $attributes)
{
    return (new \WC_Product_Data_Store_CPT())->find_matching_product_variation(
        new \WC_Product($product_id),
        $attributes
    );
}

function cc_woo_variation($data)
{
    try {
        $id = '';
        if (null !== $data->get_param('id')) {
            $id = $data->get_param('id');
        }
        $args = [];
        if (null !== $data->get_param('attributes')) {
            $args = $data->get_param('attributes');
            $args = json_decode($args, true);
        }

        if ($id && $args) {
            $variations = cc_find_matching_product_variation_id($id, $args);
            return $variations;
        }
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

add_filter('woocommerce_available_variation', 'cc_woocommerce_available_variation_filter', 10, 3);

/**
 * Function for `woocommerce_available_variation` filter-hook.
 *
 * @param  $array
 * @param  $that
 * @param  $variation
 *
 * @return
 */
function cc_woocommerce_available_variation_filter($array, $that, $variation)
{
    $array['on_sale'] = $variation->is_on_sale();

    $price = $variation->get_price();

    $price_array = array();
    $price_array['blank'] = $price;
    $price_array['formatted'] = Cwicly\WooCommerce::format_price($price, array('ex_tax_label' => false));
    $price_array['formattedcurrency'] = Cwicly\WooCommerce::format_price($price, array('show_currency' => true, 'ex_tax_label' => false));
    $price_array['formattedtax'] = Cwicly\WooCommerce::format_price($price, array('ex_tax_label' => false));
    $price_array['formattedtaxcurrency'] = Cwicly\WooCommerce::format_price($price, array('show_currency' => true, 'ex_tax_label' => false));

    $array['price'] = $price_array;

    $sale_price = $variation->get_sale_price();
    $sale_price_array = array();
    $sale_price_array['blank'] = $sale_price;
    $sale_price_array['formatted'] = Cwicly\WooCommerce::format_price($sale_price, array('ex_tax_label' => false));
    $sale_price_array['formattedcurrency'] = Cwicly\WooCommerce::format_price($sale_price, array('show_currency' => true, 'ex_tax_label' => false));
    $sale_price_array['formattedtax'] = Cwicly\WooCommerce::format_price($sale_price, array('ex_tax_label' => false));
    $sale_price_array['formattedtaxcurrency'] = Cwicly\WooCommerce::format_price($sale_price, array('show_currency' => true, 'ex_tax_label' => false));

    $array['sale_price'] = $sale_price_array;

    $regular_price = $variation->get_regular_price();
    $regular_price_array = array();
    $regular_price_array['blank'] = $regular_price;
    $regular_price_array['formatted'] = Cwicly\WooCommerce::format_price($regular_price, array('ex_tax_label' => false));
    $regular_price_array['formattedcurrency'] = Cwicly\WooCommerce::format_price($regular_price, array('show_currency' => true, 'ex_tax_label' => false));
    $regular_price_array['formattedtax'] = Cwicly\WooCommerce::format_price($regular_price, array('ex_tax_label' => false));
    $regular_price_array['formattedtaxcurrency'] = Cwicly\WooCommerce::format_price($regular_price, array('show_currency' => true, 'ex_tax_label' => false));

    $array['regular_price'] = $regular_price_array;

    $array['description'] = $variation->get_description();
    $array['short_description'] = $variation->get_short_description();

    $array['sale_percentage'] = Cwicly\WooCommerce::percentage_calculator($variation);

    $attributes = [];
    $attributes_object = wc_get_product($variation->get_parent_id())->get_variation_attributes();
    foreach ($variation->get_attributes() as $key => $value) {
        foreach ($attributes_object as $attribute_key => $attribute_value) {
            if ($key == strtolower($attribute_key)) {
                $attributes[$key] = $attribute_key;
            }
        }
    }

    $array['attributes_full'] = $attributes;
    return $array;
}

if (CC_WOOCOMMERCE) {
    add_filter('body_class', 'cc_woo_name');
    function cc_woo_name($classes)
    {
        if (is_product()) {
            global $post;
            $product = wc_get_product($post->ID);
            if ($product->get_type() == 'variable') {
                $classes[] = 'variable-product';
            }

        }
        return $classes;
    }
}
