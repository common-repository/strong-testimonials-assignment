<?php

namespace StrongTestimonialsAssignment;

/**
 * Class Admin_Component
 * @package StrongTestimonialsAssignment
 * @since 1.0.0
 */
class Admin_Component extends Component {

	/**
	 * Admin_Component constructor.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Return the current admin screen type.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_screen_type() {
		if ( is_admin() ) {
			$screen = get_current_screen();
			if ( $screen and $screen->post_type ) {
				return $screen->post_type;
			}
		}

		return '';
	}

	/**
	 * Return whether the current post type can be assigned to another.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function is_assignable() {
		return $this->post_type == $this->get_screen_type();
	}

	/**
	 * Return whether the current post type can have others assigned to it.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function is_assignee_by_screen_type() {
		return in_array( $this->get_screen_type(), $this->get_assignee_types() );
	}

}
