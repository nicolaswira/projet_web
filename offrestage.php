<!DOCTYPE html>

<?php 
    include "ConnexionBDD.php";
    $requete = "SELECT * FROM internships INNER JOIN localisations ON localisations.ID_localisation = internships.ID_localisation INNER JOIN companies ON companies.ID_company = internships.ID_company INNER JOIN evaluate ON companies.ID_company = evaluate.ID_company WHERE city_localisation = $_POST['loc'] AND competences_internship = $_POST['competences'] AND note = $_POST['confiance'] AND offer_date_internship = $_POST['dateoffre'] AND duration_internship = $_POST['duree'];"
    $query = $bdd->prepare($requete);
    $query->execute();                             /*Remplissage de la requete avec les données*/
    $results = $query->fetchALL(PDO::FETCH_OBJ);                    /*Retour un résultat sous forme d'objet*/
?>

<html lang="fr">
    <head>
        <title>Accueil - CTS</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="assets/images/logo_petit.png">
        <link rel="stylesheet" type="text/css" href="assets/css/offres.css">
        <link rel="stylesheet" href="./assets/vendors/fontawesome/css/all.min.css">
    </head>
    <body>
        <div class="container">
            <div class="navigation">
                <ul>
                    <li>
                        <a href="#">
                            <img style="height:60px;" src="assets/images/logo_petit.png" alt="Cesi Ton Stage">
                            <span class="title">Cesi Ton Stage</span>
                        </a>
                    </li>
                    <li>
                        <a href="/accueil.php">
                            <span class="icon"><i class="fas fa-home"></i></span>
                            <span class="title">Accueil</span>
                        </a>
                    </li>
                    <li class="hover">
                        <a href="/offres.php">
                            <span class="icon"><i class="fab fa-buffer"></i></span>
                            <span class="title">Offres</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="icon"><i class="fas fa-bookmark"></i></span>
                            <span class="title">Favoris</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="icon"><i class="fas fa-envelope"></i></span>
                            <span class="title">Candidatures</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="icon"><i class="fas fa-network-wired"></i></span>
                            <span class="title">Gestions</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="icon"><i class="fas fa-cog"></i></span>
                            <span class="title">Parametres</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="main">
                <div class="topbar">
                    <div class="toggle">
                        <i class="fas fa-bars"></i>
                    </div>
                    <div class="search">
                        <label>
                            <input type="text" placeholder="Recherchez ici">
                            <i class="fas fa-search"></i>
                        </label>
                    </div>
                    <div class="user">
                        <i class="fas fa-user-alt"></i>
                    </div>
                </div>
                <div class="content">
                    <div class="bubble">
                        <div class="title"><u>Filtre de recherche :</u></div>
                        <div class="text_content">
                            <form action="#" method ="post">
                                <label for="loc">Localisation :</label>
                                <select name="loc">
                                <option value="Fournisseur 1">Haguenau</option>
                                <option value="Fournisseur 2">Paris</option>
                                <option value="Fournisseur 3">Schweighouse Sur Moder</option>
                                <option value="Fournisseur 4">Andlau</option>
                                <option value="Fournisseur 5">Bissert</option>
                                <option value="Fournisseur 5">Seltz</option>
                                <option value="Fournisseur 5">Strasbourg</option>
                                <option value="Fournisseur 5">Pau</option>
                                <option value="Fournisseur 5">Reininge</option>
                                </select>

                                <label for="competences">Compétences :</label>
                                <select name="competences">
                                <option value="Fournisseur 1">HTML</option>
                                <option value="Fournisseur 2">CSS</option>
                                <option value="Fournisseur 3">JS</option>
                                <option value="Fournisseur 4">PHP</option>
                                <option value="Fournisseur 5">C++</option>
                                <option value="Fournisseur 5">Framework .NET</option>
                                <option value="Fournisseur 5">Windows Server 2019</option>
                                <option value="Fournisseur 5">SQL</option>
                                <option value="Fournisseur 5">SQL Server</option>
                                <option value="Fournisseur 5">SGBD</option>
                                <option value="Fournisseur 5">MySQL</option>
                                </select>

                                <label for="confiance">Niveau de confiance :</label>
                                <select name="confiance">
                                <option value="Fournisseur 1">A </option>
                                <option value="Fournisseur 2">B </option>
                                <option value="Fournisseur 3">C </option>
                                <option value="Fournisseur 4">D </option>
                                </select>

                                <!--<label for="evaluation">Evaluation du stagiaire :</label>
                                <select name="evaluation">
                                <option value="Fournisseur 1">A</option>
                                <option value="Fournisseur 2">B</option>
                                <option value="Fournisseur 3">C</option>
                                <option value="Fournisseur 4">D</option>
                                </select>-->

                                <label for="dateoffre">Date de l'offre :</label>
                                <input type="date" class="dateoffre" name="dateoffre">

                                <label for="duree">Durée du stage (entre 7 et 182 jours) :</label>
                                <input type="range" id="duree" name="duree" min="7" max="182" step="7" value="90">
                            </form>
                        </div>   
                    </div>     

                    <?php foreach ($results as $result): ?>
                        <div class="bubble">
                            <div class="title"><u><?php print $result->name_internship; ?></u></div>
                            <div class="text_content">
                                Nom de l'entreprise :<?= $result->name_company; ?><br>
                                Description du stage :<?= $result->description_internship; ?><br>
                                Durée du stage :<?= $result->duration_internship; ?> jours<br>
                                Rémunération :<?= $result->remuneration_internship; ?>€ / heure<br>
                                Date de l'offre :<?= $result->offer_date_internship; ?><br>
                                Places disponibles :<?= $result->place_number_internship; ?><br>
                                Compétences requises :<?= $result->competences_internship; ?><br>
                                Promotion visée :<?= $result->name_promotion; ?><br>
                                Localisation du stage :<?= $result->city_localisation; ?> <?= $result->postal_code_localisation; ?><br>
                                Confiance du pilote :<?= $result->note; ?>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <script src="assets/js/jquery-3.4.1.min.js"></script>
        <script src="assets/js/accueil.js"></script>
    </body>
</html>