<?php
/**
 * Handles logic for the admin settings page.
 *
 * @since 1.0.0
 */
final class EWL {

	public static $settings = array();

	/**
	 * Initializes the admin settings.
	 *
	 * @since 1.0.1
	 * @return void
	 */
	public static function init() {
		add_action( 'plugins_loaded', __CLASS__ . '::init_hooks' );
	}

	/**
	 * Adds the admin menu
	 * the plugin's admin settings page.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function init_hooks() {

		add_filter( 'gettext', __CLASS__ . '::change_elementor_text', 500, 3 );

		if ( ! is_admin() ) {
			return;
		}

		add_action( 'admin_menu', __CLASS__ . '::menu', 601 );
		add_filter( 'all_plugins', __CLASS__ . '::update_branding' );
		add_filter( 'admin_footer_text', __CLASS__ . '::admin_footer_text', 500 );
		add_filter( 'plugin_row_meta', __CLASS__ . '::plugin_row_meta', 500, 2 );

		if ( defined( 'ELEMENTOR_PRO_PLUGIN_BASE' ) ) {
			add_filter( 'plugin_action_links_' . ELEMENTOR_PRO_PLUGIN_BASE, __CLASS__ . '::plugin_action_links', 500 );
		}

		if ( isset( $_REQUEST['page'] ) && 'elementor-white-label' == $_REQUEST['page'] ) {
			// Only admins can save settings.
			if ( ! current_user_can('manage_options') ) {
				return;
			}

			self::save_white_label();
		}
	}

	/**
	 * Get settings.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public static function get_settings() {
		$default_settings = array(
			'plugin_name'               => '',
			'plugin_pro_name'           => '',
			'plugin_desc'               => '',
			'plugin_author'             => '',
			'plugin_uri'                => '',
			'admin_label'               => 'Elementor',
			'edit_with_elementor'       => 'Edit with Elementor',
			'hide_plugin_row_meta'      => 'on',
			'hide_license_page'         => 'on',
			'hide_elementor_plugin'     => 'on',
			'hide_elementor_pro_plugin' => 'on',
			'hide_plugin'               => 'on',
			'hide_ewl_setting_page'     => 'off',
		);

		$settings = self::get_option( 'ewl_settings', true );

		if ( ! is_array( $settings ) || empty( $settings ) ) {
			return $default_settings;
		}

		if ( is_array( $settings ) && ! empty( $settings ) ) {
			return array_merge( $default_settings, $settings );
		}
	}

	/**
	 * Change Elementor admin menu label.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public static function change_elementor_text( $translated_text, $text, $domain ) {

		$settings = self::get_settings();

		$admin_label = $settings['admin_label'];

		$admin_label = trim( $admin_label ) == '' ? 'Elementor' : trim( $admin_label );

		if ( is_admin() && $text === 'Elementor' ) {
			$translated_text = $admin_label;
		}

		$edit_with_elementor = $settings['edit_with_elementor'];

		if ( $text === 'Edit with Elementor' ) {
			$translated_text = $edit_with_elementor;
		}

		return $translated_text;
	}

	/**
	 * Renders the update message.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function render_update_message() {
		if ( ! empty( $_POST ) ) {
			echo '<div class="updated"><p>' . esc_html__( 'Settings updated!', 'elementor-white-label' ) . '</p></div>';
		}
	}

	/**
	 * Renders the admin settings menu.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function menu() {
		if ( is_main_site() || ! is_multisite() ) {

			if ( current_user_can( 'delete_users' ) ) {

				$title = esc_html__( 'Elementor White Label', 'elementor-white-label' );
				$cap   = 'delete_users';
				$slug  = 'elementor-white-label';
				$func  = __CLASS__ . '::render';

				add_submenu_page( 'elementor', $title, $title, $cap, $slug, $func );
			}
		}
	}

	public static function render() {
		include ELEMENTOR_WHITE_LABEL_PATH . 'includes/admin-settings.php';
	}

	/**
	 * Renders the action for a form.
	 *
	 * @since 1.0.0
	 * @param string $type The type of form being rendered.
	 * @return void
	 */
	public static function get_form_action( $type = '' ) {
		return admin_url( '/admin.php?page=elementor-white-label' . $type );
	}

	/**
	 * Returns an option from the database for
	 * the admin settings page.
	 *
	 * @since 1.0.0
	 * @param string $key The option key.
	 * @return mixed
	 */
	public static function get_option( $key, $network_override = true ) {
		if ( is_network_admin() ) {
			$value = get_site_option( $key );
		}
			elseif ( ! $network_override && is_multisite() ) {
				$value = get_site_option( $key );
			}
			elseif ( $network_override && is_multisite() ) {
				$value = get_option( $key );
				$value = ( false === $value || ( is_array( $value ) && in_array( 'disabled', $value ) ) ) ? get_site_option( $key ) : $value;
			}
			else {
			$value = get_option( $key );
		}

		return $value;
	}

