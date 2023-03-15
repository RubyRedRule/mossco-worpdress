<?php
namespace Cwicly;

if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

class Init
{

    public function __construct()
    {
        $this->init();
    }

    /**
     * The machine instance
     */
    public static $instance = null;

    /**
     * Init machine :)
     */
    public function init()
    {
        new Setup();
        new License();
        new Settings();
        if (CC_WOOCOMMERCE) {
            new WooCommerce();
        }
        new Actions();
        if (is_admin()) {
            new Backend();
        }
        new Frontend();
        new Themer();
    }

    /**
     * Machine turn on. Only one instance of the class is allowed.
     */
    public static function machine()
    {
        if (!isset(self::$instance) && !(self::$instance instanceof Init)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}

Init::machine();
