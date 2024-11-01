<?php
global $view;

if ( ! isset( $view['filter']['assignment'] ) || '' == $view['filter']['assignment'] ) {
	$view['filter']['assignment'] = 'none';
}

if ( ! isset( $view['filter']['assignment_value'] ) ) {
	$view['filter']['assignment_value'] = array();
}

$assignees      = $this->get_assignees();
$assignee_types = $this->get_assignee_post_type_objects();
$multiple       = $this->allow_multiple() ? 'multiple="multiple"' : '';

$form_id          = isset( $view['form_id'] ) ? $view['form_id'] : 1;
$form_fields      = wpmtst_get_form_fields( $form_id );
$field            = array_filter( $form_fields, function ( $field ) { return 'assignment' == $field['input_type']; } );
$assignment_field = $field ? $field['name'] : '';
?>
<div class="then then_display then_slideshow then_form then_not_single then_multiple" style="display: none;">
    <h3>
		<?php _e( 'Assignment', 'strong-testimonials' ); ?>
    </h3>
    <table class="form-table multiple group-select">
        <tr class="then then_display then_slideshow then_not_form" style="display: none;">
			<?php include( 'option-assignment.php' ); ?>
        </tr>
        <tr class="then then_not_display then_not_slideshow then_form" style="display: none;">
			<?php if ( $assignment_field ) : ?>
                <td><?php printf( __( 'This form has an assignment field named <strong>%s</strong>.', 'strong-testimonials-assignment' ), $assignment_field ); ?></td>
			<?php else : ?>
				<?php include( 'option-form-assignment.php' ); ?>
			<?php endif; ?>
        </tr>
    </table>
</div>
