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
   * The default controller, i.e the dashboard
   * @param {string} $name The user name to assign for this session
   */
  public function index($name = '')
  {

    if(user_is_logged_in())
    {
      $user = $this->model('User');
      $this->view('home/index', array('user' => $user));
      // App::redirect(BASEPATH . 'browse/');
    }
    else
    {
      $this->view('login/index');
    }
  }

  public function dashboard()
  {

  }

}

?>
