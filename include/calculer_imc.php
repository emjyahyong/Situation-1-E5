<?php
/**
 * title		 :calculer_imc.php
 * author        :ND
 * date          :20230210
 * version       :5.0 (correction)
 * see			 :outils_bd.php
 * note          :Ce script n'est pas sécurisé !
 * description   :
 *
 *  Calcule l'IMC et son interprétation à partir de données transmises via le formulaire 
 *  de imc.php.
 * 	Sauvegarde les données taille et poids dans une base de données
 *  Redirige vers imc.php après avoir stocké les résultats dans des variables session.
 */

// Indispensable pour manipuler des variables session
// Doit être la première instruction !
session_start();

require_once 'outils_bd.php';

function imc($une_taille_cm, $un_poids_kg) {
// Retourne l'IMC calculée à partir des arguments transmis
	return $un_poids_kg * 10000 / ($une_taille_cm * $une_taille_cm);
}

function interpretation($un_imc){
	// Retourne l'interprétation de l'IMC fourni en argument
	if ($un_imc > 40) {
		return "Obésité massive";
	} else if ($un_imc >= 35) {
		return "Obésité sévère";
	} else if ($un_imc >= 30) {
		return "Obésité modérée";
	} else if ($un_imc >= 25) {
		return "Surpoids";
	} else if ($un_imc >= 18.5) {
		return "Poids normal";
	} else if ($un_imc >= 16.5) {
		return "Insuffisance pondérale";
	} else {
		return "Dénutrition";
	}
}

// Récupération des variables transmises (données du formulaire)

$taille = $_POST['txtTaille'];
$poids = $_POST['txtPoids'];
$imcUtilisateur = round(imc($taille, $poids), 2);
echo $imcUtilisateur;
$imcInter = interpretation($imcUtilisateur);

if (isset($_SESSION["User"])) {
	// Récupération des infos util
	$id = $_SESSION["Id"];
	
	$requete = "INSERT INTO Donnees (utilisateur_id, date_enregistrement, poids, taille, imc)
	VALUES (?, DATE(NOW()), ?, ?, ?);";
	// Pour éviter les injections SQL
	$result = $cnx->prepare($requete);			
	$result->execute(array($id, $poids, $taille, $imcUtilisateur));
}

$_SESSION['imc'] = $imcUtilisateur;
$_SESSION['interpretation'] = $imcInter;

header("Location: ../index.php");