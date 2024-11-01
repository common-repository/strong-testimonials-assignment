<tr>
    <td>
        <label for="wpmtst_assignment_license_key">
			<?php _e( 'Assignment', 'strong-testimonials-assignment' ); ?>
        </label>
    </td>

    <td>
        <input type="text" class="regular-text" id="wpmtst_assignment_license_key"
               name="wpmtst_addons[assignment][license][key]" value="<?php echo esc_attr( $key ); ?>"/>

        <input type="hidden" name="wpmtst_addons[assignment][file]"
               value="<?php esc_attr_e( $file ); ?>"/>

        <input name="wpmtst_addons[assignment][name]" type="hidden" value="<?php echo esc_attr( $name ); ?>"/>

        <input name="wpmtst_addons[assignment][license][status]" type="hidden"
               value="<?php echo esc_attr( $status ); ?>"/>

        <input name="wpmtst_addons[assignment][version]" type="hidden"
               value="<?php echo esc_attr( $version ); ?>"/>
    </td>

    <td class="status" data-addon="<?php echo 'assignment'; ?>">
        <span class="indicator"></span>
		<?php if ( $key ): ?>
			<?php wp_nonce_field( 'wpmtst_nonce', 'wpmtst_nonce' ); ?>
			<?php $active = ( $status !== false && $status == 'valid' ); ?>

            <span class="ib addon-inactive ajax-done" <?php if ( $active ) {
				echo ' style="display: none;"';
			} ?>>
				<span class="license-status inactive"><?php _e( 'inactive' ); ?></span>
				<input type="button" class="button-secondary activator" value="<?php _e( 'Activate License' ); ?>"/>
			</span>

            <span class="ib addon-active ajax-done" <?php if ( ! $active ) {
				echo ' style="display: none;"';
			} ?>>
				<span class="license-status active"><?php _e( 'active' ); ?></span>
				<input type="button" class="button-secondary deactivator" value="<?php _e( 'Deactivate License' ); ?>"/>
			</span>

            <p class="response"></p>
		<?php endif; ?>
    </td>

</tr>
