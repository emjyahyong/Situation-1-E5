<?php
    session_start();

    if (isset($_SESSION["User"])) {
        // Récupération du nom d'utilisateur
        $user = $_SESSION["User"];
        echo 'ok';
        // Suppression de la session
        // session_unset();
        
        // Inclusion du fichier pour la connexion à la base de données
        require "outils_bd.php";
        
        // Préparation de la requête SQL pour éviter les injections SQL
        $requete = "DELETE FROM `Utilisateurs` WHERE nom_utilisateur = ?";
        $result = $cnx->prepare($requete);
        
        // Exécution de la requête avec le nom d'utilisateur
        if ($result->execute([$user])) {
            // Si la suppression est réussie, destruction de la session et redirection
            session_destroy();
            header("Location: ../index.php");
            exit();
        } else {
            // Gestion des erreurs
            echo "Erreur lors de la suppression de l'utilisateur.";
        }
    } else {
        // Si aucun utilisateur n'est connecté, redirection vers la page d'accueil
        header("Location: ../index.php");
        exit();
    }
?>
