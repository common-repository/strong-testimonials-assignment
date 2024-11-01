<?php
$options    = get_option( 'wpmtst_assignment' );
$post_types = $this->get_post_type_objects();
?>
<style>
    .wrap.wpmtst #assignment-form label { display: block; }
    .wpmtst .form-table p.above-fieldset { margin-bottom: 1em; }
</style>

<h2><?php _e( 'Assignment', 'strong-testimonials-assignment' ); ?></h2>

<table class="form-table" cellpadding="0" cellspacing="0">

    <tr valign="top">
        <th scope="row">
			<?php _e( 'Content Types', 'strong-testimonials-assignment' ); ?>
        </th>
        <td>
            <p class="above-fieldset">
				<?php _e( 'Allow testimonials to be assigned to these content types:', 'strong-testimonials-assignment' ); ?>
            </p>
            <fieldset>
				<?php foreach ( $post_types as $post_type => $post_type_object ) : ?>
                    <label for="assignee-<?php echo esc_attr( $post_type ); ?>">
                        <input type="checkbox"
                               id="assignee-<?php echo esc_attr( $post_type ); ?>"
                               name="wpmtst_assignment[assignees][<?php echo esc_attr( $post_type ); ?>]"
							<?php checked( in_array( $post_type, $options['assignees'] ) ); ?>>
						<?php printf( '%s (%s)', $post_type_object->label, $post_type_object->name ); ?>
                    </label>
				<?php endforeach; ?>
            </fieldset>
        </td>
    </tr>

    <tr valign="top">
        <th scope="row">
			<?php _e( 'Selection', 'strong-testimonials-assignment' ); ?>
        </th>
        <td>
            <fieldset>
                <label>
                    <select name="wpmtst_assignment[selection]">
                        <option value="single" <?php selected( 'single', $options['selection'] ); ?>>
							<?php _e( 'Single selections only', 'strong-testimonials-assignment' ); ?>
                        </option>
                        <option value="multiple" <?php selected( 'multiple', $options['selection'] ); ?>>
							<?php _e( 'Multiple selections allowed', 'strong-testimonials-assignment' ); ?>
                        </option>
                    </select>
                </label>
            </fieldset>
        </td>
    </tr>

</table>
