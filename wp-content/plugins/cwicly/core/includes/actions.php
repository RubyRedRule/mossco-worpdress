<?php
namespace Cwicly;

if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

class Actions
{
    public function __construct()
    {
        add_action('save_post', [$this, 'save_post'], 999, 3);
        add_action('delete_post', [$this, 'delete_post'], 999, 3);
        add_action('deleted_transient', [$this, 'delete_transient'], 999, 3);
        add_action('created_term', [$this, 'delete_terms'], 999, 3);
        add_action('edited_term', [$this, 'delete_terms'], 999, 3);
        add_action('delete_term', [$this, 'delete_terms'], 999, 3);
        add_filter('block_type_metadata', [$this, 'filter_metadata_registration']);
        add_action('wp_trash_post', [$this, 'delete_trash_post_action']);
        add_action('delete_post', [$this, 'delete_post_action'], 10, 2);
        add_action('updated_option', [$this, 'updated_option_action'], 10, 3);
    }

    /**
     * Fired upon WordPress 'save_post' hook. On post update delete all related caches, on post creation delete all
     * non-single endpoint caches for this post type.
     *
     * @param int      $post_id Post ID.
     * @param \WP_Post $post Post object.
     * @param bool     $update Whether this is an existing post being updated or not.
     */
    public static function save_post($post_id, $post, $update)
    {
        if ('auto-draft' === $post->post_status) {
            return;
        }
        if ($update) {
            $change = false;
            $all_transients = get_option('cwicly_rest_transients');
            if ($all_transients) {
                if ($post->post_type === 'product') {
                    $type = 'products';
                } else {
                    $type = 'posts';
                }
                foreach ($all_transients as $index => $transientName) {
                    if (str_contains($transientName, 'cc-' . $type . '-count')) {
                        delete_transient($transientName);
                        // array_splice($all_transients, $index, 1);
                        $all_transients = array_filter($all_transients, static function ($element) use ($transientName) {
                            return $element !== $transientName;
                        });
                        $change = true;
                    }
                }
                if ($change) {
                    update_option('cwicly_rest_transients', $all_transients);
                }
            }
        }
    }

    /**
     * Fired upon WordPress 'delete_post' hook. Delete all related caches, including all single cache statistics.
     *
     * @param int $post_id Post ID.
     */
    public static function delete_post($post_id)
    {
        $post = get_post($post_id);
        if (wp_is_post_revision($post)) {
            return;
        }
        $change = false;
        $all_transients = get_option('cwicly_rest_transients');
        if ($all_transients) {
            if ($post->post_type === 'product') {
                $type = 'products';
            } else {
                $type = 'posts';
            }
            foreach ($all_transients as $index => $transientName) {
                if (str_contains($transientName, 'cc-' . $type . '-count')) {
                    delete_transient($transientName);
                    // array_splice($all_transients, $index, 1);
                    $all_transients = array_filter($all_transients, static function ($element) use ($transientName) {
                        return $element !== $transientName;
                    });
                    $change = true;
                }
            }
            if ($change) {
                update_option('cwicly_rest_transients', $all_transients);
            }
        }
    }

    /**
     * Fired upon WordPress 'deleted_transient' hook. Delete all related caches, including all single cache statistics.
     *
     * @param int $post_id Post ID.
     */
    public static function delete_transient($transient)
    {
        $all_transients = get_option('cwicly_rest_transients');
        if ($all_transients && in_array($transient, $all_transients)) {
            $all_transients = array_filter($all_transients, static function ($element) use ($transient) {
                return $element !== $transient;
            });
            update_option('cwicly_rest_transients', $all_transients);
        }
    }

    /**
     * Fired upon WordPress 'delete_post' hook. Delete all related caches, including all single cache statistics.
     *
     * @param int $post_id Post ID.
     */
    public static function delete_terms(int $term_id, int $tt_id, string $taxonomy)
    {
        $change = false;
        $all_transients = get_option('cwicly_rest_transients');
        // $taxonomy_slug = get_term_by('id', $tt_id, 'name_of_the_taxonomy');
        if ($all_transients) {
            foreach ($all_transients as $index => $transientName) {
                if (str_contains($transientName, 'cc-terms') && str_contains($transientName, $taxonomy)) {
                    delete_transient($transientName);

                    $all_transients = array_filter($all_transients, static function ($element) use ($transientName) {
                        return $element !== $transientName;
                    });
                    $change = true;
                }
            }
            if ($change) {
                update_option('cwicly_rest_transients', $all_transients);
            }
        }
    }

