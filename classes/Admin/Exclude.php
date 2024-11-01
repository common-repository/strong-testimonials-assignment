<?php

namespace StrongTestimonialsAssignment;

/**
 * Class Admin_Exclude
 *
 * Borrowed heavily from:
 * Search Exclude v1.2.2 by Roman Pronskiy http://pronskiy.com
 * @link http://wordpress.org/plugins/search-exclude/
 *
 * @package StrongTestimonialsAssignment
 * @since 1.0.0
 */
class Admin_Exclude {

	/**
	 * @var
	 * @since 1.0.0
	 */
	protected $excluded;

	/**
	 * Admin_Exclude constructor.
	 */
	public function __construct() {
		$this->add_actions();
	}

	/**
	 * Add actions and filters.
	 */
	public function add_actions() {
		add_action( 'post_updated', array( $this, 'post_updated' ) );

		add_action( 'wp_ajax_assignment_exclude_save_bulk_edit', array( $this, 'save_bulk_edit' ) );

		add_action( 'wpmtst_assignment_post_type_list_column', array( $this, 'excluded_indicator' ) );

		add_action( 'quick_edit_custom_box', array( $this, 'add_quick_edit_custom_box' ) );

		add_action( 'bulk_edit_custom_box', array( $this, 'add_bulk_edit_custom_box' ) );

		add_filter( 'wpmtst_assignees_get_posts', array( $this, 'add_exclude_filter' ) );
	}

	/**
	 * Add query arg to exclude posts from assignment.
	 *
	 * @param array $args
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function add_exclude_filter( $args ) {
		$excluded = get_option( 'wpmtst_assignment_excluded' );
		if ( $excluded ) {
			$args['exclude'] = join( ',', $excluded );
		}

		return $args;
	}

	/**
	 * Set a post as excluded.
	 *
	 * @param int $post_id
	 * @since 1.0.0
	 *
	 * @return int
	 */
	public function post_updated( $post_id ) {
		if ( isset( $_POST['assignment_exclude'] ) ) {
			$exclude = isset( $_POST['assignment_exclude']['exclude'] ) ? 1 : 0;
			$this->save_post_id_to_excluded( $post_id, $exclude );
		}

		return $post_id;
	}

	/**
	 * Wrapper for excluding a single post.
	 *
	 * @param $post_id
	 * @param $exclude
	 * @since 1.0.0
	 */
	protected function save_post_id_to_excluded( $post_id, $exclude ) {
		$this->save_post_ids_to_excluded( array( intval( $post_id ) ), $exclude );
	}

	/**
	 * Wrapper for excluding a list of posts.
	 *
	 * @param $post_ids
	 * @param $exclude
	 * @since 1.0.0
	 */
	public function save_post_ids_to_excluded( $post_ids, $exclude ) {
		$exclude  = (bool) $exclude;
		$excluded = $this->get_excluded();

		if ( $exclude ) {
			// add to list
			$excluded = array_unique( array_merge( $excluded, $post_ids ) );
		} else {
			// remove from list
			$excluded = array_diff( $excluded, $post_ids );
		}
		$this->save_excluded( $excluded );
	}

	/**
	 * Return whether a post is excluded.
	 *
	 * @param $post_id
	 * @since 1.0.0
	 *
	 * @return int
	 */
	private function is_excluded( $post_id ) {
		return in_array( $post_id, get_option( 'wpmtst_assignment_excluded', array() ) ) ? 1 : 0;
	}

	/**
	 * Return list of excluded posts.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	protected function get_excluded() {
		if ( null === $this->excluded ) {
			$this->excluded = get_option( 'wpmtst_assignment_excluded', array() );
		}

		return $this->excluded;
	}

	/**
	 * Store list of excluded posts.
	 *
	 * @param $excluded
	 * @since 1.0.0
	 */
	protected function save_excluded( $excluded ) {
		update_option( 'wpmtst_assignment_excluded', $excluded );
		$this->excluded = $excluded;
	}

	/**
	 * Indicate exclusion in admin list.
	 *
	 * @since 1.0.0
	 */
	public function excluded_indicator() {
		global $post;

		$is_excluded = $this->is_excluded( $post->ID );

		printf( '<span class="assigned-excluded" id="assignment-exclude-%s" data-assignment_exclude="%d">%s</span>',
			$post->ID,
			$is_excluded,
			$is_excluded ? __( 'excluded', 'strong-testimonials-assignment' ) : '' );

	}

	/**
	 * Print the admin list Quick Edit option.
	 *
	 * @param $column
	 * @since 1.0.0
	 */
	public function add_quick_edit_custom_box( $column ) {
		if ( 'testimonials' == $column ) {
			include WPMTST_ASSIGNMENT_PATH . '/includes/admin/list/quick-edit-exclude.php';
		}
	}

	/**
	 * Print the admin list Bulk Edit option.
	 *
	 * @param $column
	 * @since 1.0.0
	 */
	public function add_bulk_edit_custom_box( $column ) {
		if ( 'testimonials' == $column ) {
			include WPMTST_ASSIGNMENT_PATH . '/includes/admin/list/bulk-edit-exclude.php';
		}
	}

	/**
	 * Process bulk edit option.
	 *
	 * @since 1.0.0
	 */
	public function save_bulk_edit() {
		$post_ids = ! empty( $_POST['post_ids'] ) ? $_POST['post_ids'] : false;
		$exclude  = isset( $_POST['exclude'] ) && '' !== $_POST['exclude'] ? $_POST['exclude'] : null;
		if ( is_array( $post_ids ) && null !== $exclude ) {
			$this->save_post_ids_to_excluded( $post_ids, $exclude );
		}
	}

}
