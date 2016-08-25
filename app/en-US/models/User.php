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
  function __construct($params = array())
  {
    if(!empty($params))
    {
      if(array_key_exists('login', $params) && array_key_exists('db', $params))
      {
        #Bind parameters to corresponding properties
        $this->login = $params['login'];
        $this->db = $params['db'];

        # Cache user data
        $user_data = $this->db->select("assg_users", array(), array('-w'=>"user_login='{$this->login}'"))[0];

        $this->id = $user_data['user_id'];
        $this->login = $user_data['user_login'];
        $this->username = $user_data['user_name'];
        $this->password = $user_data['user_password'];
        $this->salt = $user_data['user_salt'];
        $this->joined = $user_data['user_joined'];
        $this->group = $user_data['user_group'];

        # Decode meta data JSON string
        $meta = json_decode($user_data['user_meta'], true);

        # Bind meta data to remaining properties
        $this->primary_email = $meta['primary_email'];
        $this->emails = $meta['emails'];         // An associative array of email addresses
        $this->address = $meta['address'];
        $this->phones = $meta['phones'];         // An associative array of phone numbers
        $this->preferences = $meta['preferences'];
        $this->display_name = $meta['display_name'];
      }

    }
  } // end __construct()

  public function change_password($old_password, $new_password)
  {
    $db = $this->db;
    $db->update('assg_users', array('user_password'), array($new_password));

    return false;
  } // end change_password()

  /**
   * Determines whether the user has the rights to perform
   * $action on the specific $resource given it's user_group.
   * @param {string} $action The action in question e.g register.
   * @param {string} $resource The resource
   */
  public function has_permission($permission, $resource)
  {
    $id = $this->group;
    $db = $this->db;
    $has_permission = false;

    # Get user group permissions
    $user_data = $db->select("assg_groups", array("group_permissions"), array("-w"=>"group_id='{$id}'"))[0];

    if(!empty($user_data))
    {
      $permissions = json_decode($user_data['group_permissions'], true);
      $permissions[$resource];


      # Check if the permission is allowed
      switch($permission)
      {
        case 'read':
          if(strpbrk($permissions[$resource], 'r') !== FALSE)
            $has_permission = true;
          break;
        case 'edit':
          if(strpbrk($permissions[$resource], 'e') !== FALSE)
          $has_permission = true;
          break;
        case 'delete':
          if(strpbrk($permissions[$resource], 'd') !== FALSE)
          $has_permission = true;
          break;
      }
    }

    # Report whether the permission is set.
    return $has_permission;
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
      # Cache user data in Session storage
      if(Session::login($user_data['user_id'], $user_data['user_login']))
        return json_encode(array('success' => true, 'status' => LOGIN_OK,
              'msg' => 'Login Successful.', 'href' => BASEPATH . 'dashboard/'));

      # Report error
      return json_encode(array('success' => false, 'status' => LOGIN_SESSION_ERR,
      'msg' => '<strong>Error:</strong>&nbsp;Invalid username or password.&nbsp;<u>Please try again</u>.',
      'href' => BASEPATH . 'admin/'));
    }

    # Report error
    return json_encode(array('success' => false, 'status' => LOGIN_ERR,
              'msg' => '<strong>Error:</strong>&nbsp;Invalid username or password.&nbsp;<u>Please try again</u>.',
              'href' => BASEPATH . 'admin/'));
  } // end static function login()

  /*
   * Logs the user out of the system.
   */
  public static function logout()
  {
    if(User::is_logged_in())
    {
      if(Session::logout())
        return json_encode(array('success' => true, 'status' => LOGOUT_OK,
                  'msg' => 'Logout successful.',
                  'href' => BASEPATH . 'admin/'));

      return json_encode(array('success' => false, 'status' => LOGOUT_SESSION_ERR,
                'msg' => '<strong>Error:</strong>&nbsp;Logout attempt failed.',
                'href' => BASEPATH . 'dashboard/'));
    }

    return json_encode(array('success' => false, 'status' => LOGOUT_ERR,
              'msg' => '<strong>Error:</strong>&nbsp;Logout attempt failed.',
              'href' => BASEPATH . 'dashboard/'));
  } // end logout()

  /**
   * Creates a new user given detailed information.
   * @param {string} $user_login The username for loggin in to the system.
   * @param {string} $user_password The user password for loggin in to the system.
   * @param {string} $user_name The user's proper name.
   * @param {int} $user_group The user access control group.
   * @param {string} $user_meta Further user details e.g email, phone, address etc.
   * @return {int} True upon successful user registration, false otherwise.
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
        isset($_SESSION[SESSION_USER_ID]) &&
        isset($_SESSION[SESSION_USER]) &&
        !empty($_SESSION[SESSION_USER_ID]) &&
        !empty($_SESSION[SESSION_USER]) &&
        session_status() == PHP_SESSION_ACTIVE
      )
      {
        echo "Logged in.";
        return true;
      }

    return false;
  } // end is_logged_in()
}

?>
