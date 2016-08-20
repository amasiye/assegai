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
  public $group = -1;
  public $primary_email;
  public $emails;         // An associative array of email addresses
  public $address;
  public $phones;         // An associative array of phone numbers
  public $preferences;
  public $display_name = 'Default User.';

  private $db;

  /**
   * Constructs a user object.
   * @param {array} $params The list of parameters.
   */
  function __counstruct($params = array())
  {
    if(!empty($params))
    {
      if(array_key_exists('login') && array_key_exists('db'))
      {
        #Bind parameters to corresponding properties
        $this->login = $params['login'];
        $this->db = $params['db'];

        # Cache user data
        $user_data = $db->select("assg_users", array(), array('-w'=>"user_login='{$login}'"))[0];

        $id = $user_data['user_id'];
        $login = $user_data['user_login'];
        $username = $user_data['user_name'];
        $password = $user_data['user_password'];
        $salt = $user_data['user_salt'];
        $joined = $user_data['user_joined'];
        $group = $user_data['user_group'];

        # Decode meta data JSON string
        $meta = json_decode($user_data['user_meta']);

        # Bind meta data to remaining properties
        $primary_email = $meta['primary_email'];
        $emails = $meta['emails'];         // An associative array of email addresses
        $address = $meta['address'];
        $phones = $meta['phones'];         // An associative array of phone numbers
        $preferences = $meta['preferences'];
        $display_name = $meta['display_name'];
      }

    }
  } // end __construct()

  public function change_password()
  {

  } // end change_password()

  /**
   * Determines whether the user has the rights to perform
   * $action on the $target given it's user_group.
   * @param {string} $action The action in question e.g register.
   * @param {string} $target The target
   */
  public function has_permission($action, $target)
  {
    return false;
  } // end has_permission($permission)

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
   * @param {string} $user_login  User login name (a.k.a Username)
   * @param {string} $user_password The user password.
   * @param {string} $user_name The user's proper name.
   * @param {int} $user_group The
   * @param {string} $user_meta
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

  public static function deregister($user_login, User $user)
  {
    # Check user credentials
    return false;
  } // end deregister(string, User)

  /**
   *
   */
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
