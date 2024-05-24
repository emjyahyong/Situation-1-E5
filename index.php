<?php
// Démarrer la session pour manipuler des variables de session
session_start();

// Récupérer les infos utilisateur si connecté
$user = isset($_SESSION["User"]) ? $_SESSION["User"] : "";
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Accueil">
    <meta name="author" content="ND" datetime>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta itemprop="datePublished" content="2023-09-14">
    <title>HealthIndex</title>
    <link rel="stylesheet" href="css/imc.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
</head>
<body>
    <?php if ($user): ?>
        <input type="button" class="boutonJS" value="Connecté en tant que : <?= $user ?>">
        <input type="button" class="boutonJS" value="Déconnexion compte" onclick="window.location.href = '../include/deconnexion_utilisateur.php';">
        <input type="button" class="boutonJS" value="Supprimer compte" onclick="window.location.href = '../include/supprimer_utilisateur.php';">
    <?php else: ?>
        <input type="button" class="boutonJS" value="Non connecté">
        <input type="button" class="boutonJS" value="Créer compte" onclick="window.location.href = '../creer_compte.php';">
        <input type="button" class="boutonJS" value="Connexion compte" onclick="window.location.href = '../connexion_compte.php';">
    <?php endif; ?>

    <h1>Votre indice de masse corporelle (IMC)</h1>
    <div class="contenu">
        <form name="formIMC" method="post" action="include/calculer_imc.php">
            <p>Votre taille : <input type="number" name="txtTaille" size="3" placeholder="Cm"></p>
            <p>Votre poids : <input type="number" name="txtPoids" size="3" placeholder="Kg"></p>
            <input name="cmdCalculer" type="submit" class="boutonJS" value="Calculer IMC">
        </form>
    </div>
    
    <p id="idIMC">
        <?php
        require "./include/outils_bd.php";

        // Affichage de l'IMC et des derniers progrès si connecté
        if (isset($_SESSION['imc'], $_SESSION['interpretation']) && is_numeric($_SESSION['imc'])) {
            $imc = round($_SESSION['imc'], 2);
            $interpretation = $_SESSION['interpretation'];
            echo "Votre IMC : <b>{$imc}</b> - {$interpretation}";
        }

        if ($user):
        ?>
            <br><h1>Bonjour <?= $user ?>, voici vos derniers progrès :</h1>
            <div style="display: flex; justify-content: center; align-items: center;">
                <canvas id="myChart" width="400" height="300"></canvas>
                <style>
                    #myChart {
                        background-color: white;
                    }
                </style>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var labels = <?= json_encode(getDateEnregistrement()) ?>;
                        var poids = <?= json_encode(getPoids()) ?>;
                        var objectifPoids = <?= json_encode(getObjPoids()) ?>;
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
                                    }
                                }
                            }
                        };
                        var ctx = document.getElementById('myChart').getContext('2d');
                        new Chart(ctx, config);
                    });
                </script>
            </div>
        <?php endif; ?>
    </p>
</body>
</html>
