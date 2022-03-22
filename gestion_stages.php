<!DOCTYPE html>

<?php 
session_start();

if (isset($_SESSION["username"])){ ?>
<html lang="fr">
    <head>
        <?php require "Head.php" ?>
        <title>Stages - Gestion - CTS</title>
        <link rel="stylesheet" type="text/css" href="assets/css/gestion_stages.css">
    </head>
    <body>
        <div class="container">
            <?php require "Nav_bar.php "?>
            <div class="main">
                <?php require "Top_bar.php" ?>
                <div class="content">
                    <div class="content_title">Gestion des stages</div>
                </div>
            </div>
        </div>
        <?php require "Script.php" ?>
        <script src="assets/js/gestion_stages.js"></script>
    </body>
</html>
<?php } else {?>
    <script>location.href='/';</script>
<?php } ?>