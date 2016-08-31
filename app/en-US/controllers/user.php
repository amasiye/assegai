<?php

/**
 * The main user controller. It handles most requests between
 * the user model and views.
 */
class User extends Controller
{
  /**
   * Handles requests to/from the index file in the user
   * subdirectory of the views directory.
   * @param {string} $name
   */
  public function index($name)
  {

  } // end index()

  public function profile($login)
  {
    global $app;

    if(User::is_logged_in())
    {
      $user = $this->model('User', array('login' => $_SESSION[SESSION_USER], 'db' => $this->db));
      $this->view('user/profile', array('app' => $app, 'user' => $user));
    }
    else
    {
      # Error - Unauthorised
      $this->view('error/401');
    }
  } // end profile()
}


?>
