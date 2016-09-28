<?php

/**
 * Model class for semon posts.
 */
class Sermon extends Post
{

  function __construct($db, $id)
  {
    parent::__construct($db, $id, 'sermon');
  }

  public static function get()
  {

  } // end static function get()
}


?>
