<!DOCTYPE html>

<?php 
session_start();

if (isset($_SESSION["username"])){
    include "ConnexionBDD.php";
    if (!$error) {
        $query_perm = $bdd->prepare('SELECT username, code_permission FROM users NATURAL JOIN roles NATURAL JOIN roles_has_permissions NATURAL JOIN permissions WHERE code_permission=:perm AND username=:user;');
        $query_perm->execute(['user' => $_SESSION["username"], 'perm' => "SFx2"]);
        if ($query_perm->rowCount() == 1) {
?>
<html lang="fr">
    <head>
        <?php require "Head.php" ?>
        <title>Entreprises - CTS</title>
        <link rel="stylesheet" type="text/css" href="assets/css/offres_entreprises.css">
    </head>
    <body>
        <div class="container">
            <?php require "Nav_bar.php "?>
            <div class="main">
                <?php require "Top_bar.php" ?>
                <div class="content">
                    <div class="content_title">Liste des entreprises</div>
                </div>
            </div>
        </div>
        <?php require "Script.php" ?>
        <script src="assets/js/offres_entreprises.js"></script>
    </body>
</html>
<?php
        } else {
            header('HTTP/1.0 403 Forbidden');
            require "403.php";
        }
    }
} else {
    echo "<script>location.href='/';</script>";
}
?>