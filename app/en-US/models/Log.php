<?php

/**
 *
 */
class Log
{
  private $filename;
  private $handle;

  function __construct($filename)
  {
    $this->filename = $filename;
    $this->open();
  } // end __construct()

  /* Opens the log file. */
  function open()
  {
    $this->handle = fopen($this->filename, 'a') or die("Can't open {$this->filename}.");
  } // end open()

  /**
   * Writes the given note to the log file.
   * @param {string} $note The string of text to be logged.
   */
  function write($note)
  {
    fwrite($this->handle, "{$note}" . PHP_EOL);
  } // end write()

  /**
   * Returns the contents of the log file as a string.
   * @return {string} Returns the contents of the log file as a string.
   */
  function read()
  {
    return join('', file($this->filename));
  } // end read()

  /* Called during unserialization */
  function __wakeup()
  {
    $this->open();
  } // end __wakeup()

  /* Called during serialization */
  function __sleep()
  {
    # Write information to the account file
    fclose($this->handle);

    return array("filename");
  } // end __sleep()

}


?>
