<?php

namespace StrongTestimonialsAssignment;

/**
 * Class Front_ShortcodeHooks
 * @package StrongTestimonialsAssignment
 * @since 1.1.0 As separate class.
 */
class Front_ShortcodeHooks {

	/**
	 * Front_ShortcodeHooks constructor.
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
	    // [testimonial_count]
		add_filter( 'wpmtst_shortcode_defaults__testimonial_count', array( $this, 'add_shortcode_pairs' ) );
		add_filter( 'shortcode_atts_testimonial_count', array( $this, 'convert_shortcode_atts' ), 10, 4 );

		// [testimonial_average_rating]
		add_filter( 'wpmtst_shortcode_defaults__testimonial_average_rating', array( $this, 'add_shortcode_pairs' ) );
		add_filter( 'shortcode_atts_testimonial_average_rating', array( $this, 'convert_shortcode_atts' ), 10, 4 );
	}

	/**
	 * Add shortcode default attributes for [testimonial_count].
	 *
	 * @param $pairs
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function add_shortcode_pairs( $pairs ) {
		$pairs = array_merge( $pairs, array(
			'assignment' => '',
		) );

		return $pairs;
	}

	/**
	 * Shortcode filter.
	 *
	 * Convert shortcode attribute to match view attribute format.
	 * E.g. atts['assignment'] --> atts['filter']['assignment']
	 *
	 * @param $out
	 * @param $pairs
	 * @param $atts
	 * @param $shortcode
	 * @since 1.0.0
	 *
	 * @return mixed
	 */
	public function convert_shortcode_atts( $out, $pairs, $atts, $shortcode ) {
		if ( ! isset( $out['assignment'] ) ) {
			return $out;
		}

		/*
		 *  Convert 'assignment' shortcode attribute to view setting format.
		 */
		if ( 'type' == substr( $out['assignment'], 0, 4 ) ) {

			// A specific post type, e.g. 'type:agent'.
			$out['filter']['assignment']       = 'type';
			$out['filter']['assignment_type']  = substr( $out['assignment'], 5 );
			$out['filter']['assignment_value'] = array();

		} elseif ( 'current' == $out['assignment'] ) {

			// The current object(s).
			$out['filter']['assignment']       = 'current';
			$out['filter']['assignment_type']  = '';
			$out['filter']['assignment_value'] = array();

		} elseif ( '' != $out['assignment'] ) {

			// A comma-separated string of post IDs
			$out['filter']['assignment']       = 'post';
			$out['filter']['assignment_type']  = '';
			$out['filter']['assignment_value'] = explode( ',', $out['assignment'] );

		}

		unset( $out['assignment'] );

		return $out;
	}

}
