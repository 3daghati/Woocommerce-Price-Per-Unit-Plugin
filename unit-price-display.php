<?php
/**
 * Plugin Name: Unit Price Display for WooCommerce
 * Plugin URI: https://github.com/3daghati/
 * Description: Professional unit price display for WooCommerce products
 * Version: 2.0.0
 * Author: 3daghati 
 * Author URI: https://github.com/3daghati
 * Text Domain: unit-price-display
 * Domain Path: /languages
 * Requires PHP: 7.4
 * WC requires at least: 6.0
 * WC tested up to: 8.0
 * License: GPLv3
 */

defined('ABSPATH') || exit;

// Define constants
define('UNIT_PRICE_DISPLAY_VERSION', '2.0.0');
define('UNIT_PRICE_DISPLAY_FILE', __FILE__);
define('UNIT_PRICE_DISPLAY_PATH', plugin_dir_path(__FILE__));
define('UNIT_PRICE_DISPLAY_URL', plugin_dir_url(__FILE__));

require_once __DIR__ . '/vendor/autoload.php';


final class Unit_Price_Display_Plugin {

    private static $instance = null;

    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->includes();
        $this->init_hooks();
    }

    private function includes() {
        require_once UNIT_PRICE_DISPLAY_PATH . 'includes/class-admin.php';
        require_once UNIT_PRICE_DISPLAY_PATH . 'includes/class-frontend.php';
        require_once UNIT_PRICE_DISPLAY_PATH . 'includes/class-settings.php';
    }

    private function init_hooks() {
        add_action('plugins_loaded', array($this, 'init_plugin'));
        register_activation_hook(__FILE__, array($this, 'activate'));
    }

    public function init_plugin() {
        if (!class_exists('WooCommerce')) {
            add_action('admin_notices', array($this, 'woocommerce_missing_notice'));
            return;
        }

        Unit_Price_Display_Admin::init();
        Unit_Price_Display_Frontend::init();
        Unit_Price_Display_Settings::init();
        
        load_plugin_textdomain(
            'unit-price-display',
            false,
            dirname(plugin_basename(__FILE__)) . '/languages/'
        );
    }

    public function woocommerce_missing_notice() {
        ?>
        <div class="error notice">
            <p><?php esc_html_e('Unit Price Display requires WooCommerce to be installed and active.', 'unit-price-display'); ?></p>
        </div>
        <?php
    }

    public function activate() {
        // Activation logic
    }
}

Unit_Price_Display_Plugin::instance();