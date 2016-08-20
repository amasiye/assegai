<?php
/**
 * @version 1.0.0
 * @since 1.0.0
 *
 * @package Assegai
 */
class User
{
  public $id = -1;
  public $login;
  public $username = 'User';
  public $password;
  public $salt;
  public $joined;
  public $group;
  public $primary_email;
  public $emails;         // An associative array of email addresses
  public $address;
  public $phones;         // An associative array of phone numbers
  public $preferences;
  public $display_name = 'Default User.';

  private $db;

  function __counstruct()
  {
  } // end __construct()

  /**
   * Logs a user into the system given login, password and an optional salt.
   * @param {Database} $db The Database object containing the login data.
   * @param {String} $login The login/username.
   * @param {String} $password The user password.
   * @return {int} Loging status or error code.
   */
  public static function login($db, $login, $password)
  {
    # Cache user data
    $user_data = $db->select("assg_users", array(), array('-w'=>"user_login='{$login}'"))[0];

    # Verify the password
    if(password_verify($password, $user_data['user_password']))
    {
      echo "Password passsed";
      return json_encode(array('success'=> true, 'status' => LOGIN_OK));
    }

    return json_encode(array('success' => false, 'status' => LOGIN_ERR));
  } // end static function login()

  /*
   * Logs the user out of the system.
   */
  public static function logout()
  {
    return true;
  } // end logout()

  /**
   * Creates a new user given detailed information.
   * @param $details Array An associative array of user information.
   * @return int True upon successful user registration, false otherwise.
   */
  public static function register
  (
    $user_login,                            //in
    $user_password,                         //in
    $user_name,                             //in
    $user_group,                            //in
    $user_meta                              //in
  )
  {
    $user_salt = AUTH_SALT;
    // $user_salt = crypt(AUTH_KEY, AUTH_SALT);
    $user_joined = date('Y-m-d H:i:s');

    # Salt not used in current implementation.
    // $hash_options = array('salt' => $user_salt);
    $hash_options = array();
    $user_password_hashed =
        password_hash($user_password, PASSWORD_BCRYPT, $hash_options);

    // var_dump(array("login" => $user_login, "password" => $user_password, "password_hashed" => $user_password_hashed,
    // "salt" => $user_salt, "name" => $user_name, "joined" => $user_joined, "group" => $user_group, "meta" => $user_meta));
    return $db->insert(
                        'assg_users',
                        array('user_login', 'user_password', 'user_salt', 'user_name', 'user_joined', 'user_group', 'user_meta'),
                        array($user_login, $user_password_hashed, $user_salt, $user_name, $user_joined, $user_group, $user_meta)
                      );
    // return 0;
  } // end static function register($details)

  public static function is_logged_in()
  {
      if
      (
        isset($_SESSION[SITE_PREFIX . 'username']) &&
        !empty($_SESSION[SITE_PREFIX . 'username'])
      )
      return true;

    return false;
  } // end is_logged_in()
}

?>
