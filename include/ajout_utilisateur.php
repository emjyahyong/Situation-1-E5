<?php
    session_start();

    // Suppression de la session si un utilisateur était déjà identifié pour déconnexion
    if (isset($_SESSION["User"])) {
        session_unset();
        session_destroy();
    }

    require "outils_bd.php";
    // Récupération des données POST
        $postLogin = $_POST["login"];
        $postMdp = sha1($_POST["mdp"]);
        $postAge = $_POST["age"];
        $postPoids = $_POST["poids"];
        $postTaille = $_POST["taille"];
        $postImc = $postPoids / (($postTaille / 100) ** 2); // Conversion de la taille en mètres pour le calcul de l'IMC
        $postObjPoids = $_POST["obj_poids"];
        
    if (empty($postLogin) || empty($postMdp) || empty($postAge) || empty($postPoids) || empty($postTaille) || empty($postObjPoids)) {
        // Rediriger vers la page de connexion avec un message d'erreur si l'un des champs est vide
        header("Location: ../creer_compte.php?erreur=1");
        exit();
    } else {

        // Déclaration de la requête avec des variables liées pour chaque paramètre
        $requete = "CALL SP_InsertUtilisateur(:login, :mdp, :age, :poids, :taille, :imc, :obj_poids)";

        // Préparation de la requête
        $result = $cnx->prepare($requete);

        // Vérification de la préparation de la requête
        if ($result === false) {
            die("Erreur de préparation de la requête : " . $cnx->errorInfo()[2]);
        }

        // Liaison des variables aux paramètres de la requête
        $result->bindParam(':login', $postLogin, PDO::PARAM_STR);
        $result->bindParam(':mdp', $postMdp, PDO::PARAM_STR);
        $result->bindParam(':age', $postAge, PDO::PARAM_INT);
        $result->bindParam(':poids', $postPoids, PDO::PARAM_STR);
        $result->bindParam(':taille', $postTaille, PDO::PARAM_STR);
        $result->bindParam(':imc', $postImc, PDO::PARAM_STR);
        $result->bindParam(':obj_poids', $postObjPoids, PDO::PARAM_STR);

        // Exécution de la requête
        if (!$result->execute()) {
            header("Location: ../creer_compte.php?erreur=0");
            exit();
        } else {
            header("Location: ../index.php");
            exit(); // S'assurer que le script s'arrête après la redirection
        }
    }
?>
