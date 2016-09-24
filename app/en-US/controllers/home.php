<?php
/**
 * The default site controller. All requests will
 *
 * @since 0.0.1
 * @version 0.0.1
 *
 * @package Assegai
 */
class Home extends Controller
{
  /**
   * @param {string} $option Options for the home controller.
   */
  public function index($option = '')
  {
    switch ($option)
    {
      case 'login':
        App::redirect(BASEPATH . 'admin/');
        break;

      default:
        if(User::is_logged_in())
        {
          $user = $this->model('User');
          $this->view('home/index', array('user' => $user));
          // App::redirect(BASEPATH . 'browse/');
        }
        else
        {
          $user = $this->model('User');
          $this->view('home/index', array('user' => $user));
        }
        break;
    }

  } // end index()

  public function uploads()
  {
    $this->view('error/403');
  } // end uploads

} // end class Home

?>
