<?php

namespace StrongTestimonialsAssignment;

/**
 * Class Common
 * @package StrongTestimonialsAssignment
 * @since 1.0.0
 */
class Common {

	/**
	 * @var Testimonial
	 * @since 1.0.0
	 */
	private $testimonial;

	/**
	 * @var FieldAssignment
	 * @since 1.0.0
	 */
	private $field_assignment;

	/**
	 * Common constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->includes();
		$this->add_actions();

		$this->testimonial      = new Testimonial();
		$this->field_assignment = new FieldAssignment;
	}

	/**
	 * Includes.
	 *
	 * @since 1.0.0
	 */
	private function includes() {
		require_once WPMTST_ASSIGNMENT_PATH . 'includes/functions.php';
	}

	/**
	 * Add actions and filters.
	 *
	 * @since 1.0.0
	 */
	public function add_actions() {
		add_filter( 'wpmtst_view_default', array( $this, 'add_view_attribute' ) );

		add_action( 'init', array( $this, 'load_textdomain' ) );
		add_action( 'init', array( $this, 'register_scripts' ) );
	}

	/**
	 * Load text domain.
	 *
	 * @since 1.0.0
	 */
	public function load_textdomain() {
		load_plugin_textdomain( WPMTST_ASSIGNMENT_NAME, false, WPMTST_ASSIGNMENT_PATH . '/languages' );
	}

	/**
	 * Register scripts and styles.
	 *
	 * @since 1.0.0
	 */
	public function register_scripts() {
		/**
		 * Exclude in Bulk/Quick Edit handler.
		 */
		wp_register_script( 'wpmtst-assignment-exclude',
			WPMTST_ASSIGNMENT_URL . 'assets/admin/js/assignment-exclude.js',
			array( 'jquery', 'inline-edit-post' ),
			WPMTST_ASSIGNMENT_VERSION,
			true );

		/**
		 * Select2 - Common
		 */
		wp_register_script( 'wpmtst-select2',
			WPMTST_ASSIGNMENT_URL . 'assets/vendor/select2/js/select2.min.js',
			array( 'jquery' ),
			'4.0.5',
			true );

		wp_register_style( 'wpmtst-select2',
			WPMTST_ASSIGNMENT_URL . 'assets/vendor/select2/css/select2-custom.min.css' );

		/**
		 * Select2 - Back End
		 */
		wp_register_script( 'wpmtst-assignment',
			WPMTST_ASSIGNMENT_URL . 'assets/admin/js/assignment.js',
			array( 'wpmtst-select2' ),
			WPMTST_ASSIGNMENT_VERSION,
			true );

		wp_register_script( 'wpmtst-assignment-view',
			WPMTST_ASSIGNMENT_URL . 'assets/admin/js/assignment-view.js',
			array( 'wpmtst-select2' ),
			WPMTST_ASSIGNMENT_VERSION,
			true );

		wp_register_style( 'wpmtst-assignment',
			WPMTST_ASSIGNMENT_URL . 'assets/admin/css/assignment.css',
			array( 'wpmtst-select2' ),
			WPMTST_ASSIGNMENT_VERSION );

		/**
		 * Extra admin styles.
		 */
		wp_register_style( 'wpmtst-assignment-assignee-admin-list',
			WPMTST_ASSIGNMENT_URL . 'assets/admin/css/assignment-admin-list.css',
			array(),
			WPMTST_ASSIGNMENT_VERSION );

		wp_register_style( 'wpmtst-assignment-assigned-meta-box',
			WPMTST_ASSIGNMENT_URL . 'assets/admin/css/assignment-meta-box.css',
			array(),
			WPMTST_ASSIGNMENT_VERSION );

		/**
		 * View editor.
		 */
		wp_register_style( 'wpmtst-assignment-view',
			WPMTST_ASSIGNMENT_URL . 'assets/admin/css/assignment-view.css',
			array( 'wpmtst-select2' ),
			WPMTST_ASSIGNMENT_VERSION );

		/**
		 * Form preview.
		 */
		wp_register_script( 'wpmtst-assignment-form-preview',
			WPMTST_ASSIGNMENT_URL . 'assets/admin/js/assignment-form-preview.js',
			array( 'wpmtst-select2' ),
			WPMTST_ASSIGNMENT_VERSION,
			true );

		wp_register_style( 'wpmtst-assignment-form-preview',
			WPMTST_ASSIGNMENT_URL . 'assets/admin/css/assignment-form-preview.css',
			array( 'wpmtst-select2' ),
			WPMTST_ASSIGNMENT_VERSION );

		/**
		 * Front-end form field.
		 */
		wp_register_script( 'wpmtst-assignment-field',
			WPMTST_ASSIGNMENT_URL . 'assets/front/js/assignment-field.js',
			array( 'wpmtst-select2' ),
			WPMTST_ASSIGNMENT_VERSION,
			true );

		wp_register_style( 'wpmtst-assignment-field',
			WPMTST_ASSIGNMENT_URL . 'assets/front/css/assignment-field.css',
			array( 'wpmtst-select2' ),
			WPMTST_ASSIGNMENT_VERSION );

	}

	/**
	 * Add custom view attribute.
	 *
	 * @param $view_default
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function add_view_attribute( $view_default ) {
		$view_default['filter']['assignment']       = '';
		$view_default['filter']['assignment_value'] = array();

		return $view_default;
	}

}
