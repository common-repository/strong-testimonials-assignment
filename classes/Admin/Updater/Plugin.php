<?php

namespace StrongTestimonialsAssignment;

/**
 * Class Admin_Updater_Plugin
 * @package StrongTestimonialsAssignment
 * @since 1.0.0
 */
class Admin_Updater_Plugin {

	/**
	 * Admin_Updater_Plugin constructor.
	 */
	public function __construct() {
		$this->add_actions();
	}

	/**
	 * Add actions and filters.
	 *
	 * @since 1.0.0
	 */
	public function add_actions() {
		add_action( 'admin_init', array( $this, 'plugin_update_check' ) );
	}

	/**
	 * Check if plugin has updated.
	 *
	 * @since 1.0.0
	 */
	public function plugin_update_check() {
		$current_version = $this->get_current_version();
		if ( ! $current_version || $current_version != WPMTST_ASSIGNMENT_VERSION ) {
			$this->update_addon_info();
			$this->set_trigger();
		}
	}

	/**
	 * Get this add-on's version.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_current_version() {
		// TODO get_sub_option
		$addons = get_option( 'wpmtst_addons' );
		if ( isset( $addons[ WPMTST_ASSIGNMENT_KEY ]['version'] ) ) {
			return $addons[ WPMTST_ASSIGNMENT_KEY ]['version'];
		} else {
			return null;
		}
	}

	/**
	 * Set this add-on's version.
	 *
	 * @since 1.0.0
	 */
	public function update_addon_info() {
		// TODO update_sub_option
		$addons = get_option( 'wpmtst_addons' );
		if ( $addons ) {
			$addons[ WPMTST_ASSIGNMENT_KEY ]['version'] = WPMTST_ASSIGNMENT_VERSION;
		} else {
			$addons[ WPMTST_ASSIGNMENT_KEY ] = strong_testimonials_assignment_data();
		}
		update_option( 'wpmtst_addons', $addons );
	}

	/**
	 * Set the trigger that the plugin has updated.
	 */
	private function set_trigger() {
		update_option( 'plugin_updated_' . WPMTST_ASSIGNMENT_NAME, true );
	}

}
