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

  /**
   * Constructs a new controller
   */
  function __construct()
  {
      global $db_host, $db_user, $db_pass, $db_name;
      $this->db = new Database($db_host, $db_user, $db_pass, $db_name);
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

    if(!empty($args))
      return new $model($args);

    return new $model();
  }

  /**
   * Loads a view with it's corresponding data.
   * @param {string} $view The name of the view.
   * @param {array} $data The corresponding data for the view.
   */
  public function view($view, $data = array())
  {
    global $locale;

    if(file_exists('app/' . $locale . '/views/' . $view . '.php'))
      require_once 'app/' . $locale . '/views/' . $view . '.php';

    // return new $view();
  }

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
