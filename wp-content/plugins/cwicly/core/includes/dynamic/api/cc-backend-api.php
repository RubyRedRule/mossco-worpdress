<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Cwicly_Backend_API extends WP_REST_Controller
{

    /**
     * Constructor
     */

    public function __construct()
    {
        // register REST route
        $this->register_routes();
    }

    /**
     * Register the routes for the objects of the controller.
     */
    public function register_routes()
    {
        $version = '1';
        $namespace = 'cwicly/v' . $version;

        $base = 'dynamic_query';
        register_rest_route($namespace, '/' . $base, array(
            array(
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => array($this, 'get_dynamic_query'),
                'permission_callback' => array($this, 'permissions_check'),
                'args' => array(

                ),
            ),
        ));

        $base2 = 'woocommerce';
        register_rest_route($namespace, '/' . $base2, array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'get_woocommerce'),
                'permission_callback' => array($this, 'permissions_check'),
                'args' => array(

                ),
            ),
        ));

        $base3 = 'compiler';
        register_rest_route($namespace, '/' . $base3, array(
            array(
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => array($this, 'get_code'),
                'permission_callback' => array($this, 'permissions_check'),
                'args' => array(

                ),
            ),
        ));

        $base4 = 'refresh_license';
        register_rest_route($namespace, '/' . $base4, array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array('Cwicly\License', 'the_lc_check'),
                'permission_callback' => array($this, 'permissions_check'),
                'args' => array(

                ),
            ),
        ));

        $base5 = 'get_google_fonts';
        register_rest_route($namespace, '/' . $base5, array(
            array(
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => array($this, 'get_google_fonts'),
                'permission_callback' => array($this, 'permissions_check'),
                'args' => array(

                ),
            ),
        ));

        $base6 = 'delete_local_font';
        register_rest_route($namespace, '/' . $base6, array(
            array(
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => array($this, 'delete_local_font'),
                'permission_callback' => array($this, 'permissions_check'),
                'args' => array(

                ),
            ),
        ));

        $base7 = 'upload_local_font';
        register_rest_route($namespace, '/' . $base7, array(
            array(
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => array($this, 'upload_local_font'),
                'permission_callback' => array($this, 'permissions_check'),
                'args' => array(

                ),
            ),
        ));

        $base8 = 'delete_local_custom_variant';
        register_rest_route($namespace, '/' . $base8, array(
            array(
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => array($this, 'delete_local_custom_variant'),
                'permission_callback' => array($this, 'permissions_check'),
                'args' => array(

                ),
            ),
        ));

        $base8 = 'heartbeat';
        register_rest_route($namespace, '/' . $base8, array(
            array(
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => array($this, 'heartbeat'),
                'permission_callback' => array($this, 'permissions_check'),
            ),
        ));

        $base9 = 'duplicate_template';
        register_rest_route($namespace, '/' . $base9, array(
            array(
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => array($this, 'duplicate_template'),
                'permission_callback' => array($this, 'permissions_check_admin'),
            ),
        ));

        $base10 = 'themer-heartbeat';
        register_rest_route($namespace, '/' . $base10, array(
            array(
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => array($this, 'themer_heartbeat'),
                'permission_callback' => array($this, 'permissions_check_admin'),
            ),
        ));

        $base11 = 'entities';
        register_rest_route($namespace, '/' . $base11, array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'entities'),
                'permission_callback' => array($this, 'permissions_check'),
            ),
        ));

        register_rest_route($namespace, '/' . $base11, array(
            array(
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => array($this, 'entities_post'),
                'permission_callback' => array($this, 'permissions_check'),
            ),
        ));
    }

    public function entities($request)
    {
        $params = $request->get_params();
        $type = $params['type'] ?? null;

        $list = array(
            'global-styles' => 'cwicly_global_styles',
            'global-stylesheets' => 'cwicly_global_stylesheets',
            'global-stylesheets-folders' => 'cwicly_global_stylesheets_folders',
            'global-classes' => 'cwicly_global_classes',
            'global-classes-folders' => 'cwicly_global_classes_folders',
            'external-classes' => 'cwicly_external_classes',

        );

        foreach ($list as $key => $value) {
            if ($type === $key) {
                $option = get_option($value);
                return array(
                    $value => $option,
                );
            }
        }
    }

    public function entities_post($request)
    {
        $body = $request->get_body();
        $body = json_decode($body, true);
        foreach ($body as $key => $value) {
            update_option($key, $value);
        }
        return $body;
    }

    public function duplicate_template($request)
    {
        $body = json_decode($request->get_body(), true);

        $type = $body['type'] ?? null;
        $id = $body['id'] ?? null;
        $new_title = $body['title'] ?? null;
        $theme = $body['theme'] ?? null;

        $new_title = wp_strip_all_tags($new_title);
        $new_title_slug = sanitize_title($new_title);

        if ($type && $id && $new_title && $theme) {
            $existing_template_id = $id; // Replace with the ID of the existing FSE template
            $new_template_args = array(
                'post_title' => $new_title, // Replace with the title of the new template
                'post_type' => $type, // This should be 'wp_template' for FSE templates
                'post_status' => 'publish', // Set the status of the new template post
                'post_name' => $type === 'wp_template_part' ? $new_title_slug : 'wp-custom-template-' . $new_title_slug, // Set the slug of the new template post
                'tax_input' => $type === 'wp_template_part' ?
                array(
                    'wp_theme' => array($theme),
                    'wp_template_part_area' => array('uncategorized'),
                )
                :
                array(
                    'wp_theme' => array($theme),
                ),
            );
            $new_template_id = wp_insert_post($new_template_args);
            if ($new_template_id) {
                $existing_template_content = get_post_field('post_content', $existing_template_id);
                $existing_template_blocks = parse_blocks($existing_template_content);
                $new_template_content = serialize_blocks($existing_template_blocks);
                wp_update_post(array(
                    'ID' => $new_template_id,
                    'post_content' => $new_template_content,
                ));
            }
            return $new_template_id;
        } else {
            return new WP_Error('error', 'Missing data', array('status' => 400));
        }
    }

    public function delete_local_custom_variant($request)
    {
        $body = json_decode($request->get_body(), true);

        $font_name = $body['font'] ?? null;
        $font_base = $body['base'] ?? null;

        if ($font_name && $font_base) {
            $uploads_dir = wp_upload_dir();
            $base_dir = $uploads_dir['basedir'] . '/cwicly/local-fonts/';

            $font_dir = $base_dir . '/custom/' . $font_name . '/' . $font_base . '.woff2';

            if (file_exists($font_dir)) {
                // make it work from the frontend, as well
                require_once ABSPATH . 'wp-admin/includes/file.php';
                // this variable will hold the selected filesystem class
                global $wp_filesystem;
                // this function selects the appropriate filesystem class
                WP_Filesystem();
                // finally, you can call the 'delete' function on the selected class,
                // which is now stored in the global '$wp_filesystem'
                $wp_filesystem->delete($font_dir, true);
                return true;
            }
        }
        return false;
    }

    public function upload_local_font($request)
    {
        $name = $request->get_param('name');

        $files = $request->get_file_params();

        if (empty($files)) {
            return new WP_Error('no_file', 'No file was uploaded', array('status' => 400));
        }

        $countfiles = count($files);

        $upload_dir = wp_upload_dir();
        $base = trailingslashit($upload_dir['basedir']) . 'cwicly/';
        $local_fonts = trailingslashit($base) . 'local-fonts/';
        $dir = $local_fonts . 'custom/';

        if (!file_exists($dir)) {
            wp_mkdir_p($dir);
        }

        global $wp_filesystem;
        if (!$wp_filesystem) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
        }
        WP_Filesystem(false, $upload_dir['basedir'], true);

        $paths = array();

        for ($i = 0; $i < $countfiles; $i++) {
            $filename = $files['file' . $i . '']['name'];

            $target_file = $dir . '/' . $name . '/' . basename($filename);

            if (!$wp_filesystem->is_dir($dir . '/' . $name)) {
                $wp_filesystem->mkdir($dir . '/' . $name);
            }

            // Upload file
            move_uploaded_file($files['file' . $i . '']['tmp_name'], $target_file);

            $local_url = CC_UPLOAD_URL . '/cwicly/local-fonts/custom/' . rawurlencode($name) . '/' . rawurlencode($filename);
            $paths[] = $local_url;
        }
        return new WP_REST_Response($paths, 200);
    }

    /**
     * Delete local font
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|bool
     */
    public function delete_local_font($request)
    {

        $body = json_decode($request->get_body(), true);

        $font_name = $body['font'] ?? null;
        $is_google = $body['isGoogle'] ?? null;

        if ($font_name) {
            $uploads_dir = wp_upload_dir();
            $base_dir = $uploads_dir['basedir'] . '/cwicly/local-fonts/';

            if ($is_google) {
                $font_dir = $base_dir . '/google/' . $font_name . '/';
            } else {
                $font_dir = $base_dir . '/custom/' . $font_name . '/';
            }

            if (file_exists($font_dir)) {
                // make it work from the frontend, as well
                require_once ABSPATH . 'wp-admin/includes/file.php';
                // this variable will hold the selected filesystem class
                global $wp_filesystem;
                // this function selects the appropriate filesystem class
                WP_Filesystem();
                // finally, you can call the 'delete' function on the selected class,
                // which is now stored in the global '$wp_filesystem'
                $wp_filesystem->delete($font_dir, true);
                return true;
            }
        }
        if (!$is_google) {
            return true;
        }
        return false;
    }

    /**
     * Get Google Fonts and save them to local
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|bool
     */
    public function get_google_fonts($request)
    {
        $body = json_decode($request->get_body(), true);

        $string = $body['string'] ?? null;

        if ($string) {

            // FIRST METHOD

            // preg_match_all("/url\((.*?)\) format\('woff2'\)/", $string, $matches);
            preg_match_all('#/\*.*?\*/\s*@font-face\s*\{.*?\}#s', $string, $matches);

            if (empty($matches[0])) {
                return $string;
            }

            // $woff2_urls = $matches[1];

            $uploads_dir = wp_upload_dir();
            $base_dir = $uploads_dir['basedir'] . '/cwicly/local-fonts/';

            if (!file_exists($base_dir)) {
                wp_mkdir_p($base_dir);
            }

            foreach ($matches[0] as $match) {
                preg_match("/url\((.*?)\) format\('woff2'\)/", $match, $woff2_url);
                $woff2_url = $woff2_url[1];
                preg_match("/font-family: '(.*?)';/", $match, $font_family_matches);
                preg_match("/font-weight: (.*?);/", $match, $font_weight_matches);
                preg_match("/font-style: (.*?);/", $match, $font_style_matches);

                if (!empty($font_family_matches[1]) && !empty($font_weight_matches[1]) && !empty($font_style_matches[1])) {
                    $font_family = $font_family_matches[1];
                    $font_weight = $font_weight_matches[1];
                    $font_style = $font_style_matches[1];

                    preg_match("/\/\*(.*?)\*\//", $match, $unicode_range_matches);
                    if (!empty($unicode_range_matches[1])) {
                        $unicode_range = trim($unicode_range_matches[1]);
                        $font_dir = $base_dir . '/google/' . $font_family . '/' . $unicode_range . '/';
                    } else {
                        $font_dir = $base_dir . '/google/' . $font_family . '/';
                    }

                    if (!file_exists($font_dir)) {
                        wp_mkdir_p($font_dir);
                    }

                    $filename = $font_family . '-' . $font_weight . '-' . $font_style . '.woff2';
                    $filenameURL = rawurlencode($font_family) . '-' . rawurlencode($font_weight) . '-' . rawurlencode($font_style) . '.woff2';
                    $local_url = CC_UPLOAD_URL . '/cwicly/local-fonts/google/' . rawurlencode($font_family) . '/' . $unicode_range . '/' . $filenameURL;

                    if (!file_exists($font_dir . $filename)) {
                        $response = wp_remote_get($woff2_url);

                        if (is_array($response) && !is_wp_error($response)) {
                            $body = wp_remote_retrieve_body($response);

                            if (!empty($body)) {
                                file_put_contents($font_dir . $filename, $body);
                            }
                        } else {
                            return 'Error: Failed to download the WOFF2 file ' . $woff2_url;
                        }
                    }

                    $string = str_replace($woff2_url, $local_url, $string);
                }
            }

            return $string;

            //// SECOND METHOD

            // $fontName = '';
            // if (!$fontName) {
            //     preg_match('/font-family: \'(.*)\'/', $string, $fontName);
            //     $fontName = $fontName[1];
            // }

            // $woff2Files = [];
            // preg_match_all('/url\((.*\.woff2)\)/', $string, $woff2Files);
            // $upload_dir = wp_upload_dir();
            // $localFontsDirectory = $upload_dir['basedir'] . '/cwicly/local-fonts/' . $fontName;
            // if (!file_exists($localFontsDirectory)) {
            //     mkdir($localFontsDirectory, 0755, true);
            // }
            // foreach ($woff2Files[1] as $url) {
            //     $response = wp_remote_get($url);
            //     if (is_wp_error($response)) {
            //         return $response->get_error_message();
            //     }
            //     if (200 !== wp_remote_retrieve_response_code($response)) {
            //         return 'Error: ' . wp_remote_retrieve_response_code($response);
            //     }
            //     $fontData = wp_remote_retrieve_body($response);
            //     $savePath = $localFontsDirectory . '/' . basename($url);
            //     $saveResult = file_put_contents($savePath, $fontData);
            //     if ($saveResult === false) {
            //         return new WP_Error('cant_save_file', __('Can\'t save file', 'cwicly'), array('status' => 500));
            //     }
            // }
            // return new WP_REST_Response(true, 200);
        }
    }

    /**
     * Compile and return Code
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function get_code($request)
    {
        if (null !== ($request->get_param('scss'))) {
            $code = $request->get_param('scss');

            if (!class_exists('\ScssPhp\ScssPhp\Compiler')) {
                require_once CWICLY_DIR_PATH . 'core/lib/scssphp/scss.inc.php';
            }

            $compiler = new \ScssPhp\ScssPhp\Compiler();

            try {
                if (method_exists($compiler, 'compileString')) {
                    $code = $compiler->compileString($code)->getCss();
                } else {
                    $code = $compiler->compile($code);
                }
            } catch (\ScssPhp\ScssPhp\Exception\SassException$e) {
                echo json_encode([
                    'error' => true,
                    'message' => $e->getMessage(),
                ]);

                die;
            }

            return new WP_REST_Response($code, 200);
        }
    }

    /**
     * Catch all for WooCommerce API
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function get_woocommerce($request)
    {
        if (null !== ($request->get_param('upsellproducts')) || null !== ($request->get_param('relatedproducts'))) {
            $query_prep = new WC_Product_Query(array('limit' => 4));

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
        }

        return new WP_REST_Response($query, 200);
    }

    /**
     * Get a collection of items for Query block
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function get_dynamic_query($request)
    {
        $body = json_decode($request->get_body(), true);

        $queryType = $body['queryType'] ?? null;
        $postId = $body['postId'] ?? null;

        $queryMaxItems = $body['queryMaxItems'] ?? null;

        $querySticky = $body['querySticky'] ?? null;
        $queryPostType = $body['queryPostType'] ?? null;
        $queryPerPage = $body['queryPerPage'] ?? null;
        $queryOffset = $body['queryOffset'] ?? null;
        $queryExcludeCurrent = $body['queryExcludeCurrent'] ?? null;
        $queryMetaKey = $body['queryMetaKey'] ?? null;
        $queryOrderBy = $body['queryOrderBy'] ?? null;
        $queryOrder = $body['queryOrder'] ?? null;
        $queryInclude = $body['queryInclude'] ?? null;
        $queryExclude = $body['queryExclude'] ?? null;
        $queryPostParent = $body['queryPostParent'] ?? null;
        $queryInParent = $body['queryInParent'] ?? null;
        $queryNotInParent = $body['queryNotInParent'] ?? null;
        $queryTaxonomy = $body['queryTaxonomy'] ?? null;
        $queryMeta = $body['queryMeta'] ?? null;
        $queryTaxonomyRelation = $body['queryTaxonomyRelation'] ?? null;
        $queryMetaRelation = $body['queryMetaRelation'] ?? null;
        $queryPassword = $body['queryPassword'] ?? null;
        $queryPostPassword = $body['queryPostPassword'] ?? null;
        $queryAuthor = $body['queryAuthor'] ?? null;
        $queryAuthorName = $body['queryAuthorName'] ?? null;
        $queryAuthorIn = $body['queryAuthorIn'] ?? null;
        $queryAuthorNotIn = $body['queryAuthorNotIn'] ?? null;
        $querySearch = $body['querySearch'] ?? null;
        $queryPostStatus = $body['queryPostStatus'] ?? null;
        $queryCommentCount = $body['queryCommentCount'] ?? null;
        $queryCommentCompare = $body['queryCommentCompare'] ?? null;
        $queryPerm = $body['queryPerm'] ?? null;
        $queryMimeType = $body['queryMimeType'] ?? null;
        $queryDate = $body['queryDate'] ?? null;
        $queryDateRelation = $body['queryDateRelation'] ?? null;

        $queryTaxonomies = $body['queryTaxonomies'] ?? null;
        $queryObjectIDs = $body['queryObjectIDs'] ?? null;
        $queryHideEmpty = $body['queryHideEmpty'] ?? null;
        $queryCount = $body['queryCount'] ?? null;
        $queryPadCount = $body['queryPadCount'] ?? null;
        $queryExcludeTree = $body['queryExcludeTree'] ?? null;
        $queryNumber = $body['queryNumber'] ?? null;
        $queryFields = $body['queryFields'] ?? null;
        $queryName = $body['queryName'] ?? null;
        $querySlug = $body['querySlug'] ?? null;
        $queryHierarchical = $body['queryHierarchical'] ?? null;
        $queryNameLike = $body['queryNameLike'] ?? null;
        $queryDescriptionLike = $body['queryDescriptionLike'] ?? null;
        $queryGet = $body['queryGet'] ?? null;
        $queryChildOf = $body['queryChildOf'] ?? null;
        $queryParent = $body['queryParent'] ?? null;
        $queryChildless = $body['queryChildless'] ?? null;

        $queryRole = $body['queryRole'] ?? null;
        $queryRoleIn = $body['queryRoleIn'] ?? null;
        $queryRoleNotIn = $body['queryRoleNotIn'] ?? null;
        $queryBlogID = $body['queryBlogID'] ?? null;
        $querySearchColumn = $body['querySearchColumn'] ?? null;
        $queryWho = $body['queryWho'] ?? null;
        $queryTotalCount = $body['queryTotalCount'] ?? null;
        $queryHasPublished = $body['queryHasPublished'] ?? null;

        $queryCommentParent = $body['queryCommentParent'] ?? null;
        $queryCommentInParent = $body['queryCommentInParent'] ?? null;
        $queryCommentNotParent = $body['queryCommentNotParent'] ?? null;
        $queryCommentPostID = $body['queryCommentPostID'] ?? null;
        $queryCommentID = $body['queryCommentID'] ?? null;
        $queryCommentNotID = $body['queryCommentNotID'] ?? null;
        $queryCommentIncludeUnapproved = $body['queryCommentIncludeUnapproved'] ?? null;
        $queryCommentKarma = $body['queryCommentKarma'] ?? null;
        $queryAuthorEmail = $body['queryAuthorEmail'] ?? null;
        $queryAuthorURL = $body['queryAuthorURL'] ?? null;
        $queryCommentAuthorIn = $body['queryCommentAuthorIn'] ?? null;
        $queryCommentAuthorNotIn = $body['queryCommentAuthorNotIn'] ?? null;

        $queryWooType = $body['queryWooType'] ?? null;
        $queryWooParentExclude = $body['queryWooParentExclude'] ?? null;
        $queryWooSKU = $body['queryWooSKU'] ?? null;
        $queryWooTag = $body['queryWooTag'] ?? null;
        $queryWooCategory = $body['queryWooCategory'] ?? null;
        $queryWooWidth = $body['queryWooWidth'] ?? null;
        $queryWooHeight = $body['queryWooHeight'] ?? null;
        $queryWooWeight = $body['queryWooWeight'] ?? null;
        $queryWooLength = $body['queryWooLength'] ?? null;
        $queryWooPrice = $body['queryWooPrice'] ?? null;
        $queryWooRegularPrice = $body['queryWooRegularPrice'] ?? null;
        $queryWooSalePrice = $body['queryWooSalePrice'] ?? null;
        $queryWooTotalSales = $body['queryWooTotalSales'] ?? null;
        $queryWooVirtual = $body['queryWooVirtual'] ?? null;
        $queryWooDownloadable = $body['queryWooDownloadable'] ?? null;
        $queryWooFeatured = $body['queryWooFeatured'] ?? null;
        $queryWooSoldIndividually = $body['queryWooSoldIndividually'] ?? null;
        $queryWooManageStock = $body['queryWooManageStock'] ?? null;
        $queryWooReviewsAllowed = $body['queryWooReviewsAllowed'] ?? null;
        $queryWooBackorders = $body['queryWooBackorders'] ?? null;
        $queryWooVisibility = $body['queryWooVisibility'] ?? null;
        $queryWooStockQuantity = $body['queryWooStockQuantity'] ?? null;
        $queryWooStockStatus = $body['queryWooStockStatus'] ?? null;
        $queryWooTaxStatus = $body['queryWooTaxStatus'] ?? null;
        $queryWooTaxClass = $body['queryWooTaxClass'] ?? null;
        $queryWooShippingClass = $body['queryWooShippingClass'] ?? null;
        $queryWooDownloadLimit = $body['queryWooDownloadLimit'] ?? null;
        $queryWooDownloadExpiry = $body['queryWooDownloadExpiry'] ?? null;
        $queryWooAverageRating = $body['queryWooAverageRating'] ?? null;
        $queryWooReviewCount = $body['queryWooReviewCount'] ?? null;
        $queryWooDateCreated = $body['queryWooDateCreated'] ?? null;
        $queryWooDateModified = $body['queryWooDateModified'] ?? null;
        $queryWooDateOnSaleFrom = $body['queryWooDateOnSaleFrom'] ?? null;
        $queryWooDateOnSaleTo = $body['queryWooDateOnSaleTo'] ?? null;

        $blockContext = array();

        if (isset($body['taxterms']) && $body['taxterms']) {
            $blockContext['taxterms'] = $body['taxterms'];
        }

        $args_class = new CC_Query_Args($blockContext);
        $args = $args_class->cc_query_preparation(
            $queryType,
            $postId,

            $queryMaxItems,

            $querySticky,
            '',
            $queryPostType,
            $queryPerPage,
            $queryOffset,
            $queryExcludeCurrent,
            $queryMetaKey,
            $queryOrderBy,
            $queryOrder,
            $queryInclude,
            $queryExclude,
            $queryPostParent,
            $queryInParent,
            $queryNotInParent,
            $queryTaxonomy,
            $queryMeta,
            $queryTaxonomyRelation,
            $queryMetaRelation,
            $queryPassword,
            $queryPostPassword,
            $queryAuthor,
            $queryAuthorName,
            $queryAuthorIn,
            $queryAuthorNotIn,
            $querySearch,
            $queryPostStatus,
            $queryCommentCount,
            $queryCommentCompare,
            $queryPerm,
            $queryMimeType,
            $queryDate,
            $queryDateRelation,

            $queryTaxonomies,
            $queryObjectIDs,
            $queryHideEmpty,
            $queryCount,
            $queryPadCount,
            $queryExcludeTree,
            $queryNumber,
            $queryFields,
            $queryName,
            $querySlug,
            $queryHierarchical,
            $queryNameLike,
            $queryDescriptionLike,
            $queryGet,
            $queryChildOf,
            $queryParent,
            $queryChildless,

            $queryRole,
            $queryRoleIn,
            $queryRoleNotIn,
            $queryBlogID,
            $querySearchColumn,
            $queryWho,
            $queryTotalCount,
            $queryHasPublished,

            $queryCommentParent,
            $queryCommentInParent,
            $queryCommentNotParent,
            $queryCommentPostID,
            $queryCommentID,
            $queryCommentNotID,
            $queryCommentIncludeUnapproved,
            $queryCommentKarma,
            $queryAuthorEmail,
            $queryAuthorURL,
            $queryCommentAuthorIn,
            $queryCommentAuthorNotIn,

            $queryWooType,
            $queryWooParentExclude,
            $queryWooSKU,
            $queryWooTag,
            $queryWooCategory,
            $queryWooWidth,
            $queryWooHeight,
            $queryWooWeight,
            $queryWooLength,
            $queryWooPrice,
            $queryWooRegularPrice,
            $queryWooSalePrice,
            $queryWooTotalSales,
            $queryWooVirtual,
            $queryWooDownloadable,
            $queryWooFeatured,
            $queryWooSoldIndividually,
            $queryWooManageStock,
            $queryWooReviewsAllowed,
            $queryWooBackorders,
            $queryWooVisibility,
            $queryWooStockQuantity,
            $queryWooStockStatus,
            $queryWooTaxStatus,
            $queryWooTaxClass,
            $queryWooShippingClass,
            $queryWooDownloadLimit,
            $queryWooDownloadExpiry,
            $queryWooAverageRating,
            $queryWooReviewCount,
            $queryWooDateCreated,
            $queryWooDateModified,
            $queryWooDateOnSaleFrom,
            $queryWooDateOnSaleTo,
            false
        );

        $query = '';

        if (isset($args['tax_query'])) {
            foreach ($args['tax_query'] as $index => $tax_query) {
                if ($index !== 'relation') {
                    if (is_string($index)) {
                        if (!isset($tax_query->terms) || (isset($tax_query->terms) && !$tax_query->terms)) {
                            if ($index !== 'relation') {
                                $args['tax_query']->$index->operator = 'XXX';
                            }
                        }
                    } else {
                        if (!isset($tax_query['terms']) || (isset($tax_query['terms']) && !$tax_query['terms'])) {
                            if ($index !== 'relation') {$args['tax_query'][$index]['operator'] = 'XXX';
                            }
                        }
                    }
                }
            }
        }
        if (isset($args['meta_query'])) {
            foreach ($args['meta_query'] as $index => $meta_query) {
                if ($index !== 'relation') {
                    if (is_string($index)) {
                        if (!isset($meta_query->value) || !Cwicly\Helpers::check_if_exists($meta_query->value)) {
                            if ($index !== 'relation') {
                                $args['meta_query']->$index->value = [];
                            }
                        }
                    } else {
                        if (!isset($meta_query['value']) || !Cwicly\Helpers::check_if_exists($meta_query['value'])) {
                            if ($index !== 'relation') {
                                $args['meta_query'][$index]['value'] = [];
                            }
                        }
                    }
                }
            }
        }

        add_filter('posts_results', 'remove_content_field', 10, 2);
        function remove_content_field($posts, $query)
        {
            if ($query->get('exclude_content')) {
                foreach ($posts as &$post) {
                    unset($post->post_content);
                }
            }
            return $posts;
        }
        if ($queryType === 'posts') {
            if ($body['queryMake']) {
                $query_prep = new WP_Query($args);
                $posts_query = $query_prep->posts;
                $query = array();
                foreach ($posts_query as $post) {
                    $poster = (array) $post;
                    $poster['cc_featuredimage'] = get_the_post_thumbnail_url($poster['ID'], 'full');
                    $query[] = (object) $poster;
                }
            }
        } else if ($queryType === 'terms') {
            if ($body['queryMake']) {
                $query = new WP_Term_Query($args);
            }
        } else if ($queryType === 'users') {
            if ($body['queryMake']) {
                $query_prep = new WP_User_Query($args);
                $query = $query_prep->get_results();
            }
        } else if ($queryType === 'comments') {
            if ($body['queryMake']) {
                $query = new WP_Comment_Query($args);
                if (isset($args['hierarchical']) && $args['hierarchical'] === 'flat') {
                    $query->comments = cc_query_comment_tree($query->comments);
                }
            }
        } else if ($queryType === 'products') {
            if ($body['queryMake']) {
                $query_prep = new WC_Product_Query($args);
                $products_query = $query_prep->get_products();
                $query = array();

                $ids = array();
                foreach ($products_query as $product) {
                    $ids[] = $product->get_id();
                    $producter = $this->product_preparation($product, $request);

                    if ($product->get_type() === 'grouped') {
                        $children = $product->get_children();
                        foreach ($children as $child) {
                            if ($ids && !in_array($child, $ids)) {
                                $producter['woogroups_info'][] = $this->product_preparation(wc_get_product($child), $request);
                            }
                        }
                    }

                    $query[] = $producter;
                }
            }
        }

        remove_filter('posts_results', 'remove_content_field', 10);
        $final = array(
            'query' => $query,
            'result' => var_export($args, true),
        );

        return new WP_REST_Response($final, 200);
    }

    /**
     * Get all WooCommerce product info necessary for backend
     *
     * @param $product WC_Product The product object.
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|bool
     */
    public function product_preparation($product, $request)
    {
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

        $producter['wooFields'] = array();

        if ($product) {
            $price = $product->get_price();
            $saleprice = $product->get_sale_price();
            $regularprice = $product->get_regular_price();
            $producter['wooFields']['salepercentage'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::percentage_calculator($product)));
            $producter['wooFields']['price'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($price, '')));
            $producter['wooFields']['price_formatted'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($price, 'formatted')));
            $producter['wooFields']['price_formattedcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($price, 'formattedcurrency')));
            $producter['wooFields']['price_formattedtax'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($price, 'formattedtax')));
            $producter['wooFields']['price_formattedtaxcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($price, 'formattedtaxcurrency')));
            $producter['wooFields']['saleprice'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($saleprice, '')));
            $producter['wooFields']['saleprice_formatted'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($saleprice, 'formatted')));
            $producter['wooFields']['saleprice_formattedcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($saleprice, 'formattedcurrency')));
            $producter['wooFields']['saleprice_formattedtax'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($saleprice, 'formattedtax')));
            $producter['wooFields']['saleprice_formattedtaxcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($saleprice, 'formattedtaxcurrency')));
            $producter['wooFields']['regularprice'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($regularprice, '')));
            $producter['wooFields']['regularprice_formatted'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($regularprice, 'formatted')));
            $producter['wooFields']['regularprice_formattedcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($regularprice, 'formattedcurrency')));
            $producter['wooFields']['regularprice_formattedtax'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($regularprice, 'formattedtax')));
            $producter['wooFields']['regularprice_formattedtaxcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($regularprice, 'formattedtaxcurrency')));
        }
        $producter['wooFields']['currency'] = get_woocommerce_currency();
        $producter['wooFields']['currencysymbol'] = html_entity_decode(get_woocommerce_currency_symbol());
        if ($product && $product->get_type() === 'variable') {
            $variationminprice = $product->get_variation_price();
            $variationmaxprice = $product->get_variation_price('max');
            $variationregnminprice = $product->get_variation_regular_price();
            $variationregnmaxprice = $product->get_variation_regular_price('max');
            $variationsalenminprice = $product->get_variation_sale_price();
            $variationsalenmaxprice = $product->get_variation_sale_price('max');

            $producter['wooFields']['variationmin'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationminprice, '')));
            $producter['wooFields']['variationmin_formatted'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationminprice, 'formatted')));
            $producter['wooFields']['variationmin_formattedcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationminprice, 'formattedcurrency')));
            $producter['wooFields']['variationmin_formattedtax'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationminprice, 'formattedtax')));
            $producter['wooFields']['variationmin_formattedtaxcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationminprice, 'formattedtaxcurrency')));
            $producter['wooFields']['variationmax'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationmaxprice, 'formatted')));
            $producter['wooFields']['variationmax_formatted'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationmaxprice, 'formatted')));
            $producter['wooFields']['variationmax_formattedcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationmaxprice, 'formattedcurrency')));
            $producter['wooFields']['variationmax_formattedtax'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationmaxprice, 'formattedtax')));
            $producter['wooFields']['variationmax_formattedtaxcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationmaxprice, 'formattedtaxcurrency')));

            $producter['wooFields']['variationregmin'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationregnminprice, '')));
            $producter['wooFields']['variationregmin_formatted'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationregnminprice, 'formatted')));
            $producter['wooFields']['variationregmin_formattedcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationregnminprice, 'formattedcurrency')));
            $producter['wooFields']['variationregmin_formattedtax'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationregnminprice, 'formattedtax')));
            $producter['wooFields']['variationregmin_formattedtaxcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationregnminprice, 'formattedtaxcurrency')));
            $producter['wooFields']['variationregmax'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationregnmaxprice, 'formatted')));
            $producter['wooFields']['variationregmax_formatted'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationregnmaxprice, 'formatted')));
            $producter['wooFields']['variationregmax_formattedcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationregnmaxprice, 'formattedcurrency')));
            $producter['wooFields']['variationregmax_formattedtax'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationregnmaxprice, 'formattedtax')));
            $producter['wooFields']['variationregmax_formattedtaxcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationregnmaxprice, 'formattedtaxcurrency')));

            $producter['wooFields']['variationsalemin'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationsalenminprice, '')));
            $producter['wooFields']['variationsalemin_formatted'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationsalenminprice, 'formatted')));
            $producter['wooFields']['variationsalemin_formattedcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationsalenminprice, 'formattedcurrency')));
            $producter['wooFields']['variationsalemin_formattedtax'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationsalenminprice, 'formattedtax')));
            $producter['wooFields']['variationsalemin_formattedtaxcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationsalenminprice, 'formattedtaxcurrency')));
            $producter['wooFields']['variationsalemax'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationsalenmaxprice, 'formatted')));
            $producter['wooFields']['variationsalemax_formatted'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationsalenmaxprice, 'formatted')));
            $producter['wooFields']['variationsalemax_formattedcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationsalenmaxprice, 'formattedcurrency')));
            $producter['wooFields']['variationsalemax_formattedtax'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationsalenmaxprice, 'formattedtax')));
            $producter['wooFields']['variationsalemax_formattedtaxcurrency'] = html_entity_decode(wp_strip_all_tags(Cwicly\WooCommerce::dynamic_price($variationsalenmaxprice, 'formattedtaxcurrency')));
        }

        if ($product && $product->get_type() === 'variable') {
            $variations_attributes_and_values = array();
            foreach ($product->get_variation_attributes() as $taxonomy => $terms_slug) {
                // To get the attribute label (in WooCommerce 3+)
                $taxonomy_label = wc_attribute_label($taxonomy, $product);

                // Setting some data in an array
                $variations_attributes_and_values[$taxonomy] = array('label' => $taxonomy_label);
                $variations_attributes_and_values[$taxonomy]['type'] = wc_get_attribute(wc_attribute_taxonomy_id_by_name($taxonomy))->type;
                $variations_attributes_and_values[$taxonomy]['slug'] = $taxonomy;

                // foreach ($terms_slug as $term) {

                //     if (get_term_by('slug', $term, $taxonomy)) {
                //         // Getting the term object from the slug
                //         $term_obj = get_term_by('slug', $term, $taxonomy);

                //         $term_id = $term_obj->term_id; // The ID  <==  <==  <==  <==  <==  <==  HERE
                //         $term_name = $term_obj->name; // The Name
                //         $term_slug = $term_obj->slug; // The Slug
                if ($product && taxonomy_exists($taxonomy)) {
                    // Get terms if this is a taxonomy - ordered. We need the names too.
                    $terms = wc_get_product_terms(
                        $product->get_id(),
                        $taxonomy,
                        array(
                            'fields' => 'all',
                        )
                    );
                    foreach ($terms as $term) {

                        if (taxonomy_exists($taxonomy)) {
                            // Getting the term object from the slug
                            // $term_obj = get_term_by('slug', $term, $taxonomy);

                            $term_id = $term->term_id; // The ID  <==  <==  <==  <==  <==  <==  HERE
                            $term_name = $term->name; // The Name
                            $term_slug = $term->slug; // The Slug
                            $term_type = '';
                            if ($variations_attributes_and_values[$taxonomy]['type'] && $variations_attributes_and_values[$taxonomy]['type'] === 'color') {
                                $term_type = get_term_meta($term_id, '_cwicly_color', true);
                            }
                            if ($variations_attributes_and_values[$taxonomy]['type'] && $variations_attributes_and_values[$taxonomy]['type'] === 'image') {
                                $term_type = wp_get_attachment_url(get_term_meta($term_id, '_cwicly_image_id', true));
                            }

                            // Setting the terms ID and values in the array
                            // $variations_attributes_and_values[$taxonomy]['terms'][$term_id] = array(
                            $variations_attributes_and_values[$taxonomy]['terms'][] = array(
                                'name' => $term_name,
                                'slug' => $term_slug,
                                'type' => $term_type,
                            );
                        }
                    }
                } else {
                    foreach ($terms_slug as $term) {
                        $variations_attributes_and_values[$taxonomy]['terms'][$term] = array(
                            'name' => $term,
                            'slug' => $term,
                            'type' => null,
                        );
                    }
                }

            }
            $producter['woovariables'] = $variations_attributes_and_values;
        } else {
            $producter['woovariables'] = array();
        }

        if ($product->get_type() === 'grouped') {
            $products = $product->get_children();
            $producter['woogroups'] = $products;
            $producter['woogroups_info'] = array();
        } else {
            $producter['woogroups'] = array();
        }

        if (has_post_thumbnail($producter['id'])) {
            $producter['cc_featuredimage'] = get_the_post_thumbnail_url($producter['id']);
        } else {
            $producter['cc_featuredimage'] = 'nofeaturedimage';
        }

        return $producter;
    }

    public function heartbeat($request)
    {
        $heartbeat = get_option('cwicly_heartbeat');

        $body = json_decode($request->get_body(), true);

        if (isset($body['heartbeat']) && $body['heartbeat']) {

            $heartbeat_editor = $body['heartbeat'];

            $heartbeat_editor_new = array();
            foreach ($heartbeat as $key => $value) {
                if (!isset($heartbeat_editor) || $value > $heartbeat_editor[$key]) {
                    if ($key === 'cwicly_global_classes') {
                        $heartbeat_editor_new[] = array(
                            'type' => $key,
                            'time' => $heartbeat[$key],
                            'globalClasses' => get_option('cwicly_global_classes'),
                            'globalClassesRendered' => get_option('cwicly_global_classes_rendered'),
                        );
                    } else {
                        $heartbeat_editor_new[] = array(
                            'type' => $key,
                            'time' => $heartbeat[$key],
                            'value' => get_option($key),
                        );
                    }
                }
            }

            return new WP_REST_Response(json_encode($heartbeat_editor_new), 200);
        } else {
            return new WP_Error('no_heartbeat', 'No heartbeat', array('status' => 404));
        }
    }

    public function themer_heartbeat($request)
    {
        $heartbeat = get_option('cwicly_themer_heartbeat');

        $body = json_decode($request->get_body(), true);

        if (isset($body['heartbeat'])) {

            $heartbeat_editor = $body['heartbeat'];

            $heartbeat_editor_new = array();
            foreach ($heartbeat as $key => $value) {
                if (!isset($heartbeat_editor) || $value > $heartbeat_editor[$key]) {
                    if ($key === 'cwicly_pre_conditions') {
                        $heartbeat_editor_new[] = array(
                            'type' => $key,
                            'time' => $heartbeat[$key],
                            'preConditions' => get_option('cwicly_pre_conditions'),
                            'conditions' => get_option('cwicly_conditions'),
                        );
                    } else {
                        $heartbeat_editor_new[] = array(
                            'type' => $key,
                            'time' => $heartbeat[$key],
                            'value' => get_option($key),
                        );
                    }
                }
            }

            return new WP_REST_Response(json_encode($heartbeat_editor_new), 200);
        } else {
            return new WP_REST_Response(false, 200);
        }
    }
    /**
     * Check if a given request has access to get items
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|bool
     */
    public function permissions_check($request)
    {
        return current_user_can('edit_posts');
    }

    /**
     * Check if a given request has access to get items as Admin
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|bool
     */
    public function permissions_check_admin($request)
    {
        return current_user_can('manage_options');
    }
}

/**
 * This allows access to the class instance from other places.
 */

function cc_backend_api()
{
    static $instance;

    if (!$instance) {
        $instance = new Cwicly_Backend_API();
    }

    return $instance;
}

/**
 * Init only when needed
 */
function cc_init_backend_api()
{
    // if (is_admin()) {
    cc_backend_api();
    // }
}
add_action('rest_api_init', 'cc_init_backend_api');
