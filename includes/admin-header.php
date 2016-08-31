<?php
// $db = $data['db'];
$user = $data['user'];

require_once "includes/head-shared.php";
?>
<body>
<?php if (User::is_logged_in()): ?>

  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a href="<?= BASEPATH; ?>" class="navbar-brand"><?= SITE_NAME; ?></a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li class="active"><a href="admin/">Dashboard</a></li>
          <li><a href="add/"><span></span></a></li>
          <li><a href="design/">Design</a></li>
        </ul>

        <!-- Modal - Logout Dialog -->
        <div id="dialog-logout" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal Content -->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Logout Dialog</h4>
              </div>
              <div class="modal-body">
                <p>Hello</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>

        <ul class="nav navbar-nav navbar-right">
        <?php if (!User::is_logged_in()): ?>
          <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
          <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
        <?php else: ?>

          <!--#ViewMode -->
          <li class="active"><a href="#" onlclick="switchViewingMode(event, 'desktop')" title="Desktop view"><i class="fa fa-desktop"></i></a></li>
          <li><a href="#" onlclick="switchViewingMode(event, 'tablet')" title="Tablet view"><i class="fa fa-tablet"></i></a></li>
          <li><a href="#" onlclick="switchViewingMode(event, 'mobile')" title="Mobile view"><i class="fa fa-mobile"></i></a></li>
          <!--#ViewModeEnd -->

          <li><a href="#" onclick="publish(event)"><span class="glyphicon glyphicon-publish"></span> Publish</a></li>
          <!-- Publish Operation -->
          <script>
            function switchViewingMode(event, mode)
            {
              event.preventDefault();

              alert("New mode: " + mode + "\n\nSwitch View Mode operation not yet implemented.");

              return false;
            }

            function publish(event)
            {
              event.preventDefault();

              alert("Publish operation has not been implemented yet.");

              return false;
            } // end publish
          </script>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?= $user->display_name; ?> <span class="glyphicon glyphicon-menu-hamburger"></span></a>
            <ul class="dropdown-menu">
              <li class="dropdown-header">Welcome <?= $user->display_name; ?></li>
              <li><a href="user/profile/<?= $user->login; ?>"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
              <li><a href="user/notifications/"><span class="glyphicon glyphicon-bell"></span> Notifications <span class="badge">0</span></a></li>
              <li><a href="user/settings/"><span class="glyphicon glyphicon-wrench"></span> Settings</a></li>
              <li class="divider"></li>
              <li><a id="btn-logout" href="#" onclick="return logout(event)"><span class="glyphicon glyphicon-log-out" ></span> Logout</a></li>
              <script type="text/javascript">
                function logout(event)
                {
                  event.preventDefault();
                  // Attempt to logout
                  var url = $('base').attr('href') + 'api/user/logout/';
                  var data = {var1:"hwell", var2:" world"};
                  // alert(url);
                  $.get(url, data, callback);
                  return false;
                }

                function callback(data, status, xhr)
                {
                  var response = JSON.parse(data);

                  if(response.success)
                  {
                    location.href = response.href;
                  }
                  else
                  {
                    // $('#dialog-logout').removeClass("hide");
                    $('#dialog-logout .modal-header h4').html("Logout Error");
                    $('#dialog-logout .modal-body').html(response.msg);
                    $('#dialog-logout').modal("show");
                  }
                  // alert("\nSuccess: " + response.success +
                  //       "\nStatus: " + response.status +
                  //       "\nMessage: " + response.msg +
                  //       "\nHref: " + response.href);
                } // end callback
              </script>
            </ul>
          </li>
        <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

<?php endif; ?>
