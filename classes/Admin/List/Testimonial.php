<?php

namespace StrongTestimonialsAssignment;

/**
 * Class Admin_List_Testimonial
 * @package StrongTestimonialsAssignment
 * @since 1.0.0
 */
class Admin_List_Testimonial extends Admin_List {

	/**
	 * Admin_List_Testimonial constructor.
	 */
	public function __construct() {
		parent::__construct();

		$this->set_columns();

		add_action( 'admin_init', array( $this, 'add_actions' ) );
	}

	/**
	 * Set our columns.
	 *
	 * @since 1.0.0
	 */
	private function set_columns() {
		$this->columns = array(
			'assignment' => array(
				'title'    => __( 'Assignment', 'strong-testimonials-assignment' ),
				'sortable' => true,
				'callback' => 'print_column_callback',
			),
		);
	}

	/**
	 * Add actions and filters.
	 *
	 * @since 1.0.0
	 */
	public function add_actions() {
		$post_types = array( $this->post_type );

		foreach ( $post_types as $post_type ) {

			add_filter( "manage_{$post_type}_posts_columns", array( $this, 'add_column' ) );

			add_action( "manage_{$post_type}_posts_custom_column", array( $this, 'print_column_callback' ) );

			add_filter( "manage_edit-{$post_type}_columns", array( $this, 'reorder_columns' ) );

			add_filter( "manage_edit-{$post_type}_sortable_columns", array( $this, 'sortable_columns' ) );

		}

		add_filter( 'request', array( $this, 'add_filter_to_query' ) );
		add_filter( 'request', array( $this, 'assignment_column_orderby' ) );

		add_action( 'restrict_manage_posts', array( $this, 'add_list_filter' ) );
	}

	/**
	 * Print list columns.
	 *
	 * @param $column
	 * @since 1.0.0
	 */
	public function print_column_callback( $column ) {
		global $post;

		if ( ! isset( $this->columns[ $column ] ) ) {
			return;
		}

		// array
		$assignment = array_filter( get_post_meta( $post->ID, 'strong_assignment' ) );

		if ( $assignment ) {

			foreach ( $assignment as $post_id ) {
				$thing = get_post( $post_id );
				if ( $thing ) {
					$thing_type = get_post_type_object( $thing->post_type );
					if ( $thing_type ) {
						printf( '<div><a href="%s" title="%s">%s</a></div>',
							esc_url( admin_url( 'post.php?post=' . $post_id . '&action=edit' ) ),
							esc_attr( sprintf( __( 'go to this %s', 'strong-testimonials-assignment' ), $thing_type->labels->singular_name ) ),
							esc_html( $thing->post_title ) );
					}
				}
			}

		}
	}

	/**
	 * Print list filter elements.
	 *
	 * @param $post_type
	 * @since 1.0.0
	 */
	public function add_list_filter( $post_type ) {
		if ( $this->is_viewing_trash() ) {
			return;
		}

		if ( $this->is_assignable() ) {

			$values = array();

			$post_types = $this->get_post_type_objects();

			foreach ( $post_types as $post_type => $post_object ) {
				$posts = get_posts( array(
					'posts_per_page' => - 1,
					'post_type'      => $post_type,
				) );
				foreach ( $posts as $post2 ) {
					$values[ $post2->post_title ] = $post2->ID;
				}
			}

			include WPMTST_ASSIGNMENT_PATH . '/includes/admin/list/filter-testimonials.php';
		}
	}

	/**
	 * Return whether user is viewing an admin list page.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	private function is_admin_list() {
		global $pagenow;

		return ( ! empty( $pagenow ) && $pagenow == 'edit.php' );
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
		if ( $this->is_admin_list() && $this->is_assignable() ) {

			if ( isset( $_GET['assignment'] ) && 'all' != $_GET['assignment'] ) {

				$vars = array_merge( $vars, array(
					'meta_key'   => 'strong_assignment',
					'meta_value' => intval( $_GET['assignment'] ),
				) );

			}

		}

		return $vars;
	}

	/**
	 * Add sort args to query.
	 *
	 * @param $vars
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function assignment_column_orderby( $vars ) {
		if ( $this->is_admin_list() && $this->is_assignable() ) {

			if ( isset( $vars['orderby'] ) && 'assignment' == $vars['orderby'] ) {

				$vars = array_merge( $vars, array(
					'meta_key' => 'strong_assignment',
					'orderby'  => 'meta_value',
				) );

			}

		}

		return $vars;
	}

}
