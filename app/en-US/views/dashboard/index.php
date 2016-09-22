<?php
$user = $data['user'];
$recent_posts = $data['recent_posts'];
$totals = $data['totals'];

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

        <div class="page-header">
          <h2>Welcome: <small><?= ucwords($user->display_name); ?></small></h2>
        </div>

        <div class="col-md-6">
          <div class="well well-lg">
            <h4>Overview</h4>
            <table class="table">
              <tr>
                <th></th>
                <th>#</th>
              </tr>
              <?php foreach ($totals as $key => $value): ?>
                <tr>
                  <td><?= ucwords($key); ?></td>
                  <td><?= $value ?></td>
                </tr>
              <?php endforeach; ?>
            </table>
          </div>
        </div>

        <div class="col-md-6">
          <div class="well well-lg">
            <h4>Activity</h4>
            <table class="table">
              <tr>
                <th>Modified</th>
                <th>Title</th>
                <th>Type</th>
              </tr>
              <?php
              for($x = 0; $x < count($recent_posts); $x++) {
                $then = new DateTime($recent_posts[$x]['post_modified']);
                $date_val = TimeManager::get_time_since($then);
              ?>
              <tr>
                <td><?= $date_val; ?></td>
                <td><?= $recent_posts[$x]['post_title']; ?></td>
                <td><?= ucwords($recent_posts[$x]['post_type']); ?></td>
              </tr>
              <?php } ?>
            </table>
          </div>
        </div>

      </div>

    </div>

  </div>
<?php require_once "includes/admin-footer.php"; ?>
