<!DOCTYPE html>

<html>

    <head>

        <link href="/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="/css/bootstrap-theme.min.css" rel="stylesheet"/>
        <link href="/css/styles.css" rel="stylesheet"/>

        <?php if (isset($title)): ?>
            <title>Postit Pets: <?= htmlspecialchars($title) ?></title>
        <?php else: ?>
            <title>Postit Pets</title>
        <?php endif ?>
                
        <script src="/js/jquery-1.10.2.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/scripts.js"></script>

    </head>

    <body style>

        <div class="container">
            <div id="bar">navbar-fixed-top
            <nav class="navbar navbar-default " role="banner">
              <div class="container">
                <div class="navbar-header">
                  <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a href="/" class="navbar-brand">Post it Pets</a>
                </div>
                <nav class="collapse navbar-collapse" role="navigation">
                  <ul class="nav navbar-nav">
                  <?php if (empty($_SESSION["id"])): ?>
                    <li>
                      <a href="login.php">Log In</a>
                    </li>
                  <?php endif ?>
                    <li>
                      <a href="poster_links.php?status=found">Found</a>
                    </li>
                    <li>
                      <a href="poster_links.php?status=lost">Lost</a>
                    </li>
                    <li>
                      <a href="search.php">Search</a>
                    </li>
                  <?php if (isset($_SESSION["id"])): ?>
                    <li>
                      <a href="index.php">Profile</a>
                    </li>
                    <li>
                      <a href="new_poster.php">New Poster</a>
                    </li>
                    <li>
                      <a href="settings.php">Settings</a>
                    </li>
                    <li>
                      <a href="logout.php">Log Out</a>
                    </li>
                  <?php endif ?>
                  </ul>
                </nav>
              </div>
            </nav>
            </div>
            
            <div id="top">
                
            </div>

            <div id="middle">
