<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include the ACF plugin.
include_once(MY_ACF_PATH . 'acf.php');

add_filter('acf/settings/url', 'my_acf_settings_url');
function my_acf_settings_url($url)
{
    return MY_ACF_URL;
}
