<?php
$user = $data['user'];
$layout = $data['layout'];

require_once "includes/admin-header.php";
?>
  <div class="container-fluid min-height-576">
    <div class="row content">

      <!-- Left Panel -->
      <div class="col-sm-2 sidenav">
        <?= App::get_ui_component($db, $user, 'nav-layouts/edit'); ?>
      </div>

      <!-- Right Panel -->
      <div id="stage" class="col-sm-10">

        <div class="frame editor-frame" ondrop="drop(event)" ondragover="allowDrop(event)"><?= $layout->content; ?></div>

      </div><!--#end col-sm-10 (right panel) -->

    </div><!--#end .row, .content -->

  </div>
  <script>
    var container = document.querySelector('.container');
    var minHeight = 576;
    var newTitle = '<?= $layout->title; ?>';
    document.title = "Assegai Layout Editor: " + newTitle;

    // Load editor stylesheet
    var editorStyles = document.createElement('link');
    editorStyles.rel = 'stylesheet';
    editorStyles.href = 'css/assegai-editor.css';
    document.querySelector("head").append(editorStyles);

    function allowDrop(event)
    {
      event.preventDefault();
    } // end allowDrop()

    function drag(event)
    {
      event.dataTransfer.setData("content", event.target.getAttribute("data-element-type"));
    }

    function drop(event)
    {
      event.preventDefault();
      var data = event.dataTransfer.getData("content");
      var node, text;

      switch (data)
      {
        // Use a dummy container since editor already has a container
        // Then alter dummy container to container when saving or publishing
        case 'container':
          node = document.createElement('div');
          text = document.createTextNode("Container");
          node.appendChild(text);
          node.className = "dummy-container";
          break;

        // Use a dummy container since editor already has a container
        // Then alter dummy container to container when saving or publishing
        case 'container-fluid':
          node = document.createElement('div');
          text = document.createTextNode("Responsive Container");
          node.appendChild(text);
          node.className = "dummy-container-fluid";
          break;

        case 'row':
          node = document.createElement('div');
          text = document.createTextNode("row");
          node.appendChild(text);
          node.className = "row";
          break;

        case 'carousel':
          node = document.createElement('div');
          text = document.createTextNode("Carousel");
          node.appendChild(text);
          node.className = "row";
          break;
          break;

        case 'header':
          node = document.createElement('header');
          text = document.createTextNode("Header");
          node.appendChild(text);
          node.className = "header";
          break;

        case 'footer':
          node = document.createElement('footer');
          text = document.createTextNode("Footer");
          node.appendChild(text);
          node.className = "footer";
          break;

        case 'title':
          node = document.createElement('h1');
          text = document.createTextNode("Title");
          node.appendChild(text);
          node.className = "display-1";
          break;

        case 'text':
          node = document.createElement('p');
          text = document.createTextNode("Text");
          node.appendChild(text);
          node.className = "lead";
          break;

        case 'image':
          node = document.createElement('img');
          node.className = "img-rounded";
          node.src ="uploads/images/1/128.jpg"
          console.debug(node);
          break;

        case 'gallery':
          node = document.createElement('div');
          for(i = 1; i < 7; i++)
          {
            var img = document.createElement('img');
            img.className = "img-rounded";
            img.src = "uploads/images/1/128(" + i + ").jpg";
            node.appendChild(img);
          }
          node.className = "col-md-12";
          break;

        default:

      }
      event.target.appendChild(node);
    }
  </script>
<?php require_once "includes/admin-footer.php"; ?>
