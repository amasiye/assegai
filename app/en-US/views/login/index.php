<?php require_once "includes/admin-header.php"; ?>

<div class="container">
  <div class="col-md-offset-4 col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <?php
          $user_login  = "Admin";
          $user_password = "admin1234";
          $user_name = "Administrator";
          $user_group = 1;
          $user_meta = json_encode(array('email'=>'admin@host.domain', 'address'=>'', 'phone'=>9027006887));
          // $user->login($db, $user_login, $user_password);
          // User::register($user_login, $user_password, $user_name, $user_group, $user_meta);
          // echo "<h2>Hello World</h2>";
        ?>
        <h2>Login</h2>
      </div>

      <?php if (!isset($_GET['register'])): ?>
      <div class="panel-body">

          <form role="form" class="clearfix">
            <?php if (isset($_GET['loggedout']) && !empty($_GET['loggedout']) && $_GET['loggedout'] == 1): ?>
              <div id="alert-feedback" class="alert alert-warning">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                You have been logged-out.
              </div>
            <?php else: ?>
              <div id="alert-feedback" class="alert" style="display:none;"></div>
            <?php endif; ?>

            <!-- Username -->
            <div class="form-group">
              <label for="username">Username:&nbsp;</label>
              <input type="text" id="username" name="username" class="form-control" placeholder="Username"
              title="" pattern="[\w\W]+" maxlength="20" required>
            </div>

            <!-- Password -->
            <div class="form-group">
              <label for="password">Password:&nbsp;</label>
              <input type="password" id="password" name="password" class="form-control" placeholder="Password" maxlength="64" required>
            </div>

            <!-- Remember Me -->
            <!-- <div class="form-group">
              <div class="checkbox">
                <label><input type="checkbox"> Remember me</label>
              </div>
            </div> -->

            <!-- Submit -->
            <div class="form-group">
              <button type="button" class="btn btn-primary btn-block" id="btn-submit" name="btn-submit">Login</button>
            </div>
            <script>

            document.querySelector("button").onclick = function() { login($('#username').val(), $('#password').val()); };
            function login(username, password)
            {
              var url = $('base').attr('href') + 'api/user/login/';
              $.post(
                "http://localhost/atatusoft/Assegai/assegai/api/user/login/",
                {
                  username: $('#username').val(),
                  password: $('#password').val()
                },
                function(res) {
                  var result = JSON.parse(res);

                  if(result.success == true)
                  {

                    if($('#alert-feedback').hasClass('alert-danger'))
                    $('#alert-feedback').removeClass('alert-danger');

                    $('#alert-feedback').addClass("alert-success");
                    $('#alert-feedback').html(result.msg);

                    // Show the alert
                    $('#alert-feedback').css('display','block');

                    window.location.href = result.href;
                    // window.location.href = $('base').attr('href') + 'dashboard/';
                  }
                  else
                  {
                    $('#alert-feedback').css("display","block");
                    $('#alert-feedback').addClass("alert-danger");
                    $('#alert-feedback').html(result.msg);
                  }
                }
                );

              } // end login(string, string)

            </script>
          </form>

      </div>

      <ul class="list-group">
        <li class="list-group-item"><a href="<?= BASEPATH . 'admin/?register=1'; ?>">Register</a></li>
        <li class="list-group-item"><a href="<?= BASEPATH . 'admin/?recover=1'; ?>">Lost your password?</a></li>
      </ul>

      <?php else: ?>
      <div class="panel-body">

        <form role="form" class="clearfix">

          <!-- Login -->

          <!-- Password -->

          <!-- Repeat Password -->

          <!-- Name -->
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" placeholder="Enter your full name">
          </div>

        </form>

      </div>

      <ul class="list-group">
        <li class="list-group-item"><a href="<?= BASEPATH . 'admin/'?>">Login</a></li>
      </ul>
      <script>
      alert("Hello");
      document.querySelector('link-register').onclick = register();

      function register()
      {

      } // end register()
      </script>
      <?php endif; ?>

    </div> <!-- end panel-default -->
  </div><!-- end  -->
</div>

<?php require_once "includes/admin-footer.php"; ?>
