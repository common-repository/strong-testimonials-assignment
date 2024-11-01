<?php
/**
 * @package           StrongTestimonialsAssignment
 * @author            Chris Dillon <chris@strongplugins.com>
 * @license           GPL-2.0+
 * @link              https://strongplugins.com
 * @copyright         Copyright (c) 2019, Chris Dillon
 *
 * @wordpress-plugin
 * Plugin Name:       Strong Testimonials Assignment
 * Plugin URI:
 * Description:       Assign testimonials to any content type.
 * Version:           2.0
 * Author:            Chris Dillon
 * Author URI:        https://strongplugins.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       strong-testimonials-assignment
 * Domain Path:       /languages
 */

defined( 'ABSPATH' ) or die(); // Exit if accessed directly

define( 'WPMTST_ASSIGNMENT_VERSION', '2.0' );
define( 'WPMTST_ASSIGNMENT_NAME', dirname( plugin_basename( __FILE__ ) ) );
define( 'WPMTST_ASSIGNMENT_KEY', str_replace( 'strong-testimonials-', '', WPMTST_ASSIGNMENT_NAME ) );
define( 'WPMTST_ASSIGNMENT_PATH', plugin_dir_path( __FILE__ ) );
define( 'WPMTST_ASSIGNMENT_URL', plugin_dir_url( __FILE__ ) );

/**
 * On plugin activation.
 *
 * @since 1.0.0
 */
function strong_testimonials_assignment_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'classes/Activation.php';
	StrongTestimonialsAssignment\Activation::activate();
}

/**
 * On plugin deactivation.
 *
 * @since 1.0.0
 */
function strong_testimonials_assignment_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'classes/Activation.php';
	StrongTestimonialsAssignment\Activation::deactivate();
}

register_activation_hook( __FILE__, 'strong_testimonials_assignment_activate' );
register_deactivation_hook( __FILE__, 'strong_testimonials_assignment_deactivate' );

/**
 * Get plugin data.
 *
 * @since 1.0.0
 */
function strong_testimonials_assignment_data() {
	$plugin = get_file_data( __FILE__, array(
		'name'    => 'Plugin Name',
		'version' => 'Version',
	) );

	$addon = array(
		'file'    => plugin_basename( __FILE__ ),
		'name'    => $plugin['name'],
		'version' => $plugin['version'],
		'license' => array(
			'key'    => '',
			'status' => '',
		),
	);

	return $addon;
}

/**
 * Autoloader.
 *
 * @since 1.0.0
 */
spl_autoload_register( 'strong_testimonials_assignment_autoloader' );

/**
 * @param $class_name
 */
function strong_testimonials_assignment_autoloader( $class_name ) {
	$base = 'StrongTestimonialsAssignment';

	if ( false !== strpos( $class_name, $base ) ) {
		$classes_dir = plugin_dir_path( __FILE__ ) . 'classes';
		$class_file  = str_replace( array( $base, '_' ), array( '', '/' ), $class_name ) . '.php';
		/** @noinspection PhpIncludeInspection */
		require_once wp_normalize_path( $classes_dir . $class_file );
	}
}

/**
 * Run after all plugins are loaded.
 *
 * Check for minimum required versions.
 *
 * @since 1.0.0
 */
if ( ! version_compare( PHP_VERSION, '5.3', '>=' ) ) {
	add_action( 'admin_notices', 'wpmtst_assignment_fail_php_version' );
} elseif ( ! version_compare( get_bloginfo( 'version' ), '4.4', '>=' ) ) {
	add_action( 'admin_notices', 'wpmtst_assignment_fail_wp_version' );
} elseif ( ! version_compare( get_option( 'wpmtst_plugin_version' ), '2.31', '>=' ) ) {
	add_action( 'admin_notices', 'wpmtst_assignment_fail_plugin_version' );
} else {
	add_action( 'plugins_loaded', 'wpmtst_assignment_run' );
}

/**
 * Fire it up.
 *
 * @since 1.0.0
 */
function wpmtst_assignment_run() {
	$plugin = new StrongTestimonialsAssignment\Core();
	$plugin->run();
}

/**
 * Admin notice for minimum PHP version.
 *
 * @since 1.0.0
 */
function wpmtst_assignment_fail_php_version() {
	/* translators: %s: PHP version */
	$message = sprintf( esc_html__( 'Strong Testimonials Assignment requires PHP version %s+. The plugin is currently NOT ACTIVE.', 'strong-testimonials-assignment' ), '5.3' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}

/**
 * Admin notice for minimum WordPress version.
 *
 * @since 1.0.0
 */
function wpmtst_assignment_fail_wp_version() {
	/* translators: %s: WordPress version */
	$message = sprintf( esc_html__( 'Strong Testimonials Assignment requires WordPress version %s+. The plugin is currently NOT ACTIVE.', 'strong-testimonials-assignment' ), '4.4' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}

/**
 * Admin notice for minimum Strong Testimonials version.
 *
 * @since 1.0.0
 */
function wpmtst_assignment_fail_plugin_version() {
	/* translators: %s: Strong Testimonials plugin version */
	$message = sprintf( esc_html__( 'Strong Testimonials Assignment add-on requires Strong Testimonials version %s+. The plugin is currently NOT ACTIVE.', 'strong-testimonials-assignment' ), '2.31' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}
