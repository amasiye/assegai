<?php
/**
 * 
 */
class HTML
{
  
  function __construct()
  {
    # code...
  }

  public static function print_page_header($txt)
  {
    $display_block = "<header><h3>{$txt}</h3></header>";

    echo $display_block;
  }
}
?>