<?php require_once _ROOTPATH_ . '/templates/header.php';
/** @var \App\Entity\Sejour $sejour */
?>

<div class="container mt-5">
<h1><?= htmlspecialchars($pageTitle) ?></h1>

<h2>Médecin: <?= htmlspecialchars($medecin->getNomComplet()) ?></h2>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Nombre de Patients</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($plannings as $planning): ?>
        <tr>
            <td><?= htmlspecialchars($planning->getDate_i()->format('Y-m-d')) ?></td>
            <td><?= htmlspecialchars($planning->getNombrePatients()) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<a href="index.php?controller=admin&action=viewMedecins">Retour à la liste des médecins</a>
</div>
<?php require_once _ROOTPATH_ . '/templates/footer.php' ?>