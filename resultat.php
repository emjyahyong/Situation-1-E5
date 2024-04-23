<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Calcul IMC (correction v3.1)">
	<meta name="author" content="ND">	
	<title>Données IMC</title>
	<link rel="stylesheet" href="css/imc.css">
</head>
<body>
<div class="contenu">
	<?php

		$cheminFichier = './lib';
		$files = scandir($cheminFichier);

		echo "<h1>Données des utilisateurs</h1>";
		echo "<table class='center'>";
		foreach ($files as $file) {
			$extension = pathinfo($file, PATHINFO_EXTENSION);

			if ($extension === 'csv') {
				$cheminComplet = $cheminFichier . '/' . $file; // Chemin complet du fichier CSV

				if (file_exists($cheminComplet)) {
					// Ouverture du fichier en lecture ('r' pour 'read')
					$res = fopen($cheminComplet, 'r');

					// Génération de l'entête du tableau
					echo '<tr>';
					$lignes = explode(';', fgets($res));
					echo '<th>' . $lignes[0] . '</th>';
					echo '<th>' . $lignes[1] . '</th>';
					echo '</tr>';

					// Parcours total du fichier
					while (!feof($res)) {
						// Génération des lignes du tableau
						echo '<tr>';
						$lignes = explode(';', fgets($res));
						echo '<td>' . $lignes[0] . '</td>';
						echo '<td>' . $lignes[1] . '</td>';
						echo '</tr>';
					}
					// Fermeture du fichier
					fclose($res);
				}
			}
		}

		
		echo '</table>';
		?>
</div>
</body>
</html>