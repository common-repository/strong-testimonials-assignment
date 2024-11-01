<?php
/**
 * Uninstall procedure.
 *
 * @package StrongTestimonialsAssignment
 * @since 1.0.0
 */

defined( 'WP_UNINSTALL_PLUGIN' ) or die(); // Exit if accessed directly

/**
 * Leave no trace.
 */
delete_option( 'wpmtst_assignment' );
delete_option( 'wpmtst_assignment_excluded' );
delete_post_meta_by_key( 'strong_assignment' );
delete_post_meta_by_key( 'strong_assignment_count' );

$views = wpmtst_get_views();
if ( $views ) {
	foreach ( $views as $key => $view ) {
		$view_data = unserialize( $view['value'] );
		if ( is_array( $view_data ) ) {
			unset( $view_data['filter']['assignment'],
				$view_data['filter']['assignment_type'],
				$view_data['filter']['assignment_value'] );

			$view['data'] = $view_data;
			wpmtst_save_view( $view );
		}
	}
}
