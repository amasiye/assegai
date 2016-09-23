<?php

/**
 * This class provides a structured representation of all Posts that
 * are of the type Page. It defines methods that allow access to these
 * posts, so they can change the Page document structure, style and
 * and content of the resultant coresponding HTML document views.
 */
class Page extends Post implements iNode
{
  protected $parent = null;
  protected $children = array();

  public $head;
  public $body;
  public $template;

  /**
   * Constructs a page from the given database given its id.
   * @param {Database} $db The database containing the page.
   * @param {int} $id The page id.
   */
  function __construct($db, $id)
  {
    parent::__construct($db, $id, 'page');
    $this->template = $this->meta['template'];
    $this->parent = $this->meta['parent'];
    $this->children = json_decode($this->meta['children'], true);
  } // end __construct()

  /**
   * Adds the specified childNode argument as the last child to the current node.
   * If the argument referenced an existing node on the DOM gree, the node will
   * be detached from its current position and attached at the new position.
   */
  public function append_child(Post $child)
  {
    # Append child to children array
    array_push($this->children, $child->id);

    # Update meta array to include new value for children array
    $this->meta['children'] = $this->children;

    # Turn meta into json and update this post's meta column to reflect the change
    return $this->db->update('assg_posts', array('post_meta'), array($this->meta), array('where' => "post_id='{$this->id}'"));
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
   * @return {int} Returns an array containing all the child nodes that belong
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
}


?>
