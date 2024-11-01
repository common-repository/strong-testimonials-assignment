<?php

namespace StrongTestimonialsAssignment;

/**
 * Class Front_Views
 * @package StrongTestimonialsAssignment
 * @since 1.0.0
 */
class Front_Views {

	/**
	 * Front_Views constructor.
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
		add_action( 'wpmtst_form_before_fields', array( $this, 'add_hidden_field' ) );

		add_filter( 'wpmtst_view_container_data', array( $this, 'add_diagnostic_data' ), 10, 2 );
		add_filter( 'wpmtst_view_container_class', array( $this, 'add_diagnostic_class' ), 10, 2 );
	}

	/**
	 * Print the hidden field that captures the current assignment.
	 *
	 * @since 1.0.0
	 */
	public function add_hidden_field() {
		$atts = WPMST()->atts();

		if ( isset( $atts['filter']['assignment'] ) ) {

			switch ( $atts['filter']['assignment'] ) {
				case'current':
					$assignment = get_the_ID();
					break;
				case 'post':
					$assignment = join( ',', $atts['filter']['assignment_value'] );
					break;
				default:
					$assignment = '';
			}

			if ( $assignment ) {
				echo '<input type="hidden" name="strong_assignment" value="' . $assignment . '">';
			}

		}
	}

	/**
	 * Add data attribute to view container for troubleshooting.
	 *
	 * @param array $container_data_list
	 * @param array $atts
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function add_diagnostic_data( $container_data_list, $atts ) {
		if ( isset( $atts['filter']['assignment'] ) ) {
			$container_data_list['assignment'] = $atts['filter']['assignment'];
		}

		return $container_data_list;
	}

	/**
	 * Add CSS class to view container for troubleshooting.
	 *
	 * @param array $container_class_list
	 * @param array $atts
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function add_diagnostic_class( $container_class_list, $atts ) {
		if ( isset( $atts['filter']['assignment'] ) && 'none' != $atts['filter']['assignment'] ) {
			$container_class_list[] = 'filter-assignment';
		}

		return $container_class_list;
	}

}