	/**
	 * Set the branding data to plugin.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public static function update_branding( $all_plugins ) {
		$settings = self::get_settings();

			if ( defined( 'ELEMENTOR_PLUGIN_BASE' ) ) {
				$all_plugins[ELEMENTOR_PLUGIN_BASE]['Name']        = ! empty( $settings['plugin_name'] )     ? $settings['plugin_name']      : $all_plugins[ELEMENTOR_PLUGIN_BASE]['Name'];
				$all_plugins[ELEMENTOR_PLUGIN_BASE]['PluginURI']   = ! empty( $settings['plugin_uri'] )      ? $settings['plugin_uri']       : $all_plugins[ELEMENTOR_PLUGIN_BASE]['PluginURI'];
				$all_plugins[ELEMENTOR_PLUGIN_BASE]['Description'] = ! empty( $settings['plugin_desc'] )     ? $settings['plugin_desc']      : $all_plugins[ELEMENTOR_PLUGIN_BASE]['Description'];
				$all_plugins[ELEMENTOR_PLUGIN_BASE]['Author']      = ! empty( $settings['plugin_author'] )   ? $settings['plugin_author']    : $all_plugins[ELEMENTOR_PLUGIN_BASE]['Author'];
				$all_plugins[ELEMENTOR_PLUGIN_BASE]['AuthorURI']   = ! empty( $settings['plugin_uri'] )      ? $settings['plugin_uri']       : $all_plugins[ELEMENTOR_PLUGIN_BASE]['AuthorURI'];
				$all_plugins[ELEMENTOR_PLUGIN_BASE]['Title']       = ! empty( $settings['plugin_name'] )     ? $settings['plugin_name']      : $all_plugins[ELEMENTOR_PLUGIN_BASE]['Title'];
				$all_plugins[ELEMENTOR_PLUGIN_BASE]['AuthorName']  = ! empty( $settings['plugin_author'] )   ? $settings['plugin_author']    : $all_plugins[ELEMENTOR_PLUGIN_BASE]['AuthorName'];
			}

			if ( defined( 'ELEMENTOR_PRO_PLUGIN_BASE' ) ) {
				$all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['Name']        = ! empty( $settings['plugin_pro_name'] )     ? $settings['plugin_pro_name']      : $all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['Name'];
				$all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['PluginURI']   = ! empty( $settings['plugin_uri'] )      ? $settings['plugin_uri']       : $all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['PluginURI'];
				$all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['Description'] = ! empty( $settings['plugin_desc'] )     ? $settings['plugin_desc']      : $all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['Description'];
				$all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['Author']      = ! empty( $settings['plugin_author'] )   ? $settings['plugin_author']    : $all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['Author'];
				$all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['AuthorURI']   = ! empty( $settings['plugin_uri'] )      ? $settings['plugin_uri']       : $all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['AuthorURI'];
				$all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['Title']       = ! empty( $settings['plugin_pro_name'] )     ? $settings['plugin_pro_name']      : $all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['Title'];
				$all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['AuthorName']  = ! empty( $settings['plugin_author'] )   ? $settings['plugin_author']    : $all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['AuthorName'];
			}

			if ( $settings['hide_plugin'] == 'on' ) {
				unset( $all_plugins[ELEMENTOR_WHITE_LABEL_PRO_BASE] );
			}

			if ( $settings['hide_elementor_plugin'] == 'on' ) {
				if ( defined( 'ELEMENTOR_PLUGIN_BASE' ) ) {
					unset( $all_plugins[ELEMENTOR_PLUGIN_BASE] );
				}
			}

			if ( $settings['hide_elementor_pro_plugin'] == 'on' ) {
				if ( defined( 'ELEMENTOR_PRO_PLUGIN_BASE' ) ) {
					unset( $all_plugins[ELEMENTOR_PRO_PLUGIN_BASE] );
				}
			}

			return $all_plugins;
	}

	/**
	 * Saves the white label settings.
	 *
	 * @since 1.0.0
	 * @access private
	 * @return void
	 */
	private static function save_white_label() {
		if ( ! isset( $_POST['ewl-settings-nonce'] ) || ! wp_verify_nonce( $_POST['ewl-settings-nonce'], 'ewl-settings' ) ) {
			return;
		}

		$settings = self::get_settings();

		if ( defined( 'ELEMENTOR_PRO_PLUGIN_BASE' ) ) {
			$settings['plugin_pro_name'] = isset( $_POST['ewl_plugin_pro_name'] ) ? sanitize_text_field( $_POST['ewl_plugin_pro_name'] ) : '';
		}
		$settings['plugin_name']               = isset( $_POST['ewl_plugin_name'] ) ? sanitize_text_field( $_POST['ewl_plugin_name'] ) : '';
		$settings['plugin_desc']               = isset( $_POST['ewl_plugin_desc'] ) ? esc_textarea( $_POST['ewl_plugin_desc'] ) : '';
		$settings['plugin_author']             = isset( $_POST['ewl_plugin_author'] ) ? sanitize_text_field( $_POST['ewl_plugin_author'] ) : '';
		$settings['plugin_uri']                = isset( $_POST['ewl_plugin_uri'] ) ? esc_url( $_POST['ewl_plugin_uri'] ) : '';
		$settings['admin_label']               = isset( $_POST['ewl_admin_label'] ) ? sanitize_text_field( $_POST['ewl_admin_label'] ) : '';
		$settings['edit_with_elementor']       = isset( $_POST['ewl_edit_with_elementor'] ) ? sanitize_text_field( $_POST['ewl_edit_with_elementor'] ) : '';
		$settings['hide_license_page']         = isset( $_POST['ewl_hide_license_page'] ) ? 'on' : 'off';
		$settings['hide_elementor_plugin']     = isset( $_POST['ewl_hide_elementor_plugin'] ) ? 'on' : 'off';
		$settings['hide_elementor_pro_plugin'] = isset( $_POST['ewl_hide_elementor_pro_plugin'] ) ? 'on' : 'off';
		$settings['hide_plugin']               = isset( $_POST['ewl_hide_plugin'] ) ? 'on' : 'off';
		$settings['hide_ewl_setting_page']     = isset( $_POST['ewl_hide_ewl_setting_page'] ) ? 'on' : 'off';
		$settings['hide_plugin_row_meta']      = isset( $_POST['ewl_hide_plugin_row_meta'] ) ? 'on' : 'off';

		update_site_option( 'ewl_settings', $settings );
	}

