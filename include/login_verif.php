<?php
/* ================================================  login_verif.php
	BTS SIO SLAM, ND 
	Attention, le code présenté est à sécuriser !
        v2.0
================================================= */
	session_start();

	// Si un utilisateur était déjà identifié on supprime sa session.	
	// Utilisé pour la deconnexion (on suppose ici que la page précédente
	// est logoff.inc.php)
	if (isset($_SESSION["User"])) {
            session_unset();
            header("Location: ../index.php");
            exit();
	}
	if (!isset($_POST["login"]) && !isset($_POST["mdp"]) ) {	
            header("Location: ../index.php?page=login.inc.php&Err=BadId");
            exit();
	} else {

            require "outils_bd.php";

		$postLogin = $_POST["login"];	
		$postPwd   = $_POST["mdp"];

		$requete = "Select * from utilisateurs ".
			   "Where nom_utilisateur = ? ".
			   "And mot_de_passe    = ?";
                
                // Pour éviter les injections SQL
                $result = $cnx->prepare($requete);			
                $result->execute(array($postLogin, $postPwd));
                
                $line = $result->fetch();
				
		if (!$line) {
			// Utilisateur non trouvé ($line ne contient pas d'enregistrement)
			header("Location: ../index.php?page=login.inc.php&Err=BadId");
		} else {
			// Utilisateur trouvé
			$maLigne = $line;
			
			// Mémorisation des infos utilisateur
			$_SESSION["User"] = $maLigne['nom_utilisateur']; 
			$_SESSION["Id"] = $maLigne['id']; 

			header("Location: ../index.php");
		}
	}
?>
