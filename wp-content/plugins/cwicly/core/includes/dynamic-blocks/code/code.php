<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

register_block_type(__DIR__, array(
    'render_callback' => 'cc_code_render_callback',
));

function cc_code_render_callback($attributes, $content, $block)
{
    $hideLoggedin = cc_hide_logged_in($attributes);
    $hideGuest = cc_hide_guest($attributes);

    if (!is_admin() && $hideGuest && $hideLoggedin && cc_conditions_maker($attributes, $block)) {

        $repeated = false;
        if (isset($block->context['product_index'])) {
            $repeated = true;
        } else if (isset($block->context['taxterms_index'])) {
            $repeated = true;
        } else if (isset($block->context['repeater_row'])) {
            $repeated = true;
        } else if (isset($block->context['queryId']) && !isset($block->context['query_index'])) {
            $repeated = true;
        } else if (isset($block->context['queryId']) && isset($block->context['query_index']) && $block->context['query_index'] !== 1) {
            $repeated = true;
        }

        if (isset($attributes['codeCSS']) && $attributes['codeCSS'] && !$repeated) {
            $customcss = str_replace(array("\r", "\n"), '', $attributes['codeCSS']);
            $customcss = preg_replace('!\s+!', ' ', $customcss);
            add_action('wp_head', function () use ($customcss, $attributes) {
                echo '<style id="css-' . $attributes['id'] . '">' . $customcss . '</style>' . PHP_EOL;
            });
        }
        if (isset($attributes['codeJS']) && $attributes['codeJS'] && !$repeated) {
            $customjs = $attributes['codeJS'];
            add_action('wp_footer', function () use ($customjs, $attributes) {
                echo '<script id="script-' . $attributes['id'] . '" type="text/javascript">' . $customjs . '</script>' . PHP_EOL;
            });
        }

        $final = '';
        if (isset($attributes['code'])) {
            ob_start();

            // ERROR
            $error_reporting = error_reporting(E_ALL);
            $display_errors = ini_get('display_errors');
            ini_set('display_errors', 1);

            try {
                $eval = eval(' ?>' . $attributes['code'] . '<?php ');
                $final = ob_get_clean();
            } catch (Exception $e) {
                wp_reset_postdata();
                ob_get_clean();
                echo 'Exception: ' . $e->getMessage();
            } catch (ParseError $e) {
                wp_reset_postdata();
                ob_get_clean();
                echo 'ParseError: ' . $e->getMessage();
            } catch (Error $e) {
                wp_reset_postdata();
                ob_get_clean();
                echo 'Error: ' . $e->getMessage();
            }

            // RESET ERROR
            ini_set('display_errors', $display_errors);
            error_reporting($error_reporting);
        }
        return $final;
    }
}
