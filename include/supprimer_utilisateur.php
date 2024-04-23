<?php
session_start();

// Si un utilisateur était déjà identifié on supprime sa session.
// Utilisé pour la deconnexion (on suppose ici que la page précédente
// est logoff.inc.php)

    $user = $_SESSION["User"];
    session_unset();
    require "outils_bd.php";
    $requete = "DELETE FROM `utilisateurs` WHERE nom_utilisateur = ?";

    // Pour éviter les injections SQL
    $result = $cnx->prepare($requete);
    $result->execute(array($user));

    session_destroy();
    header("Location: ../index.php");

?>
