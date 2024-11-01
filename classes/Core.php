<?php

namespace StrongTestimonialsAssignment;

/**
 * Class Core
 * @package StrongTestimonialsAssignment
 * @since 1.0.0
 */
class Core {

	/**
	 * Instantiate our components.
	 *
	 * @since 1.0.0
	 */
	public function run() {
		/**
		 * Functionality on both front and back end.
		 *
		 * @since 1.0.0
		 */
		new Common();

		/**
		 * Back-end functionality.
		 *
		 * @since 1.0.0
		 */
		new Admin();

		/**
		 * Front-end functionality.
		 *
		 * @since 1.0.0
		 */
		new Front();
	}

}
