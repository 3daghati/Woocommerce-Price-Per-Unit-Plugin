<?php
defined('ABSPATH') || exit;

class Unit_Price_Display_Settings {

    public static function init() {
        add_filter('woocommerce_get_sections_products', array(__CLASS__, 'add_section'));
        add_filter('woocommerce_get_settings_products', array(__CLASS__, 'add_settings'), 10, 2);
    }

    public static function add_section($sections) {
        $sections['unit_price_display'] = __('Unit Price Display', 'unit-price-display');
        return $sections;
    }

    public static function add_settings($settings, $current_section) {
        if ('unit_price_display' === $current_section) {
            $settings = array(
                array(
                    'title' => __('Unit Price Display Settings', 'unit-price-display'),
                    'type'  => 'title',
                    'id'    => 'unit_price_display_options'
                ),
                
                array(
                    'title'    => __('Display Position', 'unit-price-display'),
                    'id'       => 'unit_price_display_position',
                    'type'     => 'select',
                    'options'  => array(
                        'after_price' => __('After Price', 'unit-price-display'),
                        'below_price' => __('Below Price', 'unit-price-display'),
                    ),
                    'default'  => 'after_price',
                ),

                array(
                    'type' => 'sectionend',
                    'id'   => 'unit_price_display_options'
                ),
            );
        }
        return $settings;
    }
}