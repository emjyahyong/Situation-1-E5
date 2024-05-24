<?php
	session_start();

	if (isset($_SESSION["User"])) {
            session_unset();
            header("Location: ../index.php");
            exit();
	}
	if (empty($_POST["login"]) || empty($_POST["mdp"]) ) {	
            header("Location: ../connexion_compte.php?erreur=1");
            exit();
	} else {

            require "outils_bd.php";

		$postLogin = $_POST["login"];	
		$postPwd   = sha1($_POST["mdp"]);

		$requete = "Select * from Utilisateurs ".
			   "Where nom_utilisateur = ? ".
			   "And mot_de_passe    = ?";
                
                // Pour éviter les injections SQL
                $result = $cnx->prepare($requete);			
                $result->execute(array($postLogin, $postPwd));
                
                $line = $result->fetch();
				
		if (!$line) {
			// Utilisateur non trouvé ($line ne contient pas d'enregistrement)
			header("Location: ../connexion_compte.php?erreur=0");
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
