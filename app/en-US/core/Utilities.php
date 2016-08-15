<?php
/**
 * This file contains some usefull free functions that wouldn't make
 * sense belonging to any class files.
 *
 * @package assegai
 */

/**
 * Empties out an array.
 *
 * @param &$a The array to empty;
 * @return N/A
 * @pre An array of size > 0 is passed to the function.
 * @post All elements of the array have been removed.
 */
function array_empty(Array &$a)
{
  $size = count($a);

  for($x = 0; $x < $size; $x++)
  {
    array_pop($a);
  }
}

?>
