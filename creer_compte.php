<?php
// Démarrer la session pour manipuler des variables de session
session_start();
$user = isset($_SESSION["User"]) ? $_SESSION["User"] : "";

if (isset($_GET['erreur'])) {
    if ($_GET['erreur'] == 1) {
        // Affiche un message d'alerte en utilisant JavaScript
        echo '<script>';
        echo 'alert("Une erreur est survenue : Veuillez remplir entièrement le formulaire ");';
        echo '</script>';
    } else {
        echo '<script>';
        echo 'alert("Une erreur est survenue : Identifiant déjà existant");';
        echo '</script>';
    }
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Calcul IMC (correction v3.1) : Tout côté serveur - Fichier">
    <meta name="author" content="ND" datetime>
    <meta itemprop="datePublished" content="2023-09-14">
    <title>Inscription - HealthIndex</title>
    <link rel="stylesheet" href="css/imc.css">
</head>
<body>
    <input type="button" class="boutonJS" value="Revenir à l'accueil" onclick="window.location.href = '../index.php';">
    <input type="button" class="boutonJS" value="Connexion compte" onclick="window.location.href = '../connexion_compte.php';">
    
    <h1>Créer un compte</h1>
    <div class="contenu">
        <form name="formIMC" method="post" action="include/ajout_utilisateur.php">
            <p>Login : <input type="text" name="login" id="login"></p>
            <p>Mot de passe : <input type="password" name="mdp"></p>
            <p>Age : <input type="number" name="age"></p>
            <p>Poids : <input type="number" name="poids"></p>
            <p>Taille : <input type="number" name="taille"></p>
            <p>Objectif Poids : <input type="number" name="obj_poids"></p>
            <input name="cmdCreer" type="submit" class="boutonJS" value="Créer">
        </form>
    </div>

    <?php
    // Affichage de l'IMC et de son interprétation si disponibles
    if (isset($_SESSION['imc'], $_SESSION['interpretation']) && is_numeric($_SESSION['imc'])) {
        $imc = round($_SESSION['imc'], 2);
        $interpretation = $_SESSION['interpretation'];
        echo "Votre IMC : <b>{$imc}</b> - {$interpretation}";
    }
    ?>
</body>
</html>
