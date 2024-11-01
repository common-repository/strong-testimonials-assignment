<?php

namespace StrongTestimonialsAssignment;

/**
 * Class Testimonial
 * @package StrongTestimonialsAssignment
 * @since 1.0.0
 */
class Testimonial {

	/**
	 * Our post type name.
	 *
	 * @var
	 * @since 1.0.0
	 */
	private $post_type;

	/**
	 * Testimonial constructor.
	 */
	public function __construct() {
		$this->set_post_type();

		$this->add_actions();
	}

	/**
	 * Set our post type.
	 */
	private function set_post_type() {
		$this->post_type = 'wpm-testimonial';
	}

	/**
	 * Add actions and filters.
	 *
	 * @since 1.0.0
	 */
	private function add_actions() {
		add_action( 'save_post_wpm-testimonial', array( $this, 'save_assignment' ), 10, 3 );
	}

	/**
	 * Store assignment value when testimonial is saved.
	 *
	 * On both back and front end.
	 *
	 * @param $post_id
	 * @param $post
	 * @param $update
	 * @since 1.0.0
	 */
	public function save_assignment( $post_id, $post, $update ) {
		// array
		if ( isset( $_POST['strong_assignment'] ) ) {
			$assignments = array_map( 'sanitize_text_field', (array) $_POST['strong_assignment'] );
		} else {
			$assignments = array();
		}

		// array
		$previous = get_post_meta( $post_id, 'strong_assignment' );

		// array
		delete_post_meta( $post_id, 'strong_assignment' );

		if ( empty( array_filter( $assignments ) ) ) {
			// set placeholder
			update_post_meta( $post_id, 'strong_assignment', 0, true );
		} else {
			// set new assignments
			foreach ( $assignments as $assignment ) {
				// single
				if ( wpmtst_assignment_is_post_excluded( $assignment ) ) {
					update_post_meta( $post_id, 'strong_assignment', 0, true );
				} else {
					add_post_meta( $post_id, 'strong_assignment', $assignment );
				}
			}
		}

		// assemble list of all affected assignees
		$recount = array_unique( array_merge( $previous, $assignments ) );

		// recount
		array_walk( $recount, array( $this, 'count_assignments' ) );
	}

	/**
	 * Count testimonials assigned to a specific object.
	 *
	 * @param $assignee
	 * @since 1.0.0
	 */
	public function count_assignments( $assignee ) {
		$testimonials = get_posts( array(
			'posts_per_page' => - 1,
			'post_type'      => $this->post_type,
			'meta_query'     => array(
				array(
					// single
					'key'   => 'strong_assignment',
					'value' => $assignee,
				),
			),
		) );

		update_post_meta( $assignee, 'strong_assignment_count', count( $testimonials ) );
	}

}
