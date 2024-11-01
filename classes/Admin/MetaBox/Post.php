<?php

namespace StrongTestimonialsAssignment;

/**
 * Class Admin_MetaBox_Post
 * @package StrongTestimonialsAssignment
 * @since 1.0.0
 */
class Admin_MetaBox_Post extends Admin_Component {

	/**
	 * Admin_MetaBox_Post constructor.
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
			'assigned-testimonials',
			__( 'Assigned Testimonials', 'strong-testimonials-assignment' ),
			array( $this, 'meta_box_callback' ),
			$this->get_assignee_types(),
			'normal',
			'default'
		);
	}

	/**
	 * Print meta boxes.
	 *
	 * @since 1.0.0
	 */
	public function meta_box_callback() {
		include WPMTST_ASSIGNMENT_PATH . '/includes/admin/metabox/post.php';
	}

}
