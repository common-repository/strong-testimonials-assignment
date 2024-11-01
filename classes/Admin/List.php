<?php

namespace StrongTestimonialsAssignment;

/**
 * Class Admin_List
 * @package StrongTestimonialsAssignment
 * @since 1.0.0
 */
class Admin_List extends Admin_Component {

	/**
	 * @var
	 * @since 1.0.0
	 */
	public $columns;

	/**
	 * Admin_List constructor.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Add our list column(s).
	 *
	 * @param array $columns
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function add_column( $columns ) {
		if ( $this->columns ) {
			foreach ( $this->columns as $name => $column ) {
				$columns[ $name ] = $column['title'];
			}
		}

		return $columns;
	}

	/**
	 * Reorder columns.
	 *
	 * Keep "date" as last column.
	 *
	 * @param array $columns
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function reorder_columns( $columns ) {
		$date_index = array_search( 'date', array_keys( $columns ) );

		foreach ( $this->columns as $column => $column_title ) {

			$column_index = array_search( $column, array_keys( $columns ) );

			if ( false !== $date_index && false !== $column_index ) {
				$columns = array_merge(
					array_slice( $columns, 0, $date_index ),
					array_slice( $columns, $column_index, 1 ),
					array_slice( $columns, $date_index, 1 ) );
			}

		}

		return $columns;
	}

	/**
	 * Make our column(s) sortable.
	 *
	 * @param array $columns
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function sortable_columns( $columns ) {
		foreach ( $this->columns as $name => $column ) {

			if ( $column['sortable'] ) {
				$columns[ $name ] = $name;
			}

		}

		return $columns;
	}

	/**
	 * Print our column(s).
	 *
	 * @param string $column
	 * @since 1.0.0
	 */
	public function print_column( $column ) {
		foreach ( $this->columns as $name => $column_array ) {

			if ( $column == $name &&
			     isset( $column_array['callback'] ) &&
			     $column_array['callback'] &&
			     method_exists( $this, $column_array['callback'] ) ) {
				call_user_func( array( $this, $column_array['callback'] ) );
			}

		}
	}

	/**
	 * Return whether user is viewing the trashed posts.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function is_viewing_trash() {
		return isset( $_GET['post_status'] ) && 'trash' == $_GET['post_status'];
	}

}
