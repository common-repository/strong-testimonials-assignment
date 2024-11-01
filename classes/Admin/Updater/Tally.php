<?php

namespace StrongTestimonialsAssignment;

/**
 * Class Admin_Updater_Tally
 * @package StrongTestimonialsAssignment
 * @since 1.0.0
 */
class Admin_Updater_Tally {

	/**
	 * @var
	 * @since 1.0.0
	 */
	public $post_type;

	/**
	 * Admin_Updater_Tally constructor.
	 */
	public function __construct() {
		$this->set_post_type();
		$this->add_actions();
	}

	/**
	 * Set our post type.
	 *
	 * @since 1.0.0
	 */
	private function set_post_type() {
		$this->post_type = 'wpm-testimonial';
	}

	/**
	 * Add actions and filters.
	 *
	 * @since 1.0.0
	 */
	public function add_actions() {
		add_action( 'admin_init', array( $this, 'update_check' ), 20 );
	}

	/**
	 * Check for initialization or update steps.
	 *
	 * @since 1.0.0
	 */
	public function update_check() {
		// Initialize assignments
		if ( get_option( 'strong_testimonials_assignment_init' ) ) {
			$this->set_initial_assignments();

			$options = get_option( 'wpmtst_assignment' );
			$start   = array( 'added' => $options['assignees'] );
			$this->set_initial_counts( $start );
			delete_option( 'strong_testimonials_assignment_init' );
			do_action( 'strong_testimonials_assignment_initialized' );
		}

		// Recalculate upon changes elsewhere
		$delta = get_option( 'strong_testimonials_assignment_reset_counts' );
		if ( $delta ) {
			$this->set_initial_counts( $delta );
			delete_option( 'strong_testimonials_assignment_reset_counts' );
		}
	}

	/**
	 * Store initial assignment value.
	 *
	 * @since 1.0.0
	 */
	public function set_initial_assignments() {
		$testimonials = get_posts( array(
			'posts_per_page' => -1,
			'post_type'      => $this->post_type,
		) );

		foreach ( $testimonials as $testimonial ) {
			add_post_meta( $testimonial->ID, 'strong_assignment', 0, true );
		}
	}

	/**
	 * Store initial assignment counts.
	 *
	 * @param array $delta
	 * @since 1.0.0
	 */
	public function set_initial_counts( $delta ) {

		if ( isset( $delta['added'] ) && $delta['added'] ) {

			foreach ( $delta['added'] as $assignee ) {
				$posts = get_posts( array(
					'posts_per_page' => -1,
					'post_type'      => $assignee,
				) );
				foreach ( $posts as $post2 ) {
					$current_count = get_post_meta( $post2->ID, 'strong_assignment_count', true );
					if ( '' === $current_count ) {
						add_post_meta( $post2->ID, 'strong_assignment_count', 0 );
					}
				}
			}

		}

		if ( isset( $delta['removed'] ) && $delta['removed'] ) {

			foreach ( $delta['removed'] as $assignee ) {
				$posts = get_posts( array(
					'posts_per_page' => -1,
					'post_type'      => $assignee,
				) );
				foreach ( $posts as $post2 ) {
					$current_count = get_post_meta( $post2->ID, 'strong_assignment_count', true );
					if ( '0' === $current_count ) {
						delete_post_meta( $post2->ID, 'strong_assignment_count' );
					}
				}
			}

		}

	}

}
