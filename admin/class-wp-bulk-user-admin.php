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
	 * The allowed file extension array of this plugin main page.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array $allowed_ext The allowed file extension array of this plugin main page.
	 */
	private $allowed_ext;

	/**
	 * The sequence of user fields.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array $sequence The sequence of user fields.
	 */
	private $sequence;

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
			'guimode' => 'Add With GUI',
			'txtmode' => 'Add With Text',
			'import'  => 'Import (CSV,XLSX)',
		);
		$this->sequence    = array(
			'user_login',
			'user_email',
			'first_name',
			'last_name',
			'user_url',
			'user_pass',
			'user_role'
		);
		$this->allowed_ext = array( 'csv', 'xlsx' );

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

		wp_enqueue_style( $this->plugin_name . '-sweetalert2-css', plugin_dir_url( __FILE__ ) . 'css/sweetalert2.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-style-css', plugin_dir_url( __FILE__ ) . 'css/wp-bulk-user-admin.css', array(), $this->version, 'all' );

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

		$params = array(
			'ajax_nonce' => wp_create_nonce(PLUGIN_AJAX_NONCE),
		);
		wp_localize_script( $this->plugin_name . 'ajax-object', 'ajax_object', $params );
		wp_enqueue_script( $this->plugin_name . '-sweetalert2-js', plugin_dir_url( __FILE__ ) . 'js/sweetalert2.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-main-js', plugin_dir_url( __FILE__ ) . 'js/wp-bulk-user-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'ajax-object' );

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
	public function render_plugin_admin_tabs( $active = 'guimode' ) {
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
	 * @return array | mixed
	 */
	public function add_multiple_users() {
		if ( isset( $_REQUEST ) && !empty( $_REQUEST['wpbu_users'] ) ) {
			$status = array();
			$wpbu_users = ( $_REQUEST['wpbu_users'] );
			$wpbu_email = intval( $_REQUEST['wpbu_send_user_notification'] );
			var_dump(strpos( $wpbu_users, PHP_EOL  ));
			if ( strpos( $wpbu_users, "\r\n" ) ) {
				$users     = explode( "\r\n", $wpbu_users );
				$failed    = array();
				$will_save = true;
				foreach ( $users as $user ) {
					$origin = $user;
					$user   = preg_replace( '/\[+/', '', $user );
					$user   = preg_replace( '/\]+/', '', $user );
					$user   = rtrim( $user, ',' );
					$data   = explode( ',', $user );
					$data   = array_map( 'trim', $data );
					$data   = array_map( 'sanitize_text_field', $data );
					if ( count( $data ) != 7 ) {
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
							$user_data = array_combine( $this->sequence, $data );
							$user_id   = wp_insert_user( $user_data );
							if ( is_wp_error( $user_id ) ) {
								$status['insert']['error']['message'] .= $origin;
								$status['insert']['error']['type']    = 'warning';
							} else {
								$status['insert']['success']['message'] = '<strong>Successfully created user list</strong>';
								$status['insert']['success']['type']    = 'success';
								if ($wpbu_email) {
									wp_mail( $user_data[1], 'User ', 'Your email created successful' );
								}
							}
						}
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
			} else {
				$status['invalid']['message'] = 'User list is not set correctly. In automation, you have to follow the <a href="http://wiki.github.com/wp-bulk-user" target="_blank">convention</a>';
				$status['invalid']['type']    = 'error';
			}
		} else {
			$status['empty']['message'] = 'This field is required, please enter with following the <a href="http://wiki.github.com/wp-bulk-user" target="_blank">convention</a>.';
			$status['empty']['type']    = 'error';
		}
		echo json_encode($status);
		exit;

		/*$status = array();
		if ( isset( $request ) && ! empty( $request['wpbu_users'] ) ) {
			$request['wpbu_users'] = sanitize_textarea_field( $request['wpbu_users'] );
			if ( strpos( $request['wpbu_users'], "\r\n" ) ) {
				$users     = explode( "\r\n", $request['wpbu_users'] );
				$failed    = array();
				$will_save = true;
				foreach ( $users as $user ) {
					$origin = $user;
					$user   = preg_replace( '/\[+/', '', $user );
					$user   = preg_replace( '/\]+/', '', $user );
					$user   = rtrim( $user, ',' );
					$data   = explode( ',', $user );
					$data   = array_map( 'trim', $data );
					if ( count( $data ) != 7 ) {
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
							$user_data = array_combine( $this->sequence, $data );
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
						}
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
			} else {
				$status['invalid']['message'] = 'User list is not set correctly. In automation, you have to follow the <a href="http://wiki.github.com/wp-bulk-user" target="_blank">convention</a>';
				$status['invalid']['type']    = 'error';
			}
		} else {
			$status['empty']['message'] = 'This field is required, please enter with following the <a href="http://wiki.github.com/wp-bulk-user" target="_blank">convention</a>.';
			$status['empty']['type']    = 'error';
		}*/
	}

	/**
	 * Check uploaded file extension.
	 *
	 * @since   1.0.0
	 */
	public function check_file_extension() {
		$filename  = $_FILES['wpbu_im_file']['name'];
		$extension = pathinfo( $filename, PATHINFO_EXTENSION );
		if ( ! in_array( $extension, $this->allowed_ext ) ) {
			$status = 'error';
		} else {
			$status = $extension;
		}

		return $status;
	}

	/**
	 * Import CSV file.
	 *
	 * @since   1.0.0
	 *
	 * @param $request  array
	 *
	 * @return array | mixed
	 */
	public function importCSV( $request ) {
		@ini_set( 'upload_max_size', '64M' );
		@ini_set( 'post_max_size', '64M' );
		@ini_set( 'max_execution_time', '1000' );
		$status    = array();
		$failed    = array();
		$will_save = true;
		$csv       = \Box\Spout\Reader\ReaderFactory::create( \Box\Spout\Common\Type::CSV );
		$csv->open( $_FILES['wpbu_im_file']['tmp_name'] );
		foreach ( $csv->getSheetIterator() as $sheet ) {
			foreach ( $sheet->getRowIterator() as $user ) {
				$users[] = $user;
				unset( $users[0] );
				if ( username_exists( $user[0] ) ) {
					$failed['user_name'][] = $user[0];
				}
				if ( email_exists( $user[1] ) ) {
					$failed['user_email'][] = $user[1];
				}
				if ( $will_save ) {
					$user_data = array_combine( $this->sequence, $user );
					$user_id   = wp_insert_user( $user_data );
					if ( is_wp_error( $user_id ) ) {
						$records                              = implode( ', ', $user );
						$status['insert']['error']['message'] .= $records . '<br>';
						$status['insert']['error']['type']    = 'warning';
					} else {
						$status['insert']['success']['message'] = '<strong>Successfully created user list</strong>';
						$status['insert']['success']['type']    = 'success';
					}
				}
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
		$csv->close();

		return $status;
	}

	/**
	 * Import XLSX file.
	 *
	 * @since   1.0.0
	 *
	 * @param $request  array
	 *
	 * @return array | mixed
	 */
	public function importXLSX( $request ) {
		@ini_set( 'upload_max_size', '64M' );
		@ini_set( 'post_max_size', '64M' );
		@ini_set( 'max_execution_time', '1000' );
		$status    = array();
		$failed    = array();
		$will_save = true;
		$excel     = \Box\Spout\Reader\ReaderFactory::create( \Box\Spout\Common\Type::XLSX );
		$excel->open( $_FILES['wpbu_im_file']['tmp_name'] );
		foreach ( $excel->getSheetIterator() as $sheet ) {
			foreach ( $sheet->getRowIterator() as $user ) {
				$users[] = $user;
				unset( $users[0] );
				if ( username_exists( $user[0] ) ) {
					$failed['user_name'][] = $user[0];
				}
				if ( email_exists( $user[1] ) ) {
					$failed['user_email'][] = $user[1];
				}
				if ( $will_save ) {
					$user_data = array_combine( $this->sequence, $user );
					$user_id   = wp_insert_user( $user_data );
					if ( is_wp_error( $user_id ) ) {
						$records                              = implode( ', ', $user );
						$status['insert']['error']['message'] .= $records . '<br>';
						$status['insert']['error']['type']    = 'warning';
					} else {
						$status['insert']['success']['message'] = '<strong>Successfully created user list</strong>';
						$status['insert']['success']['type']    = 'success';
					}
				}
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
		$excel->close();

		return $status;
	}

	/**
	 * Export CSV file.
	 *
	 * @since   1.0.0
	 */
	public function exportCSV() {
		ignore_user_abort( true );
		set_time_limit( 0 );
		$contents = array();
		$users    = get_users();
		foreach ( $users as $user ) {
			$row['user_login'] = $user->data->user_login;
			$row['user_email'] = $user->data->user_email;
			$row['first_name'] = $user->data->first_name;
			$row['last_name']  = $user->data->last_name;
			$row['user_url']   = $user->data->user_url;
			$row['user_pass']  = '0';
			$row['user_role']  = $user->roles[0];
			array_push( $contents, $row );
		}
		$file        = 'your-file.csv';
		$string_data = serialize( $contents );
		//$f= fopen($file, 'w');
		file_put_contents( $file, $string_data );
		header( 'Content-Description: File Transfer' );
		header( 'Content-Type: text/csv' );
		header( 'Content-Disposition: attachment; filename="' . basename( $file ) . '"' );
		header( 'Expires: 0' );
		header( 'Cache-Control: must-revalidate' );
		header( 'Pragma: public' );
		header( 'Content-Length: ' . filesize( $file ) );
		echo readfile( $file );
		exit;
	}

	/**
	 * Export XLSX file.
	 *
	 * @since   1.0.0
	 */
	public function exportXLSX() {
		//set_time_limit(0);
		$excel = \Box\Spout\Writer\WriterFactory::create( \Box\Spout\Common\Type::XLSX );
		ob_start();
		$excel->openToBrowser( 'test.xlsx' );
		$excel->addRow( $this->sequence );
		$users    = get_users();
		$contents = array();
		$row      = array();
		foreach ( $users as $user ) {
			$row['user_login'] = $user->data->user_login;
			$row['user_email'] = $user->data->user_email;
			$row['first_name'] = $user->data->first_name;
			$row['last_name']  = $user->data->last_name;
			$row['user_url']   = $user->data->user_url;
			$row['user_pass']  = '0';
			$row['user_role']  = $user->roles[0];
			$excel->addRow( $row );
		}
		$excel->close();
	}

}