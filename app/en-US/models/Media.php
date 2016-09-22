<?php
/**
 *
 */
class Media extends Post
{
  public $filename;
  public $source;
  public $href;
  public $thumb;

  function __construct($db, $id)
  {
    parent::__construct($db, $id);
    $this->filename = $this->meta['filename'];
    $this->source = $this->meta['source'];
    $this->href = $this->meta['href'];
    $this->thumb = $this->meta['thumb'];
  } // end __construct()

  /**
   * Returns an array of media items. If filters is not set returns all media
   * items in the database.
   * @param {Database} $db The database holding the media items.
   * @param {array} $filters The filters to apply to the databse query.
   */
  public static function get($db, $filters = null)
  {
    $result = array();
    $where = array('where' => "post_type='media'");
    if(!is_null($filters) && !empty($filters))
      $where = array_merge($where, $filters);

    if(($rows = $db->select('assg_posts', null, array('where' => "post_type='media'"))) == QUERY_EXEC_ERR)
      return QUERY_EXEC_ERR;

    foreach($rows as $row)
    {
        array_push($result, new Media($db, $row['post_id']));
    }

    return $result;
  } // end get()
}
 ?>
