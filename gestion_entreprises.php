<!DOCTYPE html>

<?php 
session_start();

if (isset($_SESSION["username"])){
    include "ConnexionBDD.php";
    if (!$error) {
        $query = $bdd->prepare('SELECT * FROM companies');
        $query->execute(['user' => $_SESSION["username"]]);
        $results = $query->fetchALL(PDO::FETCH_OBJ); ?>

<html lang="fr">
    <head>
        <?php require "Head.php" ?>
        <title>Entreprises - Gestion - CTS</title>
        <link rel="stylesheet" type="text/css" href="assets/css/gestion_entreprises.css">
    </head>
    <body>
        <div id="modal_edit_company" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <div class="title_modal">Modification des entreprises</div>
                    <form class="form_edit_company" action="/Edit_company.php" method="POST">
                        <div class="table-container">
                            <div class="info_message"></div>
                            <div class="flex-table">
                                <div class="flex-row name">Nom de l'entreprise</div>
                                <div class="flex-row value"><input class="input_edit_company" type="text" name="name_company" required autocomplete="off"></div>
                            </div>
                            <div class="flex-table">
                                <div class="flex-row name">Secteur d'activité</div>
                                <div class="flex-row value"><input class="input_edit_company" type="text" name="activity_sector_company" required autocomplete="off"></div>
                            </div>
                            <div class="flex-table">
                                <div class="flex-row name">Nombre de stagiaires CESI</div>
                                <div class="flex-row value"><input class="input_edit_company" type="text" name="nb_intern_cesi_company" required autocomplete="off"></div>
                            </div>
                            <div class="flex-table">
                                <div class="flex-row name">Visibilité</div>
                                <div class="flex-row value"><input class="input_edit_company" type="text" name="visibility_company" required autocomplete="off"></div>
                            </div>
                        </div>
                        <button type="submit">Modifier</button>
                    </form>
                </div>
            </div>


        <div class="container">
            <?php require "Nav_bar.php "?>
            <div class="main">
                <?php require "Top_bar.php" ?>
                <div class="content">
                    <div class="content_title">Gestion des entreprises</div>
                    <?php
                        echo "<div><table class='table'>";
                            echo "<thead>";
                                echo "<tr>";
                                echo "<th>Nom</th>";
                                echo "<th>Secteur d'activité</th>";
                                echo "<th>Nb stagiaires CESI</th>";
                                echo "<th>Visibilité</th>";
                                echo "<th>Action</th>";
                                echo "</tr>";
                            echo "</thead>";
                        foreach($results as $row){
                            echo "<tbody>";
                                echo "<tr>";
                                echo "<td>";
                                echo $row->name_company;
                                echo "</td>";
                                echo "<td>";
                                echo $row->activity_sector_company;
                                echo "</td>";
                                echo "<td>";
                                echo $row->nb_intern_cesi_company;
                                echo "</td>";
                                echo "<td>";
                                echo $row->visibility_company;
                                echo "</td>";
                                echo "<td> <div class='action'> <a href='#' class='button_edit_company'> <i class='fas fa-pen'> </i> </a>
                                            <a href='#' class='button_delete_company'> <i class='fas fa-trash-alt'> </i> </a>
                                        </div>
                                        </td>";
                                echo "</tr>";
                                echo "</tbody>";
                            }
                        echo "</table></div>";
                    ?>
                </div>
            </div>
        </div>

        <?php require "Script.php" ?>
        <script src="assets/js/gestion_entreprises.js"></script>
    </body>
</html>
<?php 
    }
} else {
    echo "<script>location.href='/';</script>";
}
?>