    /**
     * Function for `wp_trash_post` action-hook.
     *
     * @param int     $postid Post ID.
     *
     * @return void
     */
    public function delete_trash_post_action($postid)
    {
        $post = get_post($postid);

        if ($post->post_type === 'wp_template_part') {
            if (file_exists(wp_upload_dir()['basedir'] . '/cwicly/css/cc-tp-' . get_stylesheet() . '_' . $post->post_name . '.css')) {
                wp_delete_file(wp_upload_dir()['basedir'] . '/cwicly/css/cc-tp-' . get_stylesheet() . '_' . $post->post_name . '.css');
            }
        } else if ($post->post_type === 'wp_template') {
            if (file_exists(wp_upload_dir()['basedir'] . '/cwicly/css/cc-tp-' . get_stylesheet() . '_' . $post->post_name . '.css')) {
                wp_delete_file(wp_upload_dir()['basedir'] . '/cwicly/css/cc-tp-' . get_stylesheet() . '_' . $post->post_name . '.css');
            }
        } else if ($post->post_type === 'wp_block') {
            if (file_exists(wp_upload_dir()['basedir'] . '/cwicly/css/cc-rb-' . $postid . '.css')) {
                wp_delete_file(wp_upload_dir()['basedir'] . '/cwicly/css/cc-rb-' . $postid . '.css');
            }
        } else if (file_exists(wp_upload_dir()['basedir'] . '/cwicly/css/cc-post-' . $postid . '.css')) {
            wp_delete_file(wp_upload_dir()['basedir'] . '/cwicly/css/cc-post-' . $postid . '.css');
        }
    }

    /**
     * Function for `delete_post` action-hook.
     *
     * @param int     $postid Post ID.
     * @param WP_Post $post   Post object.
     *
     * @return void
     */
    public static function delete_post_action($postid, $post)
    {
        if ($post->post_type === 'wp_template_part') {
            if (file_exists(wp_upload_dir()['basedir'] . '/cwicly/css/cc-tp-' . get_stylesheet() . '_' . $post->post_name . '.css')) {
                wp_delete_file(wp_upload_dir()['basedir'] . '/cwicly/css/cc-tp-' . get_stylesheet() . '_' . $post->post_name . '.css');
            }
        } else if ($post->post_type === 'wp_template') {
            if (file_exists(wp_upload_dir()['basedir'] . '/cwicly/css/cc-tp-' . get_stylesheet() . '_' . $post->post_name . '.css')) {
                wp_delete_file(wp_upload_dir()['basedir'] . '/cwicly/css/cc-tp-' . get_stylesheet() . '_' . $post->post_name . '.css');
            }
        } else if ($post->post_type === 'wp_block') {
            if (file_exists(wp_upload_dir()['basedir'] . '/cwicly/css/cc-rb-' . $postid . '.css')) {
                wp_delete_file(wp_upload_dir()['basedir'] . '/cwicly/css/cc-rb-' . $postid . '.css');
            }
        } else if (file_exists(wp_upload_dir()['basedir'] . '/cwicly/css/cc-post-' . $postid . '.css')) {
            wp_delete_file(wp_upload_dir()['basedir'] . '/cwicly/css/cc-post-' . $postid . '.css');
        }
    }

