<?php
require_once "app/en-US/init.php";

$app = new App;

# Make a new connection to the database
global $db_host, $db_user, $db_pass, $db_name;
$db = new Database($db_host, $db_user, $db_pass, $db_name);

?>
