<?php
/**
 * Image model class. Handles all logic and persistent storage
 * for media/image post types.
 */
class Image extends Media
{

  function __construct($db, $id)
  {
    parent::__construct($db, $id);
  } // end __construct()
}

?>
