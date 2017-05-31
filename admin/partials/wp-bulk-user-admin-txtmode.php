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

<div class="wrapper">
    <p></p>
    <div class="wpbu-console"></div>
    <form class="validate" method="post">
        <fieldset class="wpbu-fieldset">
            <h2 class="wpbu-pull-left">Add Multiple Users (Plain text mode)</h2>
            <div class="wpbu-pull-right wpbu-help-icon">
                <a href="" title="Help"><span class="dashicons dashicons-editor-help"></span></a>
            </div>
            <div class="wpbu-clear-fix"></div>
            <hr>
            <table class="form-table">
                <tbody>
                <tr valign="top">
                    <th scope="row">
                        <label for="wpbu_users">Enter User Information</label>
                    </th>
                    <td scope="row">
                    <textarea id="wpbu_users" name="wpbu_users" class="wpbu-input-block" rows="10" required
                              placeholder="Enter users information by set, wrap with [ ] Please take a look below exapmple."><?=isset($old_post)?$old_post:''?></textarea>
                        <p class="wpbu-input-help">
                            <strong>Syntax:</strong>
                            <em class="wpbu-blue">[ user_login, user_email, first_name, last_name, user_url, user_pass, role ]</em>
                        </p>
                        <p class="wpbu-input-help">
                            [ mdshamimshahnewaz, mdshamimshahnewaz@gmail.com, Md. Shamim, Shahnewaz, http://softyardbd.com, MyP@$$word, editor ],<br>
                            [ johndoe, john@outlook.com, John, Doe, http://john.com, JohnP@$$word, author ],<br>
                            [ kenedy, fkenedy@outlook.com, Franklin, Kenedy, http://john.com, JohnP@$$word, contributor],<br>
                            [ sebastain, skenedy@outlook.com, Sebastain, Kenedy, http://skenedy.com, SkP@$$word, subscriber ]
                        </p>
                        <?php $roles = array_keys(get_editable_roles()); ?>
                        <?php if(count($roles) > 0) : ?>
                            <p class="wpbu-input-help">
                                <strong>Active Roles - </strong>
                                <?php $roles_list = implode(', ', $roles); ?>
                                <strong class="wpbu-green"><?=$roles_list?></strong>
                            </p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="wpbu_send_user_notification">Send Users Notification</label>
                    </th>
                    <td>
                        <input type="checkbox" id="wpbu_send_user_notification" name="wpbu_send_user_notification"
                               value="23">
                        <em>
                            <small> Send all the new users an email about their account.</small>
                        </em>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="submit">
                <hr>
                <input type="button" class="button-primary" id="wpbu-btn-insert-text" name="submit" value="Add Multiple Users">
            </div>
        </fieldset>
    </form>
</div>
