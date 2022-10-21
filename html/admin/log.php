<?php
require_once __DIR__ . '/../include/header_admin.php';

$log_contents = $log->get_log();
?>
<div id="memberregion">
<h1>Log</h1>
<textarea cols='80' rows='50' readonly><?php echo $log_contents; ?></textarea>


<?php

require_once __DIR__ . '/../include/footer.php';
?>

