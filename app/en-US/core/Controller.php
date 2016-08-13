<?php

class Controller
{

  public function model($model)
  {
    global $locale;

    if(file_exists('app/' . $locale . '/models/' . $model . '.php'))
      require_once 'app/' . $locale . '/models/' . $model . '.php';

    return new $model();
  }

  public function view($view, $data = array())
  {
    global $locale;

    if(file_exists('app/' . $locale . '/views/' . $view . '.php'))
      require_once 'app/' . $locale . '/views/' . $view . '.php';

    // return new $view();
  }

  public function redirect($url)
  {
    header("Location: {$url}");
  }
}

?>
