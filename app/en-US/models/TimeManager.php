<?php

/**
 *
 */
class TimeManager
{
  /**
   * Returns the interval of elapsed time since the given date.
   * @param {DateTime} $then The start date of the interval.
   * @return {string} Returns a string stating in seconds, minutes, days,
   * months, or years that have elapsed since the start date.
   */
  public static function get_time_since(DateTime $then, $timezone = null)
  {
    if(!is_null($timezone))
      date_default_timezone_set($timezone);

    $now = new DateTime();
    $interval = $now->diff($then);
    $date_val = $then->format('D d m, Y');
    $year = intVal($interval->format('%y'));
    $month = intVal($interval->format('%m'));
    $day = intVal($interval->format('%d'));
    $hour = intVal($interval->format('%h'));
    $minute = intVal($interval->format('%i'));
    $second = intVal($interval->format('%s'));

    /* Fix units e.g 1 second ago vs 2 seconds ago */
    if($year == 0)  # aka same year
    {
      if($month == 0) # aka same month
      {
        if($day == 0) # aka same day
        {
          if($hour == 0) # aka same hour
          {
            if($minute == 0) # aka same minute
            {
              $date_val = ($second > 1)? $interval->format('%s seconds ago') : $data_val = $interval->format('%s second ago');
            }
            else
            {
              $date_val = ($minute > 1)? $interval->format('%i minutes ago') : $data_val = $interval->format('%i minute ago');
            }
          }
          else
          {
            $date_val = ($hour > 1)? $interval->format('%h hours ago') : $data_val = $interval->format('%h hour ago');
          }
        }
        else
        {
          $date_val = ($day > 1)? $interval->format('%d days ago') : $data_val = $interval->format('%d day ago');
        }
      }
      else
      {
        $date_val = ($month > 1)? $interval->format('%m months ago') : $data_val = $interval->format('%m month ago');
      }
    }
    else
    {
      $date_val = ($year > 1)? $interval->format('%y years ago') : $data_val = $interval->format('%y year ago');
    }


    return $date_val;
  } // end since()
}


?>
