<?php
ob_flush();
$contents = array();
$users = get_users();
foreach ( $users as $user ) {
	$row['user_login'] = $user->data->user_login;
	$row['user_email'] = $user->data->user_email;
	$row['first_name'] = $user->data->first_name;
	$row['last_name'] = $user->data->last_name;
	$row['user_url'] = $user->data->user_url;
	$row['user_pass'] = '0';
	$row['user_role'] = $user->roles[0];
	array_push($contents, $row);
}
$file = 'your-file.txt';
$string_data = serialize($contents);
file_put_contents($file, $string_data);
//header('Content-Description: File Transfer');
//header('Content-Type: text/csv');
//header('Content-Disposition: attachment; filename="'.basename($file).'"');
//header('Expires: 0');
//header('Cache-Control: must-revalidate');
//header('Pragma: public');
//header('Content-Length: ' . filesize($file));
download_url($file);
exit;
?>