<?php
$user = $data['user'];
$trash = $data['trash'];
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
          <h2><span class='glyphicon glyphicon-trash'></span> Trash Bin</small>
            <div class="pull-right btn-group">
              <?php if (!empty($trash)): ?>
                <button type='button' class="btn btn-inverse" id="btn-restore-all" title="Restore All Items"><span class="glyphicon glyphicon-repeat"></span></button>
                <button type='button' class="btn btn-default" id="btn-delete-all" title="Empty Trash"><span class="glyphicon glyphicon-trash"></span></button>
              <?php else: ?>
                <button type='button' class="btn btn-inverse disabled" id="btn-restore-all" title="Restore All Items"><span class="glyphicon glyphicon-repeat"></span></button>
                <button type='button' class="btn btn-default disabled" id="btn-delete-all" title="Empty Trash"><span class="glyphicon glyphicon-trash"></span></button>
              <?php endif; ?>
            </div>
          </h2>
        </div>

        <!-- Feedback Alert -->
        <div id="feedback-trash" class="alert hidden"></div>

        <!-- Toolbar -->
        <?php include_once VIEWSPATH . 'includes/toolbar-list.php' ?>

        <?php if (!empty($trash)): ?>
          <!-- Media Items -->
          <?php if (isset($_GET['display']) && streq($_GET['display'], 'grid')): ?>

            <!-- Grid View -->
            <div id="grid-trashed-items" class="row">
            <?php for($x = 0; $x < count($trash); $x++) { ?>
              <div class="col-sm-4 col-md-2">
                <div class="thumbnail">
                  <img src="<?= $trash[$x]->thumb; ?>" alt="">
                  <input type="checkbox" name="item-select-<?= $trash[$x]->id; ?>" id="media-select-<?= $trash[$x]->id; ?>">
                  <div class="caption">
                    <h3><?= $trash[$x]->title; ?></h3>
                    <div class="btn-group">
                      <button type="button" name="btn-restore-<?= $trash[$x]->id; ?>"
                        id="btn-restore-<?= $trash[$x]->id; ?>" class="btn btn-xs btn-inverse">
                        <span class="glyphicon glyphicon-repeat"></span>
                      </button>
                      <button type="button" name="btn-delete-<?= $trash[$x]->id; ?>"
                        id="btn-delete-<?= $trash[$x]->id; ?>" class="btn btn-xs btn-default"
                        data-toggle="modal" data-target="#trashModal">
                        <span class="glyphicon glyphicon-trash"></span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
            </div>

          <?php else: ?>
            <!-- List View -->
            <table id='list-trashed-items' class="table table-bordered">
              <tr>
                <th class="col-sm-1">
                  <input type="checkbox" name="media-select-all" id="media-select-all-top" title="Select all">
                </th>
                <th class="col-sm-7">Name</th>
                <th>Type</th>
                <th class="col-sm-2">Author</th>
                <th class="col-sm-2">Modified</th>
              </tr>

              <?php for($x = 0; $x < count($trash); $x++) { ?>
              <tr>
                <td>
                  <input type="checkbox" name="item-select-<?= $trash[$x]->id; ?>" id="media-select-<?= $trash[$x]->id; ?>">
                </td>
                <td>
                  <div class="media">
                    <div class="media-left">
                      <a href="admin/trash/#<?= $trash[$x]->id; ?>">
                        <span class="no-image no-image-64 no-image-file" title="<?= $trash[$x]->title; ?>"></span>
                      </a>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading"><?= $trash[$x]->title; ?></h4>
                      <p><?= $trash[$x]->name; ?></p>
                      <div class="btn-group pull-right">
                        <button type="button" name="btn-restore-<?= $trash[$x]->id; ?>"
                          id="btn-restore-<?= $trash[$x]->id; ?>" class="btn btn-xs btn-inverse">
                          <span class="glyphicon glyphicon-repeat"></span>
                        </button>
                        <button type="button" name="btn-delete-<?= $trash[$x]->id; ?>"
                          id="btn-delete-<?= $trash[$x]->id; ?>" class="btn btn-xs btn-default"
                          data-toggle="modal" data-target="#trashModal">
                          <span class="glyphicon glyphicon-trash"></span>
                        </button>
                      </div>
                    </div>
                  </div>
                </td>
                <td><?= ucwords($trash[$x]->type); ?></td>
                <td><?= ucwords($trash[$x]->author_name); ?></td>
                <td><?= TimeManager::get_time_since(new DateTime($trash[$x]->modified)); ?></td>
              </tr>
              <?php } ?>
              <tr>
                <th>
                  <input type="checkbox" name="media-select-all" id="media-select-all-bottom" title="Select all">
                </th>
                <th>Name</th>
                <th>Type</th>
                <th>Author</th>
                <th>Modified</th>
              </tr>
            </table>
          <?php endif; ?>
        <?php else: ?>
        <p>The trash bin is empty.</p>
        <?php endif; #end if(!empty($trash)) ?>

      </div><!--#end col-sm-10 (right panel) -->

    </div><!--#end .row, .content -->

  </div>
  <!-- Modal -->
  <div id="trashModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content -->
      <div id="modal-content-delete" class="modal-content hidden">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete Item(s)</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to permanently delete the item(s)?</p>
        </div>
        <div class="modal-footer">
          <button type="button" id="btn-confirm-delete" class="btn btn-primary" data-dismiss="modal">OK</button>
          <button type="button" id="btn-cancel-delete" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>

      <div id="modal-content-auth" class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">User Access Control</h4>
        </div>
        <div class="modal-body">
          <div class="alert alert-warning">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            Authorization is required to delete items.
          </div>
          <div id="feedback-auth" class="alert hidden"></div>
          <form class="form-horizontal">
            <div class="form-group">
              <label for="username" class="col-sm-2 control-label">Username:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="admin-username" value="" placeholder="Username">
              </div>
            </div>
            <div class="form-group">
              <label for="password" class="col-sm-2 control-label">Password:</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" name="admin-password" value="" placeholder="Password">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" name="btn-confirm" id="btn-confirm-auth">OK</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>
  <script>
    var container = document.querySelector('.container');
    var minHeight = 576;

    // var trashController = document.createElement("script");
    // trashController.src = "js/controllers/trash-controller.js";
    // document.querySelector("head").appendChild(trashController);
  </script>
<?php require_once "includes/admin-footer.php"; ?>
