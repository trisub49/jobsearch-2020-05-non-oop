<!DOCTYPE HTML>
<?php
    session_start();
    include("data.php");
    include("functions.php");
    $connectionx = dbconnect($dbhost, $dbname, $dbuser, $dbpass);
?>
<!------------------------------------------------------------------------------------------------------->
<html>
    <head>
        <title>Álláskereső (Projektmunka)</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap-theme.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/icono.min.css">
        <!--<link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@400&display=swap" rel="stylesheet">-->
        <link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
    </head>
<!------------------------------------------------------------------------------------------------------->    
    <body>
        <!--<div id="logo"><h2>Álláskereső</h2></div>-->
        <div id="menu" class="container-fluid">
            <?php include("menu.php"); ?>
        </div>
        <div id="container" class="container">
            <div class="row">
                <div id="page" class="col-xl-8 col-lg-8 col-md-8">
                    <?php include("loader.php"); ?>
                </div>
                <div id="makemoney" class="d-none d-sm-none d-md-block d-lg-block d-xl-block col-xl-3 col-lg-3 col-md-3">
                    <?php include("makemoney.php"); ?>
                </div>
            </div>
        </div>
        <div id="footer" class="container-fluid" style="padding: 10px; background-color: rgba(0,0,0,0.3); color: white; text-align: center;">
}">
            <h4><b>Projektmunka - Álláskereső portál</b></h4>
            <h5>Készítette: Farkas András - 2020</h5>
        </div>
    </body>
</html>