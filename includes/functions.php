<?php

defined( 'ABSPATH' ) or die(); // Exit if accessed directly

/**
 * Return whether a post is excluded from assignments.
 *
 * Will use the current post if no post ID given.
 *
 * @since 1.0.0
 * @param $post_id
 *
 * @return bool
 */
function wpmtst_assignment_is_post_excluded( $post_id ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$post_type = get_post_type( $post_id );
	if ( ! $post_type ) {
		if ( is_home() ) {
			$post_type = 'post'; // the blog page (not necessarily the front page)
		} else {
			return false; // this works for all archive pages
		}
	}

	$options = get_option( 'wpmtst_assignment' );
	$assignee_post_types = $options['assignees'];

	$excluded_objects = get_option( 'wpmtst_assignment_excluded', array() );

	return in_array( $post_id, $excluded_objects ) || ! in_array( $post_type, $assignee_post_types ) ? 1 : 0;
}
