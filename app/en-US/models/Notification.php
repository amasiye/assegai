<?php

/**
 *
 */
class Notification
{
  public $id;
  public $date;
  public $title;
  public $details;
  public $status;

  function __construct($id, $data = "")
  {
    if(!isset($data) || empty($data) || $data = null)
      $data = Notification::get($id);

    if($data !== FALSE)
    {
      $data_parsed = explode('|', $data);
      $this->id = $data_parsed[0];
      $this->date = $data_parsed[1];
      $this->title = $data_parsed[2];
      $this->details = $data_parsed[3];
      $this->status = $data_parsed[4];
    }

  } // end __construct()

  /**
   * Marks a notifaction as read i.e 1
   * @return {boolean} True if successful, false otherwise.
   */
  public function mark_as_read()
  {
    return $this->mark_as(1);
  } // end mark_as_read()

  /**
   * Marks a notifaction as unread i.e 0
   * @return {boolean} True if successful, false otherwise.
   */
  public function mark_as_unread()
  {
    return $this->mark_as(0);
  } // end mark_as_unread()

  /**
   * Marks a notifaction as read or unread i.e 1 or 0
   * @param {int} $read_status The read status of the notification.
   * @return {boolean} True if successful, false otherwise.
   */
  private function mark_as($read_status)
  {
    global $locale;
    // $id = $this->id - 1;
    $id = $this->id;
    $filename = NOTICEPATH_REL . "notifications.txt";
    $result = true;

    # Read details
    $handle = fopen($filename, "r");

    $output_str = array();

    while(!feof($handle))
    {
      $line = fgets($handle);

      # if line isn't empty grab its detailss
      if(!empty($line))
      {
        $line_bits = explode('|', $line);

        if($line_bits[0] == $id)
        $line_bits[count($line_bits) - 1] = (int)$read_status . PHP_EOL;

        array_push($output_str, implode('|', $line_bits));
      }
      // $output_str .= implode('|', $line_bits) . PHP_EOL;
    } // end $handle

    fclose($handle);

    # Open file for writting
    $handle = fopen($filename, 'w');

    # Write new details to file.
    for($x = 0; $x < count($output_str); $x++)
    {
      if(!fwrite($handle, $output_str[$x]))
        $result = false;
    }

    # Close file
    fclose($handle);

    return $result;
  } // end mark_as(int)

  /**
   * Return either all or a specific notifications
   * @param {int} $id The id of the notification to be retrieved.
   * @return {array} Either a string of data for a single notification,
   * an array of all available notifications or false on failure.
   */
  public static function get($id = 0)
  {
    $notifications = file(NOTICEPATH . 'notifications.txt');
    $id--;

    # Return specified notification if specified
    if($id > -1 && $id < count($notifications))
      return $notifications[$id];

    # otherwise return all notifications
    if($id == -1)
      return $notifications;

    return false;
  } // end get()

  /**
   * Posts a new notification.
   * @param {string} $title The name of the notification.
   * @param {string} $details The details of the notification.
   * @return {boolean} True if successful, false otherwise.
   */
  public static function post($title, $details)
  {
    $filename = NOTICEPATH_REL . 'notifications.txt';
    $notifications = file($filename);
    $result = true;

    $line = implode('|', array(count($notifications) + 1, date('Y-m-d H:i:s'), $title, $details, "0" . PHP_EOL));
    // array_push($notifications, $line);
    // var_dump($notifications);

    $handle = fopen($filename, 'a');

    # Lock the file
    if(flock($handle, LOCK_EX))
    {
      if(!fwrite($handle, $line))
        $result = false;
      # Release lock
      flock($handle, LOCK_UN);
    }
    else
    {
      $result = false;
    }

    fclose($handle);

    return $result;
  } // end post()

  /**
   * Alias of get.
   * @return {array} Either an array of all available notifications
   * or false on failure.
   */
  public static function pull()
  {
    return Notification::get();
  } // end pull()

  /**
   * Pulls all unread notifications and returns them in an array
   * @return {array} An array of notifications or false on failure.
   */
  public static function pull_unread()
  {
    if($notifications_strings = Notification::pull())
    {

      $notifications = array();

      # Break up each string into Notification data and craete
      # Notification objects array
      foreach ($notifications_strings as $notification)
      {
        $n = explode('|', $notification);

        # Check if the notification has been read
        if($n[4] == 0)
        {
          # Note ineffieciency ... notification constructor is opening
          # the notification file again even though we just accessed that
          # data. Must make more effecient later.
          $new_notification = new Notification($n[0]);
          array_push($notifications, $new_notification);
        }

      }

      return $notifications;

    }

    return false;
  } // end pull_unread()

  /**
   * An alias of post.
   * @param {string} $title The name of the notification.
   * @param {string} $details The details of the notification.
   * @return {boolean} True if successful, false otherwise.
   */
   public static function push($title, $details)
   {
     return Notification::post($title, $details);
   } // end push()
}


?>
