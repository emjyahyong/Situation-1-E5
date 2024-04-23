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
			session_destroy();
            header("Location: ../index.php");
            exit();
	}
?>
