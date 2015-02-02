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
        
            <div id="top">
                <a href="/"><img alt="C$50 Finance" src="/img/logo.gif"/></a>
            </div>

            <div id="middle">remember to stick a navbar up top and change it if logged in!
            
            <?php if (isset($_SESSION["id"])): ?>
                <ul class = "nav nav-pills">
                    <li><a href="index.php">Home/Welcome</a>
                    
                </ul>
            <?php endif ?>
