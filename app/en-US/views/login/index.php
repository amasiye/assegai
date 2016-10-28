<?php require_once "includes/header.php"; ?>

<div class="container">
  <div class="col-lg-offset-4 col-lg-4">
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

        <?php if (!isset($_GET['register'])): ?>
        <h2>Login</h2>
      </div>

      <div class="panel-body">

          <form role="form" class="clearfix">
            <?php if (isset($_GET['loggedout']) && !empty($_GET['loggedout']) && $_GET['loggedout'] == 1): ?>
              <div id="alert-feedback" class="alert alert-info">
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

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
            <script>

            document.querySelector("button").onclick = function() { login($('#username').val(), $('#password').val()); };
            // document.querySelector("input").onkeyup = function(event) { alert("You pressed a key"); };

            $("body").ready(function() {

              $("input").keydown(function(event) {
                if(event.which === 13)
                  login($('#username').val(), $('#password').val());
              });

            });

            function login(username, password)
            {
              var url = $('base').attr('href') + 'api/user/login/';
              $.post(
                "http://localhost/atatusoft/Assegai/assegai/api/user/login/",
                {
                  username: $('#username').val(),
                  password: $('#password').val()
                },
                function(data, status) {
                  // console.log(data);
                  var result = JSON.parse(data);

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
        <li class="list-group-item"><a href="<?= BASEPATH; ?>">&#8592;&nbsp;Back to <?= SITE_NAME; ?></a></li>
      </ul>

      <?php else: ?>
      <h2>Register</h2>
    </div>
      <div class="panel-body">

        <form role="form" class="clearfix">

          <!-- Login -->

          <!-- Password -->

          <!-- Repeat Password -->

          <!-- Name -->
          <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
          </div>

          <!-- Password -->
          <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
          </div>

          <!-- Repeat Password -->
          <div class="form-group has-success has-feedback">
            <label for="password-repeat">Repeat Password:</label>
            <input type="password" id="password-repeat" name="password-repeat" class="form-control" placeholder="Repeat password" required>
            <span class="glyphicon glyphicon-ok form-control-feedback"></span>
          </div>

          <!-- Password Strength Indicator -->
          <div class="form-group">
            <div class="">
            </div>
          </div>

          <!-- Email -->
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" placeholder="Email">
          </div>

          <!-- Registration button -->
          <div class="form-group">
            <button type="button" class="btn btn-primary btn-block" id="btn-register" name="btn-register">Register</button>
          </div>

        </form>

      </div>

      <ul class="list-group">
        <li class="list-group-item"><a href="<?= BASEPATH . 'admin/'?>">Login</a></li>
        <li class="list-group-item"><a href="<?= BASEPATH . 'admin/?recover=1'; ?>">Lost your password?</a></li>
        <li class="list-group-item"><a href="<?= BASEPATH; ?>">&#8592;&nbsp;Back to <?= SITE_NAME; ?></a></li>
      </ul>
      <script>
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
