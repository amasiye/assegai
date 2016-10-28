<?php
/**
 * The user model class. Handles the business logic of all
 * user related requests and operations and provides an
 * interface to the user table of the database.
 *
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
  public $group_name = '';
  public $meta;
  public $primary_email;
  public $emails;         // An associative array of email addresses
  public $address;
  public $phones;         // An associative array of phone numbers
  public $preferences;
  public $display_name = 'Default User';
  public $profile_image = BASEPATH . RESPATH . 'images/default-profile.jpg';
  public $error;

  private $db;
  private $app;

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
        if(array_key_exists('app', $params))
          $this->app = $params['app'];

        # Cache user data
        $user_data = $this->db->select(USERS_TABLE, array(), array('where'=>"user_login='{$this->login}'"))[0];
        // var_dump($user_data); exit;
        $this->id = $user_data['user_id'];
        $this->login = $user_data['user_login'];
        $this->username = $user_data['user_name'];
        $this->password = $user_data['user_password'];
        $this->salt = $user_data['user_salt'];
        $this->joined = $user_data['user_joined'];
        $this->group = $user_data['user_group'];
        $this->group_name = Group::get_group_name($this->db, $this->group);

        # Decode meta data JSON string
        $this->meta = json_decode($user_data['user_meta'], true);

        # Bind meta data to remaining properties
        $this->primary_email = $this->meta['primary_email'];
        $this->emails = $this->meta['emails'];         // An associative array of email addresses
        $this->address = $this->meta['address'];
        $this->phones = $this->meta['phones'];         // An associative array of phone numbers
        $this->preferences = $this->meta['preferences'];
        $this->display_name = $this->meta['display_name'];

      }

    }
  } // end __construct()

  /**
   * Updates the specified user details.
   * @param {array} $columns The user columns to update.
   * @param {array} $values The new values.
   * @return {boolean} True if successful, false otherwise.
   */
  public function update($columns = array(), $values = array())
  {
    $db = $this->db;
    /* This array is the one supplied to the Database->update() method */
    $stmt_columns = array();
    $update_session_login = false;

    # Check for keys and convert to appropriate database column/field name
    # Login
    if(in_array('login', $columns))
    {
      $stmt_columns[array_search('login', $columns)] = 'user_login'; // Match the $column keys with the $stmt_columns
      $update_session_login = true;
    }

    # Username
    if(in_array('username', $columns))
      $stmt_columns[array_search('username', $columns)] = 'user_name';

    # Group
    if(in_array('group', $columns))
      $stmt_columns[array_search('group', $columns)] = 'user_group';

    # Group
    if(in_array('meta', $columns))
      $stmt_columns[array_search('meta', $columns)] = 'user_meta';

    # Call update
    $result = $db->update(USERS_TABLE, $stmt_columns, $values, array("-w" => "user_id='{$this->id}'"));

    if($result == QUERY_EXEC_OK)
    {
      // if($update_session_login && App::get_api_key_author($db, ))
      //   $_SESSION[SESSION_USER] =
      return true;
    }

    # Report if any errors
    $this->error = $result;

    return false;
  } // end update()

  /**
   * Changes the user's password.
   * @param {string} $old_password The old user password.
   * @param {string} $new_password The new user password.
   * @return {boolean} True if password change is successful, false otherwise.
   */
  public function change_password($old_password, $new_password)
  {
    $db = $this->db;

    # Cache user data
    $user_data = $db->select(USERS_TABLE, array(), array('-w'=>"user_login='{$this->login}'"))[0];

    # Verify the password
    if(password_verify($old_password, $user_data['user_password']))
    {
      # No salt in current implementation
      $hash_options = array();
      $user_password_hashed =
          password_hash($new_password, PASSWORD_BCRYPT, $hash_options);

      if($db->update(USERS_TABLE, array('user_password'), array($user_password_hashed),
                      array('-w'=>"user_id='{$this->id}'")) == QUERY_EXEC_OK)
      {
        return true;
      }

      return false;
    }

    return false;
  } // end change_password()

  /**
   * Determines whether the user has the rights to perform
   * $action on the specific $resource given their user_group.
   * @param {string} $action The action in question e.g register.
   * @param {string} $resource The resource.
   * @return {boolean} True if persmission exists, false otherwies.
   */
  public function has_permission($action, $resource)
  {
    $id = $this->group;
    $db = $this->db;
    $has_permission = false;

    # Get user group permissions
    $user_data = $db->select("assg_groups", array("group_permissions"), array("-w"=>"group_id='{$id}'"))[0];

    if(!empty($user_data))
    {
      $permissions = json_decode($user_data['group_permissions'], true);

      # Break out if the the permission is not defined.
      if(!key_exists($resource, $permissions))
        return false;

      # Check if the action is allowed
      switch($action)
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
   * Returns the display name of the site administrator.
   * @return {string} Return the display name of the site administrator.
   */
  public function admin_name()
  {
    $db = $this->db;
    return $db->select(USERS_TABLE, array('display_name'), array('where' => "user_login='Admin'"))[0]['display_name'];
  } // end admin_name()

  /**
   * Returns an array of all user records in the database.
   * @return {array} An associative array containing all user records.
   */
  public static function get_users($db, $filters = array())
  {
    return $db->select(USERS_TABLE, null, $filters);
  } // end get_users()

  /**
   * Logs a user into the system given login, password and an optional salt.
   * @param {Database} $db The Database object containing the login data.
   * @param {String} $login The login/username.
   * @param {String} $password The user password.
   * @return {string} JSON string - success (boolean), status (int),
   * msg (string), href (string)
   */
  public static function login($db, $login, $password)
  {
    # Cache user data
    $user_data = $db->select(USERS_TABLE, array(), array('-w'=>"user_login='{$login}'"))[0];

    # Verify the password
    if(password_verify($password, $user_data['user_password']))
    {
      # Cache user data in Session storage
      if(Session::login($user_data))
        return json_encode(array('success' => true, 'status' => LOGIN_OK,
              'msg' => 'Login Successful.', 'href' => BASEPATH . 'admin/dashboard/'));

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

  /**
   * Logs the user out of the system.
   * @return {string} JSON string - success (boolean), status (int),
   * msg (string), href (string)
   */
  public static function logout()
  {
    if(User::is_logged_in())
    {
      // if(false)
      if(Session::logout())
        return json_encode(array('success' => true, 'status' => LOGOUT_OK,
                  'msg' => 'Logout successful.',
                  'href' => BASEPATH . 'admin/?loggedout=1'));

      return json_encode(array('success' => false, 'status' => LOGOUT_SESSION_ERR,
                'msg' => '<strong>Error ' . LOGOUT_SESSION_ERR . ': </strong>&nbsp;Logout session reset failed.',
                'href' => BASEPATH . 'dashboard/'));
    }

    return json_encode(array('success' => false, 'status' => LOGOUT_ERR,
              'msg' => '<strong>Error ' . LOGOUT_ERR . ': </strong>&nbsp;Logout attempt failed.',
              'href' => BASEPATH . 'dashboard/'));
  } // end logout()

  /**
   * Creates a new user given detailed information.
   * @param {string} $user_login The username for loggin in to the system.
   * @param {string} $user_password The user password for loggin in to the system.
   * @param {string} $user_name The user's proper name.
   * @param {int} $user_group The user access control group.
   * @param {string} $user_meta Further user details e.g email, phone, address etc.
   * @return {int} An integer corresponding to a status code.
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
                        USERS_TABLE,
                        array('user_login', 'user_password', 'user_salt', 'user_name', 'user_joined', 'user_group', 'user_meta'),
                        array($user_login, $user_password_hashed, $user_salt, $user_name, $user_joined, $user_group, $user_meta)
                      );
    // return 0;
  } // end static register()

  /**
   * Deregisters a user from the system given a user_login name.
   * @param {Database} $db The database object for connection purposes.
   * @param {string} $user_login The login name of the user to be deregistered.
   * @param {string} $auth_login The authorising username.
   * @param {string} $auth_password The authorising password.
   * @return {boolean} Returns true if deregistration was successful or false if unsuccessful.
   */
  public static function deregister($db, $user_login, $auth_login, $auth_password)
  {
    # Check user credentials
    $user_data = User::get_users($db, array('-w'=>"user_login='{$auth_login}'"))[0];

    if(password_verify($auth_password, $user_data['user_password']))
    {
      # Perform deletion
      if($db->delete(USERS_TABLE, array('-w'=>"user_login='User'")) === QUERY_EXEC_OK)
      {
        return true;
      }
    }

    return false;
  } // end deregister(string, User)

  /**
   * Determines whether any user is logged in.
   * @return {boolean} True if a user session exists, otherwise false.
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
        // echo "Logged in.";
        return true;
      }

    return false;
  } // end is_logged_in()

  /**
   * Checks the database for a given login name.
   * @param {Database} $db The database containing the user login information.
   * @param {string} $login The login name.
   * @return {boolean} Returns true if the name exists or false if it doesn't.
   */
  public static function login_name_exists($db, $login)
  {
    $result = $db->select(USERS_TABLE, array('user_login'), array("-w" => "user_login='{$login}'"))[0];

    if(!empty($result) && strcmp($result['user_login'], $login) == 0)
      return true;

    return false;
  } // end login_name_exists()

  /**
   * Determines whether the user is an Administrator.
   * @return {boolean} Returns true if the user is an Administrator or false if they are not.
   */
  public static function is_admin($db, $login)
  {
    $group_id = $db->select(USERS_TABLE, array('user_group'), array("where" => "user_login='{$login}'"))[0]['user_group'];
    $group_name = Group::get_group_name($db, $group_id);
    if(strcmp($group_name, "Administrator") == 0)
      return true;

    return false;
  } // end is_admin()

  /**
   * Returns an array of users. If the $filters paramater is ommited, returns
   * all the users in the database.
   * @param {Database} $db The database containing the users.
   * @param {array} $filters The filters to apply to the database query.
   * @return {array} Returns an array of users given $filters or QUERY_EXEC_ERR
   */
  public static function get($db, $filters = array())
  {
    $result = array();

    if(($rows = $db->select(USERS_TABLE, null, $filters)) == QUERY_EXEC_ERR)
      return QUERY_EXEC_ERR;

    foreach($rows as $column)
    {
      array_push($result, $column);
    }

    return $result;
  } // end get()

  /**
   * Returns the dispaly name of a user given their user id.
   * @param {Database} $db The database containing the user.
   * @param {int} $id The user id.
   * @return {string} Returns the display name given user or QUERY_EXEC_ERR
   */
  public static function get_display_name($db, $id)
  {
    if(($row = User::get($db, array('where' => "user_id='{$id}'"))) == QUERY_EXEC_ERR)
      return QUERY_EXEC_ERR;
    return json_decode($row[0]['user_meta'], true)['display_name'];
  } // end get_display_name()

}

?>
