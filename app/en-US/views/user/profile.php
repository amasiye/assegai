<?php
$user = $data['user'];
$display_name_last_letter = last_letter($user->display_name);
// exit;
// echo $display_name_last_letter; exit;
require_once "includes/admin-header.php";
?>
  <div class="container-fluid">

    <div class="row content">

      <!-- Left Panel -->
      <div class="col-sm-2 sidenav">
        <?= App::get_ui_component($db, $user, 'dashboard'); ?>
      </div>

      <!-- Right Panel -->
      <div class="col-sm-10">

        <div class="page-header">
          <h2>Profile: <small><?= ucwords($user->display_name); ?></small>
          <?php if ($user->has_permission('edit','profiles')): ?>
            <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#edit-profile-modal">Edit</button>
          <?php endif; ?>
          </h2>
        </div>

        <!-- Profile Image -->
        <div class="col-sm-3">
          <div class="panel">
            <img class="img-circle img-responsive" src="<?= $user->profile_image; ?>" alt="<?= $media->title; ?>">
          </div>

          <button type="button" class="btn btn-info btn-lg btn-block" data-toggle="modal" data-target="#edit-profile-modal">
            <span class="glyphicon glyphicon-camera"></span> Choose Picture
          </button>

        </div><!--# .col-sm-3 -->

        <div class="col-sm-9">
          <div class="panel-body">

            <!-- #Feedback -->
            <div id="feedback" class="alert hidden"></div>

            <!-- #Profile Details  -->
            <form id="profile-details" class="form-horizontal">

              <!-- User Login -->
              <div class="form-group">
                <label class="control-label col-sm-3">User Login:</label>
                <div class="col-sm-9">
                  <p id="preview-login" class="form-control-static"><?= $user->login; ?></p>
                </div>
              </div>

              <!-- Username -->
              <div class="form-group">
                <label class="control-label col-sm-3">Username:</label>
                <div class="col-sm-9">
                  <p id="preview-username" class="form-control-static"><?= $user->username; ?></p>
                </div>
              </div>

              <!-- Display Name -->
              <div class="form-group">
                <label class="control-label col-sm-3">Display Name:</label>
                <div class="col-sm-9">
                  <p id="preview-display-name" class="form-control-static"><?= $user->display_name; ?>
                  </p>
                </div>
              </div>

              <!-- Primary Email -->
              <div class="form-group">
                <label class="control-label col-sm-3">Primary Email:</label>
                <div class="col-sm-9">
                  <p id="preview-email-primary" class="form-control-static"><?= $user->primary_email; ?></p>
                </div>
              </div>

              <!-- Other Email -->
              <div class="form-group">
                <label class="control-label col-sm-3">Other Email:</label>
                <div class="col-sm-9">
                  <p id="preview-email-other" class="form-control-static"><?= $user->emails; ?></p>
                </div>
              </div>

              <!-- Address -->
              <div class="form-group">
                <label class="control-label col-sm-3">Address:</label>
                <div class="col-sm-9">
                  <p id="preview-address" class="form-control-static"><?= $user->address; ?></p>
                </div>
              </div>

              <!-- Group -->
              <div class="form-group">
                <label class="control-label col-sm-3">User Group:</label>
                <div class="col-sm-9">
                  <p id="preview-group" class="form-control-static"><?= $user->group_name; ?></p>
                </div>
              </div>

              <!-- Joined -->
              <div class="form-group">
                <label class="control-label col-sm-3">Joined:</label>
                <div class="col-sm-9">
                  <p id="preview-joined" class="form-control-static"><?= TimeManager::get_time_since(new DateTime($user->joined)); ?></p>
                </div>
              </div>

              <!-- Preferences -->
              <div class="form-group">
                <label class="control-label col-sm-3">Preferences:</label>
                <div class="col-sm-9">
                  <p id="preview-preferences" class="form-control-static"><?= $user->preferences; ?></p>
                </div>
              </div>

              <!-- Edit Profile Modal -->
              <div id="edit-profile-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                  <!-- Modal content-->

                    <?php include_once "includes/modal/profile-info.php" ?>
                    <?php include_once "includes/modal/profile-image-browser.php" ?>


                    <!-- Delete the follwoing line when scripts are migrated to single js file  -->
                    <script src="js/jquery/jquery.min.js"></script>
                    <script>
                    function init()
                    {
                      // Add event listener for save button
                      $('[name=btn-profile-save]').click(function() { updateProfile(); });

                      // Add event listener for upload button
                      $('[name=image-profile-edit]').click(function() { $('[name=image-profile-file]').trigger('click'); });

                      // listen for change to file then upload
                      $('[name=image-profile-file]').change(function() { updateProfilePicture(); });
                    } // end init()

                    function updateProfilePicture()
                    {
                      var formData = new FormData();
                      var file = $('[name=image-profile-file]')[0];
                      var form = $('#image-profile-form')[0];
                      formData.append("file",file);
                      formData.append("form",form);

                      var endpoint = '<?= BASEPATH . "api/user/upload/"; ?>';
                      var xhr = new XMLHttpRequest();
                      xhr.onreadystatechange = function() {
                        if(this.readyState === 4 && this.status === 200) {
                          console.debug(this.responseText);
                          alert(this.responseText);
                        }
                      };
                      xhr.open("POST", endpoint, true);
                      xhr.send(formData);
                      // $.ajax({
                      //   url: endpoint,
                      //   type: "POST",
                      //   data: formData,
                      //   processData: false,
                      //   contentType: false,
                      //   success: function(data, status) {
                      //     console.log(data);
                      //     alert(data);
                      //   },
                      //   error: function(xhr, status, errorMessage) {
                      //     console.log(errorMessage);
                      //     $html = "<div class='alert alert-danger'>" +
                      //               errorMessage +
                      //             "</div>";
                      //     $('button[name=image-profile-edit]').insertAfter(html);
                      //   }
                      // });
                    } // updateProfilePicture();

                    function updateProfile()
                    {
                      var fieldsAreValid = true;

                      // Validate and bind fields
                      if(!usernameIsValid($('#login').val()))
                      {
                        $('#feedback-modal').addClass('alert-danger');
                        $('#feedback-modal').html("Error: Please check to make sure that all fields are filled out and valid.");
                        $('#feedback-modal').removeClass('hidden');
                        fieldsAreValid = false;
                      }


                      // Post ajax call
                      if(fieldsAreValid)
                      {
                        var url = 'api/user/update/'
                        var data = {
                          login: $('#login').val(),
                          username: $('#username').val(),
                          displayName: $('#display-name').val(),
                          <?php if (User::is_admin($db, $user->login)): ?>
                          groupName: $('#group-name').val(),
                          <?php endif; ?>
                          primaryEmail: $('#email-primary').val(),
                          emails: $('#email-other').val(),
                          address: $('#address').val(),
                          phones: $('#phones').val(),
                          preferences: $('#preferences').val()
                        };

                        // Append api key to data
                        data['<?= $data['app']->get_api_key_id(); ?>'] = '<?= $data['app']->get_api_key(); ?>';
                        // alert(JSON.stringify(data));
                        $.post(url, data, function(data, status) { saveRequestCallback(data, status);  });
                      }

                    } // end updateProfile()

                    function saveRequestCallback(data, status)
                    {
                      console.debug(data);
                      var results = JSON.parse(data);

                      // Clear modal feedback
                      $('#feedback-modal').removeClass('alert-danger').addClass('hidden');

                      if(results.success == true)
                      {
                        // Update login
                        if(results.login.success == true)
                          $('#preview-login').html(results.login.value);

                        // Update username
                        if(results.username.success == true && results.username.value != null)
                          $('#preview-username').html(results.username.value);

                        // // Update display name
                        if(results.displayName.success == true && results.displayName.value != null)
                        {
                          $('#preview-display-name').html(results.displayName.value);
                          $('#profile-title').html(results.displayName.value);
                        }

                        // Update primary email
                        if(results.primaryEmail.success == true && results.primaryEmail.value != null)
                          $('#preview-email-primary').html(results.primaryEmail.value);

                        // Update other email
                        if(results.emails.success == true && results.emails.value != null)
                          $('#preview-email-other').html(results.emails.value);

                        // Update address
                        if(results.address.success == true && results.address.value != null)
                          $('#preview-address').html(results.address.value);

                        <?php if (User::is_admin($db, $user->login)): ?>
                        // Update user group
                        if(results.groupName.success == true && results.groupName.value != null)
                          $('#preview-username').html(results.username.value);
                        <?php endif; ?>

                        clearModalAlert('#feedback-modal');
                        showSuccesAlert('#feedback', "<strong>Success:</strong> Profile changes saved.");

                        $('#edit-profile-modal').modal('hide');

                      }
                      else
                      {
                        // Show modal alert
                        showModalAlert('#feedback-modal', results.errorMessage);
                      }
                    } // end saveRequestCallback()

                    function clearModalAlert(selector)
                    {
                      $(selector).html("");
                      $(selector).removeClass('alert-danger').addClass('hidden');
                    } // end clearModalAlert

                    function showModalAlert(selector, txt)
                    {
                      $(selector).html(txt);
                      $(selector).addClass('alert-danger').removeClass('hidden');
                    } // end showModalAlert()

                    function showSuccesAlert(selector, txt)
                    {
                      $(selector).html(txt);
                      $(selector).addClass('alert-success').removeClass('hidden');
                    } // end showSuccesAlert()

                    document.addEventListener("DOMContentLoaded", init, false);
                    </script>

                  </div>
                </div><!-- -->
              </div>

            </form>
          </div>

        </div>
      </div>
    </div><!--# .row, .content -->

  </div><!--# .container-fluid -->
<?php require_once "includes/admin-footer.php" ?>
