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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta itemprop="datePublished" content="2023-09-14">
    <title>Calcul de l'IMC (3.1C)</title>
    <link rel="stylesheet" href="css/imc.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
</head>
<body>
    <?php
    
    require "include/outils_bd.php";
        if (isset($_SESSION["User"])) {        
            echo '<input type="button" class="boutonJS" value="Connecté en tant que : '.$user.'"> ';
            echo '<input type="button" class="boutonJS" value="Deconnexion compte" onclick="window.location.href = \'../include/deconnexion_utilisateur.php\';"> ';
            // echo '<input type="button" class="boutonJS" value="Modifier compte" onclick="window.location.href = \'http://localhost/imc/include/deconnexion_utilisateur.php\';"> ';
            echo '<input type="button" class="boutonJS" value="Supprimer compte" onclick="window.location.href = \'../include/supprimer_utilisateur.php\';"> ';


        } else {
            echo '<input type="button" class="boutonJS" value="Non connecté"> ';
            echo '<input type="button" class="boutonJS" value="Créer compte" onclick="window.location.href = \'../creer_compte.php\';"> ';
            echo '<input type="button" class="boutonJS" value="Connexion compte" onclick="window.location.href = \'../connexion_compte.php\';">';
        }
    ?>

    <h1>Votre indice de masse corporelle (IMC)</h1>
    <div class="contenu">
        <form name="formIMC" method="post" action="include/calculer_imc.php">
            <p>
                Votre taille : <input type="number" name="txtTaille" size="3"  placeholder="Cm">
            </p>                    
            <p>
                Votre poids : <input type="number" name="txtPoids" size="3" placeholder="Kg">
            </p>

            <input name="cmdCalculer" type="submit" class="boutonJS" value="Calculer IMC">
        </form>
    </div>
    
    <p id="idIMC">
    
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
        
		if (isset($_SESSION["User"])) {
			echo "<br><h1>Bonjour ".$user.", voici vos derniers progrès :</h1>";

			echo "<div style='display: flex; justify-content: center; align-items: center; '>"; // Début du div centré
		
			echo "<canvas id='myChart' width='400' height='300'></canvas>";
		
			echo "<style>
				#myChart {
					background-color: white;
				}
			</style>";
		
			echo "<script>
				document.addEventListener('DOMContentLoaded', function() {
				  // Données d'exemple
				  var labels = " . json_encode(getDateEnregistrement()) . ";
				  var poids = " . json_encode(getPoids()) . ";
				  var objectifPoids = " . json_encode(getObjPoids()) . ";
		
				  var config = {
					type: 'line',
					data: {
					  labels: labels,
					  datasets: [{
						label: 'Poids',
						backgroundColor: 'rgba(75, 192, 192, 0.2)',
						borderColor: 'rgba(75, 192, 192, 1)',
						data: poids,
						fill: false,
					  }, {
						label: 'Objectif de poids',
						backgroundColor: 'rgba(255, 99, 132, 0.2)',
						borderColor: 'rgba(255, 99, 132, 1)',
						data: objectifPoids,
						fill: false,
					  }]
					},
					options: {
					  responsive: false,
					  maintainAspectRatio: false,
					  aspectRatio: 1,
					  scales: {
						x: {
						  title: {
							display: true,
							text: 'Jours'
						  }
						},
						y: {
						  title: {
							display: true,
							text: 'Poids'
						  },
						  min: 0,
						  stepSize: 10
						}
					  },
					  plugins: {
						legend: {
						  labels: {
							color: 'black'
						  }
						},
						backgroundColor: 'white'
					  }
					}
				  };
		
				  var ctx = document.getElementById('myChart').getContext('2d');
				  var myChart = new Chart(ctx, config);
				});
			</script>";
		
			echo "</div>"; // Fin du div centré
		}
		
		
		
    ?>
    </p>
</body>
</html>
