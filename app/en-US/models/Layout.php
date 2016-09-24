<?php

/**
  * This class provides a structured representation of all Posts that
  * are of the type Layout. It defines methods that allow access to these
  * posts, so they can change the Layout document structure, style and
  * and content of the resultant coresponding HTML document views.
 */
class Layout extends Post
{
  /**
   * Constructs a layout.
   * @param {Database} $db The database holding the layout data.
   * @param {int} $id The layout id.
   */
  function __construct($db, $id)
  {
    parent::__construct($db, $id, 'layout');
  } // end __construct()

  /**
   * Returns an array of layouts.
   * @param {Database} $db The database that holds the layout data.
   * @param {array} $filters [Optional] The filters to apply to the query.
   * @return {array} Returns an array of layouts or QUERY_EXEC_ERR on failure.
   */
  public static function get($db, $filters = array())
  {
    $result = array();
    $where = array('where' => "post_type='layout'");
    if(!is_null($filters) && !empty($filters))
    {
      if(array_key_exists('where', $filters))
      {
        $where['where'] .= " AND " . $filters['where'];
        unset($filters['where']);
      }

      $where = array_merge($where, $filters);
    }

    if(($rows = $db->select('assg_posts', null, $where)) == QUERY_EXEC_ERR)
      return QUERY_EXEC_ERR;

    foreach($rows as $row)
    {
        array_push($result, new Layout($db, $row['post_id']));
    }

    return $result;
  } // end get()
}


?>
