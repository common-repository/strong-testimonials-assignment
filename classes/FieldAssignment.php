<?php

namespace StrongTestimonialsAssignment;

/**
 * Class FieldAssignment
 * @package StrongTestimonialsAssignment
 * @since 1.0.0
 */
class FieldAssignment extends Component {

	/**
	 * FieldAssignment constructor.
	 */
	public function __construct() {
		parent::__construct();

		$this->add_actions();
	}

	/**
	 * Add actions and filters.
     *
     * @since 1.0.0
	 */
	private function add_actions() {
		add_filter( 'wpmtst_fields', array( $this, 'add_field' ) );

		add_action( 'wpmtst_custom_field_assignment_input', array( $this, 'field_input' ), 10, 2 );

		// TODO This is not working because of remove_field hack.
		//add_filter( 'wpmtst_notification_custom_field_value', array( $this, 'notification_field_value' ), 10, 3 );

		add_filter( 'option_wpmtst_custom_forms', array( $this, 'remove_field' ), 10, 2 );

		/**
		 * Back end.
		 */
		add_action( 'load-wpm-testimonial_page_testimonial-fields', array( $this, 'enqueue_scripts_form_preview' ) );

		/**
		 * Front end.
		 */
		add_filter( 'wpmtst_styles', array( $this, 'add_style' ) );
		add_filter( 'wpmtst_scripts', array( $this, 'add_script' ) );
	}

	/**
	 * Enqueue scripts and styles.
     *
     * @since 1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'wpmtst-assignment' );
		wp_enqueue_script( 'wpmtst-assignment-field' );
	}

	/**
	 * Enqueue scripts and styles in form preview.
	 *
     * @since 1.0.0
	 */
	public function enqueue_scripts_form_preview() {
		wp_enqueue_style( 'wpmtst-assignment-form-preview' );
		wp_enqueue_script( 'wpmtst-assignment-form-preview' );
	}

	/**
	 * Add style to internal queue (front end).
	 *
	 * @param array $styles
     * @since 1.0.0
	 *
	 * @return array
	 */
	public function add_style( $styles ) {
		$styles['wpmtst-assignment-field']  = 'wpmtst-assignment-field';

		return $styles;
	}

	/**
	 * Add script to internal queue (front end).
	 *
	 * @param array $scripts
     * @since 1.0.0
	 *
	 * @return array
	 */
	public function add_script( $scripts ) {
		$scripts['wpmtst-assignment-field'] = 'wpmtst-assignment-field';

		return $scripts;
	}


	/**
     * Remove assignment field from user-defined custom fields.
     *
     * Because the assignment field has its own meta box and should not be
     * displayed in the Client Details meta box.
     * TODO This is a hack until main plugin is able to register custom validator
     *
	 * @param array $value
	 * @param string $option
     * @since 1.0.0
	 *
	 * @return array
	 */
	public function remove_field( $value, $option ) {
		global $pagenow, $post_type;

		$in_testimonial_editor = ( is_admin() &&
		                           in_array( $pagenow, array( 'post.php', 'post-new.php' ) ) &&
		                           $this->post_type == $post_type );

		$in_form_processor = ( isset( $_POST['action'] ) &&
		                       'wpmtst_form' == $_POST['action'] &&
		                       isset( $_POST['strong_assignment'] ) );

		if ( $in_testimonial_editor || $in_form_processor ) {

			foreach ( $value as $form_key => $form ) {
				foreach ( $form['fields'] as $field_key => $field ) {
					if ( 'assignment' == $field['input_type'] ) {
						unset( $value[ $form_key ]['fields'][ $field_key ] );
					}
				}
			}

		}

		return $value;
	}

	/**
     * Add the assignment custom field.
     *
	 * @param array $fields
     * @since 1.0.0
	 *
	 * @return array
	 */
	public function add_field( $fields ) {
		$field_options = get_option( 'wpmtst_fields' );

		if ( isset( $field_options['field_base'] ) ) {
			$base = $field_options['field_base'];
		} else {
			return $fields;
		}

		$new_field = array(
			'input_type'              => 'assignment',
			'action_input'            => 'wpmtst_custom_field_assignment_input',
			'action_output'           => 'wpmtst_custom_field_assignment_output',
			'option_label'            => __( 'assignment', 'strong-testimonials-assignment' ),
			'show_default_options'    => 0,
			'show_placeholder_option' => 0,
			'admin_table'             => 0,
			'admin_table_option'      => 0,
			'show_admin_table_option' => 0,
			'name_mutable'            => 1,
		);

		$fields['field_types']['optional']['assignment'] = array_merge( $base, $new_field );

		return $fields;
	}

	/**
	 * Callback to print input HTML on front end.
	 *
	 * @param $field
	 * @param $value
     * @since 1.0.0
	 */
	public function field_input( $field, $value ) {
		$required = isset( $field['required'] ) && $field['required'] ? 'required' : '';

		// TODO Select current object as default?
		$assignment = array();
		$assignees  = $this->get_assignees();
		$multiple   = $this->allow_multiple() ? 'multiple="multiple"' : '';

		// TODO Move to partial. Add filter on CSS class.
		ob_start();
		?>
		<?php /* Passive input needed to submit value if no selection made. */ ?>
        <input type="hidden" name="strong_assignment" value="0">
        <select class="wpmtst-assignment" id="strong_assignment" name="strong_assignment[]"
                placeholder="<?php esc_attr_e( $field['placeholder'] ); ?>"
			<?php echo esc_attr( $multiple ); ?> <?php echo esc_attr( $required ); ?>>

			<?php if ( ! $multiple ) : ?>
                <option value="0" <?php selected( empty( $assignment ) ); ?>>
					<?php _e( 'Select', 'strong-form-assignment' ); ?>
                </option>
			<?php endif; ?>

			<?php foreach ( $assignees as $post_type => $assignee ) : ?>
                <optgroup label="<?php esc_attr_e( $assignee['name'] ); ?>">

					<?php foreach ( $assignee['posts'] as $post2 ) : ?>
                        <option value="<?php esc_attr_e( $post2->ID ); ?>" <?php selected( in_array( $post2->ID, $assignment ) ); ?>>
							<?php esc_html_e( $post2->post_title ); ?>
                        </option>
					<?php endforeach; ?>

                </optgroup>
			<?php endforeach; ?>

        </select>
		<?php

		echo ob_get_clean();
	}

	/**
     * Return the assignment value for the notification email.
     *
	 * @param $replace
	 * @param $field
	 * @param $post
     * @since 1.0.0
	 *
	 * @return string
	 */
	public function notification_field_value( $replace, $field, $post ) {
		if ( 'assignment' == $field['input_type'] ) {
			if ( isset( $post[ $field['name'] ] ) && $post[ $field['name'] ] ) {
				$replace = $this->get_assignee( $post[ $field['name'] ] );
				$replace .= ' (' . $post[ $field['name'] ] . ')';
			}
		}

		return $replace;
	}

}
