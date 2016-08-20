<?php

# Status Codes array
$status_codes = array(
  'LOGIN_ERR_USERNAME' => 1,
  'LOGIN_ERR_PASSWORD' => 2,
  'LOGIN_ERR_TIMEOUT' => 3
);

define('LOGIN_ERR_USERNAME', 101);
define('LOGIN_ERR_PASSWORD', 102);
define('LOGIN_ERR_TIMEOUT', 103);
define('LOGIN_OK', 200);
define('LOGIN_ERR', 201);
define('QUERY_STMT_OK', 300);
define('QUERY_STMT_ERR', 301);
define('QUERY_STMT_PARAM_ERR', 302);
define('QUERY_EXEC_ERR', 311);
define('FILE_WRITE_OK', 400);
define('FILE_WRITE_ERR', 401);
define('API_REQUEST_ERR', 501);
?>
