<?php

namespace StrongTestimonialsAssignment;

/**
 * Class Activation
 *
 * Fired during plugin (de)activation.
 *
 * @package StrongTestimonialsAssignment
 * @since 1.0.0
 */
class Activation {

	/**
	 * @since 1.0.0
	 */
	public static function activate() {
		update_option( 'strong_testimonials_assignment_init', 1 );
	}

	/**
	 * @since 1.0.0
	 */
	public static function deactivate() { }

}
