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
  public $media_type;
  public $mime_type;

  function __construct($db, $id)
  {
    parent::__construct($db, $id);
    $this->filename = $this->meta['filename'];
    $this->source = $this->meta['source'];
    $this->href = $this->meta['href'];
    $this->thumb = $this->meta['thumb'];
    $this->media_type = $this->meta['media_type'];
    $this->mime_type = array_pop(explode('.', $this->filename));

    # Resole mime_type to correct web format.
    switch(strtolower($this->mime_type))
    {
      # Image
      case 'jpg':
      case 'jpeg':
        $this->mime_type = 'image/jpeg';
        break;
      case 'png':
        $this->mime_type = 'image/png';
        break;
      case 'bm':
      case 'bmp':
        $this->mime_type = 'image/bmp';
        break;

      # Audio
      case 'mp3':
        $this->mime_type = 'audio/mpeg3';
        break;
      case 'wav':
        $this->mime_type = 'audio/wav';
        break;
      case 'ogg':
        $this->mime_type = (strcmp($this->media_type, 'audio') == 0)? 'audio/ogg' : 'video/ogg';
        break;

      # Video
      case 'mp4':
        $this->mime_type = 'video/mp4';
        break;
      case 'webm':
        $this->mime_type = 'video/webm';
        break;
      case 'ogv':
        $this->mime_type = 'video/ogg';
        break;
    }
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
        array_push($result, new Media($db, $row['post_id']));
    }

    return $result;
  } // end get()
}
 ?>
