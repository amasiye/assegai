<?php
/**
 * Audio model class. Handles all logic and persistent storage
 * for media/audio post types.
 */
class Audio extends Media
{

  function __construct($db, $id)
  {
    parent::__construct($db, $id);
  } // end __construct()
}

?>
