<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
  <head lang="en">
    <meta charset="ansi">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    if(isset($title) && !empty($title))
    {
    ?>
    <title><?= $title; ?></title>
    <?php
    }
    else
    {
    ?>
    <title><?= SITE_NAME; ?> | <?= SITE_TAGLINE; ?> - Alpha [Build <?= APP_VER; ?>]</title>
    <?php
    }
    ?>
    <meta name="description" content="<?= App::get_site_description($db); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <base href=<?= BASEPATH; ?>>

    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="stylesheet" href="css/normalize.min.css">

    <!-- Latest compiled and minified CSS -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">

    <!-- <link rel="stylesheet" href="css/flat-ui.min.css"> -->

    <!-- Great Vibes Font from Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Great+Vibes' rel='stylesheet' type='text/css'>

    <!-- Main css -->
    <link rel="stylesheet" href="css/assegai-main.css">

  </head>
  <body>
      <!--[if lt IE 8]>
          <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
      <![endif]-->
