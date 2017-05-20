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
}
?>
<div class="wrapper">
    <p></p>
	<?php
    $old_post = '';
    if ( count( $status ) ) {
	    if ( array_key_exists( 'invalid', $status ) ) {
		    echo '<p class="notice notice-' . $status['invalid']['type'] . ' notice-large is-dismissible"><strong>' . $status['invalid']['message'] . '</strong></p>';
		    $old_post = $_POST['wpbu_users'];
	    }
	    if ( array_key_exists( 'empty', $status ) ) {
		    echo '<p class="notice notice-' . $status['empty']['type'] . ' notice-large is-dismissible"><strong>' . $status['empty']['message'] . '</strong></p>';
		    $old_post = $_POST['wpbu_users'];
	    }
		if ( array_key_exists( 'mismatch', $status ) ) {
			$message = '<strong>Mismatch occurred, please check the <a href="http://wiki.github.com/wp-bulk-user" target="_blank">convention</a>:</strong>';
			echo '<p class="notice notice-' . $status['mismatch']['error']['type'] . ' notice-large is-dismissible">' . $message . '<br><em>' . $status['mismatch']['error']['message'] . '</em></p>';
			$old_post = $_POST['wpbu_users'];
	    }
		if ( array_key_exists( 'username', $status ) ) {
			echo '<p class="notice notice-' . $status['username']['exists']['type'] . ' notice-large is-dismissible">' . $status['username']['exists']['message'] . '</p>';
			$old_post = $_POST['wpbu_users'];
		}
		if ( array_key_exists( 'email', $status ) ) {
			echo '<p class="notice notice-' . $status['email']['exists']['type'] . ' notice-large is-dismissible">' . $status['email']['exists']['message'] . '</p>';
			$old_post = $_POST['wpbu_users'];
		}
		if ( array_key_exists( 'insert', $status ) && !empty( $status['insert']['error'] ) ) {
			$message = '<strong>Following record(s) are not inserted:</strong>';
			echo '<p class="notice notice-' . $status['insert']['error']['type'] . ' notice-large is-dismissible">' . $message . '<br><em>' . $status['insert']['error']['message'] . '</em></p>';
			$old_post = $_POST['wpbu_users'];
		}
		if ( array_key_exists( 'insert', $status ) && !empty( $status['insert']['success'] ) ) {
			echo '<p class="notice notice-' . $status['insert']['success']['type'] . ' notice-large is-dismissible">' . $status['insert']['success']['message'] . '</p>';
		}
	}
	?>
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
                              placeholder="Enter users information by set, wrap with [ ] Please take a look below exapmple."><?=isset($old_post)?$old_post:''?></textarea>
                        <p class="wpbu-input-help">
                            [ mdshamimshahnewaz, mdshamimshahnewaz@gmail.com, Md. Shamim, Shahnewaz,
                            http://softyardbd.com,
                            MyP@$$word ],<br>
                            [ johndoe, john@outlook.com, John, Doe, http://john.com, JohnP@$$word ],<br>
                            [ kenedy, fkenedy@outlook.com, Franklin, Kenedy, http://john.com, JohnP@$$word ],<br>
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
