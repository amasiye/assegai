<?php

/**
 * Contains useful methods for debugging, tracing and profiling.
 */
class Debug
{

  /**
   * Writes log data to the log file.
   * @param {string} $txt The log data or text.
   */
  public static function log_to_file($txt)
  {
    $handle = fopen(LOGPATH, "a");

    $log_txt = date("Y-m-d H:i:s") . " " . txt
              . "----------------------------------" . PHP_EOL;
              
    if(fwrite($handle, $log_txt) === TRUE)
    {
      fclose($handle);
      return FILE_WRITE_OK;
    }

    fclose($handle);

    return FILE_WRITE_ERR;
  } // end log_to_file(string)

} // end Debug


?>
