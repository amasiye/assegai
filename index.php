<?php
require_once "app/en-US/init.php";

$app = new App;
$db = $app->db;
$db->insert('$table', array('$columns'), '$values', '$filter');
?>
