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
          <h2>Media: <small><?= ucwords(SITE_NAME); ?></small>
            <a href="#" class="pull-right"><span class="glyphicon glyphicon-plus-sign"></span></a>
          </h2>
        </div>

        <!-- Toolbar -->

        <!-- Media Items -->
        <table class="table table-bordered">
          <tr>
            <th class="col-sm-1">
              <input type="checkbox" name="media-select-all" id="media-select-all-top">
            </th>
            <th class="col-sm-7">File</th>
            <th class="col-sm-2">Author</th>
            <th class="col-sm-2">Modified</th>
          </tr>

          <?php for($x = 0; $x < count($media); $x++) { ?>
          <tr>
            <td>
              <input type="checkbox" name="media-select-{$x}" id="media-select-{$x}">
            </td>
            <td>
              <div class="media">
                <div class="media-left">
                  <a href="#">
                    <img src="<?= $media[$x]->thumb; ?>" class="media-object" alt="<?= $media[$x]->title; ?>" width="64">
                  </a>
                </div>
                <div class="media-body">
                  <h4 class="media-heading"><?= $media[$x]->title; ?></h4>
                  <p><?= $media[$x]->filename; ?></p>
                </div>
              </div>
            </td>
            <td><?= $media[$x]->author_name; ?></td>
            <td><?= TimeManager::get_time_since(new DateTime($media[$x]->modified)); ?></td>
          </tr>
          <?php } ?>
          <tr>
            <th>
              <input type="checkbox" name="media-select-all" id="media-select-all-bottom">
            </th>
            <th>File</th>
            <th>Author</th>
            <th>Modified</th>
          </tr>
        </table>

      </div><!--#end col-sm-10 (right panel) -->

    </div><!--#end .row, .content -->

  </div>
  <script>
    var container = document.querySelector('.container');
    var minHeight = 576;
  </script>
<?php require_once "includes/admin-footer.php"; ?>
