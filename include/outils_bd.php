<?php
	
	// Mini-projet IMC v3.2 (tout côté serveur)

	// Paramètres de connexion à la base MySQL
	$bdHote        = "172.18.153.42";
	$bdNom         = "imc_data";
	$bdUtilisateur = "e5";	
	$bdMotDePasse  = "e5";	
	
	// Ouverture de la connexion
    try {
        $cnx = new PDO('mysql:host='.$bdHote.';dbname='.$bdNom, $bdUtilisateur, $bdMotDePasse);
    }
 
    catch(Exception $err) {
        echo 'Erreur : '.$err->getMessage().'<br />';
		echo 'N° : '.$err->getCode();
    }
	
	if (isset($_SESSION["User"])) {
		// Récupération des infos util
		$user = $_SESSION["User"];
		$id = $_SESSION["Id"];
	}

	function saveData($un_pseudo, $une_taille_cm, $un_poids_kg) {
		global $cnx;
		
		$ip = $_SERVER['REMOTE_ADDR'];
		$sql = "Insert Into imc_log (ip, src, taille, poids) " .
			   "values ('$ip', '$un_pseudo', $une_taille_cm, $un_poids_kg)";

		$cnx->exec($sql);
	}	

	function getDateEnregistrement(){
		global $cnx;
		global $id;
		$stmt = $cnx->prepare("SELECT DATE_FORMAT(date_enregistrement, '%Y-%m-%d') AS date_enregistrement FROM Donnees WHERE utilisateur_id = :userId ORDER BY id");
		$stmt->bindParam(':userId', $_SESSION["Id"]);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
		// Formater les données dans un format JSON
		$data = [];
		foreach ($result as $row) {
			$data[] = $row['date_enregistrement'];
		}
	
		// Convertir le tableau de données en format JSON
		return $data;
	}
	

	function getPoids(){
		global $cnx;
		global $id;
		$stmt = $cnx->prepare("SELECT poids FROM Donnees WHERE utilisateur_id = :userId ORDER BY id");
        $stmt->bindParam(':userId', $_SESSION["Id"]);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Formater les données dans un format JSON
        $data = [];
        foreach ($result as $row) {
            $data[] = floatval($row['poids']);
        }

        // Convertir le tableau de données en format JSON
        return $data;
	}

	function getObjPoids(){
		global $cnx;
		global $id;
	
		// Récupérer l'objectif de poids de l'utilisateur
		$stmt = $cnx->prepare("SELECT objectif_poids FROM Utilisateurs WHERE id = :userId");
		$stmt->bindParam(':userId', $_SESSION["Id"]);
		$stmt->execute();
		$objectifPoids = $stmt->fetch(PDO::FETCH_ASSOC)['objectif_poids'];
	
		// Récupérer le nombre de poids enregistrés pour l'utilisateur
		$stmt2 = $cnx->prepare("SELECT COUNT(poids) AS nb_poids FROM Donnees WHERE utilisateur_id = :userId");
		$stmt2->bindParam(':userId', $_SESSION["Id"]);
		$stmt2->execute();
		$nbPoids = $stmt2->fetch(PDO::FETCH_ASSOC)['nb_poids'];
	
		// Créer un tableau contenant l'objectif de poids répété
		$data = array_fill(0, $nbPoids, floatval($objectifPoids));
	
		// Convertir le tableau de données en format JSON
		return $data;
	}
	

	function getNbLog($un_pseudo) {
		global $cnx;
	
		$sql = "Select count(*) as nbLog from imc_log where src='$un_pseudo'";
		$mesLignes = $cnx->query($sql);
		$ligne = $mesLignes->fetch();
		return $ligne['nbLog'];
	}
	