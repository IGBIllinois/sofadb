<?php
/**
 *  About Page 
 */
$title = " Forensic Anthropology Case Database (FADAMA) - About";
require_once "../include/header_admin.php";

?>

<div id="memberregion">
<div class="scroll">
<table id='hortable'>
	<tbody>
		<tr><td>Code Website</td></td><td><a href='<?php echo settings::get_website_url(); ?>' target='_blank'><?php echo settings::get_website_url(); ?></a></td></tr>
		<tr><td>App Version</td><td><?php echo settings::get_version(); ?></td></tr>
		<tr><td>Webserver Version</td><td><?php echo \IGBIllinois\Helper\functions::get_webserver_version(); ?></td></tr>
		<tr><td>MySQL Version</td><td><?php echo $db->get_version(); ?></td>
		<tr><td>PHP Version</td><td><?php echo phpversion(); ?></td></tr>
		<tr><td>PHP Extensions</td><td><?php 
			$extensions_string = "";
			foreach (\IGBIllinois\Helper\functions::get_php_extensions() as $row) {
				$extensions_string .= implode(", ",$row) . "<br>";
			}
			echo $extensions_string;
		?></td></tr>
		</tbody>
</table>
<br>
<table id='hortable'>
	<thead>
		<tr><th>Setting</th><th>Value</th></tr>
	</thead>
	<tbody>
		<tr><td>ENABLE_LOG</td><td><?php if (settings::get_log_enabled()) { echo "TRUE"; } else { echo "FALSE"; } ?></td></tr>
		<tr><td>LOG_FILE</td><td><?php echo settings::get_logfile(); ?></td></tr>
		<tr><td>TIMEZONE</td><td><?php echo settings::get_timezone(); ?></td></tr>
		<tr><td>MYSQL_HOST</td><td><?php echo settings::get_mysql_host(); ?></td></tr>
		<tr><td>MYSQL_DATABASE</td><td><?php echo settings::get_mysql_database(); ?></td></tr>
		<tr><td>MYSQL_USER</td><td><?php echo settings::get_mysql_user(); ?></td></tr>
		<tr><td>SESSION_NAME</td><td><?php echo settings::get_session_name(); ?></td></tr>
		<tr><td>SESSION_TIMEOUT</td><td><?php echo settings::get_session_timeout(); ?></td></tr>
		<tr><td>SMTP_HOST</td><td><?php echo settings::get_smtp_host(); ?></td></tr>
		<tr><td>SMTP_PORT</td><td><?php echo settings::get_smtp_port(); ?></td></tr>
		<tr><td>SMTP_USERNAME</td><td><?php echo settings::get_smtp_username(); ?></td></tr>
		<tr><td>SMTP_PASSWORD</td><td><?php echo settings::get_smtp_password(); ?></td></tr>
		<tr><td>FROM_EMAIL</td><td><?php echo settings::get_from_email(); ?></td></tr>
		<tr><td>ADMIN_EMAIL</td><td><?php echo implode(",",settings::get_admin_email()); ?></td></tr>
	</tbody>
</table>
</div>
<?php 
require_once("../include/footer.php");
?>
