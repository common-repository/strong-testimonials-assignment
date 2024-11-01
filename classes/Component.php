<?php

namespace StrongTestimonialsAssignment;

/**
 * Class Component
 * @package StrongTestimonialsAssignment
 * @since 1.0.0
 */
class Component {

	/**
	 * @var
	 * @since 1.0.0
	 */
	public $post_type;

	/**
	 * Component constructor.
	 */
	public function __construct() {
		$this->set_post_type();
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
	 * Get the post types that can have testimonials assigned to them.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_assignee_types() {
		$options = get_option( 'wpmtst_assignment' );

		return $options['assignees'];
	}

	/**
	 * Return setting for using single or multiple assignments.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function allow_multiple() {
		$options = get_option( 'wpmtst_assignment' );

		return $options['selection'] == 'multiple';
	}

	/**
	 * Return registered post type objects.
	 *
	 * All public post types except testimonials.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_post_type_objects() {
		$post_types = get_post_types( array( 'public' => true, ), 'objects' );

		$exclude = array( $this->post_type => '' );

		$post_types = array_diff_key( $post_types, $exclude );

		return $post_types;
	}

	/**
	 * Return list of user-selected post type objects.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_assignee_post_type_objects() {
		$post_types = array_intersect_key( $this->get_post_type_objects(), array_flip( $this->get_assignee_types() ) );

		return $post_types;
	}

	/**
	 * Return a list of post types and posts that can have testimonial assignments.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_assignees() {
		$assignees = array();

		$post_type_objects = $this->get_assignee_post_type_objects();

		foreach ( $post_type_objects as $post_type => $post_type_object ) {

			$args = apply_filters( 'wpmtst_assignees_get_posts', array(
				'posts_per_page' => - 1,
				'post_type'      => $post_type,
			) );

			$assignees[ $post_type ] = array(
				'name'  => $post_type_object->labels->name,
				'posts' => get_posts( $args ),
			);

		}

		return apply_filters( 'wpmtst_assignees', $assignees );
	}

	/**
	 * Return the post title of an assignee post object.
	 *
	 * @param $post_id
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_assignee( $post_id ) {
		$assignee = get_post( $post_id );

		if ( $assignee ) {
			return $assignee->post_title;
		}

		return '';
	}

}
