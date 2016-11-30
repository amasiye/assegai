<?php
$path = 'js/controllers/';
$controllers = array();

$controllers['mail']['path'] = $path . 'mail.js';
$controllers['trash']['path'] = $path . 'trash.js';
$controllers['media']['path'] = $path . 'media.js';
$controllers['settings']['path'] = $path . 'settings.js';
$controllers['analytics']['path'] = $path . 'analytics.js';
$controllers['page-editor']['path'] = $path . 'page-editor.js';
$controllers['layout-editor']['path'] = $path . 'layout-editor.js';
$controllers['display-options']['path'] = $path . 'display-options.js';

$controllers['mail']['load'] = false;
$controllers['trash']['load'] = false;
$controllers['media']['load'] = false;
$controllers['settings']['load'] = false;
$controllers['analytics']['load'] = false;
$controllers['page-editor']['load'] = false;
$controllers['layout-editor']['load'] = false;
$controllers['display-options']['load'] = false;

if(empty($client_side_controllers))
  $client_side_controllers = array();

foreach ($client_side_controllers as $controller)
{
  if(!streq(gettype($controller), 'string'))
    break;

  if(array_key_exists($controller, $controllers))
  {
    $controllers[$controller]['load'] = true;
    # Turn caching off
    if(
        array_key_exists('options', $client_side_controllers) &&
        array_key_exists('caching', $client_side_controllers['options']) &&
        $client_side_controllers['options']['caching']
      )
    {
      $controllers[$controller]['path'] .= '?v=' . time();
    }
  }
  else
  {
    echo "<strong>Error: </strong>Could not load controller - {$controller}.js";
  }
}
 ?>
  <!-- jQuery library -->
  <script src="js/jquery/jquery.min.js"></script>
  <!-- // <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
  <!-- // <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->

  <!-- Latest compiled JavaScript -->
  <script src="js/bootstrap.min.js"></script>
  <!-- // <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>  -->

  <!-- Assegai JavaScript -->
  <script src="js/assegai.js"></script>

  <?php if (!empty($controllers)): ?>
      <!-- JavaScript Libraries -->
      <?php foreach ($controllers as $controller): ?>
        <?php if ($controller['load']): ?>
          <script src="<?= $controller['path']; ?>"></script>
        <?php endif; ?>
      <?php endforeach; ?>
  <?php endif; ?>

  <!-- Login Scripts -->
  <script>

  </script>

  <script>
    var request;
    var url = "app/scripts/ipinfo.php";
    var btnStartTrial = document.getElementById("btn-start-trial");

    document.addEventListener("DOMContentLoaded", doRequest, false)
    // btnStartTrial.onclick = doRequest;

    function doRequest()
    {
      if( XMLHttpRequest ) { request = new XMLHttpRequest(); }
      else if( ActiveXObject ) { request = new ActiveXObject("Microsoft.XMLHTTP"); }
      else { return false; }

      // request.open("POST", url, true);
      // request.send(null);
      // request.onreadystatechange = retrieveData;
    }

    function retrieveData()
    {
      if(request.readyState === 4 && request.status === 200)
      {
        var data = JSON.parse(request.responseText);

        // If href is defined
        if(typeof(btnStartTrial) !== typeof(null))
        {
          if(typeof(btnStartTrial.href) === typeof("document"))
          {
            switch(data.country)
            {
              case "CA":
                btnStartTrial.href = "login/register/en-CA";
                break;

              case "US":
                btnStartTrial.href = "login/register/en-US";
                break;

              case "UK":
                btnStartTrial.href = "login/register/en-UK";
                break;

              default:
                alert("Sorry, But we are not yet available in your country");
            }
          }
        }
      }
    }
  </script>

  <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
  <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

  <script src=""<?php echo $loop_out; ?>"js/main.js"></script>

  <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
  <script>
      (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
      function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
      e=o.createElement(i);r=o.getElementsByTagName(i)[0];
      e.src='//www.google-analytics.com/analytics.js';
      r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
      ga('create','UA-XXXXX-X','auto');ga('send','pageview');
  </script>
</body>
</html>
