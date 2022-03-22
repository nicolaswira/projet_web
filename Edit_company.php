<?php
session_start();

if (isset($_SESSION["username"])){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {                            /*Seulement si la method est en POST*/
        if (isset($_POST["new_name_company"]) && isset($_POST["new_activity_sector_company"]) 
            && isset($_POST["new_nb_internship_cesi_company"]) && isset($_POST["new_visibility_company"])){                /*Vérification de l'existance des paramètres*/
            $new_name_company = $_POST["new_name_company"];                           /*Récupération des paramètres*/
            $new_activity_sector_company = $_POST["new_activity_sector_company"];
            $new_nb_internship_cesi_company = $_POST["new_nb_internship_cesi_company"];
            $new_visibility_company = $_POST["new_visibility_company"];
            $id=$_GET['Id_company'];

            require "ConnexionBDD.php";                                     /*Inclusion de la partie connexion*/
            
            if (!$error) {                                                  /*Si la connexion a été établie sans erreur*/
                $query = $bdd->prepare('SELECT * FROM companies;');
                $query->execute(['user' => $_SESSION["username"]]);         /*Remplissage de la requete avec les données*/
                $results = $query->fetchALL(PDO::FETCH_OBJ);                /*Retour un résultat sous forme d'objet*/

                if ($query->rowCount() == 1){
                    $query_update_company = $bdd->prepare('UPDATE companies SET name_company = new_name_company, activity_sector_company=new_activity_sector_company, nb_intern_cesi_company=new_nb_internship_cesi_company, visibility_company=new_visibility_company WHERE Id_company=Id_company;');
                    $query_update_company->execute($bddç());
                    echo "true";
                    }
                $bdd = null;                                                /*Fin de connexion*/
            } else {echo "false";}                                          /*Dans le cas d'une erreur de connexion à la BDD, retour false (erreur d'authentification)*/
        }
    }
} else {
    echo "<script>location.href='/';</script>";
}

?>