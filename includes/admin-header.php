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
        <a class="navbar-brand" href="<?= BASEPATH; ?>"><?= SITE_NAME; ?></a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li class="active"><a href="#">Home</a></li>
          <li><a href="#">Page 1</a></li>
          <li><a href="#">Page 2</a></li>
          <li><a href="#">Page 3</a></li>
        </ul>

        <!-- Modal -->
        <div id="dialog-logout" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal Content -->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
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
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?= $user->display_name; ?> <span class="glyphicon glyphicon-menu-hamburger"></span></a>
            <ul class="dropdown-menu">
              <li class="dropdown-header">Welcome <?= $user->display_name; ?></li>
              <li><a href="#"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
              <li><a href="#"><span class="glyphicon glyphicon-bell"></span> Notifications <span class="badge">0</span></a></li>
              <li><a href="#"><span class="glyphicon glyphicon-wrench"></span> Settings</a></li>
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
