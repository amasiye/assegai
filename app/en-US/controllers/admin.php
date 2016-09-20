<?php
/**
 * The main controller for site administration and management requests.
 *
 * @since 0.0.1
 * @version 0.0.1
 *
 * @package Assegai
 */
class Admin extends Controller
{
  /**
   * The default endpoint, i.e the dashboard
   * @param {string} $params The user name to assign for this session
   */
  public function index($params = '')
  {
    global $app;

    if(User::is_logged_in())
    {
      $user = $this->model('User', array('login' => $_SESSION[SESSION_USER], 'db' => $this->db));
      $this->view('dashboard/index', array('app' => $app, 'user' => $user));
    }
    else
    {
      $user = $this->model('User', array('login' => 'Admin', 'db' => $this->db));
      $this->view('login/index', array('app' => $app, 'user' => $user));
    }
  } // end index()

  /**
   * Displays user profile information.
   * @param {array} $params The parameter list.
   */
  public function profile($params = '')
  {
    if(User::is_logged_in())
    {
      $user = $this->model('User', array('login' => $_SESSION[SESSION_USER], 'db' => $this->db, 'app' => $params['app']));
      $this->view('user/profile', array('app' => $params['app'], 'user' => $user));
    }
    else
    {
      # Error - Unauthorised
      $this->view('error/401');
    }
  } // end profile()

  public function pages($params = '')
  {
    if(User::is_logged_in())
    {
      // var_dump($params);
      // print_r($params['app']);
      $user = $this->model('User', array('login' => $_SESSION[SESSION_USER], 'db' => $this->db, 'app' => $params['app']));
      $this->view('pages/index', array('app' => $params['app'], 'user' => $user));
    }
    else
    {
        $this->view('error/403');
    }
  } // end edit()

}

?>
