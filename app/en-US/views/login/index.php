<?php $db = $data['db']; ?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>Login</h1>
<div>
<?php
// global $db;
// $db_new = $GLOBALS['db'];

// var_dump($db);
$db->insert('$table', array('col1', 'col2', 'col3'), array('value1', 2, true, 2.0, 'value3'), '$filter');
// echo $data['user']->display_name;
?>
</div>
</body>
</html>
