<?php

# Ensure there is a database object
if(is_null($db))
{
  # Load Config class just incase
  require_once "core/Config.php";

  $db = new Database($db_host, $db_user, $db_pass, $db_name);
}

# Mandatory fields
$user_login = $_POST['username'];
$user_password = $_POST['password'];
$user_name = $_POST['name'];

if(
  isset($user_login) &&
  isset($user_password) &&
  isset($primary_email) &&
  !empty($user_login) &&
  !empty($user_password) &&
  !empty($primary_email)
)
{

  /** Optional fields **/
  # Address
  (isset($_POST['address']) && !empty($_POST['address']))?
            $address = $_POST['address'] : $address = "";

  # Phone numbers
  (isset($_POST['phone']) && !empty($_POST['phone']))?
            $phones = $_POST['phone'] : $phones = "";

  # Preferences
  (isset($_POST['preferences']) && !empty($_POST['preferences']))?
            $preferences = $_POST['preferences'] : $preferences = "";

  # Emails
  (isset($_POST['emails']) && !empty($_POST['emails']))?
            $emails = $_POST['emails'] : $emails = "";

  # Display Name
  (isset($_POST['display-name']) && !empty($_POST['display-name']))?
            $display_name = $_POST['display_name'] : $display_name = $user_name;

  # User group
  (isset($_POST['group']) && !empty($_POST['group']))?
            $user_group = Group::get_group_id($_POST['group']) : $user_group = Group::get_group_id($db);

  $user_meta = json_encode(
                      array(
                            'primary_email' => $primary_email,
                            'emails' => $emails,
                            'address' => $address,
                            'phones' => $phones,
                            'preferences' => $preferences,
                            'display_name' => $display_name
                          )
                    );

  echo User::register(
                        $db,
                        $user_login,                            //in
                        $user_password,                         //in
                        $user_name,                             //in
                        $user_group,                            //in
                        $user_meta                              //in
                     );
}
else
{
  echo json_encode(array('success' => false, 'status' => API_REQUEST_ERR, 'msg' => '<b>Error:</b>&nbsp;A username, password and email must be provided.'));
}
?>
