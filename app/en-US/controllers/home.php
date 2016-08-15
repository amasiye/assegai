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

    if(User::is_logged_in())
    {
      $user = $this->model('User');
      $this->view('home/index', array('user' => $user));
      // App::redirect(BASEPATH . 'browse/');
    }
    else
    {
      if($option == 'assegai-login' || $option == 'admin')
      {
        // $this->redirect('admin/');
        $this->model('User');

      }
      else
      {
        $user = $this->model('User');
        $this->view('home/index', array('user' => $user));
      }
    }

  } // end index(string)

} // end class Home

?>