	/**
	 * Admin footer text.
	 *
	 * Modifies the "Thank you" text displayed in the admin footer.
	 *
	 * Fired by `admin_footer_text` filter.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string $footer_text The content that will be printed.
	 *
	 * @return string The content that will be printed.
	 */
	public static function admin_footer_text( $footer_text ) {
		$current_screen = get_current_screen();
		$is_elementor_white_label_screen = ( $current_screen && false !== strpos( $current_screen->id, 'elementor' ) );

		if ( $is_elementor_white_label_screen ) {
			$footer_text = __( ' Enjoyed <strong>Elementor White Label</strong>? Please leave us a <a href="https://namncn.com/plugins/elementor-white-label-for-elementor/" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> rating. We really appreciate your support!', 'elementor-white-label' );
		}

		return $footer_text;
	}

	/**
	 * Plugin row meta.
	 *
	 * Adds row meta links to the plugin list table
	 *
	 * Fired by `plugin_row_meta` filter.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array  $plugin_meta An array of the plugin's metadata, including
	 *                            the version, author, author URI, and plugin URI.
	 * @param string $plugin_file Path to the plugin file, relative to the plugins
	 *                            directory.
	 *
	 * @return array An array of plugin row meta links.
	 */
	public static function plugin_row_meta( $plugin_meta, $plugin_file ) {
		$settings = self::get_settings();

		if ( 'off' == $settings['hide_plugin_row_meta'] ) {
			return $plugin_meta;
		}

		if ( defined( 'ELEMENTOR_PLUGIN_BASE' ) && ELEMENTOR_PLUGIN_BASE === $plugin_file ) {
			$plugin_meta = array( $plugin_meta[0], $plugin_meta[1] );
		}

		if ( defined( 'ELEMENTOR_PRO_PLUGIN_BASE' ) && ELEMENTOR_PRO_PLUGIN_BASE === $plugin_file ) {
			$plugin_meta = array( $plugin_meta[0], $plugin_meta[1], $plugin_meta[2] );
		}

		return $plugin_meta;
	}

	/**
	 * Plugin Action Links.
	 */
	public static function plugin_action_links( $links ) {

		$settings = self::get_settings();

		if ( 'off' == $settings['hide_plugin_row_meta'] ) {
			return $links;
		}

		unset( $links['active_license'] );

		return $links;
	}
}

EWL::init();
