<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.softyardbd.com
 * @since      1.0.0
 *
 * @package    Wp_Bulk_User
 * @subpackage Wp_Bulk_User/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Bulk_User
 * @subpackage Wp_Bulk_User/admin
 * @author     Md. Shamim Shahnewaz <mdshamimshahnewaz@gmail.com>
 */
class Wp_Bulk_User_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * The admin tabs array of this plugin main page.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array $tabs The admin tabs array of this plugin main page.
	 */
	private $tabs;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of this plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->tabs        = array(
			'create' => 'Add Bulk User',
			'update' => 'Edit Bulk User',
			'upload' => 'Upload CSV/XLS',
			'backup' => 'Backup',
		);

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Bulk_User_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Bulk_User_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-bulk-user-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Bulk_User_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Bulk_User_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-bulk-user-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the administration menu for this plugin.
	 *
	 * @since   1.0.0
	 */
	public function add_plugin_admin_menu() {

		add_menu_page(
			'WP Bulk User Manager',
			'WP Bulk User',
			'read',
			$this->plugin_name,
			array( $this, 'display_plugin_main_page' ),
			'dashicons-groups',
			100
		);

		add_submenu_page(
			$this->plugin_name,
			'WP Bulk User Manager',
			'Manage Users',
			'read',
			$this->plugin_name,
			array( $this, 'display_plugin_main_page' )
		);

		add_submenu_page(
			$this->plugin_name,
			'WP Bulk User Settings',
			'Settings',
			'read',
			$this->plugin_name . '-settings',
			array( $this, 'display_plugin_settings_page' )
		);

		add_submenu_page(
			$this->plugin_name,
			'About WP Bulk User',
			'About',
			'read',
			$this->plugin_name . '-about',
			array( $this, 'display_plugin_about_page' )
		);

	}

	/**
	 * Render plugin Admin Tabs on Main page.
	 *
	 * @since   1.0.0
	 */
	public function render_plugin_admin_tabs( $active = 'create' ) {
		echo '<div class="nav-tab-wrapper">';
		foreach ( $this->tabs as $slug => $title ) {
			$class = ( $slug == $active ) ? ' nav-tab-active wpbu-blue' : '';
			$url   = '?page=' . $this->plugin_name . '&tab=' . $slug;
			echo '<a class="nav-tab ' . $class . '" href="' . $url . '">' . $title . "</a>";

		}
		echo '</div>';
	}

	/**
	 * Render plugin Main page.
	 *
	 * @since   1.0.0
	 */
	public function display_plugin_main_page() {
		include_once( 'partials/wp-bulk-user-admin-display.php' );
	}

	/**
	 * Render plugin Settings page.
	 *
	 * @since   1.0.0
	 */
	public function display_plugin_settings_page() {
		include_once( 'partials/wp-bulk-user-admin-settings.php' );
	}

	/**
	 * Render plugin About page.
	 *
	 * @since   1.0.0
	 */
	public function display_plugin_about_page() {
		include_once( 'partials/wp-bulk-user-admin-about.php' );
	}

	/**
	 * Add multiple users.
	 *
	 * @since   1.0.0
	 *
	 * @param $request  array
	 *
	 * @return array | mixed
	 */
	public function add_multiple_users( $request ) {
		$status    = array();
		$sequences = array( 'user_login', 'user_email', 'first_name', 'last_name', 'user_url', 'user_pass' );
		if ( isset( $request ) && ! empty( $request['wpbu_users'] ) ) {
			if ( strpos( $request['wpbu_users'], PHP_EOL ) ) {
				$users     = explode( PHP_EOL, $request['wpbu_users'] );
				$failed    = array();
				$will_save = true;
				foreach ( $users as $user ) {
					$origin = $user;
					$user   = ltrim( $user, '[' );
					$user   = rtrim( $user, ',' );
					$user   = rtrim( $user, ']' );
					$data   = explode( ',', $user );
					if ( count( $data ) != 6 ) {
						$status['mismatch']['error']['message'] .= '<br>' . $origin;
						$status['mismatch']['error']['type']    = 'error';
					} else {
						if ( username_exists( $data[0] ) ) {
							$failed['user_name'][] = $data[0];
						}
						if ( email_exists( $data[1] ) ) {
							$failed['user_email'][] = $data[1];
						}
						if ( $will_save ) {
							$user_data = array_combine( $sequences, $data );
							$user_id   = wp_insert_user( $user_data );
							if ( is_wp_error( $user_id ) ) {
								$status['insert']['error']['message'] .= $origin;
								$status['insert']['error']['type']    = 'warning';
							} else {
								$status['insert']['success']['message'] = '<strong>Successfully created user list</strong>';
								$status['insert']['success']['type']    = 'success';
								if ( isset( $request['wpbu_send_user_notification'] ) && $request['wpbu_send_user_notification'] == true ) {
									wp_mail( $user_data[1], 'User ', 'Your email created successful' );
								}
							}
						}  {
							if ( count( $failed['user_name'] ) ) {
								$status['username']['exists']['message'] = '<strong>The following username record(s) are already exists : </strong>' . '<br>' . implode( ', ', $failed['user_name'] );
								$status['username']['exists']['type']    = 'error';
							}
							if ( count( $failed['user_email'] ) ) {
								$status['email']['exists']['message'] = '<strong>The following email record(s) are already exists : </strong>' . '<br>' . implode( ', ', $failed['user_email'] );
								$status['email']['exists']['type']    = 'error';
							}
						}
					}
				}
			} else {
				$status['invalid_set'] = 'User list is not set correctly. In automation, you have to follow the <a href="http://wiki.github.com/wp-bulk-user" target="_blank">convention</a>';
				$status['type']        = 'warning';
			}
		} else {
			$status['empty_user'] = 'This field is required, please enter with following the <a href="http://wiki.github.com/wp-bulk-user" target="_blank">convention</a>.';
			$status['type']       = 'error';
		}

		return $status;
	}

}
