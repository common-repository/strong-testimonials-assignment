<?php

namespace StrongTestimonialsAssignment;

/**
 * Class Front
 * @package StrongTestimonialsAssignment
 * @since 1.0.0
 */
class Front {

	/**
	 * Front constructor.
	 */
	public function __construct() {
		new Front_Views();
		new Front_Query();
		new Front_ShortcodeHooks();
	}

}
