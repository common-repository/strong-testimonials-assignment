<?php

namespace StrongTestimonialsAssignment;

/**
 * Class Admin_Views
 * @package StrongTestimonialsAssignment
 * @since 1.0.0
 */
class Admin_Views extends Admin_Component {

	/**
	 * Admin_Views constructor.
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
		add_action( 'admin_print_styles-wpm-testimonial_page_testimonial-views', array( $this, 'enqueue_styles_on_view', ) );

		add_action( 'admin_print_scripts-wpm-testimonial_page_testimonial-views', array( $this, 'enqueue_scripts_on_view', ) );

		add_action( 'wpmtst_view_editor_before_group_select', array( $this, 'add_view_editor_section' ) );

		add_filter( 'wpmtst_sanitized_view', array( $this, 'sanitize_view' ), 10, 2 );
	}

	/**
	 * @since 1.0.0
	 */
	public function enqueue_styles_on_view() {
		wp_enqueue_style( 'wpmtst-assignment-view' );
	}

	/**
	 * @since 1.0.0
	 */
	public function enqueue_scripts_on_view() {
		wp_enqueue_script( 'wpmtst-assignment-view' );
	}

	/**
	 * Add sections to the View editor.
	 *
	 * @since 1.0.0
	 */
	public function add_view_editor_section() {
		include( WPMTST_ASSIGNMENT_PATH . '/includes/admin/views/group-assignment.php' );
	}

	/**
	 * Validate settings.
	 *
	 * @param array $data
	 * @param array $input
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function sanitize_view( $data, $input ) {
		// Replace primary input value with secondary (form mode).
		if ( 'form' == $input['mode'] ) {

			if ( isset( $input['filter']['form_assignment'] ) ) {
				$input['filter']['assignment'] = $input['filter']['form_assignment'];
				unset( $input['filter']['form_assignment'] );
			}

			if ( isset( $input['filter']['form_assignment_value'] ) ) {
				$input['filter']['assignment_value'] = $input['filter']['form_assignment_value'];
				unset( $input['filter']['form_assignment_value'] );
			}

		}

		$data['filter']['assignment'] = sanitize_text_field( $input['filter']['assignment'] );

		if ( isset( $input['filter']['assignment_type'] ) ) {
			$data['filter']['assignment_type'] = sanitize_text_field ( $input['filter']['assignment_type'] );
		} else {
			$data['filter']['assignment_type'] = '';
		}

		if ( isset( $input['filter']['assignment_value'] ) ) {
			$data['filter']['assignment_value'] = array_map( 'sanitize_text_field', (array) $input['filter']['assignment_value'] );
		} else {
			$data['filter']['assignment_value'] = array();
		}

		return $data;
	}

}
