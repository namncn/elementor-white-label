<?php
/**
 * Plugin Name: Elementor White Label
 * Plugin URI: https://namncn.com
 * Description: White Label for Elementor Page Builder.
 * Version: 1.0.1
 * Author: PhoenixDigi Việt Nam
 * Author URI: https://phoenixdigi.vn
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: elementor-white-label
 * Domain Path: /languages/
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'ELEMENTOR_WHITE_LABEL_VER', '1.0.1' );
define( 'ELEMENTOR_WHITE_LABEL_PATH', plugin_dir_path( __FILE__ ) );
define( 'ELEMENTOR_WHITE_LABEL_BASE', plugin_basename( __FILE__ ) );
define( 'ELEMENTOR_WHITE_LABEL_URL', plugins_url( '/', __FILE__ ) );

require_once ELEMENTOR_WHITE_LABEL_PATH . 'includes/class-elementor-white-label.php';

/**
 * Load Localisation files.
 */
function ewl_load_plugin_textdomain() {
	load_plugin_textdomain( 'elementor-white-label', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'ewl_load_plugin_textdomain' );
