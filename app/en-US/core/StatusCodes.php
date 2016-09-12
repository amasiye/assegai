<?php

/* Status code definitions */
define('LOGIN_ERR_USERNAME', 101);
define('LOGIN_ERR_PASSWORD', 102);
define('LOGIN_ERR_TIMEOUT', 103);
define('LOGIN_OK', 200);
define('LOGIN_ERR', 201);
define('LOGIN_SESSION_ERR', 202);
define('LOGOUT_OK', 250);
define('LOGOUT_ERR', 251);
define('LOGOUT_SESSION_ERR', 252);
define('QUERY_EXEC_OK', 300);
define('QUERY_EXEC_ERR', 301);
define('QUERY_STMT_OK', 310);
define('QUERY_STMT_ERR', 311);
define('QUERY_STMT_PARAM_ERR', 312);
define('FILE_WRITE_OK', 400);
define('FILE_WRITE_ERR', 401);
define('API_REQUEST_ERR', 501);
define('API_REQUEST_ERR_MISSING_KEY', 502);
define('API_REQUEST_ERR_INVALID_KEY', 503);
define('UPDATE_ERR_LOGIN', 601);
?>
