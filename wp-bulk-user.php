<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.softyardbd.com
 * @since             1.0.0
 * @package           Wp_Bulk_User
 *
 * @wordpress-plugin
 * Plugin Name:       WP Bulk User
 * Plugin URI:        http://www.softyardbd.com
 * Description:       WP Bulk User is allow to <strong>create multiple users in a single screen.</strong> It can manage users easily. This is very helpful tools to manage your heavy weight site users. You can upload via an excel or csv file through its powerful tools with a provided example sheets.
 * Version:           1.0.0
 * Author:            Md. Shamim Shahnewaz
 * Author URI:        http://www.softyardbd.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-bulk-user
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-bulk-user-activator.php
 */
function activate_wp_bulk_user() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-bulk-user-activator.php';
	Wp_Bulk_User_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-bulk-user-deactivator.php
 */
function deactivate_wp_bulk_user() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-bulk-user-deactivator.php';
	Wp_Bulk_User_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_bulk_user' );
register_deactivation_hook( __FILE__, 'deactivate_wp_bulk_user' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-bulk-user.php';

/**
 * This is for loading Box/Spout library.
 */
require plugin_dir_path( __FILE__ ) . 'vendor/Spout/Autoloader/autoload.php';

/**
 * This is for loading application constants.
 */
require 'constants.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_bulk_user() {

	$plugin = new Wp_Bulk_User();
	$plugin->run();

}
run_wp_bulk_user();
