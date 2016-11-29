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
        <?= App::get_ui_component($db, $user, 'dashboard'); ?>
      </div>

      <!-- Right Panel -->
      <div class="col-sm-10">

        <div class="page-header">
          <h2><span class="glyphicon glyphicon-dashboard"></span> Dashboard: <small><?= ucwords($user->display_name); ?></small>
            <span class="pull-right"><img class="img-circle" src="<?= $user->profile_image; ?>" alt="<?= $user->display_name; ?>" width="48"></span>
          </h2>
        </div>

        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4>Overview</h4>
            </div>
            <div class="panel-body">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th></th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($totals as $key => $value): ?>
                    <tr>
                      <td><?= ucwords($key); ?></td>
                      <td><?= $value ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div><!--# end .panel-body -->

          </div>
        </div>

        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4>Recent Activity</h4>
            </div>

            <div class="panel-body">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Modified</th>
                    <th>Title</th>
                    <th>Type</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // for($x = 0; $x < count($recent_posts); $x++) {
                  for($x = 0; $x < 5; $x++) {
                    $then = new DateTime($recent_posts[$x]['post_modified']);
                    $date_val = TimeManager::get_time_since($then);
                  ?>
                  <tr>
                    <td><?= $date_val; ?></td>
                    <td><?= $recent_posts[$x]['post_title']; ?></td>
                    <?php if (strcmp($recent_posts[$x]['post_type'], 'media') == 0): ?>
                      <td><?= ucwords(json_decode($recent_posts[$x]['post_meta'], true)['media_type']); ?></td>
                    <?php else: ?>
                      <td><?= ucwords($recent_posts[$x]['post_type']); ?></td>
                    <?php endif; ?>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>

          </div>
        </div>

      </div><!--# end .col-md-10 -->

    </div><!--# end row -->

  </div>
<?php require_once "includes/admin-footer.php"; ?>
