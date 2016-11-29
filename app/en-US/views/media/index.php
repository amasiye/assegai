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
          <h2>Media: <small><?= ucwords(SITE_NAME); ?></small>
            <a href="admin/media/new/" class="btn btn-info pull-right">New</a>
          </h2>
        </div>

        <!-- Feedback Alert -->
        <div id="feedback-media" class="alert hidden"></div>

        <!-- Toolbar -->
        <?php include_once VIEWSPATH . "includes/toolbar-list.php"; ?>

        <?php if (!empty($media)): ?>
          <!-- Media Items -->
          <?php if (isset($_GET['display']) && streq($_GET['display'], 'grid')): ?>

          <?php else: ?>
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
                        <a href="admin/media/edit/<?= $media[$x]->id; ?>">
                          <img src="<?= $media[$x]->thumb; ?>" class="media-object" alt="<?= $media[$x]->title; ?>" width="64">
                        </a>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading"><?= $media[$x]->title; ?></h4>
                        <p><?= $media[$x]->mime_type; ?></p>
                        <div class="btn-group pull-right">
                          <button type="button" name="btn-edit-<?= $media[$x]->id; ?>"
                            id="btn-edit-<?= $media[$x]->id; ?>" class="btn btn-xs btn-inverse" Title="Edit">
                            <span class="glyphicon glyphicon-pencil"></span>
                          </button>
                          <button type="button" name="btn-trash-<?= $media[$x]->id; ?>"
                            id="btn-trash-<?= $media[$x]->id; ?>" class="btn btn-xs btn-default" title="Send to Trash Bin">
                            <span class="glyphicon glyphicon-trash"></span>&nbsp;
                          </button>
                        </div>
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
            <?php endif; ?>
          <?php else: ?>
          <p>No media items found.</p>
        <?php endif; ?>

      </div><!--#end col-sm-10 (right panel) -->

    </div><!--#end .row, .content -->

  </div>
  <script>
    var container = document.querySelector('.container');
    var minHeight = 576;
  </script>
<?php require_once "includes/admin-footer.php"; ?>
