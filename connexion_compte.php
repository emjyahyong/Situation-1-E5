<?php
	// Indispensable pour manipuler des variables session
	// Doit être la première instruction !
	session_start();
	if (isset($_SESSION["User"])) {
		// Récupération des infos util
		$user = $_SESSION["User"];
	}
?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Calcul IMC (correction v3.1) : Tout côté serveur - Fichier">
	<meta name="author" content="ND" datetime>	
	<meta itemprop="datePublished" content="2023-09-14">
	<title>Calcul de l'IMC (3.1C)</title>
	<link rel="stylesheet" href="css/imc.css">
</head>
<body>
	<input type="button" class="boutonJS" value="Revenir à l'accueil" onclick="window.location.href = '../index.php';">
	<input type="button" class="boutonJS" value="Créer compte" onclick="window.location.href = '../creer_compte.php';">

	<h1>Se connecter</h1>
	<div class="contenu">
		<form name="formIMC" method="post" action="include/login_verif.php">
			<p>
				Login : <input type="text" name="login" id="login" size="3">
			</p>					
			<p>
				Mot de passe : <input type="text" name="mdp" size="3">
			</p>
			<input name="cmdConnexion" type="submit" class="boutonJS" value="Connexion">
		</form>
	</div>

	<?php
		// Note: Ce code n'est pas sécurisé !
		// Dans cette version, on récupère l'imc et son interprétation dans des variables session
		//
		if (isset($_SESSION['imc']) && isset($_SESSION['interpretation'])) {
			$imc = $_SESSION['imc'];
			$interpretation = $_SESSION['interpretation'];
			if (is_numeric($imc)) {
				$message = 'Votre IMC : <b>' . round($imc, 2) . '</b> - ' . $interpretation;
				echo $message;
			}
		}
	?>
	</p>
</body>
</html>