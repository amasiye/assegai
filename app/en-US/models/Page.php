<?php
/**
 * This class provides a structured representation of all Posts that
 * are of the type Page. It defines methods that allow access to these
 * posts, so they can change the Page document structure, style and
 * and content of the resulting coresponding HTML document views.
 */
class Page extends Post implements iNode
{
  protected $parent = null;
  protected $children = array();

  public $head;
  public $body;
  public $layout;
  public $styles;

  /**
   * Constructs a page from the given database given its id.
   * @param {Database} $db The database containing the page.
   * @param {integer} $id The page id.
   */
  function __construct($db, $id)
  {
    parent::__construct($db, $id, 'page');
    $this->layout = $this->meta['layout'];
    $this->parent = $this->meta['parent'];
    $this->children = json_decode($this->meta['children'], true);
  } // end __construct()

  /**
   * Adds the specified childNode argument as the last child to the current node.
   * If the argument referenced an existing node on the DOM gree, the node will
   * be detached from its current position and attached at the new position.
   * @param {Post} $child The child node to be appended to the list of children.
   * @return {integer} Returns QUERY_EXEC_OK on success, or either QUERY_EXEC_ERR or
   * PARAM_TYPE_ERR on failure.
   */
  public function append_child($child)
  {
    if(strcmp(get_class($child), 'Post') != 0)
    {
      return PARAM_TYPE_ERR;
    }

    # Append child to children array
    array_push($this->children, $child->id);

    # Update meta array to include new value for children array
    $this->meta['children'] = $this->children;

    # Turn meta into json and update this post's meta column to reflect the change
    return $this->db->update(PAGE_TABLE, array('post_meta'), array($this->meta), array('where' => "post_id='{$this->id}'"));
  } // end append_child()

  /**
   * Removes a child node from the current element, which must be a child of
   * the current node.
   * @param {iNode} $child The child node.
   * @return {boolean} Returns true if the child exists or false otherwise.
   */
  public function remove_child($child)
  {
    $result = array();
    $child_exists = false;
    $pre_length = count($this->children);

    foreach($this->children as $c)
    {
      if($c === $child)
        $child_exists = true;

      array_push($result, $c);
    }

    if($child_exists)
      $this->children = $result;

    return ($pre_length > count($this->children))? true : false;
  } // end remove_child()

  function compare_id($id)
  {

  } // end compare_id()

  /**
   * Returns an array containing all the child nodes that belong to this node.
   * @return {integer} Returns an array containing all the child nodes that belong
   * to this node.
   */
  public function get_children()
  {
    return $this->children;
  } // end get_children()

  /**
   * Sets the parent node of this node to the given node.
   * @param {iNode} $parent The new parent node.
   */
  public function set_parent($parent)
  {
    $this->parent = $parent;
  } // end set_parent()

  /**
   * Returns the parent node of this node or null if none exists.
   * @return {iNode} Returns the parent node of this node or null if none exists.
   */
  public function get_parent()
  {
    return $this->parent;
  } // end get_parent()

  /**
   * Clone a iNode, and optionally, all of its contents. By default, it clones
   * the content of the node.
   */
  public function clone_node()
  {
    return HTML::create_html_element();
  } // end  clone_node()

  /**
   * Returns an array of layouts.
   * @param {Database} $db The database that holds the layout data.
   * @param {array} $filters [Optional] The filters to apply to the query.
   * @return {array} Returns an array of layouts or QUERY_EXEC_ERR on failure.
   */
  public static function get($db, $filters = array())
  {
    $result = array();
    $where = array('where' => "post_type='page'");
    if(!is_null($filters) && !empty($filters))
    {
      if(array_key_exists('where', $filters))
      {
        $where['where'] .= " AND " . $filters['where'];
        unset($filters['where']);
      }

      $where = array_merge($where, $filters);
    }

    if(($rows = $db->select(PAGE_TABLE, null, $where)) == QUERY_EXEC_ERR)
      return QUERY_EXEC_ERR;

    foreach($rows as $row)
    {
        array_push($result, new Page($db, $row['post_id']));
    }

    return $result;
  } // end get()
}


?>
