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
$plugin_admin = new Wp_Bulk_User_Admin('', '');
if ($_POST['submit'] && $_POST['submit'] == 'Export Users') {
    if ((isset($_POST['wpbu_csv']) && intval($_POST['wpbu_csv'])) || (isset($_POST['wpbu_xlsx']) && $_POST['wpbu_xlsx'])) {
        $csv_on = intval($_POST['wpbu_csv']);
        $xlsx_on = intval($_POST['wpbu_xlsx']);
        var_dump($csv_on, $xlsx_on);
        if($csv_on) {
            $plugin_admin->exportCSV();
        } else if($xlsx_on) {
            $plugin_admin->exportXLSX();
        } else {
            // Do nothing...
        }
    }
}
?>
<div class="wrapper">
    <p></p>
    <form action="<?php echo esc_url(admin_url('admin.php?page=' . PLUGIN_SLUG . '&tab=export')) ?>" class="validate"
          method="post">
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
                        <label for="wpbu_csv"><input type="checkbox" id="wpbu_csv" name="wpbu_csv" value="1"> CSV
                            <small>(comma separated value)</small>
                        </label>&nbsp;&nbsp;
                        <label for="wpbu_xlsx"><input type="checkbox" id="wpbu_xlsx" name="wpbu_xlsx" value="1"> XLSX
                            <small>(Microsoft Excel Sheets)</small>
                        </label>&nbsp;&nbsp;
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="submit">
                <hr>
                <input type="submit" class="button-primary" name="submit" value="Export Users">
            </div>
        </fieldset>
    </form>
</div>
