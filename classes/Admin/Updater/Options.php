<?php

namespace StrongTestimonialsAssignment;

/**
 * Class Admin_Updater_Options
 * @package StrongTestimonialsAssignment
 * @since 1.0.0
 */
class Admin_Updater_Options {

	/**
	 * Admin_Updater_Options constructor.
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
		add_action( 'admin_init', array( $this, 'update_check' ) );
		add_filter( 'default_option_wpmtst_assignment', array( $this, 'default_option' ), 10, 3 );
	}

	/**
	 * Check for initialization or update steps.
	 *
	 * Keep this as option/action pair because the [option] is set on admin_menu for EDD
	 * and the [action] needs to happen on admin_init (the next step in sequence).
	 *
	 * @since 1.0.0
	 */
	public function update_check() {
		if ( get_option( 'plugin_updated_' . WPMTST_ASSIGNMENT_NAME ) ) {
			// Reset trigger
			delete_option( 'plugin_updated_' . WPMTST_ASSIGNMENT_NAME );
			// Run hooked actions
			do_action( 'plugin_updated_' . WPMTST_ASSIGNMENT_NAME );
		}
	}

    /**
	 * The default options.
	 *
	 * @param $default
	 * @param $option
	 * @param $passed_default
	 * @since 1.1.0
	 *
	 * @return array
	 */
	public function default_option( $default, $option, $passed_default ) {
		return array(
			'assignees' => array(),
			'selection' => 'single',
		);
	}
}
