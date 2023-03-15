<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if (! class_exists('CWICLY_INITIAL_START')) {
    class CWICLY_INITIAL_START{
        protected static $_instance = null;
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        // PHP Error Notice
        public static function php_error_notice(){
            $message = sprintf( esc_html__( 'Careful! Cwicly requires PHP version %s or higher. You will likely not be able to use the website builder on this install.', 'cwicly' ), '5.4' );
            $html_message = sprintf( '<div class="notice notice-error is-dismissible">%s</div>', wpautop( $message ) );
            echo wp_kses_post( $html_message );
        }

        // Wordpress Error Notice
        public static function wordpress_error_notice(){
            $message = sprintf( esc_html__( 'Careful! Cwicly requires WordPress version %s or more. The blocks will inevitably lead to an error.', 'cwicly'), '5.5' );
            $html_message = sprintf( '<div class="notice notice-error is-dismissible">%s</div>', wpautop( $message ) );
            echo wp_kses_post( $html_message );
        }
        // Theme Error Notice
        public static function theme_error_notice(){
            $message = sprintf( esc_html__( 'Careful! You have activated the Cwicly plugin but not the Cwicly theme. We recommend installing and activating both the Cwicly theme and the Cwicly plugin.', 'cwicly'));
            $html_message = sprintf( '<div class="notice notice-error is-dismissible">%s</div>', wpautop( $message ) );
            echo wp_kses_post( $html_message );
        }
    }
}
