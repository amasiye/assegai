<?php
require_once "app/en-US/init.php";

$app = new App;
global $db_host, $db_user, $db_pass, $db_name;

# Make a new connection to the database
$db = new Database($db_host, $db_user, $db_pass, $db_name);

?>
