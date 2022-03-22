<!DOCTYPE html>

<?php 
session_start();

if (isset($_SESSION["username"])){ ?>
<html lang="fr">
    <head>
        <?php require "Head.php" ?>
        <title>Candidatures - CTS</title>
        <link rel="stylesheet" type="text/css" href="assets/css/candidatures.css">
    </head>
    <body>
        <div class="container">
            <?php require "Nav_bar.php "?>
            <div class="main">
                <?php require "Top_bar.php" ?>
                <div class="content">
                    <div class="content_title">Candidatures</div>
                </div>
            </div>
        </div>
        <?php require "Script.php" ?>
        <script src="assets/js/candidatures.js"></script>
    </body>
</html>
<?php } else {?>
    <script>location.href='/';</script>
<?php } ?>