    /**
     * Fired upon WordPress metadata call for blocks. Allows us to filter the defaults.
     *
     */
    public function filter_metadata_registration($metadata)
    {
        if (isset($metadata['name']) && $metadata['name'] && strpos($metadata['name'], 'cwicly/') !== false) {
            $optimise = get_option('cwicly_optimise');
            if ($optimise && isset($optimise['cwiclyDefaults']) && $optimise['cwiclyDefaults'] === 'true') {
                return $metadata;
            }

            if (strpos($metadata['name'], 'cwicly/query-template') === false) {
                $metadata['attributes']['containerLayoutDisplay'] = array('type' => 'object');
            }

            $metadata['attributes']['containerLayoutPosition'] = array('type' => 'object');
            $metadata['attributes']['backgroundImageTypePseudo'] = array('type' => 'object');
            if (strpos($metadata['name'], 'cwicly/styler') === false) {
                $metadata['attributes']['backgroundImageType'] = array('type' => 'string');
            }
            $metadata['attributes']['containerLayoutTag'] = array('type' => 'string');

            // BUTTON
            $metadata['attributes']['containerLayoutAlignItems'] = array('type' => 'object');
            $metadata['attributes']['containerLayoutFlexDirection'] = array('type' => 'object');
            // BUTTON

            // COLUMNS & MAPS
            if (strpos($metadata['name'], 'cwicly/columns') !== false ||
                strpos($metadata['name'], 'cwicly/image') !== false ||
                strpos($metadata['name'], 'cwicly/modal') !== false ||
                strpos($metadata['name'], 'cwicly/icon') !== false ||
                strpos($metadata['name'], 'cwicly/section') !== false ||
                strpos($metadata['name'], 'cwicly/maps') !== false) {
                $metadata['attributes']['containerSizeWidth'] = array('type' => 'object');
            }
            // COLUMNS & MAPS

            // COLUMNS
            if (strpos($metadata['name'], 'cwicly/columns') !== false) {
                $metadata['attributes']['columnsControl'] = array('type' => 'boolean');
                $metadata['attributes']['columnsTemplateColumns'] = array('type' => 'object');
                $metadata['attributes']['columnsMinimumColumnsWidth'] = array('type' => 'object');
                $metadata['attributes']['columnsAutoFitControl'] = array('type' => 'boolean');
                $metadata['attributes']['columnsColumnGap'] = array('type' => 'object');
                $metadata['attributes']['columnsRowGap'] = array('type' => 'object');
                $metadata['attributes']['columnsRowHeight'] = array('type' => 'object');
                $metadata['attributes']['columnsItems'] = array('type' => 'object');
                $metadata['attributes']['columnsAutoItems'] = array('type' => 'object');
                // COLUMNS
            }

            if (strpos($metadata['name'], 'cwicly/repeater') !== false ||
                strpos($metadata['name'], 'cwicly/query-template') !== false ||
                strpos($metadata['name'], 'cwicly/taxonomyterms') !== false) {
                $metadata['attributes']['columnsColumnGap'] = array('type' => 'object');
                $metadata['attributes']['columnsRowGap'] = array('type' => 'object');
            }

            // IMAGES
            if (strpos($metadata['name'], 'cwicly/image') !== false ||
                strpos($metadata['name'], 'cwicly/slide') !== false) {
                $metadata['attributes']['containerSizeWidth'] = array('type' => 'object');
                $metadata['attributes']['containerSizeHeight'] = array('type' => 'object');
            }
            // IMAGES

            // LIST
            if (strpos($metadata['name'], 'cwicly/list') !== false) {
                $metadata['attributes']['listStyleUl'] = array('type' => 'string');
                $metadata['attributes']['listStyleOl'] = array('type' => 'string');
            }
            // LIST

            // SECTION
            if (strpos($metadata['name'], 'cwicly/section') !== false) {
                $metadata['attributes']['containerSizeMaxWidth'] = array('type' => 'object');
            }
            // SECTION
            return $metadata;
        }
        return $metadata;
    }

    /**
     * Function for `updated_option` action-hook.
     *
     * @param string $option    Name of the updated option.
     * @param mixed  $old_value The old option value.
     * @param mixed  $value     The new option value.
     *
     * @return void
     */
    public function updated_option_action($option, $old_value, $value)
    {
        if (
            $option === 'cwicly_local_active_fonts' ||
            $option === 'cwicly_local_fonts' ||
            $option === 'cwicly_section_defaults' ||
            $option === 'cwicly_global_styles' ||
            $option === 'cwicly_breakpoints' ||
            $option === 'cwicly_global_classes' ||
            $option === 'cwicly_global_classes_folders' ||
            $option === 'cwicly_global_stylesheets' ||
            $option === 'cwicly_global_stylesheets_folders'
        ) {
            $hearbeat = get_option('cwicly_heartbeat');

            if (!$hearbeat) {
                $hearbeat = [];
            }
            $hearbeat[$option] = time();

            update_option('cwicly_heartbeat', $hearbeat);
        }

        if (
            $option === 'cwicly_global_parts' ||
            $option === 'cwicly_pre_conditions'
        ) {
            $hearbeat = get_option('cwicly_themer_heartbeat');

            if (!$hearbeat) {
                $hearbeat = [];
            }
            $hearbeat[$option] = time();

            update_option('cwicly_themer_heartbeat', $hearbeat);
        }
    }
}
