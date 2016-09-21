<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><?= SITE_NAME; ?></a>
    </div>
    <ul class="navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="#">Page 1</a></li>
      <li><a href="#">Page 2</a></li>
      <li><a href="#">Page 3</a></li>
    </ul>
  </div>
</nav><!--#end nav -->

<div class="container-fluid">
  <!-- Content  -->
  <div class="row">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
      </ol><!--#end ol -->

      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">

        <div class="item active">
          <img src="<?= RESPATH; ?>images/default-carousel.png" alt="Alterante Image Text">
        </div>

        <div class="item">
          <img src="<?= RESPATH; ?>images/default-carousel.png" alt="Alterante Image Text">
        </div>

        <div class="item">
          <img src="<?= RESPATH; ?>images/default-carousel.png" alt="Alterante Image Text">
        </div>

        <div class="item">
          <img src="<?= RESPATH; ?>images/default-carousel.png" alt="Alterante Image Text">
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>

      </div><!--#end .carousel-inner -->
    </div><!--#end .carousel -->
  </div><!--#end .row -->

  <!-- Columns -->
  <div class="row">
    <!-- Column right -->
    <div class="col-sm-4"></div>

    <!-- Column middle -->
    <div class="col-sm-4"></div>

    <!-- Column left -->
    <div class="col-sm-4"></div>
  </div><!--#end .row -->

  <!-- Footer -->
  <div class="row">
    <footer></footer>
  </div><!--# end .row -->

</div><!--#end .container-fluid -->
