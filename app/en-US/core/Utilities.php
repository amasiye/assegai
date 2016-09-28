<?php
/**
 * This file contains some usefull free functions that wouldn't make
 * sense belonging to any class files.
 *
 * @package Assegai
 * @version 1.0.0
 * @since 1.0.0
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


/* --   String Functions    -- */

/**
 * Returns the last letter of the given string.
 * @param {string} $str The string in question.
 * @return {string} Returns the last letter of the given string.
 */
function last_letter($str)
{
  return substr($str, -1);
} // end last_letter()

/**
 * Replaces a key within an array with some other key.
 * @param {string} $find The original array key.
 * @param {string} $replace The replacement array key.
 * @param {array} $array The array to be searched.
 * @return {array} Returns an array with the replaced key or false on failure.
 */
function key_replace($find, $replace, $array)
{
  if(key_exists($find, $array))
  {
    $keys = array_keys($array);
    $keys = str_replace($find, $replace, $keys);
    # replace keys in array
    $new_array = array();
    foreach ($keys as $index => $key)
    {
      $new_array[$key] = array_shift($array);
    }

    return $new_array;
  }

  return false;
} // end key_replace()

/**
 * Compares two string for equality.
 * @param {string} $str1 The first string.
 * @param {string} $str The second string.
 * @return {booelan} Returns true if the strings are equal or false if they are not.
 */
function streq($str1, $str2)
{
  return (strcmp($str1, $str2) == 0)? true : false;
} // end streq()

?>
