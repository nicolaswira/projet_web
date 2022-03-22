<!DOCTYPE html>

<?php
session_start();

if (isset($_SESSION["username"])){
    $sql = 'SELECT ID_internship ,name_internship, description_internship, duration_internship, remuneration_internship, offer_date_internship, place_number_internship, competences_internship, city_localisation, postal_code_localisation, GROUP_CONCAT(name_promotion SEPARATOR ", ") AS "name_promotion", name_company, visibility_company, note FROM internships NATURAL JOIN localisations NATURAL JOIN companies NATURAL JOIN internship_for_promo NATURAL JOIN promotions NATURAL JOIN evaluate INNER JOIN users ON evaluate.ID_user=users.ID_user NATURAL JOIN roles WHERE name_role="Pilote"';
    $params = [];
    $selected = [];
    if (isset($_GET["localisation"]) && isset($_GET["competences"]) && isset($_GET["confiance"]) && isset($_GET["dateoffre"]) && isset($_GET["duree"]) && isset($_GET["promotion"])){
        if ($_GET["localisation"] != ""){
            $sql = $sql . " AND city_localisation=:localisation";
            $params['localisation'] = $_GET["localisation"];
            $selected['localisation'] = $_GET["localisation"];
        }
        if ($_GET["competences"] != ""){
            $sql = $sql . " AND competences_internship LIKE :competences";
            $params['competences'] = '%'.$_GET["competences"].'%';
            $selected['competences'] = $_GET["competences"];
        }
        if ($_GET["confiance"] != ""){
            $sql = $sql . " AND note=:note";
            $params['note'] = $_GET["confiance"];
            $selected['note'] = $_GET["confiance"];
        }
        if ($_GET["dateoffre"] != ""){
            $sql = $sql . " AND offer_date_internship >= :dateoffre";
            $params['dateoffre'] = $_GET["dateoffre"];
            $selected['dateoffre'] = $_GET["dateoffre"];
        }
        if ($_GET["duree"] != ""){
            $sql = $sql . " AND duration_internship = :duree";
            $params['duree'] = $_GET["duree"];
            $selected['duree'] = $_GET["duree"];
        }
        if ($_GET["promotion"] != ""){
            $sql = $sql . " AND name_promotion = :promotion";
            $params['promotion'] = $_GET["promotion"];
            $selected['promotion'] = $_GET["promotion"];
        }
    }
    $sql = $sql . " GROUP BY ID_internship;";

    include "ConnexionBDD.php";
    if (!$error) {
        $query_perm = $bdd->prepare('SELECT username, code_permission FROM users NATURAL JOIN roles NATURAL JOIN roles_has_permissions NATURAL JOIN permissions WHERE code_permission=:perm AND username=:user;');
        $query_perm->execute(['user' => $_SESSION["username"], 'perm' => "SFx8"]);
        if ($query_perm->rowCount() == 1) {
            $query_internships = $bdd->prepare($sql);
            $query_internships->execute($params);
            $results_internships = $query_internships->fetchALL(PDO::FETCH_OBJ);

            $query_localisations = $bdd->prepare('SELECT city_localisation FROM localisations NATURAL JOIN internships GROUP BY city_localisation;');
            $query_localisations->execute();
            $results_localisations = $query_localisations->fetchALL(PDO::FETCH_OBJ);

            $query_competences = $bdd->prepare('SELECT competences_internship FROM internships;');
            $query_competences->execute();
            $results_competences = $query_competences->fetchALL(PDO::FETCH_OBJ);
            $liste_competences = [];
            foreach ($results_competences as $result_competences) {
                foreach (explode(", ", $result_competences->competences_internship) as $result) {
                    if (!in_array($result, $liste_competences)) {
                        array_push($liste_competences, $result);
                    }
                }
            }

            $query_notes = $bdd->prepare('SELECT note FROM internships NATURAL JOIN companies NATURAL JOIN evaluate INNER JOIN users ON evaluate.ID_user=users.ID_user NATURAL JOIN roles WHERE name_role="Pilote" GROUP BY note;');
            $query_notes->execute();
            $results_notes = $query_notes->fetchALL(PDO::FETCH_OBJ);

            $query_durations = $bdd->prepare('SELECT ROUND(duration_internship/30) AS duration_internship FROM internships GROUP BY duration_internship ORDER BY duration_internship ASC;');
            $query_durations->execute();
            $results_durations = $query_durations->fetchALL(PDO::FETCH_OBJ);

            $query_promotions = $bdd->prepare('SELECT name_promotion FROM internships NATURAL JOIN internship_for_promo NATURAL JOIN promotions GROUP BY name_promotion;');
            $query_promotions->execute();
            $results_promotions = $query_promotions->fetchALL(PDO::FETCH_OBJ);
?>
<html lang="fr">
    <head>
        <?php require "Head.php" ?>
        <title>Stages - CTS</title>
        <link rel="stylesheet" type="text/css" href="assets/css/offres_stages.css">
    </head>
    <body>
        <div class="container">
            <?php require "Nav_bar.php" ?>
            <div class="main">
                <?php require "Top_bar.php" ?>
                <div class="content">
                    <div class="content_title">Offres de stages</div>
                    <div class="bubble">
                        <div class="title_bubble">Filtres de recherche :</div>
                        <div class="text_content" style="display:block;">
                            <form class="filter_form" action="/offres_stages.php" method ="GET">
                                <div class="table-container">
                                    <div class="flex-table">
                                        <div class="flex-row name">Localisation:</div>
                                        <div class="flex-row value">
                                            <select name="localisation">
                                                <option value="" selected>-- Choisir une localisation --</option>
                                                <?php
                                                foreach($results_localisations as $localisation) {
                                                    if (isset($selected['localisation'])) {
                                                        if ($selected['localisation'] == $localisation->city_localisation) {echo '<option value="'.$localisation->city_localisation.'" selected>'.$localisation->city_localisation.'</option>';}
                                                        else {echo '<option value="'.$localisation->city_localisation.'">'.$localisation->city_localisation.'</option>';}
                                                    } else {echo '<option value="'.$localisation->city_localisation.'">'.$localisation->city_localisation.'</option>';}
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="flex-row name">Competences:</div>
                                        <div class="flex-row value">
                                            <select name="competences">
                                                <option value="" selected>-- Choisir une compétence --</option>
                                                <?php
                                                foreach($liste_competences as $competence) {
                                                    if (isset($selected['competences'])) {
                                                        if ($selected['competences'] == $competence) {echo '<option value="'.$competence.'" selected>'.$competence.'</option>';}
                                                        else {echo '<option value="'.$competence.'">'.$competence.'</option>';}
                                                    } else {echo '<option value="'.$competence.'">'.$competence.'</option>';}
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="flex-row name">Niveau de confiance:</div>
                                        <div class="flex-row value">
                                            <select name="confiance">
                                                <option value="" selected>-- Choisir une confiance --</option>
                                                <?php
                                                foreach($results_notes as $note) {
                                                    if (isset($selected['note'])) {
                                                        if ($selected['note'] == $note->note) {echo '<option value="'.$note->note.'" selected>'.$note->note.'</option>';}
                                                        else {echo '<option value="'.$note->note.'">'.$note->note.'</option>';}
                                                    } else {echo '<option value="'.$note->note.'">'.$note->note.'</option>';}
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="flex-row name">Date de début:</div>
                                        <div class="flex-row value">
                                            <input type="date" name="dateoffre">
                                        </div>
                                        <div class="flex-row name">Durée:</div>
                                        <div class="flex-row value">
                                            <select name="duree">
                                                <option value="" selected>-- Choisir une durée --</option>results_durations
                                                <?php
                                                foreach($results_durations as $duration) {
                                                    if (isset($selected['duree'])) {
                                                        if ($selected['duree'] == $duration->duration_internship*30) {echo '<option value="'.($duration->duration_internship*30).'" selected>'.$duration->duration_internship.' mois</option>';}
                                                        else {echo '<option value="'.($duration->duration_internship*30).'">'.$duration->duration_internship.' mois</option>';}
                                                    } else {echo '<option value="'.($duration->duration_internship*30).'">'.$duration->duration_internship.' mois</option>';}
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="flex-row name">Promotion:</div>
                                        <div class="flex-row value">
                                            <select name="promotion">
                                                <option value="" selected>-- Choisir une promotion --</option>
                                                <?php
                                                foreach($results_promotions as $promotion) {
                                                    if (isset($selected['promotion'])) {
                                                        if ($selected['promotion'] == $promotion->name_promotion) {echo '<option value="'.$promotion->name_promotion.'" selected>'.$promotion->name_promotion.'</option>';}
                                                        else {echo '<option value="'.$promotion->name_promotion.'">'.$promotion->name_promotion.'</option>';}
                                                    } else {echo '<option value="'.$promotion->name_promotion.'">'.$promotion->name_promotion.'</option>';}
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit">Rechercher</button>
                            </form>
                        </div>   
                    </div>     

                    <?php foreach ($results_internships as $result) { ?>
                        <div class="bubble">
                            <div class="title_bubble"><?= $result->name_internship; ?>
                                <div class="heart-1"><i class="far fa-heart"></i></div>
                                <div class="heart-2"><i class="fas fa-heart"></i></div>
                            </div>
                            
                            <div class="text_content">
                                <div class="divLeft">
                                    <div class="name_company">
                                        <?= $result->name_company; ?>
                                    </div>
                                    <?= $result->city_localisation; ?> <?= $result->postal_code_localisation; ?>
                                    <div class="description">
                                        <?= $result->description_internship; ?>
                                    </div>
                                </div>
                                <div class="divRight">  
                                    <table>
                                        <div class="table_title">Points importants:</div>
                                        
                                        <tr>
                                            <td><i class="far fa-clock"></i></td>
                                            <td><?= $result->duration_internship; ?> jours</td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-euro-sign"></i></td>
                                            <td><?= $result->remuneration_internship; ?> €/h</td>
                                        </tr>
                                        <tr>
                                            <td><i class="far fa-calendar-alt"></i></td>
                                            <td><?= $result->offer_date_internship; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-user-alt"></i></td>
                                            <td>
                                                <?php
                                                echo $result->place_number_internship;
                                                if($result->place_number_internship > 1) {echo " places disponibles";}
                                                else {echo " place disponible";}?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-chart-bar"></i></td>
                                            <td><?= $result->competences_internship; ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="button">
                                    <button class="button_postuler">Postuler</button>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php require "Script.php" ?>
        <script src="assets/js/offres_stages.js"></script>
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