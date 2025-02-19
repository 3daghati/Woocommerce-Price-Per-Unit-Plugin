<?php
defined('ABSPATH') || exit;

class Unit_Price_Display_Frontend {

    public static function init() {
        add_action('wp_enqueue_scripts', array(__CLASS__, 'enqueue_assets'));
        add_filter('woocommerce_get_price_html', array(__CLASS__, 'display_unit_price'), 100, 2);
    }

    public static function display_unit_price($price, $product) {
        if (is_admin()) return $price;
        
        $unit = $product->get_meta('_unit_measure', true);
        $display_type = get_option('unit_price_display_position', 'after_price');

        if ($unit) {
            ob_start();
            wc_get_template('price-unit-display.php', array(
                'unit' => $unit,
                'position' => $display_type
            ), '', UNIT_PRICE_DISPLAY_PATH . 'templates/');
            return $price . ob_get_clean();
        }
        
        return $price;
    }

    public static function enqueue_assets() {
        wp_enqueue_style(
            'unit-price-display',
            UNIT_PRICE_DISPLAY_URL . 'assets/css/frontend.css',
            array(),
            UNIT_PRICE_DISPLAY_VERSION
        );
    }
}