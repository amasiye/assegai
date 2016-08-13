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
   * @param {string} $name The user name to assign for this session
   */
  public function index($option = '')
  {

    if(user_is_logged_in())
    {
      $user = $this->model('User');
      $this->view('home/index', array('user' => $user));
      // App::redirect(BASEPATH . 'browse/');
    }
    else
    {
      if($option == 'assegai-login')
      {
        // $this->redirect('admin/');
        $this->model('User');

      }
      else
      {
        $this->view('home/index');
      }
    }

  } // end Home

}

?>
