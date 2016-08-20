<?php
$user_login = $_POST['username'];
$user_password = $_POST['password'];

if(
  isset($user_login) &&
  isset($user_password) &&
  !empty($user_login) &&
  !empty($user_password)
)
{
  $db = $data['db'];
  echo User::login($db, $user_login, $user_password);
}
else
{
  return json_encode(array('succes' => false, 'status' => API_REQUEST_ERR));
}
?>
