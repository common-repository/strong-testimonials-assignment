<?php

namespace StrongTestimonialsAssignment;

/**
 * Class Admin_Settings
 * @package StrongTestimonialsAssignment
 * @since 1.0.0
 */
class Admin_Settings extends Admin_Component {

	/**
	 * Admin_Settings constructor.
	 */
	public function __construct() {
		parent::__construct();

		$this->add_actions();
	}

	/**
	 * Add actions and filters.
     *
     * @since 1.0.0
	 */
	public function add_actions() {
		add_action( 'admin_init', array( $this, 'register_settings' ) );

		add_action( 'wpmtst_settings_tabs', array( $this, 'settings_tab' ), 10, 2 );

		add_filter( 'wpmtst_settings_callbacks', array( $this, 'settings_include' ) );

		add_action( 'wpmtst_settings_submit_row', array( $this, 'submit_buttons' ) );

		add_action( 'update_option_wpmtst_assignment', array( $this, 'reset_counts' ), 10, 3 );
	}

	public function reset_counts( $old_value, $value, $option ) {
		$delta = array(
			'added'   => array_diff( $value['assignees'], $old_value['assignees'] ),
			'removed' => array_diff( $old_value['assignees'], $value['assignees'] ),
		);

	    update_option( 'strong_testimonials_assignment_reset_counts', $delta );
	}

	/**
	 * Register our settings group.
     *
     * @since 1.0.0
	 */
	public function register_settings() {
		register_setting( 'wpmtst-assignment-group', 'wpmtst_assignment', array( $this, 'sanitize_options' ) );
	}

	/**
     * Validate our settings.
     *
	 * @param array $input
	 * @since 1.0.0
     *
	 * @return array
	 */
	public function sanitize_options( $input ) {
	    if ( isset( $input['assignees'] ) && ! empty( $input['assignees'] ) ) {
		    $settings['assignees'] = array_map( 'sanitize_text_field', array_keys( $input['assignees'] ) );
	    } else {
		    $settings['assignees'] = array();
	    }

		$settings['selection'] = sanitize_text_field( $input['selection'] );

		return $settings;
	}

	/**
     * Add settings tab to main plugin's settings page.
     *
	 * @param $active_tab
	 * @param $url
     * @since 1.0.0
	 */
	public function settings_tab( $active_tab, $url ) {
		printf( '<a href="%s" class="nav-tab %s">%s</a>',
			add_query_arg( 'tab', 'assignment', $url ),
			$active_tab == 'assignment' ? 'nav-tab-active' : '',
			__( 'Assignment', 'strong-testimonials-assignment' ) );
	}

	/**
     * Include our settings page in main plugin's settings pages.
     *
	 * @param array $includes
     * @since 1.0.0
	 *
	 * @return array
	 */
	public function settings_include( $includes ) {
		$includes['assignment'] = array( $this, 'settings_page' );

		return $includes;
	}

	/**
     * Print our settings page.
     *
	 * @since 1.0.0
	 */
	public function settings_page() {
		settings_fields( 'wpmtst-assignment-group' );
		include WPMTST_ASSIGNMENT_PATH . '/includes/admin/settings/settings.php';
	}

	/**
	 * Add our settings form submit buttons.
     *
     * @since 1.0.0
	 */
	public function submit_buttons() {
		if ( isset( $_GET['tab'] ) && 'assignment' == $_GET['tab'] ) {
			submit_button( '', 'primary', 'submit-form', false );
			printf( '<input type="reset" id="reset" class="button" value="%s"/>', esc_html__( 'Undo Changes', 'strong-testimonials-assignment' ) );
		}
	}

}
