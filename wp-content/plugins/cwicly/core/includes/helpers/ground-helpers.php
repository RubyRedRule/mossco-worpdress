<?php

if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

function cc_make_global_stylesheets($data)
{
    try {
        // CSS
        global $wp_filesystem;
        if (!$wp_filesystem) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
        }

        $css = '';
        // if ($data->get_param('css')) {
        if ($data) {
            // $css = $data->get_param('css');
            $css = $data;
            if ($css === 'empty') {
                $css = '';
            }
            update_option('cwicly_global_stylesheets_rendered', $css);

            $filename = "cc-global-stylesheets.css";

            $upload_dir = wp_upload_dir();
            $dir = trailingslashit($upload_dir['basedir']) . 'cwicly/';

            WP_Filesystem(false, $upload_dir['basedir'], true);

            if (!$wp_filesystem->is_dir($dir)) {
                $wp_filesystem->mkdir($dir);
            }

            file_put_contents($dir . $filename, $css);
        }
        return ['success' => true, 'message' => 'Updated.'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

function cc_make_global_css($data)
{
    try {

        global $wp_filesystem;
        if (!$wp_filesystem) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
        }

        $css = '';
        $common = '';
        $font = '';
        $responsive_lg = '';
        $responsive_md = '';
        $responsive_sm = '';

        if ($data) {
            $css = $data;
        }
        if ($css) {
            if ($css['common']) {
                $common = $css['common'];
            }
            if ($css['font']) {
                $font = $css['font'];
            }
            if ($css['lg']) {
                $responsive_lg = $css['lg'];
            }
            if ($css['md']) {
                $responsive_md = $css['md'];
            }
            if ($css['sm']) {
                $responsive_sm = $css['sm'];
            }
        }

        $filename = "cc-global-classes.css";

        $upload_dir = wp_upload_dir();
        $dir = trailingslashit($upload_dir['basedir']) . 'cwicly/';

        WP_Filesystem(false, $upload_dir['basedir'], true);

        if (!$wp_filesystem->is_dir($dir)) {
            $wp_filesystem->mkdir($dir);
        }

        $option = get_option('cwicly_breakpoints');

        file_put_contents($dir . $filename, $font . $common . $responsive_lg . '@media screen and (max-width: ' . $option['md'] . 'px){' . $responsive_md . '}' . '@media screen and (max-width: ' . $option['sm'] . 'px){' . $responsive_sm . '}');

        return ['success' => true, 'message' => 'Updated.'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}
