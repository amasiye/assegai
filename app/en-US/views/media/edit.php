<?php
$user = $data['user'];
$media = $data['media'];

require_once "includes/admin-header.php";
?>
  <div class="container-fluid min-height-576">
    <div class="row content">

      <!-- Left Panel -->
      <div class="col-sm-2 sidenav">
        <?= App::get_ui_component($db, $user, 'dashboard'); ?>
      </div>

      <!-- Right Panel -->
      <div class="col-sm-10">
        <!-- Page Header -->
        <div class="page-header">
          <h2>Page Edit: <small><?= $media->title; ?></small></h2>
        </div>

        <?php if ((strcmp($media->media_type, 'image')) == 0): ?>
          <div class="col-sm-3">
            <div class="panel">
              <img class="img-responsive" src="<?= $media->href; ?>" alt="<?= $media->title; ?>">
            </div>
            <button class="btn btn-block" type="button" name="image-edit">Upload New</button>
          </div>

          <div class="col-sm-9">
            <form class="form" role="form">

              <!-- File Name -->
              <div class="form-group">
                <label for="filename">Filename:</label>
                <p><?= $media->filename; ?></p>
              </div>

              <!-- Permalink -->
              <div class="form-group">
                <label for="href">Permalink:</label>
                <p><?= BASEPATH . $media->href; ?></p>
              </div>

              <!-- MIME Type -->
              <div class="form-group">
                <label for="mime-type">MIME Type:</label>
                <p><?= $media->mime_type; ?></p>
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
