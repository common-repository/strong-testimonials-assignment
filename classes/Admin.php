<?php

namespace StrongTestimonialsAssignment;

/**
 * Class Admin
 * @package StrongTestimonialsAssignment
 * @since 1.0.0
 */
class Admin extends Admin_Component {

	/**
	 * @var Admin_List_PostType
	 * @since 1.0.0
	 */
	private $admin_list_post_type;

	/**
	 * @var Admin_List_Testimonial
	 * @since 1.0.0
	 */
	private $admin_list_testimonial;

	/**
	 * @var Admin_MetaBox_Post
	 * @since 1.0.0
	 */
	private $admin_metabox_post;

	/**
	 * @var Admin_MetaBox_Testimonial
	 * @since 1.0.0
	 */
	private $admin_metabox_testimonial;

	/**
	 * @var Admin_Exclude
	 * @since 1.0.0
	 */
	private $admin_exclude;

	/**
	 * @var Admin_Views
	 * @since 1.0.0
	 */
	private $admin_views;

	/**
	 * @var Admin_Settings
	 * @since 1.0.0
	 */
	private $admin_settings;

	/**
	 * Admin constructor.
	 */
	public function __construct() {
		parent::__construct();

		$this->add_actions();

		$this->admin_list_post_type      = new Admin_List_PostType();
		$this->admin_list_testimonial    = new Admin_List_Testimonial();
		$this->admin_metabox_post        = new Admin_MetaBox_Post();
		$this->admin_metabox_testimonial = new Admin_MetaBox_Testimonial();
		$this->admin_exclude             = new Admin_Exclude();
		$this->admin_views               = new Admin_Views();
		$this->admin_settings            = new Admin_Settings();

		new Admin_Updater_Plugin();
		new Admin_Updater_View();
		new Admin_Updater_Options();
		new Admin_Updater_Tally();
	}

	/**
	 * Add actions and filters.
	 *
	 * @since 1.0.0
	 */
	public function add_actions() {
		add_action( 'load-edit.php', array( $this, 'enqueue_scripts_on_admin_list' ) );
		add_action( 'load-post.php', array( $this, 'enqueue_scripts_on_post' ) );
		add_action( 'load-post-new.php', array( $this, 'enqueue_scripts_on_post' ) );
	}

	/**
	 * Enqueue scripts and styles on admin list pages.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts_on_admin_list() {
		if ( $this->is_assignable() ) {
			wp_enqueue_script( 'wpmtst-assignment' );
			wp_enqueue_style( 'wpmtst-assignment' );
		}

		if ( $this->is_assignee_by_screen_type() ) {
			wp_enqueue_script( 'wpmtst-assignment-exclude' );
			wp_enqueue_style( 'wpmtst-assignment-assignee-admin-list' );
		}
	}

	/**
	 * Enqueue scripts and styles on post editor pages.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts_on_post() {
		if ( $this->is_assignable() ) {
			wp_enqueue_script( 'wpmtst-assignment' );
			wp_enqueue_style( 'wpmtst-assignment' );
		}

		if ( $this->is_assignee_by_screen_type() ) {
			wp_enqueue_style( 'wpmtst-assignment-assigned-meta-box' );
		}
	}

}
