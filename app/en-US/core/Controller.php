<?php
/**
 * The base Controller class. It processes and responds to events such as user
 * actions and it invokes changes to the model and the view based on those
 * events.
 * @author A. Masiye
 * @version 1.0.0
 *
 * @package assegai
 */
class Controller
{

  # Each controller establishes one database conection.
  # This is more ideal than making the connection in each
  # model class since each http request consumes only one controller
  # but may utilise more than one model.
  protected $db;
  protected $session;

  /**
   * Constructs a new controller
   */
  function __construct()
  {
      global $db_host, $db_user, $db_pass, $db_name;
      $this->db = new Database($db_host, $db_user, $db_pass, $db_name);
      $this->session = new Session;
  } // end __construct()

  /**
   * Creates a new model object.
   * @param {string} The name of the model to load.
   * @return {Object} The newly created model.
   */
  public function model($model, $args = array())
  {
    global $locale;

    if(file_exists('app/' . $locale . '/models/' . $model . '.php'))
      require_once 'app/' . $locale . '/models/' . $model . '.php';

    // if(!empty($args))
    //   return new $model($args);

    return new $model($args);
  }

  /**
   * Loads a view with it's corresponding data.
   * @param {string} $view The name of the view.
   * @param {array} $data The corresponding data for the view.
   */
  public function view($view, $data = array())
  {
    global $locale;
    $db = $this->db;
    $session = $this->session;
    $layouts = Layout::get($db);
    $pages = Page::get($db);
    // var_dump($pages); exit;

    # Set the site timezone
    date_default_timezone_set(SITE_TIMEZONE);

    if(file_exists('app/' . $locale . '/views/' . $view . '.php'))
      require_once 'app/' . $locale . '/views/' . $view . '.php';

    // return new $view();
  } // end view()

  /**
   * Validates a given input string of text.
   * @param {string} $text The string of text.
   * @param {string} $pattern The validating regex pattern.
   * @param {int} $min_length The minimum length of the string.
   * @param {int} $max_length The maximum length of the password.
   * @return {int} Returns 1 if the pattern matches given subject, 0 if it does not, or FALSE if an error occurred.
   */
  public function validate_text($text, $pattern = '/[\w\d]+/', $min_length = 6, $max_length = -1)
  {
    if($max_length < 0)
      return Form::validate_input('text', $text, $pattern, $min_length);

    return Form::validate_input('text', $text, $pattern, $min_length, $max_length);
  } // end validate_input_text()

  /**
   * Validates a given input string of text.
   * @param {string} $password The input password string.
   * @param {string} $pattern The validating regex pattern.
   * @param {int} $min_length The minimum length of the password
   * @param {int} $max_length The maximum length of the password
   * @return {int} Returns 1 if the pattern matches given subject, 0 if it does not, or FALSE if an error occurred.
   */
  public function validate_password($password, $pattern = '/[\w\d]+/', $min_length = 6, $max_length = -1)
  {
    # Check for at least 1 uppercase alphabetical character
    if(!preg_match('/[A-Z]/', $password))
      return false;

    # Check for at least 1 numerical character
    if(!preg_match('/[0-9]/', $password))
      return false;

    if($max_length < 0)
      return Form::validate_input('password', $password, $pattern, $min_length);

    return Form::validate_input('password', $password, $pattern, $min_length, $max_length);
  } // end validate_input_text()

  /**
   * Modifies the header location attribute by setting it to the given URL
   * string.
   * @param {string} $url The URL string.
   */
  public static function redirect($url)
  {
    header("Location: {$url}");
  }
}

?>
