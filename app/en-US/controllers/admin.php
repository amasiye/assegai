<?php
/**
 * The default site controller. All requests will
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
   * @param {string} $name The user name to assign for this session
   */
  public function index($name = '')
  {
    if(User::is_logged_in())
    {
      $user = $this->model('User', 'login' => $_SESSION['u_login']);
      $this->view('dashboard/index', array('user' => $user));
    }
    else
    {
      global $app;
      // $db = new Database('127.0.0.1', 'root', '', 'assegai');
      $user = $this->model('User');
      $this->view('login/index', array('app' => $app, 'user' => $user, 'db' => $this->db));
    }
  }

  public function dashboard()
  {

  }

}

?>
