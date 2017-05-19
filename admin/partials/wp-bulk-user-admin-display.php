<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.softyardbd.com
 * @since      1.0.0
 *
 * @package    Wp_Bulk_User
 * @subpackage Wp_Bulk_User/admin/partials
 */
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <hr>
    <?php
    $plugin_admin = new Wp_Bulk_User_Admin('wp-bulk-user', '');
    if (isset($_GET['tab'])) {
        $plugin_admin->render_plugin_admin_tabs($_GET['tab']);
        switch ($_GET['tab']) {
            case 'create':
                include 'wp-bulk-user-admin-create.php';
                break;

            case 'update':
                include 'wp-bulk-user-admin-update.php';
                break;

            case 'upload':
                include 'wp-bulk-user-admin-upload.php';
                break;

            case 'backup':
                include 'wp-bulk-user-admin-backup.php';
                break;

            default:
                include 'wp-bulk-user-admin-about.php';
                break;
        }
    } else {
        $plugin_admin->render_plugin_admin_tabs();
	    include 'wp-bulk-user-admin-create.php';
    }
    ?>
</div>
