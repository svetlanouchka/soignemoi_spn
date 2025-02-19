<?php
require_once _ROOTPATH_ . '\templates\header.php'; ?>

<div class="container mt-5">
    <h1 class="mb-4"><?= $pageTitle ?></h1>
    <h2>Sejours par specialite</h2>
    <canvas id="sejoursChart" width="400" height="200"></canvas>
    <h2>Patients par mois</h2>
    <canvas id="patientsChart" width="400" height="200"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var statistics = <?= json_encode($statistics) ?>;

    var labelsSejours = statistics.sejoursParSpecialite.map(function(item) {
        return item.specialite;
    });
    var dataSejours = statistics.sejoursParSpecialite.map(function(item) {
        return item.total_sejours;
    });
    //Graphique : sejours par Spécialité
    var ctxSejours = document.getElementById('sejoursChart').getContext('2d');
    var sejoursChart = new Chart(ctxSejours, {
        type: 'bar',
        data: {
            labels: labelsSejours,
            datasets: [{
                label: 'Total Sejours',
                data: dataSejours,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    //Graphique : Patients par mois

    var labelsPatients = Object.keys(statistics.patientsParMois);
    var dataPatients = Object.values(statistics.patientsParMois);
    var ctxPatients = document.getElementById('patientsChart').getContext('2d');

    var patientsChart = new Chart(ctxPatients, {
        type: 'line',
        data: {
            labels: labelsPatients,
            datasets: [{
                label: 'Nombre de patients',
                data: dataPatients,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<?php require_once _ROOTPATH_ . '\templates\footer.php' ?>