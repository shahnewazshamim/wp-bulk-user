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
    <form action="" class="validate" novalidate="novalidate" method="post">
        <fieldset class="wpbu-fieldset">
            <h2 class="wpbu-pull-left">Export (Download CSV/XLS Format)</h2>
            <div class="wpbu-pull-right wpbu-help-icon">
                <a href="" title="Help"><span class="dashicons dashicons-editor-help"></span></a>
            </div>
            <div class="wpbu-clear-fix"></div>
            <hr>
            <table class="form-table">
                <tbody>
                <tr valign="top">
                    <th scope="row">
                        <label for="wpbu_user_login">Select Your Desire Format(s)</label>
                    </th>
                    <td scope="row">
                        <label for="wpbu_csv"><input type="checkbox" id="wpbu_csv" value="1"> CSV <small>(comma separated value)</small></label>&nbsp;&nbsp;
                        <label for="wpbu_xls"><input type="checkbox" id="wpbu_xls" value="1"> Excel Sheets/ Spreadsheets</label>&nbsp;&nbsp;
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
