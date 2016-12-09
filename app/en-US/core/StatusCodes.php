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
define('FILE_UPLOAD_OK', 410);
define('FILE_UPLOAD_ERR', 411);
define('FILE_UPLOAD_ERR_MAX_SIZE', 412);
define('FILE_UPLOAD_ERR_MIME_TYPE', 413);
define('FILE_UPLOAD_ERR_EXISTS', 414);
define('FILE_UPLOAD_VALID', 419);
define('API_REQUEST_OK', 500);
define('API_REQUEST_ERR', 501);
define('API_REQUEST_ERR_MISSING_KEY', 502);
define('API_REQUEST_ERR_INVALID_KEY', 503);
define('API_REQUEST_TIMEOUT', 504);
define('UPDATE_ERR_LOGIN', 601);
define('UPDATE_ERR_GROUP', 602);  // At least 1 admin must exist.
define('UPDATE_ERR_ILLEGAL', 602);
define('DELETE_ERR', 611);
define('PARAM_ERR', 701);
define('PARAM_TYPE_ERR', 702);
define('SETTINGS_UPDATE_OK', 800);
define('SETTINGS_UPDATE_ERR', 801);
define('SETTINGS_REQUEST_ERR', 802);
define('AUTH_OK', 900);
define('AUTH_ERR', 901);
define('AUTH_ERR_CRED', 902);
define('AUTH_DENIED', 910);
define('POST_OK', 1000);
define('POST_ERR', 1001);

/* Status Code Messages */
define('MSG_QUERY_EXEC_OK',   'Query was successfuly executed.');
define('MSG_QUERY_EXEC_ERR',  'Query execution failed.');
define('MSG_FILE_UPLOAD_OK',  'File upload was successful.');
define('MSG_FILE_UPLOAD_ERR', 'File upload error.');
define('MSG_FILE_UPLOAD_ERR_MAX_SIZE', 'Exceeded maximum allowable file upload size.');
define('MSG_FILE_UPLOAD_ERR_MIME_TYPE', 'Invalid file type.');
define('MSG_FILE_UPLOAD_ERR_EXISTS', 'The file already exists.');
define('MSG_FILE_UPLOAD_VALID', 'File is valid.');
define('MSG_API_REQUEST_OK', 'Successful API request.');
define('MSG_API_REQUEST_ERR', 'Bad API request.');
?>
