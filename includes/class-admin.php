<?php
defined('ABSPATH') || exit;

class Unit_Price_Display_Admin {

    public static function init() {
        add_action('woocommerce_product_options_pricing', array(__CLASS__, 'add_unit_field'));
        add_action('woocommerce_admin_process_product_object', array(__CLASS__, 'save_unit_field'));
        add_action('admin_enqueue_scripts', array(__CLASS__, 'admin_assets'));
    }

    public static function add_unit_field() {
        woocommerce_wp_select(array(
            'id'          => '_unit_measure',
            'label'       => __('Unit of Measurement', 'unit-price-display'),
            'description' => __('Select measurement unit for price display', 'unit-price-display'),
            'desc_tip'    => true,
            'options'     => self::get_units(),
            'class'       => 'select short unit-measure-field',
        ));
    }

    public static function save_unit_field($product) {
        $unit = isset($_POST['_unit_measure']) ? sanitize_text_field($_POST['_unit_measure']) : '';
        $product->update_meta_data('_unit_measure', $unit);
    }

    private static function get_units() {
        return apply_filters('unit_price_display_units', array(
            ''          => __('None', 'unit-price-display'),
            'piece'     => __('Per piece', 'unit-price-display'),
            'kg'        => __('Per kilogram', 'unit-price-display'),
            '100g'      => __('Per 100 grams', 'unit-price-display'),
            'meter'     => __('Per meter', 'unit-price-display'),
            'liter'     => __('Per liter', 'unit-price-display'),
            'pack'      => __('Per pack', 'unit-price-display'),
            'set'       => __('Per set', 'unit-price-display'),
        ));
    }

    public static function admin_assets() {
        wp_enqueue_script(
            'unit-price-display-admin',
            UNIT_PRICE_DISPLAY_URL . 'assets/js/admin.js',
            array('jquery'),
            UNIT_PRICE_DISPLAY_VERSION,
            true
        );
    }
}