<?php
$user = $data['user'];
require_once "includes/head-shared.php";
?>
<?php if (User::is_logged_in()): ?>

  <nav class="navbar navbar-inverse data-spy='affix' data-offset-top='197'">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a href="<?= BASEPATH; ?>admin/" class="navbar-brand">
          <img src="<?= RESPATH . 'images/logo/logo-128.png'; ?>" alt="Assegai" width="24">&nbsp;<?= SITE_NAME; ?>
        </a>
      </div>

      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <?php if (User::is_logged_in()): ?>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Pages: Home <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">Pages</li>
                <?php foreach ($pages as $page): ?>
                  <li>
                    <a href="admin/pages/edit/<?= $page->id; ?>"><?= $page->title; ?></a>
                    <?php if (!empty($page->children)): ?>
                      <ul>
                        <?php foreach ($page->children as $child): ?>
                          <li><a href="admin/pages/edit/<?= $child->id; ?>"><?= $child->title; ?></a></li>
                        <?php endforeach; ?>
                      </ul>
                    <?php endif; ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Layouts <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">Layouts</li>
                <?php foreach ($layouts as $layout): ?>
                  <li><a href="admin/layouts/edit/<?= $layout->id; ?>"><?= $layout->title; ?></a></li>
                <?php endforeach; ?>
              </ul>
            </li>
            <li><a href="admin/themes/">Themes</a></li>
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
          <?php if ($task_bar_options['view_mode']): ?>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" title="Switch Editor Views "><i id="icon-view-mode" class="fa fa-desktop"></i> <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li class="dropdown-header">Editor Views</li>
              <li>
                <a href="#" onclick="switchViewingMode(event, 'desktop')" title="Desktop view">
                  <div class="row">
                    <div class="col-sm-2 text-right"><i class="fa fa-desktop"></i></div>
                    <div class="col-sm-8 text-left">Desktop View</div>
                  </div>
                </a>
              </li>

              <li>
                <a href="#" onclick="switchViewingMode(event, 'tablet')" title="Tablet view">
                  <div class="row">
                    <div class="col-sm-2 text-right"><i class="fa fa-tablet"></i></div>
                    <div class="col-sm-8 text-left">Tablet View</div>
                  </div>
                </a>
              </li>

              <li>
                <a href="#" onclick="switchViewingMode(event, 'mobile')" title="Mobile view">
                  <div class="row">
                    <div class="col-sm-2 text-right"><i class="fa fa-mobile"></i></div>
                    <div class="col-sm-8 text-left">Mobile View</div>
                  </div>
                </a>
              </li>
            </ul>
          </li>
          <!--#end ViewMode -->
          <?php endif; ?>

          <!-- Save -->
          <?php if ($task_bar_options['save']): ?>
            <li><a href="#" onclick="save(event)" title="Save Changes">Save <span class="glyphicon glyphicon-floppy-disk"></span></a></li>
          <?php endif; ?>

          <!-- Publish -->
          <?php if ($task_bar_options['publish']): ?>
            <li><a href="#" onclick="publish(event)" title="Publish Changes">Publish <span class="glyphicon glyphicon-globe"></span></a></li>
          <?php endif; ?>

          <!-- Publish Operation -->
          <script src="js/jquery.min.js"></script>
          <script>
            function switchViewingMode(event, mode)
            {
              event.preventDefault();
              var editorFrame = document.querySelector('.editor-frame');

              switch(mode)
              {
                case 'tablet':
                  document.querySelector('#icon-view-mode').className = "fa fa-tablet";
                  if(editorFrame != null)
                  {
                    if($('.editor-frame').hasClass('editor-frame-desktop'))
                      $('.editor-frame').removeClass('editor-frame-desktop');

                    if($('.editor-frame').hasClass('editor-frame-mobile'))
                      $('.editor-frame').removeClass('editor-frame-mobile');

                    $('.editor-frame').addClass('editor-frame-tablet');
                  }
                  break;
                case 'mobile':
                  document.querySelector('#icon-view-mode').className = "fa fa-mobile";
                  if(editorFrame != null)
                  {
                    if($('.editor-frame').hasClass('editor-frame-desktop'))
                      $('.editor-frame').removeClass('editor-frame-desktop');

                    if($('.editor-frame').hasClass('editor-frame-tablet'))
                      $('.editor-frame').removeClass('editor-frame-tablet');

                    $('.editor-frame').addClass('editor-frame-mobile');
                  }
                  break;
                default:
                  document.querySelector('#icon-view-mode').className = "fa fa-desktop";
                  if(editorFrame != null)
                  {
                    if($('.editor-frame').hasClass('editor-frame-mobile'))
                      $('.editor-frame').removeClass('editor-frame-mobile');

                    if($('.editor-frame').hasClass('editor-frame-tablet'))
                      $('.editor-frame').removeClass('editor-frame-tablet');

                    $('.editor-frame').addClass('editor-frame-desktop');
                  }
                  break;
              }
              // alert($('.editor-frame').attr('class'));
              updateViewModeSettings(mode);

              return false;
            } // end switchViewingMode()

            function updateViewModeSettings(mode)
            {
              if(typeof(Storage) !== "undefined")
              {
                // console.debug('Update using localStorage');
                localStorage.setItem('assg-vm', mode);
              }
              else
              {
                // console.debug('Update using cookies');
                setCookie('assg-vm', mode, 1);
              }
            } // end updateViewModeSettings()

            function save(event)
            {
              event.preventDefault();

              alert("Publish operation has not been implemented yet.");

              return false;
            } // end save()

            function publish(event)
            {
              event.preventDefault();

              alert("Publish operation has not been implemented yet.");

              return false;
            } // end publish()
          </script>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
              <?= $_SESSION[SESSION_USER_DISPLAY]; ?> <span class="glyphicon glyphicon-user"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="dropdown-header">Welcome <?= $_SESSION[SESSION_USER_DISPLAY]; ?></li>
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
<?php
// $option = new Option($db, 1);
// echo $option->name() . ' : ' . $option->value('Assegai Test'); exit;
// $cat_name = 'alert';
// $cat = new Category($db, $cat_name);
// $cat->set_info("Tag for all {$cat_name} element types.");
// echo Category::id($db, $cat_name); exit;
// $confirmation_email = file_get_contents(ABSRESPATH . 'templates/email-user-registration.php');
// $to = 'amasiye313@gmail.com';
// $subject = '';
// $msg = "<h1>Hello {$user->login}</h1>";
// $headers = 'From: webmaster@example.com' . "\r\n" .
//     'Reply-To: webmaster@example.com' . "\r\n" .
//     'Content-Type: text/html' . "\r\n" .
//     'X-Mailer: PHP/' . phpversion();
// echo mail($to, $subject, $msg, $headers); exit;
 ?>
