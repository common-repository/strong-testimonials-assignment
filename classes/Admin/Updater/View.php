<?php

namespace StrongTestimonialsAssignment;

/**
 * Class Admin_Updater_View
 * @package StrongTestimonialsAssignment
 * @since 1.0.0
 */
class Admin_Updater_View {

	/**
	 * Admin_Updater_View constructor.
	 */
	public function __construct() {
		$this->add_actions();
	}

	/**
	 * Update views.
	 *
	 * @since 1.0.0
	 */
	public function add_actions() {
		add_action( 'plugin_updated_' . WPMTST_ASSIGNMENT_NAME, array( $this, 'update_views' ) );
	}

	/**
	 * Add filter settings to each view.
	 *
	 * @since 1.0.0
	 */
	public function update_views() {
		$views = wpmtst_get_views();

		if ( $views ) {

			foreach ( $views as $key => $view ) {

				$view_data = unserialize( $view['value'] );

				if ( ! is_array( $view_data ) ) {
					continue;
				}

				if ( ! isset( $view_data['filter']['assignment'] ) ) {

					$view_data['filter']['assignment']       = '';
					$view_data['filter']['assignment_type']  = '';
					$view_data['filter']['assignment_value'] = array();

					$view['data'] = $view_data;

					wpmtst_save_view( $view );

				}

			}

		}
	}

}
