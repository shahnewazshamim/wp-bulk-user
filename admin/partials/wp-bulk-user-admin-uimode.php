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
$roles = array_keys(get_editable_roles());
?>
<div class="wrapper">
    <p></p>
    <form action="" class="validate" method="post">
        <fieldset class="wpbu-fieldset">
            <h2 class="wpbu-pull-left">Add Multiple Users (GUI mode)</h2>
            <div class="wpbu-pull-right wpbu-help-icon">
                <a href="" title="Help"><span class="dashicons dashicons-editor-help"></span></a>
            </div>
            <div class="wpbu-clear-fix"></div>
            <hr>
            <table class="form-table">
                <tbody>
                <tr valign="top">
                    <th scope="row">
                        <label for="wpbu_user_login">User Information #01</label>
                    </th>
                    <td scope="row">
                        <input class="wpbu-input-md" id="wpbu_user_login" name="wpbu_user_login" placeholder="Username (required)">
                        <input class="wpbu-input-md" id="wpbu_email" name="wpbu_email" placeholder="Email (required)">
                        <input class="wpbu-input-md" id="wpbu_first_name" name="wpbu_first_name" placeholder="First Name">
                        <input class="wpbu-input-md" id="wpbu_last_name" name="wpbu_last_name" placeholder="Last Name">
                        <input class="wpbu-input-md" id="wpbu_url" name="wpbu_url" placeholder="Website">
                        <input class="wpbu-input-md" id="wpbu_password" name="wpbu_password" placeholder="Password">
                        <select id="wpbu_role" class="wpbu-input-md" name="wpbu_role">
	                        <?php foreach ($roles as $role) : ?>
                                <option value="<?=$role?>"><?=ucwords($role)?></option>
	                        <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr v
                <tr valign="top">
                    <th scope="row">
                        <label for="wpbu_user_add_new_row">User Information #02</label>
                    </th>
                    <td scope="row">
                        <a href="javascript:void(0)" id="wpbu_user_add_new_row" class="button-primary">Add New Row</a>
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
                <input type="submit" class="button-primary" name="submit" value="Add These Users">
            </div>
        </fieldset>
    </form>
</div>
