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
  public static function get_time_since(DateTime $then)
  {
    $now = new DateTime();
    $interval = $now->diff($then);
    $date_val = $then->format('D d m, Y');

    if(intVal($interval->format('%y')) == 0)  # aka same year
    {
      if(intVal($interval->format('%m')) == 0) # aka same month
      {
        if(intVal($interval->format('%d')) == 0) # aka same day
        {
          if(intVal($interval->format('%h')) == 0) # aka same hour
          {
            if(intVal($interval->format('%i')) == 0) # aka same minute
            {
              $date_val = $interval->format('%s seconds ago');
            }
            else
            {
              $date_val = $interval->format('%i minutes ago');
            }
          }
          else
          {
            $date_val = $interval->format('%h hours ago');
          }
        }
        else
        {
          $date_val = $interval->format('%d days ago');
        }
      }
      else
      {
        $date_val = $interval->format('%m months ago');
      }
    }
    else
    {
      $date_val = $interval->format('%y years ago');
    }


    return $date_val;
  } // end since()
}


?>
