<?php
$user = $data['user'];

require_once "includes/admin-header.php";
?>
<div class="container-fluid min-height-576">
  <div class="row content">

    <!-- Left Panel -->
    <div class="col-sm-2 sidenav">
      <?= App::get_ui_component($user, 'dashboard'); ?>
    </div>

    <!-- Right Panel -->
    <div class="col-sm-10">

      <!-- Page Header -->
      <div class="page-header">
        <h2>New Media:&nbsp;<small id="media-title"></small></h2>
      </div>

      <div>Upload area</div>

    </div><!--#end col-sm-10 (right panel) -->

  </div><!--#end .row, .content -->

</div>
<script>
  var container = document.querySelector('.container');
  var minHeight = 576;
  var newTitle = '<?= $media->title; ?>';
  document.title = "Page Edit: " + newTitle;
</script>
<?php require_once "includes/admin-footer.php"; ?>
