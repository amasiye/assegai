<?php

/**
 * This class provides a structured representation of any event or
 * activity occuring on the website and provides methods for documenting,
 * inspecting, reporting and storing such information.
 */
class Activity
{
  public $who;
  public $what;
  public $when;

  protected $db;

  /**
   * Constructs an activty.
   * @param {$db} $db The database where the activity data is held.
   * @param {int} $who The id of the activity author.
   */
  function __construct($db, $who)
  {
    $this->db = $db;
    $result = $db->select('assg_activities', null, array('where' => "activity_author='{$who}'"))[0];

    $this->who = $result['activity_who'];
    $this->what = $result['activity_what'];
    $this->when = $result['activity_when'];
  }

  /**
   * Creates and activity stating the author and the action.
   * @param {Database} $db The database where the activity data will be logged.
   * @param {int} $who The user id of the author.
   * @param {string} $what The action performed.
   */
  public static function create($db, $who, $what)
  {
    return $db->insert('assg_activities', array('activity_who', 'activity_what'), array($who, $what));
  } // end create();

  /**
   * Returns an array of activities given the author and/or the action.
   * @param {Database} $db The database where the activites are held.
   * @param {int} $who The user id of the author.
   * @param {string} $what The action performed.
   * @return {array} Returns an array of activites given the author and/or
   * action. Returns QUERY_EXEC_ERR if an error occured.
   */
  public static function get($db, $who = -1, $what = '')
  {
    $filters = array();

    if($who > 0)
      $filters['where'] = "activity_who={$who}";

    if(!empty($what))
    {
      if(!empty($filters)) $filters .= " AND"
      $filters .= " activity_what='{$what}'" ;
    }

    return $db->select('assg_activities', null, $filters);
  } // end read()

  /**
   * Deletes activites with authors corresponding to the given user id
   * and actions corresponding to the given action.
   * @param {Database} $db The database where the activity data is held.
   * @param {int} $who The user id of the activity author.
   * @param {string} $what The action performed by the given user.
   * @param {array} $filters [Optional] Any extra filters.
   * @return {int} Returns QUERY_EXEC_OK if successful, otherwise returns
   * DELETE_ERR if the parameters were invalid or QUERY_EXEC_ERR if anything
   * else went wrong.
   */
  public static function delete($db, $who, $what, $filters = array())
  {
    $f = array('where' = "activity_who={$who} AND activity_what='{$whate}'");
    if(!empty($filters))
      array_merge($f, $filters);

    return $db->delete('assg_activities', $f);
  } // end delete()

}


?>
