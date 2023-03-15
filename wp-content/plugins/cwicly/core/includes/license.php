<?php
namespace Cwicly;

if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

class License
{
    /**
     * License constructor.
     */
    public function __construct()
    {
        $this->init();
        add_action('admin_init', [$this, 'license_checker']);
    }

    /**
     * Init
     */
    public function init()
    {
        if (!defined('CC_LICENSE_KEY') || !defined('CC_LICENSE_EMAIL')) {
            add_action('admin_notices', [$this, 'no_license_key_found']);
        }
    }

    /**
     * Check license validity
     */
    public static function license_checker()
    {
        if (defined('CC_LICENSE_KEY') && defined('CC_LICENSE_EMAIL')) {
            $option = get_option('cwicly_license_check');

            $error = get_transient('cwicly_plugin_license_message');
            $pluginLicenseTransient = get_transient('cwicly_license_constant');
            $emailLicenseTransient = get_transient('cwicly_license_email_constant');

            if (!$emailLicenseTransient) {
                set_transient('cwicly_license_email_constant', CC_LICENSE_EMAIL, 30 * DAY_IN_SECONDS);
            }
            if (!$pluginLicenseTransient) {
                set_transient('cwicly_license_constant', CC_LICENSE_KEY, 30 * DAY_IN_SECONDS);
            }

            $pluginTransient = false;
            if (($pluginLicenseTransient && $pluginLicenseTransient != CC_LICENSE_KEY) || (!$pluginLicenseTransient && CC_LICENSE_KEY)) {
                $pluginTransient = true;
                set_transient('cwicly_license_constant', CC_LICENSE_KEY, 30 * DAY_IN_SECONDS);
                $error = false;
            }
            $emailTransient = false;
            if (($emailLicenseTransient && $emailLicenseTransient != CC_LICENSE_EMAIL) || (!$emailLicenseTransient && CC_LICENSE_EMAIL)) {
                $emailTransient = true;
                set_transient('cwicly_license_email_constant', CC_LICENSE_EMAIL, 30 * DAY_IN_SECONDS);
                $error = false;
            }

            if (!$option && !$error) {
                delete_transient('cwicly_plugin_license_message');
                self::the_lc_check();
            } else if (!$error) {
                $decode = json_decode($option, true);
                if (isset($decode['date']) && $decode['date'] && isset($decode['server']) && $decode['server']) {
                    $someDate = new \DateTime($decode['date']);
                    $now = new \DateTime();

                    if ($decode['server'] != Helpers::get_server_address() || $someDate->diff($now)->days > 2 || $pluginTransient || $emailTransient) {
                        delete_transient('cwicly_plugin_license_message');
                        self::the_lc_check();
                    }
                } else {
                    delete_transient('cwicly_plugin_license_message');
                    self::the_lc_check();
                }
            }
        }
    }

    public static function no_license_key_found()
    {
        ?>
    <div class="error notice">
        <p><?php _e('Cwicly license keys not found or incomplete - please contact <a href="mailto:support@cwicly.com">support@cwicly.com</a>.', 'cwicly');?></p>
        <p><?php _e('Want to enter them manually? Please check the <a href="https://docs.cwicly.com/settings/license">documentation</a>.', 'cwicly');?></p>
    </div>
    <?php
}

    public static function the_lc_check()
    {
        if (defined('CC_LICENSE_KEY') && defined('CC_LICENSE_EMAIL')) {

            $new_server = false;

            $protocols = array('http://', 'http://www.', 'www.', 'https://', 'https://www.');
            $url = str_replace($protocols, '', home_url());

            $verify_ssl_option = get_option('cwicly_ssl_verify');
            if ($verify_ssl_option === 'true') {
                $verify_ssl = true;
            } else {
                $verify_ssl = false;
            }

            $request = wp_remote_get('https://cwicly.com/wp-json/cwicly/v1/cwicly_licenser?license=' . CC_LICENSE_KEY . '&url=' . $url . '&email=' . rawurlencode(CC_LICENSE_EMAIL) . '', array('user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8) AppleWebKit/535.6.2 (KHTML, like Gecko) Version/5.2 Safari/535.6.2', 'sslverify' => $verify_ssl));

            if (is_wp_error($request) || 200 !== wp_remote_retrieve_response_code($request) || !json_decode($request['body'])) {
                Helpers::write_log('CWICLY LICENSING: Something went wrong in the Cwicly license check, trying on the new activation server.');
                $request = License::license_new_server();
                $new_server = true;
            }

            if (is_wp_error($request) || 200 !== wp_remote_retrieve_response_code($request)) {
                Helpers::write_log('CWICLY LICENSING: Something went wrong in the Cwicly license check, most likely a connection issue.');
                update_option('cwicly_plugin_license_key_status', 'error');
                set_transient('cwicly_plugin_license_message', 'error', 5 * MINUTE_IN_SECONDS);
                return ['success' => false];
            } else {
                if (!$new_server) {
                    // Helpers::write_log('CWICLY LICENSING: Old activation is working, no need to switch to the new one.');
                    $final = json_decode($request['body']);
                } else {
                    $final = json_decode(json_decode($request['body']));
                }
                $status = 'unknown';
                if (isset($final->state->success) && $final->state->success) {
                    $status = 'valid';
                } else if (isset($final->state->error) && $final->state->error) {
                    $status = $final->state->error;
                    set_transient('cwicly_plugin_license_message', 'error', 5 * MINUTE_IN_SECONDS);
                } else {
                    set_transient('cwicly_plugin_license_message', 'unknown', 5 * MINUTE_IN_SECONDS);
                }
                update_option('cwicly_plugin_license_key_status', $status);
                if ($status === 'valid') {
                    $final->server = Helpers::get_server_address();
                    $finaler = json_encode($final);
                    update_option('cwicly_license_check', $finaler);
                } else if ($status === 'expired') {
                    $final->server = Helpers::get_server_address();
                    $finaler = json_encode($final);
                    update_option('cwicly_license_check', $finaler);
                } else {
                    delete_option('cwicly_license_check');
                }
                return ['success' => true];
            }
        } else {
            return ['success' => false];
        }
    }

    public static function license_new_server()
    {
        $protocols = array('http://', 'http://www.', 'www.', 'https://', 'https://www.');
        $url = str_replace($protocols, '', home_url());

        $verify_ssl_option = get_option('cwicly_ssl_verify');
        if ($verify_ssl_option === 'true') {
            $verify_ssl = true;
        } else {
            $verify_ssl = false;
        }

        $final_url = '' . CC_LICENSE_KEY . '&url=' . $url . '&email=' . rawurlencode(CC_LICENSE_EMAIL) . '';
        $request = wp_remote_post(
            'https://license.cwicly.com/wp-json/cwicly/v1/cwicly_licenser',
            array(
                'timeout' => 15,
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode(array(
                    'url' => $final_url,
                    'sslverify' => $verify_ssl,
                )),
            )
        );

        return $request;
    }
}
