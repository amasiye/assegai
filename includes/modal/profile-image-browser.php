<?php
$image_dir = RESPATH . 'images/';
$directory = scandir('uploads/images/1/');
$count = count($directory);
$gallery = "<div class='scroll-vertical height-320'>";
$img_count = 1;
for($x = 2; $x < $count; $x++)
{
  // if(($img_count % 4) == 1) $gallery .= "<div class='row'>";

  $gallery .= "<div class='col-xs-6 col-md-3'>
    <a href='#' class='thumbnail'>
      <img src='" . BASEPATH . "/uploads/images/1/" . $directory[$x] . "' class='img-thumbnail' alt='Image " . $directory[$x] . "'>
    </a>
  </div>";
  //
  // if(($img_count % 4) == 1) $gallery .= "</div>";
  // $img_count++;
}

$gallery .= "</div>";
// for($x = 2; $x < 32; $x++)
// {
//   //$gallery .= "<img src='" . BASEPATH . "uploads/images/1/" . $directory[$x] . "' class='img-thumbnail' alt='Profile" . $directory[$x] . "'>";
//   if($img_count == 0) $gallery .= "<div class='row'>";
//   $gallery .= "<div class='col-xs-6 col-md-3'>
//                   <a href='#' class='thumbnail'>
//                     <img src='" . BASEPATH . "uploads/images/1/" . $directory[$x] . "' alt='Profile" . $directory[$x] . "'>
//                   </a>
//                 </div>";
//   if($img_count == 5)
//   {
//     "</div>";
//     $img_count = 0;
//   }
//   else
//   {
//     $img_count++;
//   }
// }
?>
<div id="user-profile-picture-browser" class="modal-content">
  <div class="modal-header">
    <h4 class="modal-title">Choose a Picture</h4>
  </div>
  <div class="modal-body">
    <?php echo $gallery; ?>
  </div>
  <div class="modal-footer">
    <input type="hidden" name="api-key" id="api-key" class="form-control" value="<?= $data['app']->get_api_key(); ?>">
    <button type="button" class="btn btn-info" name="btn-profile-save">Save</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
  </div><!-- #end modal-footer -->
</div>
