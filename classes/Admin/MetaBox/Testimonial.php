<?php

namespace StrongTestimonialsAssignment;

/**
 * Class Admin_MetaBox_Testimonial
 * @package StrongTestimonialsAssignment
 * @since 1.0.0
 */
class Admin_MetaBox_Testimonial extends Admin_Component {

	/**
	 * Admin_MetaBox_Testimonial constructor.
	 */
	public function __construct() {
		parent::__construct();

		add_action( 'admin_init', array( $this, 'add_actions' ) );
	}

	/**
	 * Add actions and filters.
	 *
	 * @since 1.0.0
	 */
	public function add_actions() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
	}

	/**
	 * Add meta boxes.
	 *
	 * @since 1.0.0
	 */
	public function add_meta_boxes() {
		add_meta_box(
			'assignment',
			__( 'Assignment', 'strong-testimonials-assignment' ),
			array( $this, 'meta_box_callback' ),
			$this->post_type,
			'side',
			'default'
		);
	}

	/**
	 * Print meta boxes.
	 *
	 * @since 1.0.0
	 */
	public function meta_box_callback() {
		include WPMTST_ASSIGNMENT_PATH . '/includes/admin/metabox/testimonial.php';
	}

}
