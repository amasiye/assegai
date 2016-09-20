<?php
/**
 *
 */
class Video extends Media
{
  public $width;
  public $height;
  public $length;
  public $autoplay;

  function __construct($db, $id)
  {
    parent::__construct($db, $id);
  } // end __construct()
}
 ?>
