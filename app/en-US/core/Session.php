<?php

/**
 * This is a wrapper class for all Session activity.
 *
 * @author A. Masiye
 * @version 1.0.0
 * @since 1.0.0
 */
class Session
{

  public $id;
  public $user_id;

  function __construct()
  {
    $this->id = session_id();

    if(isset($_SESSION[SESSION_USER]))
      $this->user_id = $_SESSION[SESSION_USER];
  }

  /**
   * @param {string} $id The corresponding user id.
   * @param {string} $login The username for logging in to the system.
   *
   * @return {boolean} True if successful, false otherwise.
   */
  public static function login($id, $login)
  {
    $_SESSION[SESSION_USER_ID] = $id;
    $_SESSION[SESSION_USER] = $login;
    // $this->$user_id = $_SESSION[SESSION_ID];

    return true;
  } // end login(string, string)

  /**
   * @param {boolan} $unset_all Indicates whether all session variables should
   * be unset before logging the user out.
   *
   * @return {boolean} True if successful, false otherwise.
   */
  public static function logout($unset_all = false)
  {
    # Remove all session variables
    if($unset_all)
      session_unset();

    # Destroy the session
    return session_destroy();
  }

  /**
   * Sets the session variable of the given name to the given value.
   * @param {string} $name The name of the Session variable.
   * @param {string} $value The value of the Session variable.
   */
  public static function put($name, $value)
  {
    return $_SESSION[$name] = $value;
  }

} // end Session

?>
