<?php

namespace StrongTestimonialsAssignment;

/**
 * Class Admin_List_PostType
 * @package StrongTestimonialsAssignment
 * @since 1.0.0
 */
class Admin_List_PostType extends Admin_List {

	/**
	 * @var
	 * @since 1.0.0
	 */
	private $assigned_label;

	/**
	 * Admin_List_PostType constructor.
	 */
	public function __construct() {
		parent::__construct();

		add_action( 'admin_init', array( $this, 'add_actions' ) );
	}

	/**
	 * Set our post type label.
	 *
	 * @since 1.0.0
	 */
	private function set_assigned_label() {
		$thing_type_object    = get_post_type_object( $this->post_type );
		$this->assigned_label = $thing_type_object->labels->name;
	}

	/**
	 * Set our list columns.
	 *
	 * @since 1.0.0
	 */
	private function set_columns() {
		$this->columns = array(
			'testimonials' => array(
				'title'    => $this->assigned_label,
				'sortable' => true,
				'callback' => array( $this, 'print_column_callback' ),
			),
		);
	}

	/**
	 * Add actions and filters.
	 *
	 * @since 1.0.0
	 */
	public function add_actions() {
		foreach ( $this->get_assignee_types() as $post_type ) {

			add_filter( "manage_{$post_type}_posts_columns", array( $this, 'add_column' ) );

			add_action( "manage_{$post_type}_posts_custom_column", array( $this, 'print_column_callback' ) );

			add_filter( "manage_edit-{$post_type}_columns", array( $this, 'reorder_columns' ) );

			add_filter( "manage_edit-{$post_type}_sortable_columns", array( $this, 'sortable_columns' ) );

		}

		add_filter( 'request', array( $this, 'add_filter_to_query' ) );

		add_action( 'restrict_manage_posts', array( $this, 'add_list_filter' ) );

		add_action( 'manage_posts_extra_tablenav', array( $this, 'add_clear_filters_button' ) );

		/**
		 * Set label after assigned post type is registered.
		 */
		$this->set_assigned_label();

		/**
		 * Set columns after assigned post type is registered.
		 */
		$this->set_columns();
	}

	/**
	 * Print our columns.
	 *
	 * @param $column
	 * @since 1.0.0
	 */
	public function print_column_callback( $column ) {
		include WPMTST_ASSIGNMENT_PATH . '/includes/admin/list/column.php';
		do_action( 'wpmtst_assignment_post_type_list_column' );
	}

	/**
	 * Print list filter element.
	 *
	 * @param $post_type
	 * @since 1.0.0
	 */
	public function add_list_filter( $post_type ) {
		if ( in_array( $post_type, $this->get_assignee_types() ) ) {
			include WPMTST_ASSIGNMENT_PATH . '/includes/admin/list/filter-posts.php';
		}
	}

	/**
	 * Add filter args to query.
	 *
	 * @param $vars
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function add_filter_to_query( $vars ) {
		global $pagenow, $post_type;

		if ( ! empty( $pagenow ) &&
		     $pagenow == 'edit.php' &&
		     in_array( $post_type, $this->get_assignee_types() ) &&
		     ! empty( $_GET['assignment_count'] ) ) {

			if ( 'yes' == $_GET['assignment_count'] ) {
				$vars = array_merge( $vars, array(
					'meta_key'     => 'strong_assignment_count',
					'meta_value'   => 0,
					'meta_compare' => '>',
				) );
			}

			if ( 'no' == $_GET['assignment_count'] ) {
				$vars = array_merge( $vars, array(
					'meta_key'   => 'strong_assignment_count',
					'meta_value' => 0,
				) );
			}

		}

		return $vars;
	}

	/**
	 * Print "Clear Filters" button.
	 *
	 * @param $which
	 * @since 1.0.0
	 */
	public function add_clear_filters_button( $which ) {
		if ( 'top' == $which ) {

			$is_filtered = ( isset( $_GET['filter_action'] ) && 'Filter' == $_GET['filter_action'] );

			if ( $is_filtered ) {
				// Build new URL with primary query args
				$args = array();
				if ( isset( $_GET['post_status'] ) && $_GET['post_status'] ) {
					$args['post_status'] = $_GET['post_status'];
				}
				if ( isset( $_GET['post_type'] ) && $_GET['post_type'] ) {
					$args['post_type'] = $_GET['post_type'];
				}
				$url = add_query_arg( $args, admin_url( 'edit.php' ) );

				echo '<div class="alignleft actions filtered-indicator">';
				echo '<a class="button button-primary" href="' . esc_url( $url ) . '">' . __( 'Clear Filters', 'strong-testimonials-assignment' ) . '</a>';
				echo '</div>';
			}

		}
	}

}
