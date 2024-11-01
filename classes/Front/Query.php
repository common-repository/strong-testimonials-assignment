<?php

namespace StrongTestimonialsAssignment;

/**
 * Class Front_Query
 * @package StrongTestimonialsAssignment
 * @since 1.0.0
 */
class Front_Query {

	/**
	 * Front_Query constructor.
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
		add_filter( 'wpmtst_query_args', array( $this, 'add_query_args' ), 10, 2 );
		add_filter( 'wpmtst_query_args_post', array( $this, 'add_query_args__post' ), 10, 2 );
		add_filter( 'wpmtst_query_args_current', array( $this, 'add_query_args__current' ), 10, 2 );
		add_filter( 'wpmtst_query_args_type', array( $this, 'add_query_args__type' ), 10, 2 );
	}

	/**
	 * Filter the query for the current assignment.
	 *
	 * @param array $args
	 * @param array $atts
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function add_query_args( $args, $atts = array() ) {
		// ID overrides filter.
		// TODO Move to view atts filter (like shortcode atts filter).
		if ( isset( $atts['id'] ) && $atts['id'] ) {
			return $args;
		}

		if ( isset( $atts['filter']['assignment'] ) && $atts['filter']['assignment'] ) {
			return apply_filters( "wpmtst_query_args_{$atts['filter']['assignment']}", $args, $atts );
		}

		return $args;
	}

	/**
	 * Filter for specific objects.
	 *
	 * @param array $args
	 * @param array $atts
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function add_query_args__type( $args, $atts ) {
		if ( 'unassigned' == $atts['filter']['assignment_type'] ) {

			$args['meta_key']   = 'strong_assignment';
			$args['meta_value'] = '0';

		} else {

			$the_assignees = get_posts( array(
				'posts_per_page'   => -1,
				'post_type'        => $atts['filter']['assignment_type'],
				'post_status'      => 'publish',
				'suppress_filters' => true,
			) );

			$the_assignee_ids = array_map( function ( $n ) { return $n->ID; }, $the_assignees );

			$args['meta_key']     = 'strong_assignment';
			$args['meta_value']   = join( ',', (array) $the_assignee_ids );
			$args['meta_compare'] = 'IN';

		}

		return $args;
	}

	/**
	 * Filter for specific objects.
	 *
	 * @param array $args
	 * @param array $atts
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function add_query_args__post( $args, $atts ) {
		$args['meta_key']     = 'strong_assignment';
		$args['meta_value']   = join( ',', (array) $atts['filter']['assignment_value'] );
		$args['meta_compare'] = 'IN';

		return $args;
	}

	/**
	 * Filter for current objects. The magic.
	 *
	 * @param array $args
	 * @param array $atts
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function add_query_args__current( $args, $atts ) {
		/*
		 * The query does not change if the current post type or the specific post is excluded.
		 */
		if ( wpmtst_assignment_is_post_excluded( get_the_ID() ) ) {
			return $args;
		}

		/*
		 * Single post or page
		 */
		if ( is_single() || is_page() ) {
			$args['meta_key']   = 'strong_assignment';
			$args['meta_value'] = get_the_ID();

			return $args;
		}

		/*
		 * Archives
		 */
		if ( is_post_type_archive() || is_category() || is_tax() || is_home() ) {
			// get the IDs of all posts being displayed
			global $posts;
			$post_list = array();
			foreach ( $posts as $post_object ) {
				$post_list[] = $post_object->ID;
			}
			$args['meta_key']     = 'strong_assignment';
			$args['meta_value']   = join( ',', $post_list );
			$args['meta_compare'] = 'IN';

			return $args;
		}

		return $args;
	}

}
