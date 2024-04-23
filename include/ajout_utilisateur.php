<?php
session_start();

// Si un utilisateur était déjà identifié on supprime sa session.
// Utilisé pour la deconnexion (on suppose ici que la page précédente
// est logoff.inc.php)

require "outils_bd.php";

    $postLogin = $_POST["login"];
    $postMdp = $_POST["mdp"];
    $postAge  = $_POST["age"];
    $postPoids = $_POST["poids"];
    $postTaille   = $_POST["taille"];
    $postImc   = $postPoids / ($postTaille * $postTaille);
    $postObj_poids  = $_POST["obj_poids"];

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
    $result->bindParam(':obj_poids', $postObj_poids, PDO::PARAM_STR);

    // Exécution de la requête
    $result->execute();

    // Vérification de l'exécution de la requête
    if (!$result) {
        $errorInfo = $cnx->errorInfo();
        echo "Erreur lors de l'exécution de la requête : " . $errorInfo[2];
    } else {
        header("Location: ../index.php");
    }

?>
