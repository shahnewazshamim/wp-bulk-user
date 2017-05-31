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
    <form id="wpbu-form-import" name="wpbu-form-import" class="validate" method="post" enctype="multipart/form-data">
        <fieldset class="wpbu-fieldset">
            <h2 class="wpbu-pull-left">Import (Download CSV/XLSX Format)</h2>
            <div class="wpbu-pull-right wpbu-help-icon">
                <a href="" title="Help"><span class="dashicons dashicons-editor-help"></span></a>
            </div>
            <div class="wpbu-clear-fix"></div>
            <hr>
            <table class="form-table">
                <tbody>
                <tr valign="top">
                    <th scope="row">
                        <label for="wpbu_user_login">Upload Your Desire Format(s)</label>
                    </th>
                    <td scope="row">
                        <input type="file" id="wpbu_im_file" name="wpbu_im_file" value="Import (Download CSV/XLS Format)" pattern="^.+\.(xlsx|xls|csv)$" required>
                        <em><small>CSV (comma separated value), XLSX (Microsoft Excel Sheets) </small></em>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="submit">
                <hr>
                <input type="button" id="wpbu_btn_import" class="button-primary" value="Import Users">
            </div>
        </fieldset>
    </form>
</div>
