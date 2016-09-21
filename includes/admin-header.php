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
        <a href="<?= BASEPATH; ?>admin/" class="navbar-brand"><?= SITE_NAME; ?></a>
      </div>

      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <?php if (User::is_logged_in()): ?>
            <li><a href="admin/">Dashboard</a></li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Pages: Home <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">Pages</li>
                <li><a href="admin/pages/edit/1">Home</a></li>
                <li><a href="admin/pages/edit/2">About</a></li>
                <li><a href="admin/pages/edit/3">Contact</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Layouts <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">Layouts</li>
                <li><a href="admin/layouts/edit/1">Blog</a></li>
                <li><a href="admin/layouts/edit/2">Marketing 1</a></li>
                <li><a href="admin/layouts/edit/3">Marketing 2</a></li>
                <li><a href="admin/layouts/edit/4">Portfolio</a></li>
              </ul>
            </li>
            <li><a href="admin/settings/">Settings</a></li>
          <?php endif; ?>
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
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" title="Switch Editor Views "><i class="fa fa-desktop"></i> <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li class="dropdown-header">Editor Views</li>
              <li>
                <a href="#" onlclick="switchViewingMode(event, 'desktop')" title="Desktop view">
                  <div class="row">
                    <div class="col-sm-2 text-right"><i class="fa fa-desktop"></i></div>
                    <div class="col-sm-8 text-left">Desktop View</div>
                  </div>
                </a>
              </li>

              <li>
                <a href="#" onlclick="switchViewingMode(event, 'tablet')" title="Tablet view">
                  <div class="row">
                    <div class="col-sm-2 text-right"><i class="fa fa-tablet"></i></div>
                    <div class="col-sm-8 text-left">Tablet View</div>
                  </div>
                </a>
              </li>

              <li>
                <a href="#" onlclick="switchViewingMode(event, 'mobile')" title="Mobile view">
                  <div class="row">
                    <div class="col-sm-2 text-right"><i class="fa fa-mobile"></i></div>
                    <div class="col-sm-8 text-left">Mobile View</div>
                  </div>
                </a>
              </li>
            </ul>
          </li>
          <!--#ViewModeEnd -->

          <li><a href="#" onclick="publish(event)" title="Publish">Publish <span class="glyphicon glyphicon-globe"></span></a></li>
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
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?= $_SESSION[SESSION_USER_DISPLAY]; ?> <span class="glyphicon glyphicon-menu-hamburger"></span></a>
            <ul class="dropdown-menu">
              <li class="dropdown-header">Welcome <?= $user->display_name; ?></li>
              <li><a href="admin/profile/"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
              <li><a href="admin/notifications/"><span class="glyphicon glyphicon-bell"></span> Notifications <span class="badge"><?php $n = count(Notification::pull_unread()); echo ($n < 100)? $n : "99+"; ?></span></a></li>
              <li><a href="admin/settings/"><span class="glyphicon glyphicon-wrench"></span> Settings</a></li>
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
