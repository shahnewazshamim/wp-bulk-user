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
if ( $_POST['submit'] && $_POST['submit'] == 'Import Users' ) {
    $extension = $plugin_admin->check_file_extension();
    switch ($extension) {
        case 'csv':
	        $status = $plugin_admin->importCSV( $_POST );
            break;
        case 'xls':
	        $status = $plugin_admin->importXLS( $_POST );
            break;
        case 'xlsx':
	        $status = $plugin_admin->importXLSX( $_POST );
            break;
        default:
            // Do nothing...
            break;
    }
}
?>
<div class="wrapper">
    <p></p>
	<?php
	if ( count( $status ) ) {
		if ( array_key_exists( 'username', $status ) ) {
			echo '<p class="notice notice-' . $status['username']['exists']['type'] . ' notice-large is-dismissible">' . $status['username']['exists']['message'] . '</p>';
		}
		if ( array_key_exists( 'email', $status ) ) {
			echo '<p class="notice notice-' . $status['email']['exists']['type'] . ' notice-large is-dismissible">' . $status['email']['exists']['message'] . '</p>';
		}
		if ( array_key_exists( 'insert', $status ) && !empty( $status['insert']['error'] ) ) {
			$message = '<strong>Following record(s) are not inserted:</strong>';
			echo '<p class="notice notice-' . $status['insert']['error']['type'] . ' notice-large is-dismissible">' . $message . '<br><em>' . $status['insert']['error']['message'] . '</em></p>';
		}
		if ( array_key_exists( 'insert', $status ) && !empty( $status['insert']['success'] ) ) {
			echo '<p class="notice notice-' . $status['insert']['success']['type'] . ' notice-large is-dismissible">' . $status['insert']['success']['message'] . '</p>';
		}
	}
	?>
    <form action="<?php echo $_SERVER['PHP_SELF'] . '?page=wp-bulk-user&tab=import'?>" id="form-import" class="validate" method="post" enctype="multipart/form-data">
        <fieldset class="wpbu-fieldset">
            <h2 class="wpbu-pull-left">Import (Download CSV/XLS Format)</h2>
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
                        <em><small>CSV (comma separated value), Excel Sheets / Spreadsheets</small></em>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="submit">
                <hr>
                <input type="submit" id="btn-import" class="button-primary" name="submit" value="Import Users">
                <div class="wpbu-loading">Processing please wait.... Don't close your browser! While finished we will redirect back to you. </div>
            </div>
        </fieldset>
    </form>
</div>
