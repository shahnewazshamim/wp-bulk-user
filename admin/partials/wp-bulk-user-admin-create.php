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

<?php
$plugin_admin = new Wp_Bulk_User_Admin( '', '' );
if ( $_POST['submit'] && $_POST['submit'] == 'Add Multiple Users' ) {
	$status = $plugin_admin->add_multiple_users( $_POST );
	if ( array_key_exists( 'empty_user', $status ) ) {
		$message = $status['empty_user'];
		$type    = $status['type'];
	}
	if ( array_key_exists( 'invalid_set', $status ) ) {
		$message = $status['invalid_set'];
		$type    = $status['type'];
	}
	if ( array_key_exists( 'insert_error', $status ) ) {
		$message = $status['insert_error'];
		$type    = $status['type'];
	}
	if ( array_key_exists( 'count_mismatch', $status ) ) {
		$message = $status['count_mismatch'];
		$type    = $status['type'];
	}
	if ( array_key_exists( 'insert_success', $status ) ) {
		$message = $status['insert_success'];
		$type    = $status['type'];
	}
}
?>
<div class="wrapper">
    <p></p>
	<?php if ( isset( $message ) && isset( $type ) && $message != '' ): ?>
        <p class="notice notice-<?= $type; ?> notice-large is-dismissible"><?= $message; ?></p>
	<?php endif; ?>
    <form action="" class="validate" novalidate="novalidate" method="post">
        <fieldset class="wpbu-fieldset">
            <h2>Add Multiple Users</h2>
            <hr>
            <table class="form-table">
                <tbody>
                <tr valign="top">
                    <th scope="row">
                        <label for="wpbu_users">Enter User Information</label>
                    </th>
                    <td scope="row">
                    <textarea id="wpbu_users" name="wpbu_users" class="wpbu-input" rows="10"
                              placeholder="Enter users information by set, wrap with [ ] Please take a look below exapmple."></textarea>
                        <p class="wpbu-input-help">
                            [ mdshamimshahnewaz, mdshamimshahnewaz@gmail.com, Md. Shamim, Shahnewaz,
                            http://softyardbd.com,
                            MyP@$$word ],<br>
                            [ johndoe, john@outlook.com, John, Doe, http://john.com, JohnP@$$word ],<br>
                            [ sebastain, skenedy@outlook.com, Sebastain, Kenedy, http://skenedy.com, SkP@$$word ]
                        </p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="wpbu_send_user_notification">Send Users Notification</label>
                    </th>
                    <td>
                        <input type="checkbox" id="wpbu_send_user_notification" name="wpbu_send_user_notification"
                               value="true">
                        <em>
                            <small> Send all the new users an email about their account.</small>
                        </em>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="submit">
                <hr>
                <input type="submit" class="button-primary" name="submit" value="Add Multiple Users">
            </div>
        </fieldset>
    </form>
</div>
