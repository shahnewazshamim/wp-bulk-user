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
        $plugin_admin->render_plugin_admin_tabs(sanitize_text_field($_GET['tab']));
        switch (sanitize_text_field($_GET['tab'])) {
            case 'txtmode':
                include 'wp-bulk-user-admin-txtmode.php';
                break;

            case 'guimode':
                include 'wp-bulk-user-admin-uimode.php';
                break;

            case 'import':
                include 'wp-bulk-user-admin-import.php';
                break;

            case 'export':
                include 'wp-bulk-user-admin-export.php';
                break;

            default:
                include 'wp-bulk-user-admin-about.php';
                break;
        }
    } else {
        $plugin_admin->render_plugin_admin_tabs();
	    include 'wp-bulk-user-admin-uimode.php';
    }
    ?>
</div>
