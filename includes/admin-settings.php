<?php
/**
 * Admin Settings.
 */

$settings = self::get_settings();

?>

<div class="wrap">

	<h2><?php esc_html_e( 'Elementor White Label', 'elementor-white-label' ); ?></h2>

	<?php self::render_update_message(); ?>

	<form method="post" id="ewl-settings-form" action="<?php echo self::get_form_action(); ?>">

		<hr>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'Plugin Name', 'elementor-white-label' ); ?>
					</th>
					<td>
						<input id=ewl_plugin_name" name="ewl_plugin_name" type="text" class="regular-text" value="<?php esc_attr_e( $settings['plugin_name'] ); ?>" />
					</td>
				</tr>
				<?php if ( defined( 'ELEMENTOR_PRO_PLUGIN_BASE' ) ) : ?>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'Plugin Pro Name', 'elementor-white-label' ); ?>
					</th>
					<td>
						<input id="ewl_plugin_pro_name" name="ewl_plugin_pro_name" type="text" class="regular-text" value="<?php esc_attr_e( $settings['plugin_pro_name'] ); ?>" />
					</td>
				</tr>
				<?php endif; ?>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e('Plugin Description', 'elementor-white-label'); ?>
					</th>
					<td>
						<textarea id="ewl_plugin_desc" name="ewl_plugin_desc" style="width: 25em;"><?php echo $settings['plugin_desc']; ?></textarea>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e('Developer / Agency Name', 'elementor-white-label'); ?>
					</th>
					<td>
						<input id="ewl_plugin_author" name="ewl_plugin_author" type="text" class="regular-text" value="<?php echo $settings['plugin_author']; ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e('Website URL', 'elementor-white-label'); ?>
					</th>
					<td>
						<input id="ewl_plugin_uri" name="ewl_plugin_uri" type="text" class="regular-text" value="<?php echo esc_url( $settings['plugin_uri'] ); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e('Elementor Menu Label', 'elementor-white-label'); ?>
					</th>
					<td>
						<input id="ewl_admin_label" name="ewl_admin_label" type="text" class="regular-text" value="<?php echo $settings['admin_label']; ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e('Edit with Elementor Text', 'elementor-white-label'); ?>
					</th>
					<td>
						<input id="ewl_edit_with_elementor" name="ewl_edit_with_elementor" type="text" class="regular-text" value="<?php echo $settings['edit_with_elementor']; ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e('Hide Elementor Plugin Row Meta & Action Link', 'elementor-white-label'); ?>
					</th>
					<td>
						<label for="ewl_hide_plugin_row_meta">
							<input id="ewl_hide_plugin_row_meta" name="ewl_hide_plugin_row_meta" type="checkbox" value="1" <?php echo $settings['hide_plugin_row_meta'] == 'on' ? 'checked="checked"' : '' ?> />
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e('Hide Elementor License page', 'elementor-white-label'); ?>
					</th>
					<td>
						<label for="ewl_hide_license_page">
							<input id="ewl_hide_license_page" name="ewl_hide_license_page" type="checkbox" value="1" <?php echo $settings['hide_license_page'] == 'on' ? 'checked="checked"' : '' ?> disabled /> <small style="color: red;"><?php esc_html_e( 'Pro version only', 'elementor-white-label' ) ?></small>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e('Hide Elementor Plugin', 'elementor-white-label'); ?>
					</th>
					<td>
						<label for="ewl_hide_elementor_plugin">
							<input id="ewl_hide_elementor_plugin" name="ewl_hide_elementor_plugin" type="checkbox" value="1" <?php echo $settings['hide_elementor_plugin'] == 'on' ? 'checked="checked"' : '' ?> disabled /> <small style="color: red;"><?php esc_html_e( 'Pro version only', 'elementor-white-label' ) ?></small>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e('Hide Elementor Pro Plugin', 'elementor-white-label'); ?>
					</th>
					<td>
						<label for="ewl_hide_elementor_pro_plugin">
							<input id="ewl_hide_elementor_pro_plugin" name="ewl_hide_elementor_pro_plugin" type="checkbox" value="1" <?php echo $settings['hide_elementor_pro_plugin'] == 'on' ? 'checked="checked"' : '' ?> disabled /> <small style="color: red;"><?php esc_html_e( 'Pro version only', 'elementor-white-label' ) ?></small>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e('Hide Elementor White Label Plugin', 'elementor-white-label'); ?>
					</th>
					<td>
						<label for="ewl_hide_plugin">
							<input id="ewl_hide_plugin" name="ewl_hide_plugin" type="checkbox" value="1" <?php echo $settings['hide_plugin'] == 'on' ? 'checked="checked"' : '' ?> disabled /> <small style="color: red;"><?php esc_html_e( 'Pro version only', 'elementor-white-label' ) ?></small>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e('Hide Elementor White Label Setting Page', 'elementor-white-label'); ?>
					</th>
					<td>
						<label for="ewl_hide_ewl_setting_page">
							<input id="ewl_hide_ewl_setting_page" name="ewl_hide_ewl_setting_page" type="checkbox" value="1" <?php echo $settings['hide_ewl_setting_page'] == 'on' ? 'checked="checked"' : '' ?> disabled /> <small style="color: red;"><?php esc_html_e( 'Pro version only', 'elementor-white-label' ) ?></small>
						</label>
					</td>
				</tr>
			</tbody>
		</table>
		<small>
			<?php __( 'Update <a href="https://namncn.com/plugins/elementor-white-label-for-elementor/" target="_blank">PRO version here</a>.', 'elementor-white-label' ); ?>
		</small>
		<?php submit_button(); ?>
		<?php wp_nonce_field( 'ewl-settings', 'ewl-settings-nonce' ); ?>

	</form>

	<hr />

	<h2><?php esc_html_e( 'Support', 'elementor-white-label' ); ?></h2>
	<p>
		<?php _e( 'For submitting any support queries, feedback, bug reports or feature requests, please visit <a href="https://namncn.com/lien-he/" target="_blank">this link</a>. Other great plugins by Nam Truong, please visit <a href="https://namncn.com/chuyen-muc/plugins/" target="_blank">this link</a>.', 'elementor-white-label' ); ?>
	</p>

</div>
