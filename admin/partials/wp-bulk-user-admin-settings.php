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
    <form action="" method="post">
        <fieldset>
            <table class="form-table">
                <tbody>
                <tr valign="top">
                    <th scope="row">
                        <label for="wpbu-backup-location">Backup Location</label>
                    </th>
                    <td>
                        <input type="text" id="wpbu-backup-location" name="wpbu-backup-location" placeholder="Enter a file location">
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="wpbu-email-notified">Email Notification</label>
                    </th>
                    <td>
                        <input type="checkbox" id="wpbu-email-notified" name="wpbu-email-notified" value="true">
                        <em><small> If <strong>checked</strong> Notify every new users via email.</small></em>
                    </td>
                </tr>
                </tbody>
            </table>
            <p class="submit">
                <input type="submit" value="Save Settings" class="button-primary" name="Submit">
            </p>
        </fieldset>
    </form>
</div>
