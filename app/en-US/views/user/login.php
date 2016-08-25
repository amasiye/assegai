<?php
$db = $data['db'];
$user_login = $_POST['username'];
$user_password = $_POST['password'];

if(
  isset($user_login) &&
  isset($user_password) &&
  !empty($user_login) &&
  !empty($user_password)
)
{
  echo User::login($db, $user_login, $user_password);
}
else
{
  echo json_encode(array('success' => false, 'status' => API_REQUEST_ERR, 'msg' => '<b>Error:</b>&nbsp;Both a username and password must be provided.'));
}
?>
