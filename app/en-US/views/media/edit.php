<?php
$user = $data['user'];
$media = $data['media'];

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
          <h2>Page Edit: <small><?= $media->title; ?></small></h2>
        </div>

        <?php if ((strcmp($media->media_type, 'image')) == 0): ?>
          <div class="col-sm-4">
            <img src="<?= $media->href; ?>" alt="<?= $media->title; ?>" />
          </div>
          
          <div class="col-sm-8">
            <form class="form" role="form">
              <div class="form-group">
                <label for="filename">Filename:</label>
              </div>
            </form>
          </div>
        <?php else: ?>

        <?php endif; ?>

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
