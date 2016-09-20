<?php
/**
 *
 */
class Media extends Post
{
  public $source;
  function __construct($db, $id)
  {
    parent::__construct($db, $id);
    $this->source = $this-fetched_data['source'];
  }
}
 ?>
